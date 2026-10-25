/**
 * KINBONI Atelier - Haute Horlogerie & Luxury Goods
 * Ultra-Premium Vanilla JavaScript Engine
 */

// ==========================================================================
// 1. PRODUCT DATABASE (12 Handcrafted Luxury Curations)
// ==========================================================================
const DEMO_PRODUCTS = [
  {
    id: 1,
    name: "Chronos Royale Automatic",
    category: "timepieces",
    categoryLabel: "Timepieces",
    price: 18500,
    originalPrice: 22000,
    rating: 4.9,
    reviewsCount: 68,
    badge: "BESTSELLER",
    image:
      "https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=800&q=80",
    hoverImage:
      "https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=800&q=80",
    description:
      "Handcrafted Swiss-precision automatic movement encased in 316L brushed surgical steel with 18k champagne gold indices, exhibition sapphire caseback, and water resistance to 50 meters.",
    specs: [
      "316L Surgical Grade Steel",
      "Double-Domed Sapphire Crystal",
      "50m Water Resistance",
      "42-Hour Power Reserve",
    ],
    inStock: true,
    featured: true,
    bestSeller: true,
    onSale: true,
  },
  {
    id: 2,
    name: "Atelier Saddle Leather Briefcase",
    category: "leather",
    categoryLabel: "Leather Goods",
    price: 14200,
    originalPrice: 16800,
    rating: 5.0,
    reviewsCount: 42,
    badge: "NEW",
    image:
      "https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=800&q=80",
    hoverImage:
      "https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=800&q=80",
    description:
      'Constructed from full-grain Tuscan vegetable-tanned bridle leather. Features hand-burnished beveled edges, solid antiqued brass hardware, and dedicated suede-lined 16" laptop sleeve.',
    specs: [
      "Vegetable-Tanned Tuscan Leather",
      "Solid Antiqued Brass Hardware",
      'Fits up to 16" MacBook Pro',
      "Lifetime Craftsmanship Warranty",
    ],
    inStock: true,
    featured: true,
    bestSeller: true,
    onSale: true,
  },
  {
    id: 3,
    name: "Nocturne Oud Extrait De Parfum",
    category: "fragrance",
    categoryLabel: "Fine Fragrance",
    price: 8900,
    originalPrice: null,
    rating: 4.8,
    reviewsCount: 94,
    badge: "SIGNATURE",
    image:
      "https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=800&q=80",
    hoverImage:
      "https://images.unsplash.com/photo-1523293182086-7651a899d37f?auto=format&fit=crop&w=800&q=80",
    description:
      "An intoxicating olfactory voyage featuring wild Cambodian agarwood, Damascus rose absolute, smoky amber resin, and velvety Bourbon vanilla in a 30% concentration extrait.",
    specs: [
      "30% Oil Concentration (Extrait)",
      "Aged Wild Cambodian Oud",
      "100ml Heavy Faceted Decanter",
      "12+ Hours Longevity",
    ],
    inStock: true,
    featured: true,
    bestSeller: true,
    onSale: false,
  },
  {
    id: 4,
    name: "Aethelgard 18K Minimalist Cuff",
    category: "jewelry",
    categoryLabel: "Fine Jewelry",
    price: 6400,
    originalPrice: 7500,
    rating: 4.9,
    reviewsCount: 37,
    badge: "LIMITED",
    image:
      "https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=800&q=80",
    hoverImage:
      "https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?auto=format&fit=crop&w=800&q=80",
    description:
      "An understated open-cuff silhouette cast in certified recycled 925 sterling silver dipped in 5 microns of 18k yellow gold with a hand-satin brushed finish.",
    specs: [
      "18k Gold Vermeil over 925 Silver",
      "Satin Matte with Polished Tips",
      "Flexible Ergonomic Fit",
      "Hypoallergenic & Nickel-Free",
    ],
    inStock: true,
    featured: true,
    bestSeller: true,
    onSale: true,
  },
  {
    id: 5,
    name: "Monaco Polarized Acetate Shades",
    category: "eyewear",
    categoryLabel: "Eyewear",
    price: 5200,
    originalPrice: null,
    rating: 4.7,
    reviewsCount: 53,
    badge: null,
    image:
      "https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=800&q=80",
    hoverImage:
      "https://images.unsplash.com/photo-1572635196237-14b3f281503f?auto=format&fit=crop&w=800&q=80",
    description:
      "Custom bio-acetate frames hand-cut and tumbled in Japan for 72 hours. Fitted with Barberini mineral glass polarized lenses for supreme optical clarity.",
    specs: [
      "Japanese Mazzucchelli Bio-Acetate",
      "UVA/UVB 400 Polarized Lenses",
      "Five-Barrel Teflon Hinges",
      "Hand-Stamped Gold Serial Number",
    ],
    inStock: true,
    featured: true,
    bestSeller: false,
    onSale: false,
  },
  {
    id: 6,
    name: "Kyoto Mulberry Silk Foulard",
    category: "silk",
    categoryLabel: "Silk & Cashmere",
    price: 4800,
    originalPrice: 5600,
    rating: 4.9,
    reviewsCount: 29,
    badge: "ARTISANAL",
    image:
      "https://images.unsplash.com/photo-1601924994987-69e26d50dc26?auto=format&fit=crop&w=800&q=80",
    hoverImage:
      "https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80",
    description:
      "Woven from Grade-6A 100% long-strand mulberry silk in a 16-momme twill weave. Features hand-rolled and hand-stitched edges by master Japanese artisans.",
    specs: [
      "100% 6A Mulberry Raw Silk",
      "16-Momme Heavyweight Twill",
      "90cm x 90cm Dimensions",
      "Hand-Rolled & Stitched Edges",
    ],
    inStock: true,
    featured: true,
    bestSeller: true,
    onSale: true,
  },
  {
    id: 7,
    name: "Heritage Bi-Fold Card Wallet",
    category: "leather",
    categoryLabel: "Leather Goods",
    price: 3200,
    originalPrice: 3900,
    rating: 4.8,
    reviewsCount: 88,
    badge: "BESTSELLER",
    image:
      "https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=800&q=80",
    hoverImage:
      "https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?auto=format&fit=crop&w=800&q=80",
    description:
      "Slimline minimalist card wallet with 6 quick-access card slots, two hidden currency sleeves, and hand-stitched French linen thread.",
    specs: [
      "Full-Grain Shell Cordovan Leather",
      "Linen Thread Hand-Stitched",
      "Holds 10-12 Cards Comfortably",
      "RFID Shielding Layer",
    ],
    inStock: true,
    featured: true,
    bestSeller: true,
    onSale: true,
  },
  {
    id: 8,
    name: "Sylvan Vetiver Botanical Parfum",
    category: "fragrance",
    categoryLabel: "Fine Fragrance",
    price: 9500,
    originalPrice: null,
    rating: 4.9,
    reviewsCount: 46,
    badge: "NEW",
    image:
      "https://images.unsplash.com/photo-1547887537-6158d64c35b3?auto=format&fit=crop&w=800&q=80",
    hoverImage:
      "https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&w=800&q=80",
    description:
      "An earthy, invigorating fragrance balancing Haitian vetiver root, bergamot rind, crisp cedarwood heart, and sparkling pink peppercorn.",
    specs: [
      "Organic French Extraction",
      "Sustainably Harvested Vetiver",
      "Magnetic Heavy Metal Cap",
      "Unisex Composition",
    ],
    inStock: true,
    featured: true,
    bestSeller: false,
    onSale: false,
  },
  {
    id: 9,
    name: "Vanguard Skeleton Dial Watch",
    category: "timepieces",
    categoryLabel: "Timepieces",
    price: 24500,
    originalPrice: 28000,
    rating: 5.0,
    reviewsCount: 22,
    badge: "LIMITED",
    image:
      "https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=800&q=80",
    hoverImage:
      "https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=800&q=80",
    description:
      "An architectural tour-de-force showcasing an open-worked skeleton movement with Geneva stripes, blued screws, and a bespoke alligator leather strap.",
    specs: [
      "Exhibition Caseback with Sapphire",
      "Skeletonized 28,800 VPH Calibre",
      "Louisiana Alligator Leather Band",
      "Individual Serialized Run of 100",
    ],
    inStock: true,
    featured: false,
    bestSeller: true,
    onSale: true,
  },
  {
    id: 10,
    name: "Cypress Minimalist Leather Tote",
    category: "leather",
    categoryLabel: "Leather Goods",
    price: 11800,
    originalPrice: null,
    rating: 4.8,
    reviewsCount: 34,
    badge: null,
    image:
      "https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=800&q=80",
    hoverImage:
      "https://images.unsplash.com/photo-1591561954557-26941169b49e?auto=format&fit=crop&w=800&q=80",
    description:
      "Unstructured day tote crafted from pebble-grain calfskin with reinforced double-handle drop, magnetic top closure, and removable zip pouch.",
    specs: [
      "Soft Grain Italian Calfskin",
      "Reinforced Base with Metal Feet",
      "Internal Key Leash & Zip Pouch",
      "Generous 25L Capacity",
    ],
    inStock: true,
    featured: false,
    bestSeller: true,
    onSale: false,
  },
  {
    id: 11,
    name: "Celeste Pearl Pendant Necklace",
    category: "jewelry",
    categoryLabel: "Fine Jewelry",
    price: 7800,
    originalPrice: 9200,
    rating: 4.9,
    reviewsCount: 51,
    badge: "NEW",
    image:
      "https://images.unsplash.com/photo-1599643477877-530eb83abc8e?auto=format&fit=crop&w=800&q=80",
    hoverImage:
      "https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?auto=format&fit=crop&w=800&q=80",
    description:
      "A luminous AAA South Sea baroque freshwater pearl suspended from a delicate 18-karat solid gold wheat chain with lobster clasp.",
    specs: [
      "Natural AAA South Sea Baroque Pearl",
      "18-Inch 18k Solid Gold Chain",
      "Each Pearl Uniquely Formed",
      "Luxury Velvet Presentation Box",
    ],
    inStock: true,
    featured: false,
    bestSeller: true,
    onSale: true,
  },
  {
    id: 12,
    name: "Soleil Aviator Titanium Shades",
    category: "eyewear",
    categoryLabel: "Eyewear",
    price: 6800,
    originalPrice: null,
    rating: 4.7,
    reviewsCount: 38,
    badge: null,
    image:
      "https://images.unsplash.com/photo-1508296695146-257a814070b4?auto=format&fit=crop&w=800&q=80",
    hoverImage:
      "https://images.unsplash.com/photo-1577803645773-f96470509666?auto=format&fit=crop&w=800&q=80",
    description:
      "Featherlight aerospace-grade Japanese beta-titanium wire frames with custom teardrop silhouettes and gradient warm-sepia scratchproof lenses.",
    specs: [
      "Aerospace Grade Beta-Titanium",
      "Weight: Only 18 Grams",
      "Hypoallergenic Ceramic Nose Pads",
      "100% Polarization with Anti-Glare",
    ],
    inStock: true,
    featured: false,
    bestSeller: true,
    onSale: false,
  },
];

