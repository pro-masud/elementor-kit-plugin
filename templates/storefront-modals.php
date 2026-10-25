<?php
/**
 * Storefront Modals, Drawers, and Global Interaction Overlays.
 *
 * Includes:
 *  1. Cart Slide-Out Drawer
 *  2. Wishlist Slide-Out Drawer
 *  3. Product Quick View Modal
 *  4. Search Modal Overlay
 *  5. Mobile Navigation Menu Drawer
 *  6. Fast 3-Field Quick Order Checkout Modal
 *  7. Live Recent Sales Social Proof Popup
 *  8. Back to Top Floating Button
 *  9. Toast Notification Container
 *
 * @package KinboniPro
 */

defined( 'ABSPATH' ) || exit;
?>

<!-- 1. CART SLIDE-OUT DRAWER -->
<div id="cart-drawer-backdrop" class="fixed inset-0 z-50 bg-stone-950/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300"></div>
<aside id="cart-drawer" class="fixed inset-y-0 right-0 z-50 w-full max-w-md bg-white dark:bg-stone-900 shadow-2xl transform translate-x-full transition-transform duration-300 ease-out flex flex-col border-l border-stone-200 dark:border-stone-800">
  <div class="p-5 border-b border-stone-200 dark:border-stone-800 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <i data-lucide="shopping-bag" class="w-5 h-5 text-gold-600 dark:text-gold-400"></i>
      <h3 class="font-serif text-lg font-medium text-stone-900 dark:text-white"><?php esc_html_e( 'Shopping Bag', 'kinboni-pro' ); ?></h3>
    </div>
    <button type="button" id="close-cart-btn" class="w-8 h-8 rounded-full flex items-center justify-center text-stone-400 hover:text-stone-900 dark:hover:text-white hover:bg-stone-100 dark:hover:bg-stone-800 transition-colors" aria-label="Close cart">
      <i data-lucide="x" class="w-5 h-5"></i>
    </button>
  </div>

  <div class="px-5 py-3.5 bg-stone-50 dark:bg-stone-950 border-b border-stone-200 dark:border-stone-800">
    <p id="free-shipping-text" class="text-xs text-stone-600 dark:text-stone-300 mb-1.5 font-medium">
      <?php printf( esc_html__( 'Add %s more for Complimentary Express Shipping', 'kinboni-pro' ), '<strong>৳2,500</strong>' ); ?>
    </p>
    <div class="w-full h-1.5 bg-stone-200 dark:bg-stone-800 rounded-full overflow-hidden">
      <div id="free-shipping-progress" class="h-full bg-gold-500 rounded-full transition-all duration-500" style="width: 0%"></div>
    </div>
  </div>

  <div id="cart-items-container" class="flex-grow overflow-y-auto p-5 space-y-4"></div>

  <div id="cart-empty-state" class="hidden flex-grow flex flex-col items-center justify-center p-8 text-center">
    <div class="w-16 h-16 rounded-full bg-stone-100 dark:bg-stone-800 flex items-center justify-center text-stone-400 mb-4">
      <i data-lucide="shopping-bag" class="w-8 h-8"></i>
    </div>
    <h4 class="font-serif text-lg font-medium text-stone-900 dark:text-white mb-2"><?php esc_html_e( 'Your Bag is Empty', 'kinboni-pro' ); ?></h4>
    <p class="text-xs text-stone-500 dark:text-stone-400 max-w-xs mb-6 font-light">
      <?php esc_html_e( 'Explore our curated horology and artisanal leather collections to begin your order.', 'kinboni-pro' ); ?>
    </p>
    <button type="button" onclick="CartController.close()" class="px-6 py-3 rounded-xl bg-gold-400 hover:bg-gold-500 text-stone-950 text-xs font-bold uppercase tracking-widest transition-all">
      <?php esc_html_e( 'Explore Creations', 'kinboni-pro' ); ?>
    </button>
  </div>

  <div id="cart-footer" class="p-5 border-t border-stone-200 dark:border-stone-800 bg-stone-50/50 dark:bg-stone-950/50 space-y-4">
    <form id="cart-promo-form" class="flex gap-2">
      <input 
        type="text" 
        id="cart-promo-input" 
        placeholder="<?php esc_attr_e( 'Promo code (try LUXE20)', 'kinboni-pro' ); ?>" 
        aria-label="Enter promotional voucher code"
        class="flex-grow px-3.5 py-2.5 text-xs uppercase rounded-xl border border-stone-200 dark:border-stone-700 bg-white dark:bg-stone-900 text-stone-900 dark:text-stone-100 focus:outline-none focus:border-gold-500"
      />
      <button type="submit" class="px-4 py-2.5 bg-stone-900 text-white dark:bg-white dark:text-stone-900 text-xs font-bold uppercase rounded-xl hover:bg-gold-500 hover:text-stone-950 transition-colors">
        <?php esc_html_e( 'Apply', 'kinboni-pro' ); ?>
      </button>
    </form>

    <div id="cart-applied-promo"></div>

    <div class="space-y-1.5 text-xs">
      <div class="flex justify-between text-stone-600 dark:text-stone-400">
        <span><?php esc_html_e( 'Subtotal', 'kinboni-pro' ); ?></span>
        <span id="cart-subtotal" class="font-semibold text-stone-900 dark:text-white">৳0</span>
      </div>
      <div id="cart-discount-row" class="hidden flex justify-between text-emerald-600 dark:text-emerald-400 font-semibold">
        <span><?php esc_html_e( 'Privilege Discount', 'kinboni-pro' ); ?></span>
        <span id="cart-discount-amount">-৳0</span>
      </div>
      <div class="flex justify-between text-stone-600 dark:text-stone-400">
        <span><?php esc_html_e( 'Express White-Glove Shipping', 'kinboni-pro' ); ?></span>
        <span class="font-semibold text-emerald-600 dark:text-emerald-400"><?php esc_html_e( 'COMPLIMENTARY', 'kinboni-pro' ); ?></span>
      </div>
      <div class="flex justify-between text-base font-bold text-stone-900 dark:text-white pt-2 border-t border-stone-200 dark:border-stone-800">
        <span><?php esc_html_e( 'Estimated Total', 'kinboni-pro' ); ?></span>
        <span id="cart-total">৳0</span>
      </div>
    </div>

    <button 
      id="cart-checkout-btn" 
      type="button" 
      class="w-full py-3.5 bg-gold-400 hover:bg-gold-500 text-stone-950 text-xs font-bold uppercase tracking-[0.15em] rounded-xl shadow-lg hover:shadow-gold-500/25 transition-all text-center flex items-center justify-center gap-2 active:scale-95"
    >
      <i data-lucide="lock" class="w-4 h-4"></i>
      <span><?php esc_html_e( 'Proceed to Secure Checkout', 'kinboni-pro' ); ?></span>
    </button>

    <p class="text-[10px] text-center text-stone-400">
      <?php esc_html_e( 'Encrypted with 256-bit bank-grade SSL security.', 'kinboni-pro' ); ?>
    </p>
  </div>
