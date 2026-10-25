/**
 * KINBONI Pro - Utilities, State & Toast Notification Engine (Module 11)
 *
 * Provides:
 *  - Centralized Reactive State & Storage Keys
 *  - Currency Formatting (with native WooCommerce currency symbol)
 *  - Haute Atelier Toast Notifications
 *  - Lucide Icon Re-hydrator
 *  - Promotional Voucher Clipboard Copy Helper
 *  - Star Rating HTML Generator
 *  - Dynamic Storefront Product Registry
 *
 * @package KinboniPro
 */

(function(window, document) {
  'use strict';

  // 1. Centralized Storage Keys
  const STORAGE_KEYS = {
    CART: 'kinboni_cart_v2',
    WISHLIST: 'kinboni_wishlist_v2',
    THEME: 'kinboni_theme_v2',
    PROMO: 'kinboni_promo_v2',
    ANNOUNCEMENT: 'kinboni_announcement_v2',
  };

  // 2. Promotional Voucher Privileges
  const PROMO_CODES = {
    LUXE20: 0.20,
    ATELIER15: 0.15,
    ROYAL10: 0.10,
    VIP25: 0.25,
    KINBONI10: 0.10,
    WELCOME: 0.15,
  };

  const FREE_SHIPPING_THRESHOLD = 2500;

  let cachedPromo = null;
  try {
    cachedPromo = localStorage.getItem('kinboni_active_promo') || localStorage.getItem(STORAGE_KEYS.PROMO);
  } catch (e) {}

  // 3. Centralized Application State
  const STATE = window.STATE = Object.assign(window.STATE || {}, {
    cart: (window.STATE && Array.isArray(window.STATE.cart) && window.STATE.cart.length > 0) ? window.STATE.cart : [],
    wishlist: (window.STATE && Array.isArray(window.STATE.wishlist)) ? window.STATE.wishlist : [],
    activePromo: (window.STATE && window.STATE.activePromo) ? window.STATE.activePromo : (cachedPromo || null),
    activePromoInfo: (window.STATE && window.STATE.activePromoInfo) ? window.STATE.activePromoInfo : null,
    activeFilter: 'all',
    quickViewProduct: null,
  });

  // 4. Currency Formatting
  function formatCurrency(amount) {
    const symbol = (window.kinboni && (window.kinboni.currency || window.kinboni.currency_symbol)) || '৳';
    const num = Number(amount) || 0;
    return symbol + num.toLocaleString('en-US');
  }

  // 5. Lucide Icon Refresh Helper
  function refreshIcons() {
    if (window.lucide && typeof window.lucide.createIcons === 'function') {
      try {
        window.lucide.createIcons();
      } catch (e) {}
    }
  }

  // 6. Haute Atelier Toast Notifications
  function showToast(message, type = 'success') {
    let container = document.getElementById('toast-container');
    if (!container) {
      container = document.createElement('div');
      container.id = 'toast-container';
      container.className = 'fixed bottom-6 right-6 z-50 flex flex-col gap-3 pointer-events-none max-w-sm w-full px-4 sm:px-0';
      document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    const icon =
      type === 'success'
        ? 'check-circle'
        : type === 'error'
          ? 'alert-circle'
          : 'info';
    const borderColor =
      type === 'success'
        ? 'border-gold-500/50'
        : type === 'error'
          ? 'border-rose-500/50'
          : 'border-stone-500/50';

    toast.className = `flex items-center gap-3 px-4 sm:px-5 py-3 rounded-xl shadow-2xl text-xs font-semibold tracking-wide bg-stone-900/95 dark:bg-stone-100/95 text-stone-100 dark:text-stone-900 border ${borderColor} backdrop-blur-md transform translate-y-4 opacity-0 transition-all duration-300 pointer-events-auto max-w-sm`;

    toast.innerHTML = `
      <i data-lucide="${icon}" class="w-4 h-4 text-gold-400 dark:text-gold-600 flex-shrink-0"></i>
      <span class="flex-grow">${message}</span>
      <button class="opacity-60 hover:opacity-100 transition-opacity ml-2" onclick="this.parentElement.remove()" aria-label="Close notification">
        <i data-lucide="x" class="w-3.5 h-3.5"></i>
      </button>
    `;

    container.appendChild(toast);
    refreshIcons();

    requestAnimationFrame(() => {
      toast.classList.remove('translate-y-4', 'opacity-0');
    });

    setTimeout(() => {
      toast.classList.add('opacity-0', 'translate-y-2');
      setTimeout(() => toast.remove(), 350);
    }, 3500);
  }

  // 7. Voucher Clipboard Copy Helper
  function copyPromoCode(code = 'LUXE20') {
    const cleanCode = (code || 'LUXE20').trim().toUpperCase();
    if (navigator.clipboard && typeof navigator.clipboard.writeText === 'function') {
      navigator.clipboard
        .writeText(cleanCode)
        .then(() => {
          showToast(`Privilege code "${cleanCode}" copied & applied!`, 'success');
        })
        .catch(() => {
          showToast(`Code: ${cleanCode} - Privilege activated!`, 'info');
        });
    } else {
      showToast(`Code: ${cleanCode} - Privilege activated!`, 'info');
    }

    // Auto-apply promo code everywhere across the site
    if (window.CartController && typeof window.CartController.applyPromo === 'function') {
      window.CartController.applyPromo(cleanCode);
    } else if (window.QuickOrderController && typeof window.QuickOrderController.applyModalPromo === 'function') {
      window.STATE.activePromo = cleanCode;
      try { localStorage.setItem('kinboni_active_promo', cleanCode); } catch(e) {}
      if (typeof window.QuickOrderController.updateSummary === 'function') {
        window.QuickOrderController.updateSummary();
      }
    }
  }

  // 8. Star Rating HTML Generator
  function renderStarRating(rating = 5, reviewsCount = 0) {
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 >= 0.5;
    let starsHtml = '';

    for (let i = 0; i < fullStars; i++) {
      starsHtml += '<i data-lucide="star" class="w-3.5 h-3.5 fill-gold-400 text-gold-400 inline"></i>';
    }
    if (hasHalfStar) {
      starsHtml += '<i data-lucide="star-half" class="w-3.5 h-3.5 fill-gold-400 text-gold-400 inline"></i>';
    }
    const remaining = 5 - fullStars - (hasHalfStar ? 1 : 0);
    for (let i = 0; i < remaining; i++) {
      starsHtml += '<i data-lucide="star" class="w-3.5 h-3.5 text-stone-300 dark:text-stone-700 inline"></i>';
    }

    const reviewText = reviewsCount > 0 ? ` (${reviewsCount})` : '';
    return `<div class="flex items-center gap-1">${starsHtml}<span class="text-[11px] text-stone-500 ml-1 font-medium">${rating.toFixed(1)}${reviewText}</span></div>`;
  }

  // 9. Product Registry Helper
  function registerProduct(product) {
    if (!product || !product.id) return null;
    const idNum = Number(product.id) || product.id;
    window.PRODUCTS = window.PRODUCTS || [];
    const idx = window.PRODUCTS.findIndex((p) => p.id === product.id || p.id === idNum);
    const normalized = Object.assign({}, product, {
      id: idNum,
      price: typeof product.price === 'number' ? product.price : parseFloat(product.price_raw || product.price || 0),
    });
    if (idx > -1) {
      window.PRODUCTS[idx] = Object.assign({}, window.PRODUCTS[idx], normalized);
    } else {
      window.PRODUCTS.push(normalized);
    }
    return normalized;
  }

  // Export globals
  window.STORAGE_KEYS = STORAGE_KEYS;
  window.PROMO_CODES = PROMO_CODES;
  window.FREE_SHIPPING_THRESHOLD = FREE_SHIPPING_THRESHOLD;
  window.formatCurrency = formatCurrency;
  window.refreshIcons = refreshIcons;
  window.showToast = showToast;
  window.copyPromoCode = copyPromoCode;
  window.renderStarRating = renderStarRating;
  window.registerProduct = registerProduct;

  window.KinboniPro = window.KinboniPro || {};
  window.KinboniPro.Utils = {
    STORAGE_KEYS,
    PROMO_CODES,
    FREE_SHIPPING_THRESHOLD,
    formatCurrency,
    refreshIcons,
    showToast,
    copyPromoCode,
    renderStarRating,
    registerProduct,
  };

})(window, document);