/**
 * Active Storefront Catalog:
 * - If products exist from WooCommerce / KINBONI Pro Dashboard (window.kinboni.products), use those real products.
 * - If no products have been added yet in WordPress, empty state will prompt to add products.
 * - In standalone static preview mode (without WordPress backend), fallback to DEMO_PRODUCTS.
 */
const HAS_BACKEND = typeof kinboni !== "undefined";
const HAS_PLUGIN_PRODUCTS =
  HAS_BACKEND &&
  kinboni.has_user_products &&
  Array.isArray(kinboni.products) &&
  kinboni.products.length > 0;

let PRODUCTS = HAS_PLUGIN_PRODUCTS
  ? kinboni.products.slice()
  : HAS_BACKEND
    ? []
    : DEMO_PRODUCTS.slice();

// ==========================================================================
// 2. STATE MANAGEMENT & STORAGE
// ==========================================================================
const STORAGE_KEYS = {
  CART: "kinboni_cart_v2",
  WISHLIST: "kinboni_wishlist_v2",
  THEME: "kinboni_theme_v2",
  PROMO: "kinboni_promo_v2",
  ANNOUNCEMENT: "kinboni_announcement_v2",
};

const STATE = window.STATE = Object.assign(window.STATE || {}, {
  cart: (window.STATE && Array.isArray(window.STATE.cart) && window.STATE.cart.length > 0) ? window.STATE.cart : [],
  wishlist: (window.STATE && Array.isArray(window.STATE.wishlist)) ? window.STATE.wishlist : [],
  activePromo: (window.STATE && window.STATE.activePromo) ? window.STATE.activePromo : null,
  activeFilter: "all",
  quickViewProduct: null,
});