</aside>

<!-- 2. WISHLIST SLIDE-OUT DRAWER -->
<div id="wishlist-drawer-backdrop" class="fixed inset-0 z-50 bg-stone-950/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300"></div>
<aside id="wishlist-drawer" class="fixed inset-y-0 right-0 z-50 w-full max-w-md bg-white dark:bg-stone-900 shadow-2xl transform translate-x-full transition-transform duration-300 ease-out flex flex-col border-l border-stone-200 dark:border-stone-800">
  <div class="p-5 border-b border-stone-200 dark:border-stone-800 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <i data-lucide="heart" class="w-5 h-5 text-rose-500"></i>
      <h3 class="font-serif text-lg font-medium text-stone-900 dark:text-white"><?php esc_html_e( 'Your Saved Wishlist', 'kinboni-pro' ); ?></h3>
    </div>
    <button type="button" id="close-wishlist-btn" class="w-8 h-8 rounded-full flex items-center justify-center text-stone-400 hover:text-stone-900 dark:hover:text-white hover:bg-stone-100 dark:hover:bg-stone-800 transition-colors" aria-label="Close wishlist">
      <i data-lucide="x" class="w-5 h-5"></i>
    </button>
  </div>

  <div id="wishlist-items-container" class="flex-grow overflow-y-auto p-5 space-y-4"></div>

  <div id="wishlist-empty-state" class="hidden flex-grow flex flex-col items-center justify-center p-8 text-center">
    <div class="w-16 h-16 rounded-full bg-stone-100 dark:bg-stone-800 flex items-center justify-center text-stone-400 mb-4">
      <i data-lucide="heart" class="w-8 h-8"></i>
    </div>
    <h4 class="font-serif text-lg font-medium text-stone-900 dark:text-white mb-2"><?php esc_html_e( 'No Saved Creations', 'kinboni-pro' ); ?></h4>
    <p class="text-xs text-stone-500 dark:text-stone-400 max-w-xs mb-6 font-light">
      <?php esc_html_e( 'Click the heart icon on any creation to bookmark it for later consideration.', 'kinboni-pro' ); ?>
    </p>
    <button type="button" onclick="WishlistController.close()" class="px-6 py-3 rounded-xl bg-stone-900 text-white dark:bg-white dark:text-stone-900 text-xs font-bold uppercase tracking-widest transition-all">
      <?php esc_html_e( 'Browse Catalogue', 'kinboni-pro' ); ?>
    </button>
  </div>
</aside>

<!-- 3. PRODUCT QUICK VIEW MODAL -->
<div id="quickview-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
  <div id="quickview-backdrop" class="fixed inset-0 bg-stone-950/70 backdrop-blur-md"></div>
  <div class="relative w-full max-w-4xl max-h-[92vh] overflow-y-auto bg-white dark:bg-stone-900 rounded-3xl shadow-2xl border border-stone-200 dark:border-stone-800 p-6 sm:p-8 z-10 animate-slide-up">
    <button type="button" id="close-quickview-btn" class="absolute top-4 right-4 w-9 h-9 rounded-full text-stone-400 hover:text-stone-900 dark:hover:text-white bg-stone-100 dark:bg-stone-800 flex items-center justify-center transition-colors" aria-label="Close modal">
      <i data-lucide="x" class="w-5 h-5"></i>
    </button>
    <div id="quickview-content"></div>
  </div>
