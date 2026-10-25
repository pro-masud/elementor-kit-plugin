/**
 * KINBONI Pro - Fast 3-Field Express COD Checkout Controller (Module 01)
 *
 * Integrates directly with native WooCommerce via AJAX:
 *  - Direct 1-Click Order Now without cart clutter or premature bag notifications
 *  - Delivery zone calculations (Inside Dhaka ৳60 / Outside Dhaka ৳120 / Complimentary >= ৳2500)
 *  - Real-time client-side field validation (Name, Bangladeshi phone, Address)
 *  - Order generation via 'kinboni_create_cod_order' with nonce, stock deduction & double-submit protection
 *  - Order confirmation screen with authoritative WooCommerce Order ID & WhatsApp link
 *
 * @package KinboniPro
 */

(function(window, document) {
  'use strict';

  function safeFormatCurrency(amount) {
    if (typeof window.formatCurrency === 'function') {
      return window.formatCurrency(amount);
    }
    const symbol = (window.kinboni && window.kinboni.currency_symbol) || '৳';
    return symbol + Number(amount || 0).toLocaleString('en-US');
  }

  function safeShowToast(message, type) {
    if (typeof window.showToast === 'function') {
      window.showToast(message, type);
    }
  }

  function safeRefreshIcons() {
    if (typeof window.refreshIcons === 'function') {
      window.refreshIcons();
    } else if (window.lucide && typeof window.lucide.createIcons === 'function') {
      window.lucide.createIcons();
    }
  }

  const QuickOrderController = {
    currentDeliveryFee: 60,
    isInitialized: false,
    isSubmitting: false,
    checkoutMode: 'cart', // 'cart' or 'direct'
    directItem: null,

    /**
     * Get active items for checkout (either current cart items or direct 1-click item).
     */
    getActiveItems() {
      if (this.checkoutMode === 'direct' && this.directItem) {
        return [this.directItem];
      }
      return Array.isArray(window.STATE?.cart) ? window.STATE.cart : [];
    },

    /**
     * Initialize DOM event listeners for COD Checkout Modal.
     * Guarded with idempotency flag to prevent duplicate listeners.
     */
    init() {
      if (this.isInitialized) return;
      this.isInitialized = true;

      const modal = document.getElementById('checkout-modal');
      const backdrop = document.getElementById('checkout-backdrop');
      const closeBtn = document.getElementById('close-checkout-modal-btn');
      const closeSuccessBtn = document.getElementById('close-success-view-btn');
      const form = document.getElementById('quick-order-form');

      if (backdrop) backdrop.onclick = () => this.close();
      if (closeBtn) closeBtn.onclick = () => this.close();
      if (closeSuccessBtn) closeSuccessBtn.onclick = () => this.close();

      // Delivery zone radio buttons
      const zoneRadios = document.querySelectorAll('input[name="order-delivery-zone"]');
      zoneRadios.forEach((radio) => {
        radio.onchange = (e) => {
          this.updateDeliveryFee(e.target.value);
        };
      });

      // Name real-time validation
      const nameInput = document.getElementById('order-customer-name');
      if (nameInput) {
        nameInput.oninput = (e) => {
          if (e.target.value.trim().length >= 2) {
            nameInput.classList.remove('border-rose-500');
            const err = document.getElementById('order-name-error');
            if (err) err.classList.add('hidden');
          }
        };
      }

      // Phone real-time validation & digit sanitization
      const phoneInput = document.getElementById('order-customer-phone');
      if (phoneInput) {
        phoneInput.oninput = (e) => {
          const cleaned = e.target.value.replace(/[^\d+]/g, '');
          e.target.value = cleaned;
          if (cleaned.length >= 11) {
            phoneInput.classList.remove('border-rose-500');
            const err = document.getElementById('order-phone-error');
            if (err) err.classList.add('hidden');
          }
        };
      }

      // Address real-time validation
      const addressInput = document.getElementById('order-customer-address');
      if (addressInput) {
        addressInput.oninput = (e) => {
          if (e.target.value.trim().length >= 5) {
            addressInput.classList.remove('border-rose-500');
            const err = document.getElementById('order-address-error');
            if (err) err.classList.add('hidden');
          }
        };
      }

      // Form submission: use onsubmit property to guarantee exactly ONE handler
      if (form) {
        form.onsubmit = (e) => {
          e.preventDefault();
          this.handleSubmit();
        };
      }

      // Escape key listener (only attached once)
      if (!this._hasEscListener) {
        this._hasEscListener = true;
        window.addEventListener('keydown', (e) => {
          if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            this.close();
          }
        });
      }
    },

    /**
     * Direct 1-Click Order Now for a specific product.
     * Bypasses the shopping bag completely with zero cart clutter.
     */
    orderDirect(productId, quantity = 1, options = {}) {
      if (!productId) return;
      const pidNum = Number(productId) || productId;
      const products = Array.isArray(window.PRODUCTS) ? window.PRODUCTS : [];
      const product = products.find((p) => p.id == pidNum || p.id == productId);

      this.checkoutMode = 'direct';
      this.directItem = {
        id: pidNum,
        name: product ? product.name : (options.title || 'Bespoke Creation'),
        price: product ? product.price : (options.price || 0),
        image: product ? product.image : (options.image || ''),
        category: product ? (product.categoryLabel || product.category || 'Atelier') : 'Atelier',
        quantity: Math.max(1, Number(quantity) || 1),
        color: options.color || 'Standard',
        size: options.size || '',
      };

      this.openModal();
    },

    /**
     * Open COD express checkout modal for current bag or specific product.
     */
    open(productId) {
      if (productId) {
        return this.orderDirect(productId, 1);
      }

      this.checkoutMode = 'cart';
      this.directItem = null;

      const activeCart = Array.isArray(window.STATE?.cart) ? window.STATE.cart : [];
      if (activeCart.length === 0) {
        safeShowToast('Your shopping bag is currently empty. Please select a product.', 'error');
        return;
      }

      this.openModal();
    },

    /**
     * Display and hydrate the modal views.
     */
    openModal() {
      if (window.CartController && typeof window.CartController.close === 'function') {
        window.CartController.close();
      }
      if (window.QuickViewController && typeof window.QuickViewController.close === 'function') {
        window.QuickViewController.close();
      }

      const modal = document.getElementById('checkout-modal');
      const formView = document.getElementById('checkout-form-view');
      const successView = document.getElementById('checkout-success-view');

      if (!modal || !formView || !successView) return;

      formView.classList.remove('hidden');
      successView.classList.add('hidden');

      this.clearErrors();
      this.renderItemsPreview();

      const selectedZone =
        document.querySelector('input[name="order-delivery-zone"]:checked')?.value || 'inside';
      this.updateDeliveryFee(selectedZone);

      modal.classList.remove('hidden');
      document.body.classList.add('overflow-hidden');
      safeRefreshIcons();

      // Focus name input for friction-free UX
      const nameInput = document.getElementById('order-customer-name');
      if (nameInput) {
        setTimeout(() => nameInput.focus(), 150);
      }
    },

    /**
     * Close COD express checkout modal.
     */
    close() {
      const modal = document.getElementById('checkout-modal');
      if (modal) {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
      }
    },

    /**
     * Render items in the checkout modal summary preview.
     */
    renderItemsPreview() {
      const container = document.getElementById('checkout-items-preview');
      if (!container) return;

      const items = this.getActiveItems();
      const products = Array.isArray(window.PRODUCTS) ? window.PRODUCTS : [];

      const itemsHtml = items
        .map((item) => {
          const product = products.find((p) => p.id == item.id) || null;
          const name = item.name || (product ? product.name : 'Bespoke Creation');
          const price = typeof item.price === 'number' ? item.price : (product ? product.price : 0);
          const image = item.image || (product ? product.image : '');
          const cat = item.category || (product ? (product.categoryLabel || product.category || 'Atelier') : 'Atelier');
          const qty = item.quantity || 1;

          return `
          <div class="flex items-center gap-3.5 p-3 rounded-2xl bg-white dark:bg-stone-900 border border-stone-200/80 dark:border-stone-800 shadow-2xs hover:border-gold-500/30 transition-colors">
            <img 
              src="${image}" 
              alt="${name}" 
              class="w-14 h-16 sm:w-16 sm:h-20 object-cover object-center rounded-xl bg-stone-100 dark:bg-stone-950 border border-stone-200/60 dark:border-stone-800 flex-shrink-0" 
            />
            <div class="flex-grow min-w-0">
              <span class="text-[9px] uppercase tracking-wider font-bold text-gold-600 dark:text-gold-400 block">
                ${cat}
              </span>
              <h5 class="font-serif text-xs sm:text-sm font-semibold text-stone-900 dark:text-stone-100 truncate">
                ${name}
              </h5>
              <div class="flex items-center justify-between mt-1.5 text-xs">
                <span class="text-stone-500 dark:text-stone-400 text-[11px]">
                  Qty: <strong class="text-stone-900 dark:text-stone-200">${qty}</strong> × ${safeFormatCurrency(price)}
                </span>
                <span class="font-serif font-bold text-stone-900 dark:text-white">
                  ${safeFormatCurrency(price * qty)}
                </span>
              </div>
            </div>
          </div>
          `;
        })
        .join('');

      container.innerHTML = itemsHtml;
    },

    /**
     * Compute delivery fee based on zone and threshold.
     */
    updateDeliveryFee(zone) {
      const items = this.getActiveItems();
      const products = Array.isArray(window.PRODUCTS) ? window.PRODUCTS : [];
      const threshold = window.FREE_SHIPPING_THRESHOLD || 2500;

      const subtotal = items.reduce((sum, item) => {
        const p = products.find((prod) => prod.id == item.id);
        const price = typeof item.price === 'number' ? item.price : (p ? p.price : 0);
        return sum + (price * (item.quantity || 1));
      }, 0);

      const isFree = subtotal >= threshold;
      if (isFree) {
        this.currentDeliveryFee = 0;
      } else {
        this.currentDeliveryFee = zone === 'outside' ? 120 : 60;
      }

      const labelInside = document.getElementById('zone-label-inside');
      const labelOutside = document.getElementById('zone-label-outside');

      if (labelInside && labelOutside) {
        if (zone === 'inside') {
          labelInside.classList.add('active', 'border-gold-500', 'bg-gold-50/50', 'dark:bg-gold-950/20', 'ring-1', 'ring-gold-500');
          labelInside.classList.remove('border-stone-200', 'dark:border-stone-700');

          labelOutside.classList.remove('active', 'border-gold-500', 'bg-gold-50/50', 'dark:bg-gold-950/20', 'ring-1', 'ring-gold-500');
          labelOutside.classList.add('border-stone-200', 'dark:border-stone-700');
        } else {
          labelOutside.classList.add('active', 'border-gold-500', 'bg-gold-50/50', 'dark:bg-gold-950/20', 'ring-1', 'ring-gold-500');
          labelOutside.classList.remove('border-stone-200', 'dark:border-stone-700');

          labelInside.classList.remove('active', 'border-gold-500', 'bg-gold-50/50', 'dark:bg-gold-950/20', 'ring-1', 'ring-gold-500');
          labelInside.classList.add('border-stone-200', 'dark:border-stone-700');
        }
      }

      this.calculateTotals();
    },

    /**
     * Recompute totals and update modal summary elements.
     */
    calculateTotals() {
      const subtotalEl = document.getElementById('order-modal-subtotal');
      const discountRow = document.getElementById('order-modal-discount-row');
      const discountEl = document.getElementById('order-modal-discount');
      const shippingEl = document.getElementById('order-modal-shipping');
      const totalEl = document.getElementById('order-modal-total');
      const zoneFeeInside = document.getElementById('zone-fee-inside');
      const zoneFeeOutside = document.getElementById('zone-fee-outside');

      const items = this.getActiveItems();
      const products = Array.isArray(window.PRODUCTS) ? window.PRODUCTS : [];
      const promoCodes = window.PROMO_CODES || { LUXE20: 0.2 };
      const threshold = window.FREE_SHIPPING_THRESHOLD || 2500;

      const subtotal = items.reduce((sum, item) => {
        const p = products.find((prod) => prod.id == item.id);
        const price = typeof item.price === 'number' ? item.price : (p ? p.price : 0);
        return sum + (price * (item.quantity || 1));
      }, 0);

      let discountAmount = 0;
      const activePromo = window.STATE?.activePromo;
      if (activePromo && promoCodes[activePromo]) {
        discountAmount = Math.round(subtotal * promoCodes[activePromo]);
      }

      const isFree = subtotal >= threshold;
      if (zoneFeeInside && zoneFeeOutside) {
        if (isFree) {
          zoneFeeInside.textContent = 'Free (Complimentary)';
          zoneFeeOutside.textContent = 'Free (Complimentary)';
          this.currentDeliveryFee = 0;
        } else {
          zoneFeeInside.textContent = '৳60';
          zoneFeeOutside.textContent = '৳120';
        }
      }

      const finalTotal = Math.max(0, subtotal - discountAmount + this.currentDeliveryFee);

      if (subtotalEl) subtotalEl.textContent = safeFormatCurrency(subtotal);

      if (discountRow && discountEl) {
        if (discountAmount > 0) {
          discountRow.classList.remove('hidden');
          discountEl.textContent = `-${safeFormatCurrency(discountAmount)}`;
        } else {
          discountRow.classList.add('hidden');
        }
      }

      if (shippingEl) {
        shippingEl.textContent = this.currentDeliveryFee === 0 ? 'Free' : safeFormatCurrency(this.currentDeliveryFee);
      }

      if (totalEl) totalEl.textContent = safeFormatCurrency(finalTotal);

      // Modal promo badge
      const modalPromoBadge = document.getElementById('order-modal-applied-promo');
      if (modalPromoBadge) {
        if (activePromo && promoCodes[activePromo]) {
          modalPromoBadge.innerHTML = `
            <div class="flex items-center justify-between p-2 rounded-lg bg-gold-50 dark:bg-gold-950/40 border border-gold-300 dark:border-gold-800 text-xs">
              <div class="flex items-center gap-1.5 text-gold-700 dark:text-gold-300 font-semibold">
                <i data-lucide="tag" class="w-3.5 h-3.5"></i>
                <span>Voucher <strong>${activePromo}</strong> (${promoCodes[activePromo] * 100}% Privilege Applied)</span>
              </div>
              <button type="button" onclick="QuickOrderController.removeModalPromo()" class="text-stone-400 hover:text-stone-700 dark:hover:text-stone-200" aria-label="Remove voucher">
                <i data-lucide="x" class="w-3.5 h-3.5"></i>
              </button>
            </div>
          `;
        } else {
          modalPromoBadge.innerHTML = '';
        }
      }
    },

    /**
     * Apply voucher code from checkout modal.
     */
    applyModalPromo() {
      const input = document.getElementById('order-modal-promo-input');
      const code = input && input.value ? String(input.value).trim().toUpperCase() : '';
      const promoCodes = window.PROMO_CODES || { LUXE20: 0.2 };

      if (!code) {
        safeShowToast('Please enter a voucher code (e.g. LUXE20).', 'info');
        return;
      }
      if (promoCodes[code]) {
        if (window.STATE) window.STATE.activePromo = code;
        if (window.CartController && typeof window.CartController.save === 'function') {
          window.CartController.save();
        }
        this.calculateTotals();
        if (window.CartController && typeof window.CartController.render === 'function') {
          window.CartController.render();
        }
        safeShowToast(`Privilege voucher "${code}" applied! ${promoCodes[code] * 100}% privilege deducted.`, 'success');
        if (input) input.value = '';
        safeRefreshIcons();
      } else {
        safeShowToast('Invalid voucher code. Try "LUXE20" for 20% privilege.', 'error');
      }
    },

    /**
     * Remove voucher code from checkout modal.
     */
    removeModalPromo() {
      if (window.STATE) window.STATE.activePromo = null;
      if (window.CartController && typeof window.CartController.save === 'function') {
        window.CartController.save();
      }
      this.calculateTotals();
      if (window.CartController && typeof window.CartController.render === 'function') {
        window.CartController.render();
      }
      safeShowToast('Privilege voucher removed.', 'info');
      safeRefreshIcons();
    },

    /**
     * Clear all validation errors.
     */
    clearErrors() {
      ['order-name-error', 'order-phone-error', 'order-address-error'].forEach((id) => {
        const el = document.getElementById(id);
        if (el) {
          el.textContent = '';
          el.classList.add('hidden');
        }
      });

      document
        .querySelectorAll('#quick-order-form input, #quick-order-form textarea')
        .forEach((el) => {
          el.classList.remove('border-rose-500', 'focus:border-rose-500');
        });
    },

    /**
     * Handle fast express order submission.
     * Guarded with atomic this.isSubmitting lock against duplicate requests.
     */
    handleSubmit() {
      if (this.isSubmitting) {
        console.warn('[KINBONI QuickOrder] Order submission already in progress. Duplicate blocked.');
        return;
      }

      this.clearErrors();

      const nameInput = document.getElementById('order-customer-name');
      const phoneInput = document.getElementById('order-customer-phone');
      const addressInput = document.getElementById('order-customer-address');
      const submitBtn = document.getElementById('order-submit-button');
      const btnText = document.getElementById('order-submit-btn-text');

      const name = nameInput ? nameInput.value.trim() : '';
      const phone = phoneInput ? phoneInput.value.trim() : '';
      const address = addressInput ? addressInput.value.trim() : '';

      let hasError = false;

      // 1. Name validation
      if (!name || name.length < 2) {
        const err = document.getElementById('order-name-error');
        if (err) {
          err.textContent = 'Please enter your full name.';
          err.classList.remove('hidden');
        }
        if (nameInput) nameInput.classList.add('border-rose-500');
        hasError = true;
      }

      // 2. Phone validation (Bangladeshi 11 digits format)
      const phoneRegex = /^(?:\+88|88)?01[3-9]\d{8}$/;
      if (!phone || !phoneRegex.test(phone.replace(/[\s-]/g, ''))) {
        const err = document.getElementById('order-phone-error');
        if (err) {
          err.textContent = 'Please provide a valid 11-digit mobile number (e.g. 017XXXXXXXX).';
          err.classList.remove('hidden');
        }
        if (phoneInput) phoneInput.classList.add('border-rose-500');
        hasError = true;
      }

      // 3. Address validation
      if (!address || address.length < 5) {
        const err = document.getElementById('order-address-error');
        if (err) {
          err.textContent = 'Please provide your full delivery address (House, Road, Area, District).';
          err.classList.remove('hidden');
        }
        if (addressInput) addressInput.classList.add('border-rose-500');
        hasError = true;
      }

      // 4. Items validation
      const items = this.getActiveItems();
      if (!items || items.length === 0) {
        safeShowToast('Your order has no selected products. Please choose a product.', 'error');
        hasError = true;
      }

      if (hasError) return;

      // Lock submission
      this.isSubmitting = true;

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
      }
      if (btnText) {
        btnText.innerHTML = `
          <span class="inline-flex items-center gap-2">
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-stone-950 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Processing Bespoke Order...
          </span>
        `;
      }

      const selectedZone =
        document.querySelector('input[name="order-delivery-zone"]:checked')?.value || 'inside';
      const ajaxUrl =
        (window.kinboni && window.kinboni.ajax_url) ||
        (window.kinboni_vars && window.kinboni_vars.ajax_url) ||
        '/wp-admin/admin-ajax.php';
      const nonce =
        (window.kinboni && window.kinboni.nonce) ||
        (window.kinboni_vars && window.kinboni_vars.nonce) ||
        '';

      const formData = new FormData();
      formData.append('action', 'kinboni_create_cod_order');
      formData.append('nonce', nonce);
      formData.append('customer_name', name);
      formData.append('customer_phone', phone);
      formData.append('customer_address', address);
      formData.append('delivery_zone', selectedZone);
      formData.append('promo_code', window.STATE?.activePromo || '');
      formData.append('items', JSON.stringify(items));

      fetch(ajaxUrl, {
        method: 'POST',
        body: formData,
      })
        .then((res) => res.json())
        .then((response) => {
          if (response && response.success && response.data) {
            const data = response.data;
            const formView = document.getElementById('checkout-form-view');
            const successView = document.getElementById('checkout-success-view');

            const confirmedName = document.getElementById('confirmed-customer-name');
            const confirmedOrderId = document.getElementById('confirmed-order-id');
            const confirmedPhone = document.getElementById('confirmed-customer-phone');
            const confirmedAddress = document.getElementById('confirmed-customer-address');
            const confirmedTotal = document.getElementById('confirmed-order-total');
            const waLink = document.getElementById('confirmed-whatsapp-link');

            if (confirmedName) confirmedName.textContent = data.customer_name;
            if (confirmedOrderId) confirmedOrderId.textContent = '#' + data.order_number;
            if (confirmedPhone) confirmedPhone.textContent = data.customer_phone;
            if (confirmedAddress) confirmedAddress.textContent = data.customer_address;
            if (confirmedTotal) confirmedTotal.textContent = data.formatted_total;
            if (waLink && data.whatsapp_url) {
              waLink.href = data.whatsapp_url;
            }

            if (formView) formView.classList.add('hidden');
            if (successView) successView.classList.remove('hidden');

            // If cart was checked out, clear cart
            if (this.checkoutMode === 'cart' && window.CartController && typeof window.CartController.clear === 'function') {
              window.CartController.clear();
            }
            this.directItem = null;

            const form = document.getElementById('quick-order-form');
            if (form) form.reset();

            safeShowToast(data.message || `Order #${data.order_number} placed successfully!`, 'success');
            safeRefreshIcons();
          } else {
            const errMsg =
              (response && response.data && response.data.message) ||
              'Unable to place order. Please review your information.';
            safeShowToast(errMsg, 'error');
          }
        })
        .catch((err) => {
          console.error('Kinboni COD Order submission error:', err);
          safeShowToast('Network error while placing order. Please verify your connection.', 'error');
        })
        .finally(() => {
          this.isSubmitting = false;
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
          }
          if (btnText) {
            btnText.textContent = 'Confirm Order (Cash on Delivery)';
          }
        });
    },
  };

  // Expose globally
  window.QuickOrderController = QuickOrderController;
  window.KinboniPro = window.KinboniPro || {};
  window.KinboniPro.QuickOrder = QuickOrderController;

  // Initialize once DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => QuickOrderController.init());
  } else {
    QuickOrderController.init();
  }

})(window, document);