const FREE_SHIPPING_THRESHOLD = 2500;
const PROMO_CODES = {
  LUXE20: 0.2,
  KINBONI10: 0.1,
  WELCOME: 0.15,
};

// ==========================================================================
// 3. UTILITIES & TOAST NOTIFICATION
// ==========================================================================
function formatCurrency(amount) {
  return "৳" + Number(amount).toLocaleString("en-US");
}

function refreshIcons() {
  if (window.lucide && typeof window.lucide.createIcons === "function") {
    try {
      window.lucide.createIcons();
    } catch (e) {
      // Prevents unhandled icon errors
    }
  }
}

function showToast(message, type = "success") {
  const container = document.getElementById("toast-container");
  if (!container) return;

  const toast = document.createElement("div");
  const icon =
    type === "success"
      ? "check-circle"
      : type === "error"
        ? "alert-circle"
        : "info";
  const borderColor =
    type === "success"
      ? "border-gold-500/50"
      : type === "error"
        ? "border-rose-500/50"
        : "border-stone-500/50";

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
    toast.classList.remove("translate-y-4", "opacity-0");
  });

  setTimeout(() => {
    toast.classList.add("opacity-0", "translate-y-2");
    setTimeout(() => toast.remove(), 350);
  }, 3500);
}

// ==========================================================================
// 4. THEME CONTROLLER (Migrated to Module 07: assets/js/modules/theme.js)
// ==========================================================================
const ThemeController = (window.KinboniPro && window.KinboniPro.Theme)
  ? window.KinboniPro.Theme
  : (window.ThemeController || {
      isDark: false,
      init() {},
      applyTheme() {},
      toggle() {},
      isDarkMode() { return false; },
    });