</div>

<!-- 4. SEARCH MODAL OVERLAY -->
<div id="search-modal" class="fixed inset-0 z-50 hidden flex flex-col justify-start p-4 sm:p-6 md:p-12">
  <div id="search-backdrop" class="fixed inset-0 bg-stone-950/80 backdrop-blur-md"></div>
  <div class="relative w-full max-w-3xl mx-auto bg-white dark:bg-stone-900 rounded-2xl shadow-2xl border border-stone-200 dark:border-stone-800 overflow-hidden z-10 animate-slide-down">
    <div class="p-5 border-b border-stone-200 dark:border-stone-800 flex items-center gap-3">
      <i data-lucide="search" class="w-5 h-5 text-gold-500 flex-shrink-0"></i>
      <input 
        type="text" 
        id="search-input" 
        placeholder="<?php esc_attr_e( 'Search by timepiece, leather, fragrance, gold, silk...', 'kinboni-pro' ); ?>" 
        aria-label="Search Kinboni Atelier creations"
        class="flex-grow bg-transparent text-stone-900 dark:text-stone-100 placeholder:text-stone-400 text-sm sm:text-base focus:outline-none"
      />
      <button type="button" id="close-search-btn" class="w-8 h-8 rounded-full flex items-center justify-center text-stone-400 hover:text-stone-900 dark:hover:text-white transition-colors" aria-label="Close search">
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>
    </div>

    <div class="px-5 py-3 bg-stone-50 dark:bg-stone-950 border-b border-stone-200 dark:border-stone-800 flex items-center gap-2 flex-wrap text-xs">
      <span class="text-stone-500 font-medium"><?php esc_html_e( 'Suggestions:', 'kinboni-pro' ); ?></span>
      <button type="button" class="search-suggestion-tag px-3 py-1 rounded-full bg-stone-200/80 dark:bg-stone-800 text-stone-700 dark:text-stone-300 hover:bg-gold-500 hover:text-stone-950 transition-colors font-medium" data-query="Timepiece">Timepieces</button>
      <button type="button" class="search-suggestion-tag px-3 py-1 rounded-full bg-stone-200/80 dark:bg-stone-800 text-stone-700 dark:text-stone-300 hover:bg-gold-500 hover:text-stone-950 transition-colors font-medium" data-query="Leather">Leather Goods</button>
      <button type="button" class="search-suggestion-tag px-3 py-1 rounded-full bg-stone-200/80 dark:bg-stone-800 text-stone-700 dark:text-stone-300 hover:bg-gold-500 hover:text-stone-950 transition-colors font-medium" data-query="Oud">Oud & Fragrance</button>
      <button type="button" class="search-suggestion-tag px-3 py-1 rounded-full bg-stone-200/80 dark:bg-stone-800 text-stone-700 dark:text-stone-300 hover:bg-gold-500 hover:text-stone-950 transition-colors font-medium" data-query="Silk">Silk & Cashmere</button>
    </div>

    <div class="p-6 max-h-[60vh] overflow-y-auto">
      <div class="flex items-center justify-between mb-4">
        <span id="search-count" class="text-xs uppercase font-bold tracking-wider text-stone-500"><?php esc_html_e( 'Live Atelier Search', 'kinboni-pro' ); ?></span>
      </div>
      <div id="search-results-container"></div>
    </div>
  </div>
</div>

