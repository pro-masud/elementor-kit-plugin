/**
 * KINBONI Pro — Quick View Module (Module 04: Product Quick View Modal & Gallery)
 * 
 * Powered authoritatively by WooCommerce & WP AJAX endpoint:
 *  - kinboni_quick_view
 * 
 * @package KinboniPro
 */

(function(window, document) {
  'use strict';

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

  function renderStarRating(rating, reviewsCount) {
    const score = Number(rating) || 5.0;
    const count = Number(reviewsCount) || 18;
    return `
      <div class="flex items-center gap-1 text-[11px] font-semibold text-stone-700 dark:text-stone-300 flex-shrink-0" title="${score.toFixed(1)} out of 5 stars from ${count} verified reviews">
        <svg class="w-3.5 h-3.5 text-amber-400 fill-amber-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
        </svg>
        <span>${score.toFixed(1)}</span>
        <span class="text-stone-400 dark:text-stone-500 font-normal">(${count})</span>
      </div>
    `;
  }

  function registerProduct(product) {
    if (!product || !product.id) return null;
    const idNum = Number(product.id) || product.id;
    window.PRODUCTS = window.PRODUCTS || [];
    const idx = window.PRODUCTS.findIndex((p) => p.id === product.id || p.id === idNum);
    const normalized = Object.assign({}, product, {
      id: idNum,
      price:
        typeof product.price === 'number'
          ? product.price
          : parseFloat(product.price_raw || product.price || 0),
    });
    if (idx > -1) {
      window.PRODUCTS[idx] = Object.assign({}, window.PRODUCTS[idx], normalized);
    } else {
      window.PRODUCTS.push(normalized);
    }
    return normalized;
  }

  const QuickViewController = {
    currentProduct: null,
    quantity: 1,

    init() {
      const modal = document.getElementById('quickview-modal');
      const backdrop = document.getElementById('quickview-backdrop');
      const closeBtn = document.getElementById('close-quickview-btn');

      if (backdrop) {
        backdrop.addEventListener('click', () => this.close());
      }
      if (closeBtn) {
        closeBtn.addEventListener('click', () => this.close());
      }

      window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
          this.close();
        }
      });
    },

    switchImage(index, url) {
      const mainImg = document.getElementById('quickview-main-image');
      if (mainImg) {
        mainImg.src = url;
      }

      document.querySelectorAll('.quickview-thumb-btn').forEach((btn, idx) => {
        if (idx === index) {
          btn.classList.add('border-gold-500', 'ring-2', 'ring-gold-500/30');
          btn.classList.remove('border-transparent', 'opacity-60');
        } else {
          btn.classList.remove('border-gold-500', 'ring-2', 'ring-gold-500/30');
          btn.classList.add('border-transparent', 'opacity-60');
        }
      });
    },

    openProduct(triggerOrData) {
      let product = null;

      if (triggerOrData && typeof triggerOrData === 'object' && triggerOrData.nodeType) {
        const json =
          triggerOrData.getAttribute('data-product') ||
          triggerOrData.dataset?.product ||
          triggerOrData.closest('[data-product]')?.getAttribute('data-product');
        if (json) {
          try {
            product = JSON.parse(json);
          } catch (e) {
            console.warn('[KINBONI QuickView] JSON parse error:', e);
          }
        }
      } else if (triggerOrData && typeof triggerOrData === 'object') {
        product = triggerOrData;
      }

      if (product) {
        const normalized = registerProduct(product);
        this.renderModal(normalized || product);
        return;
      }
    },

    open(productId) {
      if (!productId) return;

      // 1. Instant optimistic open if product exists in memory
      let cached = null;
      if (Array.isArray(window.PRODUCTS)) {
        cached = window.PRODUCTS.find((p) => p.id === productId || p.id === Number(productId) || p.id == productId);
      }
      if (!cached && window.kinboni && Array.isArray(window.kinboni.products)) {
        cached = window.kinboni.products.find((p) => p.id === productId || p.id === Number(productId) || p.id == productId);
      }

      if (cached) {
        this.renderModal(cached);
      }

      // 2. Fetch fresh live WooCommerce product data from server
      this.fetchAndOpen(productId, !cached);
    },

    fetchAndOpen(productId, showLoadingToast = true) {
      if (!productId) return;

      const ajaxUrl = (window.kinboni && window.kinboni.ajax_url)
        ? window.kinboni.ajax_url
        : '/wp-admin/admin-ajax.php';
      const nonce = (window.kinboni && window.kinboni.nonce)
        ? window.kinboni.nonce
        : '';

      if (showLoadingToast) {
        safeToast('Opening creation details...', 'info');
      }

      const fd = new FormData();
      fd.append('action', 'kinboni_quick_view');
      fd.append('product_id', productId);
      if (nonce) fd.append('nonce', nonce);

      fetch(ajaxUrl, {
        method: 'POST',
        body: fd,
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success && res.data) {
            const normalized = registerProduct(res.data);
            this.renderModal(normalized || res.data);
          } else {
            if (showLoadingToast) {
              safeToast((res.data && res.data.message) || 'Could not load product details.', 'error');
            }
          }
        })
        .catch((err) => {
          console.error('[KINBONI QuickView] Fetch error:', err);
        });
    },

    renderModal(product) {
      if (!product) return;
      this.currentProduct = product;
      this.quantity = 1;

      const modal = document.getElementById('quickview-modal');
      const content = document.getElementById('quickview-content');
      if (!modal || !content) return;

      const isWishlisted = (window.STATE && Array.isArray(window.STATE.wishlist))
        ? (window.STATE.wishlist.includes(product.id) || window.STATE.wishlist.includes(Number(product.id)))
        : false;

      const priceNum = typeof product.price === 'number'
        ? product.price
        : parseFloat(product.price_raw || product.price || 0);

      const origPriceNum = product.originalPrice
        ? parseFloat(product.originalPrice)
        : null;

      const discountPercent = (origPriceNum && origPriceNum > priceNum)
        ? Math.round(((origPriceNum - priceNum) / origPriceNum) * 100)
        : (product.discountPercent || 0);

      const formattedPrice = product.formattedPrice || safeFormatCurrency(priceNum);
      const formattedOrigPrice = origPriceNum ? safeFormatCurrency(origPriceNum) : '';

      const gallery = (product.gallery && Array.isArray(product.gallery) && product.gallery.length > 0)
        ? product.gallery
        : [product.image, product.hoverImage].filter(Boolean);

      const specs = (product.specs && Array.isArray(product.specs) && product.specs.length > 0)
        ? product.specs
        : [
            'Authentic Certified Craftsmanship',
            'Complimentary Insured Shipping',
            '7-Day Return Guarantee',
            'Kinboni Atelier Serial Verification'
          ];

      const catLabel = product.categoryLabel || product.badge || 'Fine Collection';
      const rating = product.rating || 5.0;
      const reviewsCount = product.reviewsCount || 18;
      const description = product.description || 'Mastercrafted with the utmost precision and artisanal heritage.';

      let galleryThumbsHtml = '';
      if (gallery.length > 1) {
        galleryThumbsHtml = `
          <div class="flex items-center justify-center gap-3">
            ${gallery.map((imgUrl, idx) => `
              <button 
                type="button" 
                onclick="QuickViewController.switchImage(${idx}, '${imgUrl}')"
                class="quickview-thumb-btn w-14 h-14 rounded-xl border-2 ${idx === 0 ? 'border-gold-500 ring-2 ring-gold-500/30' : 'border-transparent opacity-60 hover:opacity-100'} overflow-hidden shadow-sm transition-all"
                aria-label="${product.name} angle ${idx + 1}"
              >
                <img src="${imgUrl}" alt="${product.name} angle ${idx + 1}" class="w-full h-full object-cover" />
              </button>
            `).join('')}
          </div>
        `;
      }

      content.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
          <!-- Gallery with Thumbnail Switcher -->
          <div class="relative flex flex-col gap-3">
            <div class="relative aspect-[4/5] rounded-2xl overflow-hidden bg-stone-100 dark:bg-stone-950 border border-stone-200 dark:border-stone-800 shadow-md">
              <img 
                id="quickview-main-image"
                src="${gallery[0] || product.image}" 
                alt="${product.name}" 
                class="w-full h-full object-cover object-center transition-all duration-300"
              />
            </div>
            ${galleryThumbsHtml}
          </div>

          <!-- Product Specs & Actions -->
          <div class="flex flex-col">
            <div class="flex items-center justify-between mb-2">
              <span class="text-xs uppercase tracking-widest font-bold text-gold-600 dark:text-gold-400">
                ${catLabel}
              </span>
              ${renderStarRating(rating, reviewsCount)}
            </div>

            <h2 class="font-serif text-2xl sm:text-3xl font-medium text-stone-900 dark:text-stone-100 mb-2">
              ${product.name}
            </h2>

            <div class="flex items-baseline gap-3 mb-4">
              <span class="text-2xl font-bold text-stone-900 dark:text-white">
                ${formattedPrice}
              </span>
              ${(origPriceNum && discountPercent > 0) ? `
                <span class="text-base text-stone-400 dark:text-stone-500 line-through">
                  ${formattedOrigPrice}
                </span>
                <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-rose-600 text-white">
                  Save ${discountPercent}%
                </span>
              ` : ''}
            </div>

            <p class="text-sm text-stone-600 dark:text-stone-300 leading-relaxed mb-6 font-light">
              ${description}
            </p>

            <!-- Specifications Bullet Points -->
            <div class="border-t border-b border-stone-200 dark:border-stone-800 py-4 mb-6">
              <h4 class="text-xs font-bold uppercase tracking-wider text-stone-900 dark:text-stone-200 mb-2.5">
                Master Artisan Specifications
              </h4>
              <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-stone-600 dark:text-stone-400">
                ${specs.map((spec) => `
                  <li class="flex items-center gap-2">
                    <i data-lucide="check" class="w-3.5 h-3.5 text-gold-500 flex-shrink-0"></i>
                    <span>${spec}</span>
                  </li>
                `).join('')}
              </ul>
            </div>

            <!-- Quantity & Dual CTAs -->
            <div class="space-y-4">
              <div class="flex items-center gap-3">
                <!-- Stepper -->
                <div class="flex items-center border border-stone-300 dark:border-stone-700 rounded-xl bg-stone-50 dark:bg-stone-900 px-2 py-1.5">
                  <button 
                    type="button" 
                    onclick="QuickViewController.changeQty(-1)"
                    class="w-8 h-8 flex items-center justify-center text-stone-600 dark:text-stone-300 hover:text-gold-500 transition-colors"
                    aria-label="Decrease quantity"
                  >
                    <i data-lucide="minus" class="w-4 h-4"></i>
                  </button>
                  <span id="quickview-qty" class="w-8 text-center font-bold text-sm text-stone-900 dark:text-stone-100">1</span>
                  <button 
                    type="button" 
                    onclick="QuickViewController.changeQty(1)"
                    class="w-8 h-8 flex items-center justify-center text-stone-600 dark:text-stone-300 hover:text-gold-500 transition-colors"
                    aria-label="Increase quantity"
                  >
                    <i data-lucide="plus" class="w-4 h-4"></i>
                  </button>
                </div>

                <!-- Wishlist Toggle -->
                <button 
                  type="button" 
                  id="quickview-wishlist-btn"
                  onclick="WishlistController.toggle(${product.id}); QuickViewController.toggleWishlistBtn(${product.id});"
                  class="p-3 rounded-xl border border-stone-300 dark:border-stone-700 hover:border-rose-500 text-stone-700 dark:text-stone-200 transition-colors flex items-center justify-center active:scale-95"
                  aria-label="Wishlist toggle"
                >
                  <svg class="w-5 h-5 ${isWishlisted ? 'fill-rose-500 text-rose-500' : 'fill-transparent'}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                  </svg>
                </button>
              </div>

              <!-- Two Big Action Buttons -->
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <button 
                  type="button" 
                  onclick="QuickViewController.buyNow()"
                  class="w-full py-3.5 px-4 rounded-xl bg-gold-400 hover:bg-gold-500 text-stone-950 font-bold text-xs uppercase tracking-wider shadow-md hover:shadow-gold-500/25 transition-all flex items-center justify-center gap-2 active:scale-95"
                >
                  <i data-lucide="zap" class="w-4 h-4 fill-stone-950"></i>
                  <span>Direct Order (COD)</span>
                </button>
                <button 
                  type="button" 
                  onclick="QuickViewController.addToCart()"
                  class="w-full py-3.5 px-4 rounded-xl border border-stone-300 dark:border-stone-700 hover:border-gold-500 text-stone-900 dark:text-stone-100 font-bold text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-2 active:scale-95"
                >
                  <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                  <span>Add to Bag</span>
                </button>
              </div>
            </div>

            <!-- Trust Badges -->
            <div class="mt-6 pt-4 border-t border-stone-200 dark:border-stone-800 flex items-center justify-between text-[11px] text-stone-500 dark:text-stone-400">
              <span class="flex items-center gap-1.5"><i data-lucide="shield-check" class="w-3.5 h-3.5 text-gold-500"></i> Certified Authentic</span>
              <span class="flex items-center gap-1.5"><i data-lucide="truck" class="w-3.5 h-3.5 text-gold-500"></i> White-Glove Dispatch</span>
              <span class="flex items-center gap-1.5"><i data-lucide="refresh-cw" class="w-3.5 h-3.5 text-gold-500"></i> 7-Day Exchange</span>
            </div>
          </div>
        </div>
      `;

      modal.classList.remove('hidden');
      document.body.classList.add('overflow-hidden');
      safeRefreshIcons();
    },

    changeQty(delta) {
      this.quantity = Math.max(1, this.quantity + delta);
      const qtyEl = document.getElementById('quickview-qty');
      if (qtyEl) {
        qtyEl.textContent = this.quantity;
      }
    },

    addToCart() {
      if (!this.currentProduct) return;
      if (window.CartController && typeof window.CartController.add === 'function') {
        window.CartController.add(this.currentProduct.id, this.quantity);
      }
      this.close();
      if (window.CartController && typeof window.CartController.open === 'function') {
        window.CartController.open();
      }
    },

    buyNow() {
      if (!this.currentProduct) return;
      if (window.CartController && typeof window.CartController.add === 'function') {
        window.CartController.add(this.currentProduct.id, this.quantity);
      }
      this.close();
      setTimeout(() => {
        if (window.QuickOrderController && typeof window.QuickOrderController.open === 'function') {
          window.QuickOrderController.open(this.currentProduct.id);
        }
      }, 300);
    },

    toggleWishlistBtn(productId) {
      const btn = document.getElementById('quickview-wishlist-btn');
      if (!btn) return;
      const isWishlisted = (window.STATE && Array.isArray(window.STATE.wishlist))
        ? (window.STATE.wishlist.includes(productId) || window.STATE.wishlist.includes(Number(productId)))
        : false;

      btn.innerHTML = `
        <svg class="w-5 h-5 ${isWishlisted ? 'fill-rose-500 text-rose-500' : 'fill-transparent'}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
      `;
    },

    close() {
      const modal = document.getElementById('quickview-modal');
      if (modal) {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
      }
    },
  };

  // Expose globally
  window.QuickViewController = QuickViewController;
  window.registerProduct = registerProduct;
  window.renderStarRating = renderStarRating;
  window.KinboniPro = window.KinboniPro || {};
  window.KinboniPro.QuickView = QuickViewController;

  // Initialize once DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => QuickViewController.init());
  } else {
    QuickViewController.init();
  }

})(window, document);