// ==========================================================================
// 5. PRODUCT CARD GENERATOR (Ultra-Luxury & Ergonomic)
// ==========================================================================
function renderStarRating(rating, reviewsCount) {
  return `
    <div class="flex items-center gap-1 text-[11px] font-semibold text-stone-700 dark:text-stone-300 flex-shrink-0" title="${rating} out of 5 stars from ${reviewsCount} verified reviews">
      <svg class="w-3.5 h-3.5 text-amber-400 fill-amber-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
      </svg>
      <span>${Number(rating).toFixed(1)}</span>
      <span class="text-stone-400 dark:text-stone-500 font-normal">(${reviewsCount})</span>
    </div>
  `;
}

function createProductCard(product) {
  if (typeof window.createProductCard === "function" && window.createProductCard !== createProductCard) {
    return window.createProductCard(product);
  }
  return "";
}

// ==========================================================================
// 6. CART CONTROLLER (Migrated to Module 02: assets/js/modules/cart.js)
// ==========================================================================
const CartController = (window.KinboniPro && window.KinboniPro.Cart)
  ? window.KinboniPro.Cart
  : (window.CartController || {
      init() {},
      open() {},
      close() {},
      add() {},
      updateQuantity() {},
      remove() {},
      clear() {},
      applyPromo() {},
      removePromo() {},
      buyNow() {},
      checkout() {},
      render() {},
      updateBadges() {},
    });

// 7. WISHLIST CONTROLLER (Migrated to Module 03: assets/js/modules/wishlist.js)
// ==========================================================================
const WishlistController = (window.KinboniPro && window.KinboniPro.Wishlist)
  ? window.KinboniPro.Wishlist
  : (window.WishlistController || {
      init() {},
      open() {},
      close() {},
      toggle() {},
      remove() {},
      moveToBag() {},
      moveToCart() {},
      render() {},
      updateBadges() {},
      updateHeartButtons() {},
    });

// 8. QUICK VIEW MODAL CONTROLLER (Migrated to Module 04: assets/js/modules/quickview.js)
// ==========================================================================
function registerProduct(product) {
  if (typeof window.registerProduct === "function" && window.registerProduct !== registerProduct) {
    return window.registerProduct(product);
  }
  if (!product || !product.id) return null;
  const idNum = Number(product.id) || product.id;
  window.PRODUCTS = window.PRODUCTS || [];
  const idx = window.PRODUCTS.findIndex((p) => p.id === product.id || p.id === idNum);
  const normalized = Object.assign({}, product, {
    id: idNum,
    price: typeof product.price === "number" ? product.price : parseFloat(product.price_raw || product.price || 0),
  });
  if (idx > -1) {
    window.PRODUCTS[idx] = Object.assign({}, window.PRODUCTS[idx], normalized);
  } else {
    window.PRODUCTS.push(normalized);
  }
  return normalized;
}

const QuickViewController = (window.KinboniPro && window.KinboniPro.QuickView)
  ? window.KinboniPro.QuickView
  : (window.QuickViewController || {
      currentProduct: null,
      quantity: 1,
      init() {},
      open() {},
      openProduct() {},
      close() {},
      switchImage() {},
      changeQty() {},
      addToCart() {},
      buyNow() {},
      toggleWishlistBtn() {},
      renderModal() {},
    });

// ==========================================================================
// 9. SEARCH CONTROLLER (Migrated to Module 05: assets/js/modules/search.js)
// ==========================================================================
const SearchController = (window.KinboniPro && window.KinboniPro.Search)
  ? window.KinboniPro.Search
  : (window.SearchController || {
      debounceTimer: null,
      init() {},
      open() {},
      close() {},
      search() {},
    });

// ==========================================================================
// 10. PRODUCT RENDERER & FILTERS (Migrated to Module 06: assets/js/modules/product-renderer.js)
// ==========================================================================
const ProductRenderer = (window.KinboniPro && window.KinboniPro.ProductRenderer)
  ? window.KinboniPro.ProductRenderer
  : (window.ProductRenderer || {
      activeFilter: "all",
      init() {},
      renderFeatured() {},
      renderBestSellers() {},
      setProducts() {},
    });

// ==========================================================================
// 11. NEWSLETTER & INTERACTION CONTROLLER (Migrated to Module 10: assets/js/modules/interactions.js)
// ==========================================================================
const InteractionController = (window.KinboniPro && window.KinboniPro.Interactions)
  ? window.KinboniPro.Interactions
  : (window.InteractionController || {
      isMobileMenuOpen: false,
      openMobileMenu() {},
      closeMobileMenu() {},
      toggleMobileMenu() {},
      init() {},
    });