<!-- 5. MOBILE NAVIGATION MENU DRAWER -->
<div id="mobile-menu-backdrop" class="fixed inset-0 z-50 bg-stone-950/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300"></div>
<aside id="mobile-menu-drawer" class="fixed inset-y-0 left-0 z-50 w-full max-w-xs bg-white dark:bg-stone-900 shadow-2xl transform -translate-x-full transition-transform duration-300 ease-out flex flex-col border-r border-stone-200 dark:border-stone-800">
  <div class="p-5 border-b border-stone-200 dark:border-stone-800 flex items-center justify-between">
    <div>
      <span class="font-serif text-xl font-bold tracking-[0.2em] text-stone-900 dark:text-white uppercase">KINBONI</span>
      <span class="block text-[8px] uppercase tracking-[0.3em] text-gold-600 dark:text-gold-400 font-semibold">Haute Atelier</span>
    </div>
    <button type="button" id="close-mobile-menu-btn" class="w-8 h-8 rounded-full flex items-center justify-center text-stone-400 hover:text-stone-900 dark:hover:text-white transition-colors" aria-label="Close menu">
      <i data-lucide="x" class="w-5 h-5"></i>
    </button>
  </div>

  <nav class="flex-grow p-6 space-y-4">
    <a href="#hero" class="mobile-nav-link block font-serif text-lg font-medium text-stone-900 dark:text-stone-100 hover:text-gold-600 transition-colors">Home</a>
    <a href="#categories" class="mobile-nav-link block font-serif text-lg font-medium text-stone-900 dark:text-stone-100 hover:text-gold-600 transition-colors">Collections</a>
    <a href="#featured" class="mobile-nav-link block font-serif text-lg font-medium text-stone-900 dark:text-stone-100 hover:text-gold-600 transition-colors">Featured Shop</a>
    <a href="#bestsellers" class="mobile-nav-link block font-serif text-lg font-medium text-stone-900 dark:text-stone-100 hover:text-gold-600 transition-colors">Best Sellers</a>
    <a href="#heritage" class="mobile-nav-link block font-serif text-lg font-medium text-stone-900 dark:text-stone-100 hover:text-gold-600 transition-colors">Our Story</a>
    <a href="#testimonials" class="mobile-nav-link block font-serif text-lg font-medium text-stone-900 dark:text-stone-100 hover:text-gold-600 transition-colors">Patron Reviews</a>
    
    <div class="pt-6 border-t border-stone-200 dark:border-stone-800 space-y-3">
      <button type="button" onclick="CartController.open()" class="w-full flex items-center justify-between py-2 text-xs uppercase font-bold tracking-wider text-stone-700 dark:text-stone-300 hover:text-gold-600">
        <span class="flex items-center gap-2"><i data-lucide="shopping-bag" class="w-4 h-4"></i> Shopping Bag</span>
        <span class="cart-count-badge px-2 py-0.5 rounded-full bg-gold-400 text-stone-950 font-bold text-[10px]">0</span>
      </button>

      <button type="button" onclick="WishlistController.open()" class="w-full flex items-center justify-between py-2 text-xs uppercase font-bold tracking-wider text-stone-700 dark:text-stone-300 hover:text-gold-600">
        <span class="flex items-center gap-2"><i data-lucide="heart" class="w-4 h-4 text-rose-500"></i> Wishlist</span>
        <span class="wishlist-count-badge px-2 py-0.5 rounded-full bg-rose-600 text-white font-bold text-[10px]">0</span>
      </button>

      <button type="button" class="theme-toggle-btn w-full flex items-center justify-between py-2 text-xs uppercase font-bold tracking-wider text-stone-700 dark:text-stone-300">
        <span>Appearance</span>
        <span class="flex items-center gap-1.5 text-gold-600 dark:text-gold-400">
          <i data-lucide="sun" class="theme-sun-icon w-4 h-4 hidden"></i>
          <i data-lucide="moon" class="theme-moon-icon w-4 h-4"></i>
          <span>Switch Theme</span>
        </span>
      </button>
    </div>
  </nav>

  <div class="p-5 border-t border-stone-200 dark:border-stone-800 bg-stone-50 dark:bg-stone-950 text-xs text-stone-500">
    <p class="font-serif italic text-stone-700 dark:text-stone-300">"Crafted for the Connoisseur."</p>
    <p class="text-[10px] mt-1">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Kinboni Atelier</p>
  </div>
</aside>

