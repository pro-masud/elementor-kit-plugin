/**
 * KINBONI Pro — Cart Module (Module 02: Shopping Bag & Cart Drawer)
 * 
 * Powered authoritatively by WooCommerce & WP AJAX endpoints:
 *  - kinboni_get_cart
 *  - kinboni_add_to_cart
 *  - kinboni_update_cart_quantity
 *  - kinboni_remove_cart_item
 *  - kinboni_clear_cart
 *  - kinboni_apply_coupon
 *  - kinboni_remove_coupon
 * 
 * @package KinboniPro
 */

(function(window, document) {
  'use strict';

  // Ensure global state container exists
  window.STATE = window.STATE || {};
  window.STATE.cart = window.STATE.cart || [];
  window.STATE.activePromo = window.STATE.activePromo || null;

  const FREE_SHIPPING_THRESHOLD = 2500;

  function stripTags(str) {
    if (!str) return '';
    const tmp = document.createElement('div');
    tmp.innerHTML = str;
    return tmp.textContent || tmp.innerText || String(str).replace(/<[^>]*>?/gm, '');
  }

  function safeFormatCurrency(amount) {
    const sym = (window.kinboni && window.kinboni.currency) ? window.kinboni.currency : '৳';
    const num = Math.round(Number(amount) || 0);
    return `${sym}${num.toLocaleString()}`;
  }

  function safeToast(msg, type = 'info') {
    if (typeof window.showToast === 'function') {
      window.showToast(msg, type);
    } else {
      console.log(`[KINBONI] ${type.toUpperCase()}: ${msg}`);
    }
  }

  function safeRefreshIcons() {
    if (typeof window.refreshIcons === 'function') {
      window.refreshIcons();
    } else if (window.lucide && typeof window.lucide.createIcons === 'function') {
      try { window.lucide.createIcons(); } catch (e) {}
    }
  }

  const CartController = {
    cartData: null,
    isSyncing: false,

    init() {
      // 1. Initial hydration from localized data or fallback
      if (window.kinboni && window.kinboni.cart) {
        this.cartData = window.kinboni.cart;
        this.syncState();
        this.render();
      } else {
        // Fetch fresh WooCommerce cart state
        this.fetchCart();
      }

      // 2. Backdrop click
      const backdrop = document.getElementById('cart-drawer-backdrop');
      if (backdrop) {
        backdrop.addEventListener('click', () => this.close());
      }

      // 3. Close button
      const closeBtn = document.getElementById('close-cart-btn');
      if (closeBtn) {
        closeBtn.addEventListener('click', () => this.close());
      }

      // 4. Escape key
      window.addEventListener('keydown', (e) => {
        const drawer = document.getElementById('cart-drawer');
        if (e.key === 'Escape' && drawer && !drawer.classList.contains('translate-x-full')) {
          this.close();
        }
      });

      // 5. Drawer open trigger buttons (.open-cart-btn)
      document.querySelectorAll('.open-cart-btn').forEach((btn) => {
        btn.addEventListener('click', (e) => {
          e.preventDefault();
          this.open();
        });
      });

      // 6. Promo code form
      const promoForm = document.getElementById('cart-promo-form');
      if (promoForm) {
        promoForm.addEventListener('submit', (e) => {
          e.preventDefault();
          const input = document.getElementById('cart-promo-input');
          if (input) {
            this.applyPromo(input.value.trim());
          }
        });
      }

      // 7. Checkout button
      const checkoutBtn = document.getElementById('cart-checkout-btn');
      if (checkoutBtn) {
        checkoutBtn.addEventListener('click', () => this.checkout());
      }

      // 8. Listen to WooCommerce fragment events if fired elsewhere
      if (window.jQuery) {
        window.jQuery(document.body).on('wc_fragments_refreshed wc_fragments_loaded', () => {
          this.fetchCart(false);
        });
      }
    },

    getCartData() {
      return this.cartData;
    },

    syncState() {
      if (!this.cartData) return;

      // Update window.STATE.cart with live WooCommerce items
      window.STATE.cart = (this.cartData.items || []).map((item) => ({
        id: item.id,
        key: item.key,
        name: item.name,
        price: item.price,
        quantity: item.quantity,
        color: item.color || 'Standard',
        size: item.size || null,
        image: item.image,
        categoryLabel: item.categoryLabel,
        line_total: item.line_total,
      }));

      // Update active promo code
      if (this.cartData.coupons && this.cartData.coupons.length > 0) {
        window.STATE.activePromo = this.cartData.coupons[0].code;
      } else if (!window.STATE.activePromo) {
        try {
          const cached = localStorage.getItem('kinboni_active_promo');
          if (cached) window.STATE.activePromo = cached;
        } catch (e) {}
      }

      // Save to localStorage as quick hydration fallback
      try {
        localStorage.setItem('kinboni_cart', JSON.stringify(window.STATE.cart));
        if (window.STATE.activePromo) {
          localStorage.setItem('kinboni_active_promo', window.STATE.activePromo);
        }
      } catch (e) {}

      this.updateBadges();
    },

    fetchCart(triggerRender = true) {
      if (!window.kinboni || !window.kinboni.ajax_url) return;

      const fd = new FormData();
      fd.append('action', 'kinboni_get_cart');
      if (window.kinboni.nonce) {
        fd.append('nonce', window.kinboni.nonce);
      }

      fetch(window.kinboni.ajax_url, {
        method: 'POST',
        body: fd,
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success && res.data) {
            this.cartData = res.data;
            this.syncState();
            if (triggerRender) this.render();
          }
        })
        .catch((err) => {
          console.warn('[KINBONI Cart] Sync error:', err);
        });
    },

    open() {
      // Close other overlays if present
      if (window.InteractionController && typeof window.InteractionController.closeMobileMenu === 'function') {
        window.InteractionController.closeMobileMenu();
      }
      if (window.WishlistController && typeof window.WishlistController.close === 'function') {
        window.WishlistController.close();
      }

      const drawer = document.getElementById('cart-drawer');
      const backdrop = document.getElementById('cart-drawer-backdrop');

      if (drawer && backdrop) {
        backdrop.classList.remove('hidden');
        requestAnimationFrame(() => {
          backdrop.classList.remove('opacity-0');
          drawer.classList.remove('translate-x-full');
        });
        document.body.classList.add('overflow-hidden');
      }

      this.render();
      safeRefreshIcons();
    },

    close() {
      const drawer = document.getElementById('cart-drawer');
      const backdrop = document.getElementById('cart-drawer-backdrop');

      if (drawer && backdrop) {
        drawer.classList.add('translate-x-full');
        backdrop.classList.add('opacity-0');
        setTimeout(() => {
          backdrop.classList.add('hidden');
          document.body.classList.remove('overflow-hidden');
        }, 300);
      }
    },

    add(productId, quantity = 1, options = {}) {
      if (!productId) return;

      // Pulse animation on cart icons
      document.querySelectorAll('.cart-badge-icon').forEach((icon) => {
        icon.classList.add('scale-125');
        setTimeout(() => icon.classList.remove('scale-125'), 200);
      });

      // Resolve product information for optimistic UI / title passing
      let prodName = '';
      if (options.product && options.product.name) {
        prodName = options.product.name;
      } else if (Array.isArray(window.PRODUCTS)) {
        const found = window.PRODUCTS.find((p) => p.id == productId);
        if (found) prodName = found.name;
      }

      const fd = new FormData();
      fd.append('action', 'kinboni_add_to_cart');
      fd.append('product_id', productId);
      fd.append('quantity', quantity);
      fd.append('color', options.color || 'Standard');
      fd.append('size', options.size || '');
      fd.append('title', prodName);
      if (window.kinboni && window.kinboni.nonce) {
        fd.append('nonce', window.kinboni.nonce);
      }

      fetch(window.kinboni.ajax_url, {
        method: 'POST',
        body: fd,
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success && res.data) {
            this.cartData = res.data;
            this.syncState();
            this.render();

            safeToast(res.data.message || 'Item added to shopping bag!', 'success');

            // Trigger standard WooCommerce events
            if (window.jQuery) {
              window.jQuery(document.body).trigger('added_to_cart', [res.data, null]);
              window.jQuery(document.body).trigger('wc_fragment_refresh');
            }
          } else {
            const err = (res.data && res.data.message) || 'Unable to add item to bag.';
            safeToast(err, 'error');
          }
        })
        .catch((err) => {
          console.error('[KINBONI Cart] Add error:', err);
          safeToast('Network error while adding item.', 'error');
        });
    },

    updateQuantity(keyOrId, delta) {
      if (!keyOrId) return;

      const fd = new FormData();
      fd.append('action', 'kinboni_update_cart_quantity');
      fd.append('key', keyOrId);
      fd.append('delta', delta);
      if (window.kinboni && window.kinboni.nonce) {
        fd.append('nonce', window.kinboni.nonce);
      }

      fetch(window.kinboni.ajax_url, {
        method: 'POST',
        body: fd,
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success && res.data) {
            this.cartData = res.data;
            this.syncState();
            this.render();
            if (res.data.message) {
              safeToast(res.data.message, 'info');
            }
          } else {
            const err = (res.data && res.data.message) || 'Unable to update item quantity.';
            safeToast(err, 'error');
          }
        })
        .catch((err) => {
          console.error('[KINBONI Cart] Update error:', err);
          safeToast('Network error while updating quantity.', 'error');
        });
    },

    remove(keyOrId) {
      if (!keyOrId) return;

      const fd = new FormData();
      fd.append('action', 'kinboni_remove_cart_item');
      fd.append('key', keyOrId);
      if (window.kinboni && window.kinboni.nonce) {
        fd.append('nonce', window.kinboni.nonce);
      }

      fetch(window.kinboni.ajax_url, {
        method: 'POST',
        body: fd,
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success && res.data) {
            this.cartData = res.data;
            this.syncState();
            this.render();
            safeToast(res.data.message || 'Item removed from bag', 'info');
          } else {
            const err = (res.data && res.data.message) || 'Unable to remove item.';
            safeToast(err, 'error');
          }
        })
        .catch((err) => {
          console.error('[KINBONI Cart] Remove error:', err);
          safeToast('Network error while removing item.', 'error');
        });
    },

    clear() {
      const fd = new FormData();
      fd.append('action', 'kinboni_clear_cart');
      if (window.kinboni && window.kinboni.nonce) {
        fd.append('nonce', window.kinboni.nonce);
      }

      fetch(window.kinboni.ajax_url, {
        method: 'POST',
        body: fd,
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success && res.data) {
            this.cartData = res.data;
            this.syncState();
            this.render();
            safeToast('Shopping bag cleared', 'info');
          }
        })
        .catch((err) => {
          console.error('[KINBONI Cart] Clear error:', err);
        });
    },

    applyPromo(code) {
      const cleanCode = (code ? String(code) : '').trim().toUpperCase();
      if (!cleanCode) {
        safeToast('Please enter a voucher code (try "LUXE20").', 'info');
        return;
      }

      // Optimistic update for zero-latency UI reaction
      const promoCodes = window.PROMO_CODES || { LUXE20: 0.2 };
      if (promoCodes[cleanCode]) {
        window.STATE.activePromo = cleanCode;
        try { localStorage.setItem('kinboni_active_promo', cleanCode); } catch (e) {}
        this.render();
        if (window.QuickOrderController && typeof window.QuickOrderController.updateSummary === 'function') {
          window.QuickOrderController.updateSummary();
        }
      }

      const fd = new FormData();
      fd.append('action', 'kinboni_apply_coupon');
      fd.append('code', cleanCode);
      if (window.kinboni && window.kinboni.nonce) {
        fd.append('nonce', window.kinboni.nonce);
      }

      fetch(window.kinboni.ajax_url, {
        method: 'POST',
        body: fd,
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success && res.data) {
            this.cartData = res.data;
            window.STATE.activePromo = cleanCode;
            if (res.data.applied_coupon_info) {
              window.STATE.activePromoInfo = res.data.applied_coupon_info;
            }
            try {
              localStorage.setItem('kinboni_active_promo', cleanCode);
            } catch (e) {}

            this.syncState();
            this.render();

            // Synchronize QuickOrderController modal if present
            if (window.QuickOrderController && typeof window.QuickOrderController.updateSummary === 'function') {
              window.QuickOrderController.updateSummary();
            }

            // Dispatch global event so all components react
            window.dispatchEvent(new CustomEvent('kinboni:promo_updated', { detail: { code: cleanCode, active: true } }));

            safeToast(res.data.message || `Privilege voucher "${cleanCode}" applied!`, 'success');

            const input = document.getElementById('cart-promo-input');
            if (input) input.value = '';
          } else {
            const err = (res.data && res.data.message) || `Invalid promo code. Please use "LUXE20".`;
            safeToast(err, 'error');
          }
        })
        .catch((err) => {
          console.error('[KINBONI Cart] Apply promo error:', err);
          safeToast('Network error while applying promo code.', 'error');
        });
    },

    removePromo(code) {
      const promoToRemove = code || window.STATE.activePromo || '';

      const fd = new FormData();
      fd.append('action', 'kinboni_remove_coupon');
      fd.append('code', promoToRemove);
      if (window.kinboni && window.kinboni.nonce) {
        fd.append('nonce', window.kinboni.nonce);
      }

      window.STATE.activePromo = null;
      window.STATE.activePromoInfo = null;
      try {
        localStorage.removeItem('kinboni_active_promo');
      } catch (e) {}

      fetch(window.kinboni.ajax_url, {
        method: 'POST',
        body: fd,
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success && res.data) {
            this.cartData = res.data;
          }
          this.syncState();
          this.render();

          // Synchronize QuickOrderController modal
          if (window.QuickOrderController && typeof window.QuickOrderController.updateSummary === 'function') {
            window.QuickOrderController.updateSummary();
          }

          window.dispatchEvent(new CustomEvent('kinboni:promo_updated', { detail: { code: null, active: false } }));
          safeToast('Promo code removed', 'info');
        })
        .catch((err) => {
          console.error('[KINBONI Cart] Remove promo error:', err);
          this.syncState();
          this.render();
          if (window.QuickOrderController && typeof window.QuickOrderController.updateSummary === 'function') {
            window.QuickOrderController.updateSummary();
          }
        });
    },

    buyNow(productId) {
      if (!productId) return;
      this.close();
      if (window.QuickOrderController && typeof window.QuickOrderController.orderDirect === 'function') {
        window.QuickOrderController.orderDirect(productId, 1);
      } else if (window.QuickOrderController && typeof window.QuickOrderController.open === 'function') {
        window.QuickOrderController.open(productId);
      }
    },

    checkout() {
      const items = (this.cartData && this.cartData.items) ? this.cartData.items : (window.STATE.cart || []);
      if (!items || items.length === 0) {
        safeToast('Your bag is currently empty! Please select a product.', 'error');
        return;
      }

      this.close();

      setTimeout(() => {
        if (window.QuickOrderController && typeof window.QuickOrderController.open === 'function') {
          window.QuickOrderController.open();
        }
      }, 350);
    },

    updateBadges() {
      const count = (this.cartData && typeof this.cartData.item_count === 'number')
        ? this.cartData.item_count
        : (window.STATE.cart || []).reduce((sum, item) => sum + (item.quantity || 1), 0);

      document.querySelectorAll('.cart-count-badge').forEach((badge) => {
        badge.textContent = count;
        if (count > 0) {
          badge.classList.remove('scale-0');
          badge.classList.add('scale-100');
        } else {
          badge.classList.remove('scale-100');
          badge.classList.add('scale-0');
        }
      });
    },

    render() {
      const listContainer   = document.getElementById('cart-items-container');
      const emptyState      = document.getElementById('cart-empty-state');
      const footerContainer = document.getElementById('cart-footer');
      const subtotalEl      = document.getElementById('cart-subtotal');
      const discountRow     = document.getElementById('cart-discount-row');
      const discountEl      = document.getElementById('cart-discount-amount');
      const totalEl         = document.getElementById('cart-total');
      const shippingBar     = document.getElementById('free-shipping-progress');
      const shippingText    = document.getElementById('free-shipping-text');
      const promoBadge      = document.getElementById('cart-applied-promo');
      const checkoutBtn     = document.getElementById('cart-checkout-btn');

      if (!listContainer) return;

      const items = (this.cartData && Array.isArray(this.cartData.items))
        ? this.cartData.items
        : (window.STATE.cart || []);

      const isEmpty = !items || items.length === 0;

      // ── Empty Cart State ──
      if (isEmpty) {
        listContainer.innerHTML = '';
        if (emptyState) emptyState.classList.remove('hidden');
        if (footerContainer) footerContainer.classList.add('hidden');
        if (shippingBar) shippingBar.style.width = '0%';
        if (shippingText) {
          shippingText.innerHTML = `Add <strong>${safeFormatCurrency(FREE_SHIPPING_THRESHOLD)}</strong> more for Complimentary Express Shipping`;
        }
        if (checkoutBtn) {
          checkoutBtn.disabled = true;
          checkoutBtn.classList.add('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
        }
        this.updateBadges();
        return;
      }

      // ── Active Items State ──
      if (emptyState) emptyState.classList.add('hidden');
      if (footerContainer) footerContainer.classList.remove('hidden');
      if (checkoutBtn) {
        checkoutBtn.disabled = false;
        checkoutBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
      }

      // Render Item Cards
      const itemsHtml = items.map((item) => {
        const itemKey   = item.key || item.id;
        const formattedUnitPrice = item.price_formatted || safeFormatCurrency(item.price);
        const formattedLineTotal = item.line_total_formatted || safeFormatCurrency(item.line_total || (item.price * item.quantity));
        const itemImg = item.image || (window.kinboni && window.kinboni.placeholder) || '';

        return `
        <div class="flex items-start gap-4 p-3.5 rounded-xl bg-stone-50 dark:bg-stone-800/50 border border-stone-200/60 dark:border-stone-800 transition-all">
          <img 
            src="${itemImg}" 
            alt="${item.name}" 
            class="w-20 h-24 object-cover object-center rounded-lg bg-stone-200 dark:bg-stone-900 flex-shrink-0 cursor-pointer"
            onclick="CartController.close(); if(window.QuickViewController) QuickViewController.open(${item.id});"
          />

          <div class="flex-grow min-w-0">
            <div class="flex items-start justify-between gap-2">
              <div class="min-w-0">
                <p class="text-[10px] uppercase tracking-wider font-semibold text-gold-600 dark:text-gold-400">
                  ${item.categoryLabel || 'Atelier Creation'}
                </p>
                <h4 class="font-serif text-sm font-medium text-stone-900 dark:text-stone-100 truncate cursor-pointer hover:text-gold-600 transition-colors" onclick="CartController.close(); if(window.QuickViewController) QuickViewController.open(${item.id});">
                  ${item.name}
                </h4>
              </div>
              <button 
                type="button" 
                onclick="CartController.remove('${itemKey}')"
                class="text-stone-400 hover:text-rose-500 transition-colors p-1"
                aria-label="Remove item"
              >
                <i data-lucide="trash-2" class="w-4 h-4"></i>
              </button>
            </div>

            <div class="mt-1 text-xs font-semibold text-stone-900 dark:text-stone-100">
              ${formattedUnitPrice}
            </div>

            <div class="mt-3 flex items-center justify-between">
              <!-- Quantity Stepper -->
              <div class="flex items-center border border-stone-200 dark:border-stone-700 rounded-lg bg-white dark:bg-stone-900 overflow-hidden">
                <button 
                  type="button" 
                  onclick="CartController.updateQuantity('${itemKey}', -1)"
                  class="w-7 h-7 flex items-center justify-center text-stone-600 dark:text-stone-400 hover:bg-stone-100 dark:hover:bg-stone-800 transition-colors"
                  aria-label="Decrease quantity"
                >
                  <i data-lucide="minus" class="w-3 h-3"></i>
                </button>
                <span class="w-8 text-center text-xs font-bold text-stone-900 dark:text-stone-100">
                  ${item.quantity}
                </span>
                <button 
                  type="button" 
                  onclick="CartController.updateQuantity('${itemKey}', 1)"
                  class="w-7 h-7 flex items-center justify-center text-stone-600 dark:text-stone-400 hover:bg-stone-100 dark:hover:bg-stone-800 transition-colors"
                  aria-label="Increase quantity"
                >
                  <i data-lucide="plus" class="w-3 h-3"></i>
                </button>
              </div>

              <span class="text-xs font-bold text-stone-900 dark:text-white">
                ${formattedLineTotal}
              </span>
            </div>
          </div>
        </div>
        `;
      }).join('');

      listContainer.innerHTML = itemsHtml;

      // ── Calculations & Totals from WooCommerce or Unified State ──
      const subtotal = this.cartData ? this.cartData.subtotal : items.reduce((s, i) => s + (i.price * i.quantity), 0);
      let discount   = this.cartData ? Number(this.cartData.discount_total || 0) : 0;

      const appliedCode = (this.cartData && this.cartData.coupons && this.cartData.coupons.length > 0)
        ? this.cartData.coupons[0].code
        : window.STATE?.activePromo;

      if (discount === 0 && appliedCode && subtotal > 0) {
        const promoCodes = window.PROMO_CODES || { LUXE20: 0.2 };
        const rate = (window.STATE?.activePromoInfo && window.STATE.activePromoInfo.rate) || promoCodes[appliedCode] || 0.2;
        discount = Math.round(subtotal * rate);
      }

      const total = (this.cartData && this.cartData.discount_total > 0)
        ? this.cartData.total
        : Math.max(0, subtotal - discount);

      if (subtotalEl) {
        const rawSubtotal = (this.cartData && this.cartData.subtotal_formatted) ? this.cartData.subtotal_formatted : safeFormatCurrency(subtotal);
        subtotalEl.innerHTML = stripTags(rawSubtotal);
      }

      if (discountRow && discountEl) {
        if (discount > 0) {
          discountRow.classList.remove('hidden');
          const formattedDiscount = (this.cartData && this.cartData.discount_total > 0 && this.cartData.discount_formatted)
            ? this.cartData.discount_formatted
            : safeFormatCurrency(discount);
          discountEl.innerHTML = `-${stripTags(formattedDiscount)}`;
        } else {
          discountRow.classList.add('hidden');
        }
      }

      if (totalEl) {
        const rawTotal = (this.cartData && this.cartData.discount_total > 0 && this.cartData.total_formatted)
          ? this.cartData.total_formatted
          : safeFormatCurrency(total);
        totalEl.innerHTML = stripTags(rawTotal);
      }

      // ── Applied Promo Code Pill ──
      if (promoBadge) {
        if (appliedCode && discount > 0) {
          const savingsStr = (this.cartData && this.cartData.discount_total > 0 && this.cartData.discount_formatted)
            ? this.cartData.discount_formatted
            : safeFormatCurrency(discount);

          promoBadge.innerHTML = `
            <div class="flex items-center justify-between p-2.5 rounded-xl bg-gold-50 dark:bg-gold-950/40 border border-gold-300 dark:border-gold-800 text-xs">
              <div class="flex items-center gap-1.5 text-gold-700 dark:text-gold-300 font-semibold">
                <i data-lucide="tag" class="w-3.5 h-3.5"></i>
                <span>Voucher <strong>${appliedCode}</strong> Applied • You Save <strong>${savingsStr}</strong></span>
              </div>
              <button type="button" onclick="CartController.removePromo('${appliedCode}')" class="text-stone-400 hover:text-stone-700 dark:hover:text-stone-200 p-1" aria-label="Remove promo">
                <i data-lucide="x" class="w-3.5 h-3.5"></i>
              </button>
            </div>
          `;
        } else {
          promoBadge.innerHTML = '';
        }
      }

      // ── Free Shipping Progress Bar ──
      if (shippingBar && shippingText) {
        const progress = (this.cartData && typeof this.cartData.free_shipping_progress === 'number')
          ? this.cartData.free_shipping_progress
          : Math.min(100, Math.round((subtotal / FREE_SHIPPING_THRESHOLD) * 100));

        shippingBar.style.width = `${progress}%`;

        if (subtotal >= FREE_SHIPPING_THRESHOLD) {
          shippingText.innerHTML = `🎉 <strong class="text-gold-600 dark:text-gold-400">Complimentary Express Shipping Unlocked!</strong>`;
          shippingBar.classList.add('bg-emerald-500');
          shippingBar.classList.remove('bg-gold-500');
        } else {
          const remaining = (this.cartData && typeof this.cartData.free_shipping_remaining === 'number')
            ? this.cartData.free_shipping_remaining
            : Math.max(0, FREE_SHIPPING_THRESHOLD - subtotal);
          shippingText.innerHTML = `Add <strong>${safeFormatCurrency(remaining)}</strong> more for Complimentary Express Shipping`;
          shippingBar.classList.remove('bg-emerald-500');
          shippingBar.classList.add('bg-gold-500');
        }
      }

      this.updateBadges();
      safeRefreshIcons();
    },
  };

  // Expose CartController globally
  window.CartController = CartController;
  window.KinboniPro = window.KinboniPro || {};
  window.KinboniPro.Cart = CartController;

  // Initialize once DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => CartController.init());
  } else {
    CartController.init();
  }

})(window, document);