// ==========================================================================
// 12. FAST 3-FIELD QUICK ORDER CONTROLLER (Express Cash On Delivery)
// ==========================================================================
const QuickOrderController = {
  currentDeliveryFee: 60,

  init() {
    const modal = document.getElementById("checkout-modal");
    const backdrop = document.getElementById("checkout-backdrop");
    const closeBtn = document.getElementById("close-checkout-modal-btn");
    const closeSuccessBtn = document.getElementById("close-success-view-btn");
    const form = document.getElementById("quick-order-form");

    if (backdrop) backdrop.addEventListener("click", () => this.close());
    if (closeBtn) closeBtn.addEventListener("click", () => this.close());
    if (closeSuccessBtn)
      closeSuccessBtn.addEventListener("click", () => this.close());

    // Delivery zone selection
    const zoneRadios = document.querySelectorAll(
      'input[name="order-delivery-zone"]',
    );
    zoneRadios.forEach((radio) => {
      radio.addEventListener("change", (e) => {
        this.updateDeliveryFee(e.target.value);
      });
    });

    // Name real-time input validation
    const nameInput = document.getElementById("order-customer-name");
    if (nameInput) {
      nameInput.addEventListener("input", (e) => {
        if (e.target.value.trim().length >= 2) {
          nameInput.classList.remove("border-rose-500");
          const err = document.getElementById("order-name-error");
          if (err) err.classList.add("hidden");
        }
      });
    }

    // Phone real-time input formatting
    const phoneInput = document.getElementById("order-customer-phone");
    if (phoneInput) {
      phoneInput.addEventListener("input", (e) => {
        const cleaned = e.target.value.replace(/[^\d+]/g, "");
        e.target.value = cleaned;
        if (cleaned.length >= 11) {
          phoneInput.classList.remove("border-rose-500");
          const err = document.getElementById("order-phone-error");
          if (err) err.classList.add("hidden");
        }
      });
    }

    // Address real-time input validation
    const addressInput = document.getElementById("order-customer-address");
    if (addressInput) {
      addressInput.addEventListener("input", (e) => {
        if (e.target.value.trim().length >= 5) {
          addressInput.classList.remove("border-rose-500");
          const err = document.getElementById("order-address-error");
          if (err) err.classList.add("hidden");
        }
      });
    }

    if (form) {
      form.addEventListener("submit", (e) => {
        e.preventDefault();
        this.handleSubmit();
      });
    }

    window.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && modal && !modal.classList.contains("hidden")) {
        this.close();
      }
    });
  },

  open() {
    if (STATE.cart.length === 0) {
      showToast(
        "Your shopping bag is currently empty. Please select a product.",
        "error",
      );
      return;
    }

    CartController.close();
    QuickViewController.close();

    const modal = document.getElementById("checkout-modal");
    const formView = document.getElementById("checkout-form-view");
    const successView = document.getElementById("checkout-success-view");

    if (!modal || !formView || !successView) return;

    formView.classList.remove("hidden");
    successView.classList.add("hidden");

    this.clearErrors();
    this.renderItemsPreview();

    // Set initial zone styling
    const selectedZone =
      document.querySelector('input[name="order-delivery-zone"]:checked')
        ?.value || "inside";
    this.updateDeliveryFee(selectedZone);

    modal.classList.remove("hidden");
    document.body.classList.add("overflow-hidden");
    refreshIcons();
  },

  close() {
    const modal = document.getElementById("checkout-modal");
    if (modal) {
      modal.classList.add("hidden");
      document.body.classList.remove("overflow-hidden");
    }
  },

  renderItemsPreview() {
    const container = document.getElementById("checkout-items-preview");
    if (!container) return;

    const itemsHtml = STATE.cart
      .map((item) => {
        const product =
          PRODUCTS.find((p) => p.id == item.id) ||
          (typeof DEMO_PRODUCTS !== "undefined"
            ? DEMO_PRODUCTS.find((p) => p.id == item.id)
            : null);
        const name = product ? product.name : (item.name || "Bespoke Creation");
        const price = product ? product.price : (item.price || 0);
        const image = product ? product.image : (item.image || "");
        const cat = product ? (product.categoryLabel || product.category || "Atelier") : "Atelier";
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
                Qty: <strong class="text-stone-900 dark:text-stone-200">${item.quantity}</strong> × ${formatCurrency(price)}
              </span>
              <span class="font-serif font-bold text-stone-900 dark:text-white">
                ${formatCurrency(price * item.quantity)}
              </span>
            </div>
          </div>
        </div>
      `;
      })
      .join("");

    container.innerHTML = itemsHtml;
  },

  updateDeliveryFee(zone) {
    const subtotal = STATE.cart.reduce((sum, item) => {
      const p = PRODUCTS.find((prod) => prod.id == item.id);
      return sum + (p ? p.price * item.quantity : 0);
    }, 0);

    const isFree = subtotal >= FREE_SHIPPING_THRESHOLD;
    if (isFree) {
      this.currentDeliveryFee = 0;
    } else {
      this.currentDeliveryFee = zone === "outside" ? 120 : 60;
    }

    // Toggle active classes on zone labels
    const labelInside = document.getElementById("zone-label-inside");
    const labelOutside = document.getElementById("zone-label-outside");

    if (labelInside && labelOutside) {
      if (zone === "inside") {
        labelInside.classList.add(
          "active",
          "border-gold-500",
          "bg-gold-50/50",
          "dark:bg-gold-950/20",
          "ring-1",
          "ring-gold-500",
        );
        labelInside.classList.remove(
          "border-stone-200",
          "dark:border-stone-700",
        );

        labelOutside.classList.remove(
          "active",
          "border-gold-500",
          "bg-gold-50/50",
          "dark:bg-gold-950/20",
          "ring-1",
          "ring-gold-500",
        );
        labelOutside.classList.add("border-stone-200", "dark:border-stone-700");
      } else {
        labelOutside.classList.add(
          "active",
          "border-gold-500",
          "bg-gold-50/50",
          "dark:bg-gold-950/20",
          "ring-1",
          "ring-gold-500",
        );
        labelOutside.classList.remove(
          "border-stone-200",
          "dark:border-stone-700",
        );

        labelInside.classList.remove(
          "active",
          "border-gold-500",
          "bg-gold-50/50",
          "dark:bg-gold-950/20",
          "ring-1",
          "ring-gold-500",
        );
        labelInside.classList.add("border-stone-200", "dark:border-stone-700");
      }
    }

    this.calculateTotals();
  },

  calculateTotals() {
    const subtotalEl = document.getElementById("order-modal-subtotal");
    const discountRow = document.getElementById("order-modal-discount-row");
    const discountEl = document.getElementById("order-modal-discount");
    const shippingEl = document.getElementById("order-modal-shipping");
    const totalEl = document.getElementById("order-modal-total");
    const zoneFeeInside = document.getElementById("zone-fee-inside");
    const zoneFeeOutside = document.getElementById("zone-fee-outside");

    const subtotal = STATE.cart.reduce((sum, item) => {
      const p = PRODUCTS.find((prod) => prod.id == item.id);
      return sum + (p ? p.price * item.quantity : 0);
    }, 0);

    let discountAmount = 0;
    if (STATE.activePromo && PROMO_CODES[STATE.activePromo]) {
      discountAmount = Math.round(subtotal * PROMO_CODES[STATE.activePromo]);
    }

    const isFree = subtotal >= FREE_SHIPPING_THRESHOLD;
    if (zoneFeeInside && zoneFeeOutside) {
      if (isFree) {
        zoneFeeInside.textContent = "Free (Complimentary)";
        zoneFeeOutside.textContent = "Free (Complimentary)";
        this.currentDeliveryFee = 0;
      } else {
        zoneFeeInside.textContent = "৳60";
        zoneFeeOutside.textContent = "৳120";
      }
    }

    const finalTotal = Math.max(
      0,
      subtotal - discountAmount + this.currentDeliveryFee,
    );

    if (subtotalEl) subtotalEl.textContent = formatCurrency(subtotal);

    if (discountRow && discountEl) {
      if (discountAmount > 0) {
        discountRow.classList.remove("hidden");
        discountEl.textContent = `-${formatCurrency(discountAmount)}`;
      } else {
        discountRow.classList.add("hidden");
      }
    }

    if (shippingEl) {
      shippingEl.textContent =
        this.currentDeliveryFee === 0
          ? "Free"
          : formatCurrency(this.currentDeliveryFee);
    }

    if (totalEl) totalEl.textContent = formatCurrency(finalTotal);

    // Update applied promo badge in checkout modal
    const modalPromoBadge = document.getElementById(
      "order-modal-applied-promo",
    );
    if (modalPromoBadge) {
      if (STATE.activePromo && PROMO_CODES[STATE.activePromo]) {
        modalPromoBadge.innerHTML = `
          <div class="flex items-center justify-between p-2 rounded-lg bg-gold-50 dark:bg-gold-950/40 border border-gold-300 dark:border-gold-800 text-xs">
            <div class="flex items-center gap-1.5 text-gold-700 dark:text-gold-300 font-semibold">
              <i data-lucide="tag" class="w-3.5 h-3.5"></i>
              <span>Voucher <strong>${STATE.activePromo}</strong> (${PROMO_CODES[STATE.activePromo] * 100}% Privilege Applied)</span>
            </div>
            <button type="button" onclick="QuickOrderController.removeModalPromo()" class="text-stone-400 hover:text-stone-700 dark:hover:text-stone-200" aria-label="Remove voucher">
              <i data-lucide="x" class="w-3.5 h-3.5"></i>
            </button>
          </div>
        `;
      } else {
        modalPromoBadge.innerHTML = "";
      }
    }
  },

  applyModalPromo() {
    const input = document.getElementById("order-modal-promo-input");
    const code =
      input && input.value ? String(input.value).trim().toUpperCase() : "";
    if (!code) {
      showToast("Please enter a voucher code (e.g. LUXE20).", "info");
      return;
    }
    if (PROMO_CODES[code]) {
      STATE.activePromo = code;
      CartController.save();
      this.calculateTotals();
      CartController.render();
      showToast(
        `Privilege voucher "${code}" applied! ${PROMO_CODES[code] * 100}% privilege deducted.`,
        "success",
      );
      if (input) input.value = "";
      refreshIcons();
    } else {
      showToast(
        'Invalid voucher code. Try "LUXE20" for 20% privilege.',
        "error",
      );
    }
  },

  removeModalPromo() {
    STATE.activePromo = null;
    CartController.save();
    this.calculateTotals();
    CartController.render();
    showToast("Privilege voucher removed.", "info");
    refreshIcons();
  },

  clearErrors() {
    const nameErr = document.getElementById("order-name-error");
    const phoneErr = document.getElementById("order-phone-error");
    const addressErr = document.getElementById("order-address-error");

    if (nameErr) {
      nameErr.textContent = "";
      nameErr.classList.add("hidden");
    }
    if (phoneErr) {
      phoneErr.textContent = "";
      phoneErr.classList.add("hidden");
    }
    if (addressErr) {
      addressErr.textContent = "";
      addressErr.classList.add("hidden");
    }

    document
      .querySelectorAll("#quick-order-form input, #quick-order-form textarea")
      .forEach((el) => {
        el.classList.remove("border-rose-500", "focus:border-rose-500");
      });
  },

  handleSubmit() {
    this.clearErrors();

    const nameInput = document.getElementById("order-customer-name");
    const phoneInput = document.getElementById("order-customer-phone");
    const addressInput = document.getElementById("order-customer-address");
    const submitBtn = document.getElementById("order-submit-button");
    const btnText = document.getElementById("order-submit-btn-text");

    const name = nameInput ? nameInput.value.trim() : "";
    const phone = phoneInput ? phoneInput.value.trim() : "";
    const address = addressInput ? addressInput.value.trim() : "";

    let hasError = false;

    // 1. Name validation
    if (!name || name.length < 2) {
      const err = document.getElementById("order-name-error");
      if (err) {
        err.textContent = "Please enter your full name.";
        err.classList.remove("hidden");
      }
      if (nameInput) nameInput.classList.add("border-rose-500");
      hasError = true;
    }

    // 2. Phone validation (Bangladeshi 11 digits format)
    const phoneRegex = /^(?:\+88|88)?01[3-9]\d{8}$/;
    if (!phone || !phoneRegex.test(phone.replace(/[\s-]/g, ""))) {
      const err = document.getElementById("order-phone-error");
      if (err) {
        err.textContent =
          "Please provide a valid 11-digit mobile number (e.g. 017XXXXXXXX).";
        err.classList.remove("hidden");
      }
      if (phoneInput) phoneInput.classList.add("border-rose-500");
      hasError = true;
    }

    // 3. Address validation
    if (!address || address.length < 5) {
      const err = document.getElementById("order-address-error");
      if (err) {
        err.textContent =
          "Please provide your full delivery address (House, Road, Area, District).";
        err.classList.remove("hidden");
      }
      if (addressInput) addressInput.classList.add("border-rose-500");
      hasError = true;
    }

    // 4. Cart validation
    if (!STATE.cart || STATE.cart.length === 0) {
      showToast("Your shopping bag is currently empty. Please select a product.", "error");
      hasError = true;
    }

    if (hasError) return;

    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.classList.add("opacity-75", "cursor-not-allowed");
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
      document.querySelector('input[name="order-delivery-zone"]:checked')?.value || "inside";
    const ajaxUrl =
      (window.kinboni && window.kinboni.ajax_url) ||
      (window.kinboni_vars && window.kinboni_vars.ajax_url) ||
      "/wp-admin/admin-ajax.php";
    const nonce =
      (window.kinboni && window.kinboni.nonce) ||
      (window.kinboni_vars && window.kinboni_vars.nonce) ||
      "";

    const formData = new FormData();
    formData.append("action", "kinboni_create_cod_order");
    formData.append("nonce", nonce);
    formData.append("customer_name", name);
    formData.append("customer_phone", phone);
    formData.append("customer_address", address);
    formData.append("delivery_zone", selectedZone);
    formData.append("promo_code", STATE.activePromo || "");
    formData.append("items", JSON.stringify(STATE.cart));

    fetch(ajaxUrl, {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((response) => {
        if (response && response.success && response.data) {
          const data = response.data;
          const formView = document.getElementById("checkout-form-view");
          const successView = document.getElementById("checkout-success-view");

          // Authoritative WooCommerce fields
          const confirmedName = document.getElementById("confirmed-customer-name");
          const confirmedOrderId = document.getElementById("confirmed-order-id");
          const confirmedPhone = document.getElementById("confirmed-customer-phone");
          const confirmedAddress = document.getElementById("confirmed-customer-address");
          const confirmedTotal = document.getElementById("confirmed-order-total");
          const waLink = document.getElementById("confirmed-whatsapp-link");

          if (confirmedName) confirmedName.textContent = data.customer_name;
          if (confirmedOrderId) confirmedOrderId.textContent = "#" + data.order_number;
          if (confirmedPhone) confirmedPhone.textContent = data.customer_phone;
          if (confirmedAddress) confirmedAddress.textContent = data.customer_address;
          if (confirmedTotal) confirmedTotal.textContent = data.formatted_total;
          if (waLink && data.whatsapp_url) {
            waLink.href = data.whatsapp_url;
          }

          if (formView) formView.classList.add("hidden");
          if (successView) successView.classList.remove("hidden");

          // Clear bag & reset form
          CartController.clear();
          const form = document.getElementById("quick-order-form");
          if (form) form.reset();

          showToast(data.message || `Order #${data.order_number} placed successfully!`, "success");
          refreshIcons();
        } else {
          const errMsg =
            (response && response.data && response.data.message) ||
            "Unable to place order. Please review your information.";
          showToast(errMsg, "error");
        }
      })
      .catch((err) => {
        console.error("Kinboni COD Order submission error:", err);
        showToast("Network error while placing order. Please verify your connection.", "error");
      })
      .finally(() => {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.classList.remove("opacity-75", "cursor-not-allowed");
        }
        if (btnText) {
          btnText.textContent = "Confirm Order (Cash on Delivery)";
        }
      });
  },
};