<!-- 6. FAST 3-FIELD QUICK ORDER CHECKOUT MODAL -->
<div id="checkout-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-3 sm:p-4 md:p-6">
  <div id="checkout-backdrop" class="fixed inset-0 bg-stone-950/75 backdrop-blur-md"></div>
  
  <div class="relative w-full max-w-4xl lg:max-w-5xl max-h-[92vh] flex flex-col bg-white dark:bg-stone-900 rounded-3xl shadow-2xl border border-stone-200 dark:border-stone-800 z-10 animate-slide-up overflow-hidden">
    <div id="checkout-form-view" class="flex flex-col max-h-[92vh] overflow-y-auto">
      <div class="px-6 py-4 sm:px-8 sm:py-5 border-b border-stone-200 dark:border-stone-800 flex items-center justify-between bg-stone-50/60 dark:bg-stone-950/60 sticky top-0 z-20 backdrop-blur-md flex-shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-2xl bg-gold-400/20 text-gold-600 dark:text-gold-400 flex items-center justify-center flex-shrink-0">
            <i data-lucide="zap" class="w-5 h-5 fill-gold-500"></i>
          </div>
          <div>
            <h3 class="font-serif text-xl sm:text-2xl font-semibold text-stone-900 dark:text-white"><?php esc_html_e( 'Confirm Your Order', 'kinboni-pro' ); ?></h3>
            <p class="text-xs text-stone-500 dark:text-stone-400 font-light hidden sm:block"><?php esc_html_e( 'Pay cash when package arrives at your doorstep • Zero advance payment', 'kinboni-pro' ); ?></p>
          </div>
        </div>
        <button id="close-checkout-modal-btn" type="button" class="w-9 h-9 rounded-full flex items-center justify-center text-stone-400 hover:text-stone-900 dark:hover:text-white bg-stone-100 dark:bg-stone-800 transition-colors" aria-label="Close modal">
          <i data-lucide="x" class="w-5 h-5"></i>
        </button>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 min-h-0">
        <div class="lg:col-span-5 p-6 sm:p-7 bg-stone-50/70 dark:bg-stone-950/70 lg:border-r border-stone-200 dark:border-stone-800 flex flex-col justify-between space-y-6">
          <div class="space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-stone-200 dark:border-stone-800">
              <span class="text-xs font-bold uppercase tracking-wider text-stone-600 dark:text-stone-400"><?php esc_html_e( 'Order Items', 'kinboni-pro' ); ?></span>
              <span class="text-[11px] text-gold-600 dark:text-gold-400 font-medium"><?php esc_html_e( 'Bespoke Selection', 'kinboni-pro' ); ?></span>
            </div>
            <div id="checkout-items-preview" class="space-y-2.5 max-h-56 overflow-y-auto pr-1"></div>

            <div class="pt-3 border-t border-stone-200 dark:border-stone-800">
              <label for="order-modal-promo-input" class="block text-xs font-bold uppercase tracking-wider text-stone-800 dark:text-stone-200 mb-1.5">
                <?php esc_html_e( 'Have a Privilege Voucher?', 'kinboni-pro' ); ?>
              </label>
              <div class="flex gap-2">
                <input 
                  type="text" 
                  id="order-modal-promo-input" 
                  placeholder="<?php esc_attr_e( 'Voucher code (try LUXE20)', 'kinboni-pro' ); ?>" 
                  class="flex-grow px-3.5 py-2 text-xs uppercase rounded-xl border border-stone-300 dark:border-stone-700 bg-white dark:bg-stone-900 text-stone-900 dark:text-stone-100 focus:outline-none focus:border-gold-500"
                />
                <button 
                  type="button" 
                  onclick="QuickOrderController.applyModalPromo()"
                  class="px-4 py-2 bg-stone-900 text-white dark:bg-white dark:text-stone-900 text-xs font-bold uppercase rounded-xl hover:bg-gold-500 hover:text-stone-950 transition-colors flex-shrink-0"
                >
                  <?php esc_html_e( 'Apply', 'kinboni-pro' ); ?>
                </button>
              </div>
              <div id="order-modal-applied-promo" class="mt-2"></div>
            </div>

            <div class="pt-3 border-t border-stone-200 dark:border-stone-800 space-y-2 text-xs">
              <div class="flex justify-between text-stone-600 dark:text-stone-400">
                <span><?php esc_html_e( 'Items Subtotal:', 'kinboni-pro' ); ?></span>
                <span id="order-modal-subtotal" class="font-bold text-stone-900 dark:text-white">৳0</span>
              </div>
              <div id="order-modal-discount-row" class="hidden flex justify-between text-emerald-600 dark:text-emerald-400 font-bold">
                <span><?php esc_html_e( 'Privilege Discount:', 'kinboni-pro' ); ?></span>
                <span id="order-modal-discount">-৳0</span>
              </div>
              <div class="flex justify-between text-stone-600 dark:text-stone-400">
                <span><?php esc_html_e( 'Delivery Fee:', 'kinboni-pro' ); ?></span>
                <span id="order-modal-shipping" class="font-bold text-stone-900 dark:text-white">৳60</span>
              </div>
              <div class="flex justify-between text-base font-bold text-stone-900 dark:text-white pt-2.5 border-t border-stone-200 dark:border-stone-800">
                <span><?php esc_html_e( 'Total Payable:', 'kinboni-pro' ); ?></span>
                <span id="order-modal-total" class="font-serif text-xl font-bold text-gold-600 dark:text-gold-400">৳0</span>
              </div>
            </div>
          </div>

          <div class="p-3.5 rounded-2xl bg-white dark:bg-stone-900 border border-stone-200/80 dark:border-stone-800/80 space-y-2 text-[11px] text-stone-600 dark:text-stone-400">
            <div class="flex items-center gap-2 font-medium text-emerald-600 dark:text-emerald-400">
              <i data-lucide="shield-check" class="w-4 h-4 flex-shrink-0"></i>
              <span><?php esc_html_e( 'Cash on Delivery — Inspect upon receipt', 'kinboni-pro' ); ?></span>
            </div>
            <div class="flex items-center gap-2">
              <i data-lucide="truck" class="w-4 h-4 flex-shrink-0 text-gold-500"></i>
              <span><?php esc_html_e( 'White-Glove Courier • 1-2 Days in Dhaka', 'kinboni-pro' ); ?></span>
            </div>
            <div class="flex items-center gap-2">
              <i data-lucide="refresh-cw" class="w-4 h-4 flex-shrink-0 text-gold-500"></i>
              <span><?php esc_html_e( '7-Day Hassle-Free Exchange Policy', 'kinboni-pro' ); ?></span>
            </div>
          </div>
        </div>

        <div class="lg:col-span-7 p-6 sm:p-8">
          <div class="mb-5">
            <span class="text-xs font-bold uppercase tracking-wider text-gold-600 dark:text-gold-400"><?php esc_html_e( 'Recipient Details', 'kinboni-pro' ); ?></span>
            <h4 class="font-serif text-lg sm:text-xl font-semibold text-stone-900 dark:text-white mt-0.5"><?php esc_html_e( 'Where should we deliver your order?', 'kinboni-pro' ); ?></h4>
          </div>

          <form id="quick-order-form" class="space-y-4" novalidate>
            <div>
              <label for="order-customer-name" class="block text-xs font-bold uppercase tracking-wider text-stone-800 dark:text-stone-200 mb-1.5">
                <?php esc_html_e( '1. Full Name', 'kinboni-pro' ); ?> <span class="text-rose-500">*</span>
              </label>
              <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                  <i data-lucide="user" class="w-4 h-4"></i>
                </span>
                <input 
                  type="text" 
                  id="order-customer-name" 
                  placeholder="<?php esc_attr_e( 'Enter your full name', 'kinboni-pro' ); ?>" 
                  class="w-full pl-10 pr-4 py-2.5 sm:py-3 rounded-xl border border-stone-300 dark:border-stone-700 bg-white dark:bg-stone-900 text-stone-900 dark:text-stone-100 text-xs sm:text-sm focus:outline-none focus:border-gold-500 transition-colors shadow-2xs"
                  required
                />
              </div>
              <p id="order-name-error" class="hidden mt-1 text-xs text-rose-500 font-medium"></p>
            </div>

            <div>
              <label for="order-customer-phone" class="block text-xs font-bold uppercase tracking-wider text-stone-800 dark:text-stone-200 mb-1.5">
                <?php esc_html_e( '2. Phone Number (Active Mobile)', 'kinboni-pro' ); ?> <span class="text-rose-500">*</span>
              </label>
              <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                  <i data-lucide="phone" class="w-4 h-4"></i>
                </span>
                <input 
                  type="tel" 
                  id="order-customer-phone" 
                  placeholder="01XXXXXXXXX" 
                  maxlength="14"
                  class="w-full pl-10 pr-4 py-2.5 sm:py-3 rounded-xl border border-stone-300 dark:border-stone-700 bg-white dark:bg-stone-900 text-stone-900 dark:text-stone-100 text-xs sm:text-sm focus:outline-none focus:border-gold-500 transition-colors shadow-2xs"
                  required
                />
              </div>
              <p id="order-phone-error" class="hidden mt-1 text-xs text-rose-500 font-medium"></p>
            </div>

            <div>
              <label for="order-customer-address" class="block text-xs font-bold uppercase tracking-wider text-stone-800 dark:text-stone-200 mb-1.5">
                <?php esc_html_e( '3. Complete Delivery Address', 'kinboni-pro' ); ?> <span class="text-rose-500">*</span>
              </label>
              <div class="relative">
                <span class="absolute top-3.5 left-0 pl-3.5 flex items-start pointer-events-none text-stone-400">
                  <i data-lucide="map-pin" class="w-4 h-4"></i>
                </span>
                <textarea 
                  id="order-customer-address" 
                  rows="2" 
                  placeholder="<?php esc_attr_e( 'House/Apartment, Road, Area/Thana, District/City', 'kinboni-pro' ); ?>" 
                  class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-stone-300 dark:border-stone-700 bg-white dark:bg-stone-900 text-stone-900 dark:text-stone-100 text-xs sm:text-sm focus:outline-none focus:border-gold-500 transition-colors shadow-2xs"
                  required
                ></textarea>
              </div>
              <p id="order-address-error" class="hidden mt-1 text-xs text-rose-500 font-medium"></p>
            </div>

            <div class="pt-1">
              <label class="block text-xs font-bold uppercase tracking-wider text-stone-800 dark:text-stone-200 mb-2">
                <?php esc_html_e( 'Select Delivery Zone:', 'kinboni-pro' ); ?>
              </label>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <label id="zone-label-inside" class="delivery-zone-option flex items-center justify-between p-3.5 rounded-xl border cursor-pointer transition-all bg-white dark:bg-stone-900 border-gold-500 bg-gold-50/50 dark:bg-gold-950/20 ring-1 ring-gold-500">
                  <div class="flex items-center gap-2.5">
                    <input type="radio" name="order-delivery-zone" value="inside" checked class="text-gold-500 focus:ring-gold-500 w-4 h-4" />
                    <div>
                      <span class="text-xs font-bold text-stone-900 dark:text-stone-100 block"><?php esc_html_e( 'Inside Dhaka City', 'kinboni-pro' ); ?></span>
                      <span class="text-[10px] text-stone-500 dark:text-stone-400"><?php esc_html_e( 'Express Delivery (1-2 Days)', 'kinboni-pro' ); ?></span>
                    </div>
                  </div>
                  <span id="zone-fee-inside" class="text-xs font-bold text-stone-900 dark:text-white px-2 py-0.5 rounded bg-stone-100 dark:bg-stone-800">৳60</span>
                </label>

                <label id="zone-label-outside" class="delivery-zone-option flex items-center justify-between p-3.5 rounded-xl border cursor-pointer transition-all bg-white dark:bg-stone-900 border-stone-200 dark:border-stone-700 hover:border-gold-400">
                  <div class="flex items-center gap-2.5">
                    <input type="radio" name="order-delivery-zone" value="outside" class="text-gold-500 focus:ring-gold-500 w-4 h-4" />
                    <div>
                      <span class="text-xs font-bold text-stone-900 dark:text-stone-100 block"><?php esc_html_e( 'Outside Dhaka City', 'kinboni-pro' ); ?></span>
                      <span class="text-[10px] text-stone-500 dark:text-stone-400"><?php esc_html_e( 'Nationwide Express (2-4 Days)', 'kinboni-pro' ); ?></span>
                    </div>
                  </div>
                  <span id="zone-fee-outside" class="text-xs font-bold text-stone-900 dark:text-white px-2 py-0.5 rounded bg-stone-100 dark:bg-stone-800">৳120</span>
                </label>
              </div>
            </div>

            <div class="pt-2">
              <button 
                type="submit" 
                id="order-submit-button"
                class="w-full py-4 bg-gold-400 hover:bg-gold-500 text-stone-950 text-xs sm:text-sm font-bold uppercase tracking-widest rounded-xl shadow-lg hover:shadow-gold-500/25 transition-all flex items-center justify-center gap-2 active:scale-[0.99]"
              >
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span id="order-submit-btn-text"><?php esc_html_e( 'Confirm Order', 'kinboni-pro' ); ?></span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- VIEW 2: SUCCESS VIEW -->
    <div id="checkout-success-view" class="hidden p-6 sm:p-8 text-center animate-slide-up">
      <div class="w-16 h-16 rounded-full bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-500/10">
        <i data-lucide="check-circle-2" class="w-9 h-9"></i>
      </div>
      <span class="inline-block px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-xs font-bold uppercase tracking-wider mb-2">
        <?php esc_html_e( 'Order Successfully Placed!', 'kinboni-pro' ); ?>
      </span>
      <h3 class="font-serif text-2xl sm:text-3xl font-medium text-stone-900 dark:text-white mb-1">
        <?php esc_html_e( 'Thank You,', 'kinboni-pro' ); ?> <span id="confirmed-customer-name" class="text-gold-600 dark:text-gold-400"></span>!
      </h3>
      <p class="text-xs text-stone-500 dark:text-stone-400 max-w-sm mx-auto mb-6 font-light">
        <?php esc_html_e( 'Your order has been recorded in WooCommerce. You can view your invoice receipt below or continue shopping.', 'kinboni-pro' ); ?>
      </p>

      <div class="p-4 sm:p-5 rounded-2xl bg-stone-50 dark:bg-stone-950 border border-stone-200 dark:border-stone-800 text-xs text-left mb-6 space-y-2.5">
        <div class="flex justify-between items-center pb-2 border-b border-stone-200 dark:border-stone-800">
          <span class="text-stone-500"><?php esc_html_e( 'Order Reference:', 'kinboni-pro' ); ?></span>
          <span id="confirmed-order-id" class="font-mono font-bold text-stone-900 dark:text-white"></span>
        </div>
        <div class="flex justify-between items-center">
          <span class="text-stone-500"><?php esc_html_e( 'Phone Number:', 'kinboni-pro' ); ?></span>
          <span id="confirmed-customer-phone" class="font-semibold text-stone-900 dark:text-stone-100"></span>
        </div>
        <div class="flex justify-between items-start gap-4">
          <span class="text-stone-500 flex-shrink-0"><?php esc_html_e( 'Delivery Address:', 'kinboni-pro' ); ?></span>
          <span id="confirmed-customer-address" class="font-semibold text-stone-900 dark:text-stone-100 text-right"></span>
        </div>
        <div class="flex justify-between items-center">
          <span class="text-stone-500"><?php esc_html_e( 'Payment Method:', 'kinboni-pro' ); ?></span>
          <span class="font-bold text-emerald-600 dark:text-emerald-400"><?php esc_html_e( 'Cash on Delivery', 'kinboni-pro' ); ?></span>
        </div>
        <div class="flex justify-between items-center pt-2 border-t border-stone-200 dark:border-stone-800 text-sm font-bold">
          <span class="text-stone-900 dark:text-white"><?php esc_html_e( 'Total Net Payable:', 'kinboni-pro' ); ?></span>
          <span id="confirmed-order-total" class="text-gold-600 dark:text-gold-400 font-serif text-lg"></span>
        </div>
      </div>

      <div class="space-y-3">
        <a 
          id="confirmed-order-details-link" 
          href="#" 
          class="w-full py-3.5 px-4 bg-gold-400 hover:bg-gold-500 text-stone-950 text-xs font-bold uppercase tracking-wider rounded-xl shadow-md hover:shadow-gold-500/25 transition-all flex items-center justify-center gap-2 active:scale-[0.99]"
        >
          <i data-lucide="file-text" class="w-4 h-4"></i>
          <span><?php esc_html_e( 'View Order Details & Receipt', 'kinboni-pro' ); ?></span>
        </a>

        <button 
          id="close-success-view-btn" 
          type="button" 
          class="w-full py-3 bg-stone-100 dark:bg-stone-800 hover:bg-stone-200 dark:hover:bg-stone-700 text-stone-800 dark:text-stone-200 text-xs font-semibold uppercase tracking-wider rounded-xl transition-colors"
        >
          <?php esc_html_e( 'Continue Shopping', 'kinboni-pro' ); ?>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- 7. LIVE RECENT SALES SOCIAL PROOF POPUP -->
