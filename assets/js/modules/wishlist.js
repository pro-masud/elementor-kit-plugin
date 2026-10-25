/**
 * KINBONI Pro — Wishlist Module (Module 03: Saved Wishlist Drawer)
 * 
 * Powered authoritatively by WooCommerce & WP AJAX endpoints:
 *  - kinboni_get_wishlist
 *  - kinboni_toggle_wishlist
 *  - kinboni_remove_wishlist_item
 *  - kinboni_move_wishlist_to_cart
 * 
 * @package KinboniPro
 */

(function(window, document) {
  'use strict';

  // Ensure global state container exists
  window.STATE = window.STATE || {};
  window.STATE.wishlist = window.STATE.wishlist || [];

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

  const WishlistController = {
    wishlistData: null,
    isSyncing: false,

    init() {
      // 1. Initial hydration from localized data or fallback
      if (window.kinboni && window.kinboni.wishlist) {
        this.wishlistData = window.kinboni.wishlist;
        this.syncState();
        this.render();
      } else {
        // Fetch fresh state from server
        this.fetchWishlist();
      }

      // 2. Backdrop click
      const backdrop = document.getElementById('wishlist-drawer-backdrop');
      if (backdrop) {
        backdrop.addEventListener('click', () => this.close());
      }

      // 3. Close button
      const closeBtn = document.getElementById('close-wishlist-btn');
      if (closeBtn) {
        closeBtn.addEventListener('click', () => this.close());
      }

      // 4. Escape key
      window.addEventListener('keydown', (e) => {
        const drawer = document.getElementById('wishlist-drawer');
        if (e.key === 'Escape' && drawer && !drawer.classList.contains('translate-x-full')) {
          this.close();
        }
      });

      // 5. Drawer open trigger buttons (.open-wishlist-btn)
      document.querySelectorAll('.open-wishlist-btn').forEach((btn) => {
        btn.addEventListener('click', (e) => {
          e.preventDefault();
          this.open();
        });
      });

      this.updateHeartButtons();
    },

    getWishlistData() {
      return this.wishlistData;
    },

    syncState() {
      if (!this.wishlistData) return;

      const ids = Array.isArray(this.wishlistData.item_ids)
        ? this.wishlistData.item_ids
        : (this.wishlistData.items || []).map((i) => i.id);

      window.STATE.wishlist = ids;

      // Save to localStorage as quick hydration fallback
      try {
        localStorage.setItem('kinboni_wishlist_v2', JSON.stringify(ids));
      } catch (e) {}

      this.updateBadges();
      this.updateHeartButtons();
    },

    fetchWishlist(triggerRender = true) {
      if (!window.kinboni || !window.kinboni.ajax_url) return;

      const fd = new FormData();
      fd.append('action', 'kinboni_get_wishlist');
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
            this.wishlistData = res.data;
            this.syncState();
            if (triggerRender) this.render();
          }
        })
        .catch((err) => {
          console.warn('[KINBONI Wishlist] Sync error:', err);
        });
    },

    open() {
      // Close mobile menu or cart if open
      if (window.InteractionController && typeof window.InteractionController.closeMobileMenu === 'function') {
        window.InteractionController.closeMobileMenu();
      }
      if (window.CartController && typeof window.CartController.close === 'function') {
        window.CartController.close();
      }

      const drawer = document.getElementById('wishlist-drawer');
      const backdrop = document.getElementById('wishlist-drawer-backdrop');

      this.render();

      if (drawer && backdrop) {
        backdrop.classList.remove('hidden');
        requestAnimationFrame(() => {
          backdrop.classList.remove('opacity-0');
          drawer.classList.remove('translate-x-full');
        });
        document.body.classList.add('overflow-hidden');
      }

      safeRefreshIcons();
    },

    close() {
      const drawer = document.getElementById('wishlist-drawer');
      const backdrop = document.getElementById('wishlist-drawer-backdrop');

      if (drawer && backdrop) {
        drawer.classList.add('translate-x-full');
        backdrop.classList.add('opacity-0');
        setTimeout(() => {
          backdrop.classList.add('hidden');
          document.body.classList.remove('overflow-hidden');
        }, 300);
      }
    },

    toggle(productId) {
      if (!productId) return;

      const pidNum = Number(productId) || productId;

      // Optimistic UI update
      const currentList = Array.isArray(window.STATE.wishlist) ? window.STATE.wishlist : [];
      const isCurrentlyWishlisted = currentList.includes(pidNum) || currentList.includes(productId);

      if (isCurrentlyWishlisted) {
        window.STATE.wishlist = currentList.filter((id) => id != pidNum && id != productId);
      } else {
        window.STATE.wishlist = [...currentList, pidNum];
      }
      if (this.wishlistData) {
        this.wishlistData.count = window.STATE.wishlist.length;
        this.wishlistData.item_ids = window.STATE.wishlist;
      }
      this.updateBadges();
      this.updateHeartButtons();

      const fd = new FormData();
      fd.append('action', 'kinboni_toggle_wishlist');
      fd.append('product_id', productId);
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
            this.wishlistData = res.data;
            this.syncState();
            this.render();

            const toastType = res.data.action === 'added' ? 'success' : 'info';
            safeToast(res.data.message || (res.data.action === 'added' ? 'Saved to wishlist' : 'Removed from wishlist'), toastType);

            // Re-render product grids if they rely on local rendering
            if (window.ProductRenderer) {
              if (typeof window.ProductRenderer.renderFeatured === 'function') {
                window.ProductRenderer.renderFeatured();
              }
              if (typeof window.ProductRenderer.renderBestSellers === 'function') {
                window.ProductRenderer.renderBestSellers(window.STATE.activeFilter || 'all');
              }
            }
          } else {
            const err = (res.data && res.data.message) || 'Unable to update wishlist.';
            safeToast(err, 'error');
          }
        })
        .catch((err) => {
          console.error('[KINBONI Wishlist] Toggle error:', err);
          safeToast('Network error while updating wishlist.', 'error');
        });
    },

    remove(productId) {
      if (!productId) return;

      const fd = new FormData();
      fd.append('action', 'kinboni_remove_wishlist_item');
      fd.append('product_id', productId);
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
            this.wishlistData = res.data;
            this.syncState();
            this.render();
            safeToast(res.data.message || 'Removed from wishlist', 'info');
          }
        })
        .catch((err) => {
          console.error('[KINBONI Wishlist] Remove error:', err);
        });
    },

    moveToBag(productId) {
      if (!productId) return;

      const fd = new FormData();
      fd.append('action', 'kinboni_move_wishlist_to_cart');
      fd.append('product_id', productId);
      fd.append('quantity', 1);
      if (window.kinboni && window.kinboni.nonce) {
        fd.append('nonce', window.kinboni.nonce);
      }

      // Pulse animation on cart icons
      document.querySelectorAll('.cart-badge-icon').forEach((icon) => {
        icon.classList.add('scale-125');
        setTimeout(() => icon.classList.remove('scale-125'), 200);
      });

      fetch(window.kinboni.ajax_url, {
        method: 'POST',
        body: fd,
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success && res.data) {
            // 1. Update Wishlist
            this.wishlistData = res.data.wishlist;
            this.syncState();
            this.render();

            // 2. Update Cart Controller
            if (window.CartController) {
              window.CartController.cartData = res.data.cart;
              if (typeof window.CartController.syncState === 'function') {
                window.CartController.syncState();
              }
              if (typeof window.CartController.render === 'function') {
                window.CartController.render();
              }
            }

            safeToast(res.data.message || 'Moved item to shopping bag!', 'success');

            // Trigger standard WooCommerce events
            if (window.jQuery) {
              window.jQuery(document.body).trigger('added_to_cart', [res.data.cart, null]);
              window.jQuery(document.body).trigger('wc_fragment_refresh');
            }
          } else {
            const err = (res.data && res.data.message) || 'Unable to move item to bag.';
            safeToast(err, 'error');
          }
        })
        .catch((err) => {
          console.error('[KINBONI Wishlist] MoveToBag error:', err);
          safeToast('Network error while moving item to bag.', 'error');
        });
    },

    // Alias for MoveToBag
    moveToCart(productId) {
      this.moveToBag(productId);
    },

    has(productId) {
      const pidNum = Number(productId) || productId;
      const list = Array.isArray(window.STATE?.wishlist) ? window.STATE.wishlist : [];
      return list.includes(pidNum) || list.includes(productId);
    },

    isWishlisted(productId) {
      return this.has(productId);
    },

    updateBadges() {
      const count = (this.wishlistData && typeof this.wishlistData.count === 'number')
        ? this.wishlistData.count
        : (window.STATE.wishlist || []).length;

      document.querySelectorAll('.wishlist-count-badge').forEach((badge) => {
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

    updateHeartButtons() {
      const wishlistedIds = (this.wishlistData && Array.isArray(this.wishlistData.item_ids))
        ? this.wishlistData.item_ids
        : (window.STATE.wishlist || []);

      // 1. QuickView modal wishlist button
      const qvBtn = document.getElementById('quickview-wishlist-btn');
      if (qvBtn && window.QuickViewController && window.QuickViewController.currentProduct) {
        const curId = window.QuickViewController.currentProduct.id;
        const isWish = wishlistedIds.includes(curId) || wishlistedIds.includes(Number(curId));
        const svg = qvBtn.querySelector('svg');
        if (svg) {
          if (isWish) {
            svg.classList.add('fill-rose-500', 'text-rose-500');
            svg.classList.remove('fill-transparent');
          } else {
            svg.classList.remove('fill-rose-500', 'text-rose-500');
            svg.classList.add('fill-transparent');
          }
        }
      }

      // 2. Storefront product cards wishlist buttons
      document.querySelectorAll('button[onclick*="WishlistController.toggle"]').forEach((btn) => {
        const onclickAttr = btn.getAttribute('onclick') || '';
        const match = onclickAttr.match(/toggle\((\d+)\)/);
        if (match) {
          const btnPid = Number(match[1]);
          const isWish = wishlistedIds.includes(btnPid);
          const svg = btn.querySelector('svg');
          if (svg) {
            if (isWish) {
              svg.classList.add('fill-rose-500', 'text-rose-500');
              svg.classList.remove('fill-transparent');
            } else {
              svg.classList.remove('fill-rose-500', 'text-rose-500');
              svg.classList.add('fill-transparent');
            }
          }
          btn.setAttribute('aria-label', isWish ? 'Remove from wishlist' : 'Save to wishlist');
        }
      });
    },

    render() {
      const container  = document.getElementById('wishlist-items-container');
      const emptyState = document.getElementById('wishlist-empty-state');
      if (!container) return;

      const items = (this.wishlistData && Array.isArray(this.wishlistData.items))
        ? this.wishlistData.items
        : [];

      // If items not populated from server yet, check PRODUCTS fallback
      let displayItems = items;
      if (displayItems.length === 0 && Array.isArray(window.STATE.wishlist) && window.STATE.wishlist.length > 0 && Array.isArray(window.PRODUCTS)) {
        displayItems = window.STATE.wishlist.map((id) => {
          return window.PRODUCTS.find((p) => p.id == id);
        }).filter(Boolean);
      }

      if (!displayItems || displayItems.length === 0) {
        container.innerHTML = '';
        if (emptyState) emptyState.classList.remove('hidden');
        this.updateBadges();
        return;
      }

      if (emptyState) emptyState.classList.add('hidden');

      const html = displayItems.map((product) => {
        const itemImg = product.image || (window.kinboni && window.kinboni.placeholder) || '';
        const priceFormatted = product.formattedPrice || safeFormatCurrency(product.price);

        return `
        <div class="flex items-center gap-4 p-3.5 rounded-xl bg-stone-50 dark:bg-stone-800/50 border border-stone-200/60 dark:border-stone-800 transition-all">
          <img 
            src="${itemImg}" 
            alt="${product.name}" 
            class="w-16 h-20 object-cover object-center rounded-lg bg-stone-200 dark:bg-stone-900 flex-shrink-0 cursor-pointer"
            onclick="WishlistController.close(); if(window.QuickViewController) QuickViewController.open(${product.id});"
          />
          <div class="flex-grow min-w-0">
            <h4 class="font-serif text-sm font-medium text-stone-900 dark:text-stone-100 truncate mb-1 cursor-pointer hover:text-gold-600 transition-colors" onclick="WishlistController.close(); if(window.QuickViewController) QuickViewController.open(${product.id});">
              ${product.name}
            </h4>
            <div class="text-xs font-bold text-stone-900 dark:text-stone-100 mb-2">
              ${priceFormatted}
            </div>
            <div class="flex items-center gap-2">
              <button 
                type="button" 
                onclick="WishlistController.moveToBag(${product.id})"
                class="px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider bg-gold-400 hover:bg-gold-500 text-stone-950 rounded-lg transition-colors shadow-sm active:scale-95"
              >
                Move to Bag
              </button>
              <button 
                type="button" 
                onclick="WishlistController.toggle(${product.id})"
                class="text-xs text-stone-400 hover:text-rose-500 transition-colors p-1.5"
                aria-label="Remove from wishlist"
              >
                <i data-lucide="trash-2" class="w-4 h-4"></i>
              </button>
            </div>
          </div>
        </div>
        `;
      }).join('');

      container.innerHTML = html;
      this.updateBadges();
      this.updateHeartButtons();
      safeRefreshIcons();
    },
  };

  // Expose globally
  window.WishlistController = WishlistController;
  window.KinboniPro = window.KinboniPro || {};
  window.KinboniPro.Wishlist = WishlistController;

  // Initialize once DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => WishlistController.init());
  } else {
    WishlistController.init();
  }

})(window, document);