// ==========================================================================
// 13. GLOBAL COPY PROMO HELPER
// ==========================================================================
function copyPromoCode(code = "LUXE20") {
  navigator.clipboard
    .writeText(code)
    .then(() => {
      showToast(
        `Privilege code "${code}" copied! Use at checkout for discount.`,
        "success",
      );
    })
    .catch(() => {
      showToast(`Code: ${code}`, "info");
    });
}

// ==========================================================================
// 14. LIVE RECENT SALES POPUP CONTROLLER (Migrated to Module 08: assets/js/modules/live-sales.js)
// ==========================================================================
const LiveSalesController = (window.KinboniPro && window.KinboniPro.LiveSales)
  ? window.KinboniPro.LiveSales
  : (window.LiveSalesController || {
      init() {},
      showNext() {},
      hide() {},
      openCurrentProduct() {},
    });

// ==========================================================================
// 14B. TESTIMONIAL SLIDER CONTROLLER (Migrated to Module 09: assets/js/modules/testimonials.js)
// ==========================================================================
const TestimonialSliderController = (window.KinboniPro && window.KinboniPro.Testimonials)
  ? window.KinboniPro.Testimonials
  : (window.TestimonialSliderController || {
      swiperInstance: null,
      init() {},
      destroy() {},
    });