<div id="live-sales-popup" class="fixed bottom-20 left-3 right-3 sm:left-auto sm:right-6 z-40 sm:max-w-[340px] transform translate-y-8 opacity-0 pointer-events-none transition-all duration-500 ease-out">
  <div id="live-sales-card" onclick="LiveSalesController.openCurrentProduct()" class="relative flex items-center gap-3.5 p-3 sm:p-3.5 rounded-2xl bg-white/95 dark:bg-stone-900/95 backdrop-blur-md border border-stone-200/90 dark:border-stone-800 shadow-2xl hover:border-gold-500/60 dark:hover:border-gold-500/60 transition-all cursor-pointer group pointer-events-auto" title="Click to Quick View this creation">
    <div class="relative w-14 h-16 rounded-xl overflow-hidden bg-stone-100 dark:bg-stone-950 flex-shrink-0 border border-stone-200/60 dark:border-stone-800 shadow-sm">
      <img id="live-sale-image" src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=400&q=80" alt="Recent sale" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
      <span class="absolute top-1 left-1 w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
    </div>

    <div class="flex-grow min-w-0 pr-4">
      <div class="flex items-center gap-1.5 text-[10px] text-stone-500 dark:text-stone-400 font-medium">
        <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-500 flex-shrink-0"></span>
        <span id="live-sale-buyer" class="truncate"><?php esc_html_e( 'Gulshan-2, Dhaka • Just now', 'kinboni-pro' ); ?></span>
      </div>
      <h4 id="live-sale-name" class="font-serif text-xs sm:text-sm font-semibold text-stone-900 dark:text-white truncate group-hover:text-gold-600 dark:group-hover:text-gold-400 transition-colors mt-0.5">
        Chronos Royale Automatic
      </h4>
      <div class="flex items-center justify-between gap-2 mt-1">
        <span id="live-sale-price" class="text-xs font-bold text-stone-900 dark:text-white">৳18,500</span>
        <span class="text-[10px] font-bold text-gold-600 dark:text-gold-400 uppercase tracking-wider flex items-center gap-1 group-hover:translate-x-0.5 transition-transform">
          <span><?php esc_html_e( 'Quick View', 'kinboni-pro' ); ?></span>
          <i data-lucide="eye" class="w-3 h-3 text-gold-600 dark:text-gold-400"></i>
        </span>
      </div>
    </div>

    <button id="close-live-sale-btn" type="button" onclick="event.stopPropagation(); LiveSalesController.hide();" class="absolute top-2 right-2 w-6 h-6 rounded-full flex items-center justify-center text-stone-400 hover:text-stone-900 dark:hover:text-white hover:bg-stone-100 dark:hover:bg-stone-800 transition-colors" aria-label="Dismiss sale alert">
      <i data-lucide="x" class="w-3.5 h-3.5"></i>
    </button>
  </div>
