/**
 * KINBONI Pro - Master Storefront Orchestrator & Backward Compatibility Bridge (Module 12)
 *
 * Master coordinator for all Haute Atelier eCommerce modules:
 *  - Module 01: QuickOrderController (Express Cash On Delivery)
 *  - Module 02: CartController (Shopping Bag & Cart Drawer)
 *  - Module 03: WishlistController (Saved Wishlist Drawer)
 *  - Module 04: QuickViewController (Quick View Modal & Gallery)
 *  - Module 05: SearchController (Live Product Search Modal)
 *  - Module 06: ProductRenderer (Catalog & Category Filtering)
 *  - Module 07: ThemeController (Dark/Light Mode Switcher)
 *  - Module 08: LiveSalesController (Live Sales & Purchase Notifications)
 *  - Module 09: TestimonialSliderController (Swiper Testimonial Carousel)
 *  - Module 10: InteractionController (Mobile Drawer, Announcement, Sticky Header, Newsletter)
 *  - Module 11: Utilities Engine (Currency, Toast, Lucide, Promo, Ratings, State)
 *
 * @package KinboniPro
 */

(function(window, document) {
  'use strict';

  // Ensure Root Namespace
  window.KinboniPro = window.KinboniPro || {};

  // 1. Module Resolvers with Resilient Fallbacks
  const Utils = window.KinboniPro.Utils || {};
  const ThemeController = window.KinboniPro.Theme || window.ThemeController || { init() {} };
  const CartController = window.KinboniPro.Cart || window.CartController || { init() {} };
  const WishlistController = window.KinboniPro.Wishlist || window.WishlistController || { init() {} };
  const QuickViewController = window.KinboniPro.QuickView || window.QuickViewController || { init() {} };
  const SearchController = window.KinboniPro.Search || window.SearchController || { init() {} };
  const ProductRenderer = window.KinboniPro.ProductRenderer || window.ProductRenderer || { init() {}, renderFeatured() {}, renderBestSellers() {} };
  const QuickOrderController = window.KinboniPro.QuickOrder || window.QuickOrderController || { init() {} };
  const LiveSalesController = window.KinboniPro.LiveSales || window.LiveSalesController || { init() {} };
  const TestimonialSliderController = window.KinboniPro.Testimonials || window.TestimonialSliderController || { init() {}, destroy() {} };
  const InteractionController = window.KinboniPro.Interactions || window.InteractionController || { init() {} };

  // 2. Backward-Compatible Utilities
  const formatCurrency = Utils.formatCurrency || window.formatCurrency || function(amount) {
    const symbol = (window.kinboni && window.kinboni.currency_symbol) || '৳';
    return symbol + Number(amount || 0).toLocaleString('en-US');
  };

  const showToast = Utils.showToast || window.showToast || function(msg) {
    console.log('[KINBONI Toast]:', msg);
  };

  const refreshIcons = Utils.refreshIcons || window.refreshIcons || function() {
    if (window.lucide && typeof window.lucide.createIcons === 'function') {
      try { window.lucide.createIcons(); } catch (e) {}
    }
  };

  const copyPromoCode = Utils.copyPromoCode || window.copyPromoCode || function(code) {
    if (navigator.clipboard) navigator.clipboard.writeText(code);
  };

  const renderStarRating = Utils.renderStarRating || window.renderStarRating || function() {
    return '';
  };

  const registerProduct = Utils.registerProduct || window.registerProduct || function(prod) {
    if (prod && prod.id) {
      window.PRODUCTS = window.PRODUCTS || [];
      window.PRODUCTS.push(prod);
    }
    return prod;
  };

  // 3. Master Boot Sequence
  function bootKinboniApp() {
    try {
      if (typeof ThemeController.init === 'function') ThemeController.init();
      if (typeof CartController.init === 'function') CartController.init();
      if (typeof WishlistController.init === 'function') WishlistController.init();
      if (typeof QuickViewController.init === 'function') QuickViewController.init();
      if (typeof SearchController.init === 'function') SearchController.init();
      if (typeof QuickOrderController.init === 'function') QuickOrderController.init();
      if (typeof InteractionController.init === 'function') InteractionController.init();
      if (typeof LiveSalesController.init === 'function') LiveSalesController.init();
      if (typeof TestimonialSliderController.init === 'function') TestimonialSliderController.init();

      if (typeof ProductRenderer.init === 'function') {
        ProductRenderer.init();
        if (typeof ProductRenderer.renderFeatured === 'function') ProductRenderer.renderFeatured();
        if (typeof ProductRenderer.renderBestSellers === 'function') ProductRenderer.renderBestSellers('all');
      }

      refreshIcons();
    } catch (err) {
      console.warn('[KINBONI Pro] Boot initialization notice:', err);
    }
  }

  // Auto-boot on DOM Ready or immediately if already loaded
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootKinboniApp);
  } else {
    bootKinboniApp();
  }

  // 4. Export Globals for HTML Onclick Handlers and Inline Scripts
  window.CartController = CartController;
  window.WishlistController = WishlistController;
  window.QuickViewController = QuickViewController;
  window.SearchController = SearchController;
  window.ProductRenderer = ProductRenderer;
  window.ThemeController = ThemeController;
  window.QuickOrderController = QuickOrderController;
  window.LiveSalesController = LiveSalesController;
  window.TestimonialSliderController = TestimonialSliderController;
  window.InteractionController = InteractionController;

  window.formatCurrency = formatCurrency;
  window.showToast = showToast;
  window.refreshIcons = refreshIcons;
  window.copyPromoCode = copyPromoCode;
  window.renderStarRating = renderStarRating;
  window.registerProduct = registerProduct;

  // Root Namespace Attachments
  window.KinboniPro.Cart = CartController;
  window.KinboniPro.Wishlist = WishlistController;
  window.KinboniPro.QuickView = QuickViewController;
  window.KinboniPro.Search = SearchController;
  window.KinboniPro.ProductRenderer = ProductRenderer;
  window.KinboniPro.Theme = ThemeController;
  window.KinboniPro.QuickOrder = QuickOrderController;
  window.KinboniPro.LiveSales = LiveSalesController;
  window.KinboniPro.Testimonials = TestimonialSliderController;
  window.KinboniPro.Interactions = InteractionController;
  window.KinboniPro.boot = bootKinboniApp;

})(window, document);