// ==========================================================================
// 15. INITIALIZATION ON DOM READY OR IMMEDIATE IF ALREADY LOADED
// ==========================================================================
function bootKinboniApp() {
  try {
    if (typeof ThemeController !== "undefined") ThemeController.init();
    if (typeof CartController !== "undefined") CartController.init();
    if (typeof WishlistController !== "undefined") WishlistController.init();
    if (typeof QuickViewController !== "undefined") QuickViewController.init();
    if (typeof SearchController !== "undefined") SearchController.init();
    if (typeof QuickOrderController !== "undefined")
      QuickOrderController.init();
    if (typeof InteractionController !== "undefined")
      InteractionController.init();
    if (typeof LiveSalesController !== "undefined") LiveSalesController.init();
    if (typeof TestimonialSliderController !== "undefined")
      TestimonialSliderController.init();

    if (typeof ProductRenderer !== "undefined") {
      ProductRenderer.renderFeatured();
      ProductRenderer.renderBestSellers("all");
    }

    refreshIcons();
  } catch (e) {
    // Graceful error suppression
  }
}

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", bootKinboniApp);
} else {
  bootKinboniApp();
}

// Export globals for inline event handlers
window.CartController = CartController;
window.WishlistController = WishlistController;
window.QuickViewController = QuickViewController;
window.registerProduct = registerProduct;
window.QuickOrderController = QuickOrderController;
window.KinboniPro = window.KinboniPro || {};
window.KinboniPro.QuickOrder = QuickOrderController;
window.SearchController = SearchController;
window.ProductRenderer = ProductRenderer;
window.ThemeController = ThemeController;
window.InteractionController = InteractionController;
window.LiveSalesController = LiveSalesController;
window.TestimonialSliderController = TestimonialSliderController;
window.showToast = showToast;
window.copyPromoCode = copyPromoCode;