</div>

<!-- 8. BACK TO TOP FLOATING BUTTON -->
<button 
  id="back-to-top-btn" 
  type="button" 
  class="fixed bottom-6 right-6 z-40 p-3.5 rounded-full bg-white/90 dark:bg-stone-900/90 text-stone-900 dark:text-stone-100 border border-stone-300 dark:border-stone-700 shadow-xl opacity-0 pointer-events-none translate-y-4 hover:border-gold-500 hover:text-gold-600 dark:hover:text-gold-400 hover:scale-110 active:scale-95 transition-all duration-300"
  aria-label="Back to top of page"
>
  <i data-lucide="arrow-up" class="w-5 h-5"></i>
</button>

<!-- 9. TOAST NOTIFICATION CONTAINER -->
<div id="toast-container" class="fixed top-4 right-4 sm:top-auto sm:bottom-6 sm:left-6 z-50 flex flex-col gap-2 pointer-events-none max-w-sm w-auto"></div>

<?php
$kb_settings = class_exists( 'Kinboni_Admin' ) ? Kinboni_Admin::get_settings() : [];
$enable_wa   = ( $kb_settings['enable_whatsapp'] ?? 'no' ) === 'yes';
$wa_number   = preg_replace( '/[^0-9]/', '', $kb_settings['whatsapp_number'] ?? '' );
$wa_msg      = rawurlencode( $kb_settings['whatsapp_message'] ?? 'Hello Kinboni Concierge' );
if ( $enable_wa && ! empty( $wa_number ) ) :
?>
<!-- 10. FLOATING WHATSAPP CONCIERGE BUTTON -->
<a 
  href="https://wa.me/<?php echo esc_attr( $wa_number ); ?>?text=<?php echo esc_attr( $wa_msg ); ?>" 
  target="_blank" 
  rel="noopener noreferrer"
  class="fixed bottom-6 left-6 z-40 p-3.5 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white shadow-2xl hover:scale-110 active:scale-95 transition-all duration-300 flex items-center justify-center group"
  aria-label="Direct WhatsApp Concierge"
  title="Chat with Kinboni Concierge on WhatsApp"
>
  <svg class="w-6 h-6 fill-white" viewBox="0 0 24 24">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
  </svg>
</a>
<?php endif; ?>

