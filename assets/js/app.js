/**
 * KINBONI Atelier - Haute Horlogerie & Luxury Goods
 * Ultra-Premium Vanilla JavaScript Engine
 */

// ==========================================================================
// 1. PRODUCT DATABASE (12 Handcrafted Luxury Curations)
// ==========================================================================
const PRODUCTS = [
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
    image: "https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=800&q=80",
    hoverImage: "https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=800&q=80",
    description: "Handcrafted Swiss-precision automatic movement encased in 316L brushed surgical steel with 18k champagne gold indices, exhibition sapphire caseback, and water resistance to 50 meters.",
    specs: ["316L Surgical Grade Steel", "Double-Domed Sapphire Crystal", "50m Water Resistance", "42-Hour Power Reserve"],
    inStock: true,
    featured: true,
    bestSeller: true,
    onSale: true
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
    image: "https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=800&q=80",
    hoverImage: "https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=800&q=80",
    description: "Constructed from full-grain Tuscan vegetable-tanned bridle leather. Features hand-burnished beveled edges, solid antiqued brass hardware, and dedicated suede-lined 16\" laptop sleeve.",
    specs: ["Vegetable-Tanned Tuscan Leather", "Solid Antiqued Brass Hardware", "Fits up to 16\" MacBook Pro", "Lifetime Craftsmanship Warranty"],
    inStock: true,
    featured: true,
    bestSeller: true,
    onSale: true
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
    image: "https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=800&q=80",
    hoverImage: "https://images.unsplash.com/photo-1523293182086-7651a899d37f?auto=format&fit=crop&w=800&q=80",
    description: "An intoxicating olfactory voyage featuring wild Cambodian agarwood, Damascus rose absolute, smoky amber resin, and velvety Bourbon vanilla in a 30% concentration extrait.",
    specs: ["30% Oil Concentration (Extrait)", "Aged Wild Cambodian Oud", "100ml Heavy Faceted Decanter", "12+ Hours Longevity"],
    inStock: true,
    featured: true,
    bestSeller: true,
    onSale: false
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
    image: "https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=800&q=80",
    hoverImage: "https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?auto=format&fit=crop&w=800&q=80",
    description: "An understated open-cuff silhouette cast in certified recycled 925 sterling silver dipped in 5 microns of 18k yellow gold with a hand-satin brushed finish.",
    specs: ["18k Gold Vermeil over 925 Silver", "Satin Matte with Polished Tips", "Flexible Ergonomic Fit", "Hypoallergenic & Nickel-Free"],
    inStock: true,
    featured: true,
    bestSeller: true,
    onSale: true
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
    image: "https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=800&q=80",
    hoverImage: "https://images.unsplash.com/photo-1572635196237-14b3f281503f?auto=format&fit=crop&w=800&q=80",
    description: "Custom bio-acetate frames hand-cut and tumbled in Japan for 72 hours. Fitted with Barberini mineral glass polarized lenses for supreme optical clarity.",
    specs: ["Japanese Mazzucchelli Bio-Acetate", "UVA/UVB 400 Polarized Lenses", "Five-Barrel Teflon Hinges", "Hand-Stamped Gold Serial Number"],
    inStock: true,
    featured: true,
    bestSeller: false,
    onSale: false
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
    image: "https://images.unsplash.com/photo-1601924994987-69e26d50dc26?auto=format&fit=crop&w=800&q=80",
    hoverImage: "https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80",
    description: "Woven from Grade-6A 100% long-strand mulberry silk in a 16-momme twill weave. Features hand-rolled and hand-stitched edges by master Japanese artisans.",
    specs: ["100% 6A Mulberry Raw Silk", "16-Momme Heavyweight Twill", "90cm x 90cm Dimensions", "Hand-Rolled & Stitched Edges"],
    inStock: true,
    featured: true,
    bestSeller: true,
    onSale: true
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
    image: "https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=800&q=80",
    hoverImage: "https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?auto=format&fit=crop&w=800&q=80",
    description: "Slimline minimalist card wallet with 6 quick-access card slots, two hidden currency sleeves, and hand-stitched French linen thread.",
    specs: ["Full-Grain Shell Cordovan Leather", "Linen Thread Hand-Stitched", "Holds 10-12 Cards Comfortably", "RFID Shielding Layer"],
    inStock: true,
    featured: true,
    bestSeller: true,
    onSale: true
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
    image: "https://images.unsplash.com/photo-1547887537-6158d64c35b3?auto=format&fit=crop&w=800&q=80",
    hoverImage: "https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&w=800&q=80",
    description: "An earthy, invigorating fragrance balancing Haitian vetiver root, bergamot rind, crisp cedarwood heart, and sparkling pink peppercorn.",
    specs: ["Organic French Extraction", "Sustainably Harvested Vetiver", "Magnetic Heavy Metal Cap", "Unisex Composition"],
    inStock: true,
    featured: true,
    bestSeller: false,
    onSale: false
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
    image: "https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=800&q=80",
    hoverImage: "https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=800&q=80",
    description: "An architectural tour-de-force showcasing an open-worked skeleton movement with Geneva stripes, blued screws, and a bespoke alligator leather strap.",
    specs: ["Exhibition Caseback with Sapphire", "Skeletonized 28,800 VPH Calibre", "Louisiana Alligator Leather Band", "Individual Serialized Run of 100"],
    inStock: true,
    featured: false,
    bestSeller: true,
    onSale: true
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
    image: "https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=800&q=80",
    hoverImage: "https://images.unsplash.com/photo-1591561954557-26941169b49e?auto=format&fit=crop&w=800&q=80",
    description: "Unstructured day tote crafted from pebble-grain calfskin with reinforced double-handle drop, magnetic top closure, and removable zip pouch.",
    specs: ["Soft Grain Italian Calfskin", "Reinforced Base with Metal Feet", "Internal Key Leash & Zip Pouch", "Generous 25L Capacity"],
    inStock: true,
    featured: false,
    bestSeller: true,
    onSale: false
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
    image: "https://images.unsplash.com/photo-1599643477877-530eb83abc8e?auto=format&fit=crop&w=800&q=80",
    hoverImage: "https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?auto=format&fit=crop&w=800&q=80",
    description: "A luminous AAA South Sea baroque freshwater pearl suspended from a delicate 18-karat solid gold wheat chain with lobster clasp.",
    specs: ["Natural AAA South Sea Baroque Pearl", "18-Inch 18k Solid Gold Chain", "Each Pearl Uniquely Formed", "Luxury Velvet Presentation Box"],
    inStock: true,
    featured: false,
    bestSeller: true,
    onSale: true
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
    image: "https://images.unsplash.com/photo-1508296695146-257a814070b4?auto=format&fit=crop&w=800&q=80",
    hoverImage: "https://images.unsplash.com/photo-1577803645773-f96470509666?auto=format&fit=crop&w=800&q=80",
    description: "Featherlight aerospace-grade Japanese beta-titanium wire frames with custom teardrop silhouettes and gradient warm-sepia scratchproof lenses.",
    specs: ["Aerospace Grade Beta-Titanium", "Weight: Only 18 Grams", "Hypoallergenic Ceramic Nose Pads", "100% Polarization with Anti-Glare"],
    inStock: true,
    featured: false,
    bestSeller: true,
    onSale: false
  }
];

// ==========================================================================
// 2. STATE MANAGEMENT & STORAGE
// ==========================================================================
const STORAGE_KEYS = {
  CART: 'kinboni_cart_v2',
  WISHLIST: 'kinboni_wishlist_v2',
  THEME: 'kinboni_theme_v2',
  PROMO: 'kinboni_promo_v2',
  ANNOUNCEMENT: 'kinboni_announcement_v2'
};

const STATE = {
  cart: [],
  wishlist: [],
  activePromo: null,
  activeFilter: 'all',
  quickViewProduct: null
};

const FREE_SHIPPING_THRESHOLD = 2500;
const PROMO_CODES = {
  'LUXE20': 0.20,
  'KINBONI10': 0.10,
  'WELCOME': 0.15
};

// ==========================================================================
// 3. UTILITIES & TOAST NOTIFICATION
// ==========================================================================
function formatCurrency(amount) {
  return '৳' + Number(amount).toLocaleString('en-US');
}

function refreshIcons() {
  if (window.lucide && typeof window.lucide.createIcons === 'function') {
    try {
      window.lucide.createIcons();
    } catch (e) {
      // Prevents unhandled icon errors
    }
  }
}

function showToast(message, type = 'success') {
  const container = document.getElementById('toast-container');
  if (!container) return;

  const toast = document.createElement('div');
  const icon = type === 'success' ? 'check-circle' : (type === 'error' ? 'alert-circle' : 'info');
  const borderColor = type === 'success' ? 'border-gold-500/50' : (type === 'error' ? 'border-rose-500/50' : 'border-stone-500/50');

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

// ==========================================================================
// 4. THEME CONTROLLER (Dark / Light Mode)
// ==========================================================================
const ThemeController = {
  init() {
    const saved = localStorage.getItem(STORAGE_KEYS.THEME);
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isDark = saved ? saved === 'dark' : systemPrefersDark;

    this.applyTheme(isDark);

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
      if (!localStorage.getItem(STORAGE_KEYS.THEME)) {
        this.applyTheme(e.matches);
      }
    });

    document.querySelectorAll('.theme-toggle-btn').forEach(btn => {
      btn.addEventListener('click', () => this.toggle());
    });
  },

  applyTheme(isDark) {
    if (isDark) {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }

    const sunIcons = document.querySelectorAll('.theme-sun-icon');
    const moonIcons = document.querySelectorAll('.theme-moon-icon');

    if (isDark) {
      sunIcons.forEach(el => el.classList.remove('hidden'));
      moonIcons.forEach(el => el.classList.add('hidden'));
    } else {
      sunIcons.forEach(el => el.classList.add('hidden'));
      moonIcons.forEach(el => el.classList.remove('hidden'));
    }
  },

  toggle() {
    const isDark = document.documentElement.classList.contains('dark');
    const newTheme = !isDark;
    this.applyTheme(newTheme);
    localStorage.setItem(STORAGE_KEYS.THEME, newTheme ? 'dark' : 'light');
    showToast(newTheme ? 'Dark Mode Activated' : 'Light Mode Activated', 'info');
  }
};

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
  const isWishlisted = STATE.wishlist.includes(product.id);
  const discountPercent = product.originalPrice 
    ? Math.round(((product.originalPrice - product.price) / product.originalPrice) * 100) 
    : 0;

  return `
    <div class="group relative flex flex-col bg-white dark:bg-stone-900 border border-stone-200/80 dark:border-stone-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-luxury dark:hover:shadow-luxury-dark hover:border-gold-500/40 dark:hover:border-gold-500/40 transition-all duration-500" data-product-id="${product.id}">
      
      <!-- Image Container -->
      <div class="relative w-full aspect-[4/5] bg-stone-100 dark:bg-stone-950 overflow-hidden cursor-pointer" onclick="QuickViewController.open(${product.id})">
        <!-- Main Image -->
        <img 
          src="${product.image}" 
          alt="${product.name}" 
          loading="lazy"
          class="w-full h-full object-cover object-center transition-all duration-700 ease-out group-hover:scale-105"
        />

        <!-- Secondary Hover Image -->
        <img 
          src="${product.hoverImage}" 
          alt="${product.name} alternate angle" 
          loading="lazy"
          class="absolute inset-0 w-full h-full object-cover object-center opacity-0 transition-opacity duration-700 ease-out group-hover:opacity-100 group-hover:scale-105 pointer-events-none"
        />

        <!-- Badges -->
        <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10 pointer-events-none">
          ${product.badge ? `
            <span class="inline-block px-2.5 py-1 text-[9px] font-bold uppercase tracking-[0.2em] rounded-full bg-stone-950/90 text-stone-100 dark:bg-white/95 dark:text-stone-950 shadow-md backdrop-blur-sm border border-white/10 dark:border-stone-900/10">
              ${product.badge}
            </span>
          ` : ''}
          ${discountPercent > 0 ? `
            <span class="inline-block px-2 py-0.5 text-[9px] font-bold tracking-wider rounded-full bg-rose-600 text-white shadow-md">
              -${discountPercent}%
            </span>
          ` : ''}
        </div>

        <!-- Wishlist Button -->
        <button 
          type="button"
          onclick="event.stopPropagation(); WishlistController.toggle(${product.id})"
          aria-label="${isWishlisted ? 'Remove from wishlist' : 'Add to wishlist'}"
          class="absolute top-3 right-3 z-10 w-9 h-9 rounded-full bg-white/90 dark:bg-stone-900/90 backdrop-blur-md border border-stone-200/80 dark:border-stone-700/80 flex items-center justify-center text-stone-700 dark:text-stone-200 hover:text-rose-500 dark:hover:text-rose-400 hover:scale-110 active:scale-90 transition-all shadow-sm group/wishbtn"
        >
          <svg class="w-4 h-4 transition-colors ${isWishlisted ? 'fill-rose-500 text-rose-500' : 'fill-transparent'}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
          </svg>
        </button>

        <!-- Quick View Action Button (Reveals on Hover) -->
        <div class="absolute inset-x-3 bottom-3 z-10 opacity-0 translate-y-3 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 hidden sm:block">
          <button 
            type="button" 
            onclick="event.stopPropagation(); QuickViewController.open(${product.id})"
            class="w-full py-2.5 px-4 bg-white/95 dark:bg-stone-900/95 backdrop-blur-md hover:bg-gold-400 hover:text-stone-950 dark:hover:bg-gold-400 dark:hover:text-stone-950 text-stone-900 dark:text-stone-100 text-[11px] font-bold uppercase tracking-widest rounded-xl shadow-lg transition-all flex items-center justify-center gap-2"
          >
            <i data-lucide="eye" class="w-4 h-4"></i>
            <span>Quick View</span>
          </button>
        </div>
      </div>

      <!-- Card Details -->
      <div class="p-4 sm:p-5 flex flex-col flex-grow">
        <!-- Category & Rating -->
        <div class="flex items-center justify-between gap-2 mb-2 min-w-0">
          <span class="text-[10px] sm:text-[11px] uppercase tracking-wider font-bold text-gold-600 dark:text-gold-400 truncate">
            ${product.categoryLabel}
          </span>
          ${renderStarRating(product.rating, product.reviewsCount)}
        </div>

        <!-- Title -->
        <h3 class="font-serif text-sm sm:text-base font-medium text-stone-900 dark:text-stone-100 leading-snug line-clamp-2 min-h-[2.5rem] sm:min-h-[2.75rem] mb-2 group-hover:text-gold-600 dark:group-hover:text-gold-400 transition-colors">
          <a href="javascript:void(0)" onclick="QuickViewController.open(${product.id})">
            ${product.name}
          </a>
        </h3>

        <!-- Price Container -->
        <div class="flex items-baseline gap-2 mb-3">
          <span class="font-serif text-base sm:text-lg font-bold text-stone-900 dark:text-white">
            ${formatCurrency(product.price)}
          </span>
          ${product.originalPrice ? `
            <span class="text-xs text-stone-400 dark:text-stone-500 line-through font-normal">
              ${formatCurrency(product.originalPrice)}
            </span>
            <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 ml-auto">
              Save ${formatCurrency(product.originalPrice - product.price)}
            </span>
          ` : ''}
        </div>

        <!-- Action Buttons (Responsive & Ergonomic Flex Layout) -->
        <div class="flex items-center gap-2 mt-auto pt-3 border-t border-stone-100 dark:border-stone-800/80">
          <button 
            type="button" 
            onclick="CartController.add(${product.id}, 1)"
            class="flex-1 py-2.5 px-2 rounded-xl bg-stone-100 dark:bg-stone-800 hover:bg-stone-200 dark:hover:bg-stone-700 text-stone-900 dark:text-stone-100 text-xs font-semibold transition-all duration-200 flex items-center justify-center gap-1.5 active:scale-95"
            title="Add to shopping bag"
          >
            <i data-lucide="shopping-bag" class="w-3.5 h-3.5 flex-shrink-0 text-stone-600 dark:text-stone-300"></i>
            <span class="whitespace-nowrap">Add to Bag</span>
          </button>

          <button 
            type="button" 
            onclick="CartController.buyNow(${product.id})"
            class="flex-1 py-2.5 px-2 rounded-xl bg-gold-400 hover:bg-gold-500 text-stone-950 text-xs font-bold transition-all duration-200 flex items-center justify-center gap-1.5 shadow-sm hover:shadow-gold-500/25 active:scale-95"
            title="Direct Order with Cash on Delivery"
          >
            <i data-lucide="zap" class="w-3.5 h-3.5 fill-stone-950 flex-shrink-0"></i>
            <span class="whitespace-nowrap">Order Now</span>
          </button>
        </div>

      </div>
    </div>
  `;
}

// ==========================================================================
// 6. CART CONTROLLER
// ==========================================================================
const CartController = {
  init() {
    try {
      const saved = localStorage.getItem(STORAGE_KEYS.CART);
      STATE.cart = saved ? JSON.parse(saved) : [];
      
      const savedPromo = localStorage.getItem(STORAGE_KEYS.PROMO);
      if (savedPromo && PROMO_CODES[savedPromo]) {
        STATE.activePromo = savedPromo;
      }
    } catch (e) {
      STATE.cart = [];
    }

    this.render();
    this.updateBadges();

    const backdrop = document.getElementById('cart-drawer-backdrop');
    if (backdrop) backdrop.addEventListener('click', () => this.close());

    const closeBtn = document.getElementById('close-cart-btn');
    if (closeBtn) closeBtn.addEventListener('click', () => this.close());

    window.addEventListener('keydown', (e) => {
      const drawer = document.getElementById('cart-drawer');
      if (e.key === 'Escape' && drawer && !drawer.classList.contains('translate-x-full')) {
        this.close();
      }
    });

    document.querySelectorAll('.open-cart-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        this.open();
      });
    });

    const promoForm = document.getElementById('cart-promo-form');
    if (promoForm) {
      promoForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const input = document.getElementById('cart-promo-input');
        if (input) this.applyPromo(input.value.trim());
      });
    }

    const checkoutBtn = document.getElementById('cart-checkout-btn');
    if (checkoutBtn) {
      checkoutBtn.addEventListener('click', () => this.checkout());
    }
  },

  save() {
    localStorage.setItem(STORAGE_KEYS.CART, JSON.stringify(STATE.cart));
    if (STATE.activePromo) {
      localStorage.setItem(STORAGE_KEYS.PROMO, STATE.activePromo);
    } else {
      localStorage.removeItem(STORAGE_KEYS.PROMO);
    }
    this.updateBadges();
  },

  open() {
    InteractionController.closeMobileMenu();
    WishlistController.close();
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
    refreshIcons();
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
    const product = PRODUCTS.find(p => p.id === productId);
    if (!product) return;

    const existing = STATE.cart.find(item => item.id === productId);
    if (existing) {
      existing.quantity += quantity;
    } else {
      STATE.cart.push({
        id: productId,
        quantity: quantity,
        color: options.color || 'Standard',
        size: options.size || null
      });
    }

    this.save();
    this.render();
    showToast(`"${product.name}" added to shopping bag!`, 'success');

    document.querySelectorAll('.cart-badge-icon').forEach(icon => {
      icon.classList.add('scale-125');
      setTimeout(() => icon.classList.remove('scale-125'), 200);
    });
  },

  updateQuantity(productId, delta) {
    const itemIndex = STATE.cart.findIndex(i => i.id === productId);
    if (itemIndex > -1) {
      STATE.cart[itemIndex].quantity += delta;
      if (STATE.cart[itemIndex].quantity <= 0) {
        STATE.cart.splice(itemIndex, 1);
        showToast('Item removed from bag', 'info');
      }
      this.save();
      this.render();
    }
  },

  remove(productId) {
    STATE.cart = STATE.cart.filter(item => item.id !== productId);
    this.save();
    this.render();
    showToast('Item removed from bag', 'info');
  },

  clear() {
    STATE.cart = [];
    this.save();
    this.render();
  },

  applyPromo(code) {
    const cleanCode = (code ? String(code) : '').trim().toUpperCase();
    if (!cleanCode) {
      showToast('Please enter a voucher code (try "LUXE20").', 'info');
      return;
    }
    const upperCode = cleanCode;
    if (PROMO_CODES[upperCode]) {
      STATE.activePromo = upperCode;
      this.save();
      this.render();
      showToast(`Promo code "${upperCode}" applied! ${PROMO_CODES[upperCode] * 100}% discount applied.`, 'success');
      const input = document.getElementById('cart-promo-input');
      if (input) input.value = '';
    } else {
      showToast('Invalid promo code. Please use "LUXE20".', 'error');
    }
  },

  removePromo() {
    STATE.activePromo = null;
    this.save();
    this.render();
    showToast('Promo code removed', 'info');
  },

  updateBadges() {
    const count = STATE.cart.reduce((total, item) => total + item.quantity, 0);
    document.querySelectorAll('.cart-count-badge').forEach(badge => {
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
    const listContainer = document.getElementById('cart-items-container');
    const emptyState = document.getElementById('cart-empty-state');
    const footerContainer = document.getElementById('cart-footer');
    const subtotalEl = document.getElementById('cart-subtotal');
    const discountRow = document.getElementById('cart-discount-row');
    const discountEl = document.getElementById('cart-discount-amount');
    const totalEl = document.getElementById('cart-total');
    const shippingBar = document.getElementById('free-shipping-progress');
    const shippingText = document.getElementById('free-shipping-text');
    const promoBadge = document.getElementById('cart-applied-promo');

    if (!listContainer) return;

    if (STATE.cart.length === 0) {
      listContainer.innerHTML = '';
      if (emptyState) emptyState.classList.remove('hidden');
      if (footerContainer) footerContainer.classList.add('hidden');
      if (shippingBar) shippingBar.style.width = '0%';
      if (shippingText) {
        shippingText.innerHTML = `Add <strong>${formatCurrency(FREE_SHIPPING_THRESHOLD)}</strong> more for Complimentary Express Shipping`;
      }
      const checkoutBtn = document.getElementById('cart-checkout-btn');
      if (checkoutBtn) {
        checkoutBtn.disabled = true;
        checkoutBtn.classList.add('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
      }
      return;
    }

    if (emptyState) emptyState.classList.add('hidden');
    if (footerContainer) footerContainer.classList.remove('hidden');
    const checkoutBtn = document.getElementById('cart-checkout-btn');
    if (checkoutBtn) {
      checkoutBtn.disabled = false;
      checkoutBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
    }

    let subtotal = 0;

    const itemsHtml = STATE.cart.map(item => {
      const product = PRODUCTS.find(p => p.id === item.id);
      if (!product) return '';

      const itemTotal = product.price * item.quantity;
      subtotal += itemTotal;

      return `
        <div class="flex items-start gap-4 p-3.5 rounded-xl bg-stone-50 dark:bg-stone-800/50 border border-stone-200/60 dark:border-stone-800 transition-all">
          <img 
            src="${product.image}" 
            alt="${product.name}" 
            class="w-20 h-24 object-cover object-center rounded-lg bg-stone-200 dark:bg-stone-900 flex-shrink-0 cursor-pointer"
            onclick="CartController.close(); QuickViewController.open(${product.id});"
          />

          <div class="flex-grow min-w-0">
            <div class="flex items-start justify-between gap-2">
              <div class="min-w-0">
                <p class="text-[10px] uppercase tracking-wider font-semibold text-gold-600 dark:text-gold-400">
                  ${product.categoryLabel}
                </p>
                <h4 class="font-serif text-sm font-medium text-stone-900 dark:text-stone-100 truncate cursor-pointer hover:text-gold-600 transition-colors" onclick="CartController.close(); QuickViewController.open(${product.id});">
                  ${product.name}
                </h4>
              </div>
              <button 
                type="button" 
                onclick="CartController.remove(${product.id})"
                class="text-stone-400 hover:text-rose-500 transition-colors p-1"
                aria-label="Remove item"
              >
                <i data-lucide="trash-2" class="w-4 h-4"></i>
              </button>
            </div>

            <div class="mt-1 text-xs font-semibold text-stone-900 dark:text-stone-100">
              ${formatCurrency(product.price)}
            </div>

            <div class="mt-3 flex items-center justify-between">
              <!-- Quantity Stepper -->
              <div class="flex items-center border border-stone-200 dark:border-stone-700 rounded-lg bg-white dark:bg-stone-900 overflow-hidden">
                <button 
                  type="button" 
                  onclick="CartController.updateQuantity(${product.id}, -1)"
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
                  onclick="CartController.updateQuantity(${product.id}, 1)"
                  class="w-7 h-7 flex items-center justify-center text-stone-600 dark:text-stone-400 hover:bg-stone-100 dark:hover:bg-stone-800 transition-colors"
                  aria-label="Increase quantity"
                >
                  <i data-lucide="plus" class="w-3 h-3"></i>
                </button>
              </div>

              <span class="text-xs font-bold text-stone-900 dark:text-white">
                ${formatCurrency(itemTotal)}
              </span>
            </div>
          </div>
        </div>
      `;
    }).join('');

    listContainer.innerHTML = itemsHtml;

    let discountAmount = 0;
    if (STATE.activePromo && PROMO_CODES[STATE.activePromo]) {
      discountAmount = Math.round(subtotal * PROMO_CODES[STATE.activePromo]);
    }
    const finalTotal = Math.max(0, subtotal - discountAmount);

    if (subtotalEl) subtotalEl.textContent = formatCurrency(subtotal);

    if (discountRow && discountEl) {
      if (discountAmount > 0) {
        discountRow.classList.remove('hidden');
        discountEl.textContent = `-${formatCurrency(discountAmount)}`;
      } else {
        discountRow.classList.add('hidden');
      }
    }

    if (promoBadge) {
      if (STATE.activePromo) {
        promoBadge.innerHTML = `
          <div class="flex items-center justify-between p-2.5 rounded-lg bg-gold-50 dark:bg-gold-950/40 border border-gold-300 dark:border-gold-800 text-xs">
            <div class="flex items-center gap-1.5 text-gold-700 dark:text-gold-300 font-semibold">
              <i data-lucide="tag" class="w-3.5 h-3.5"></i>
              <span>Code <strong>${STATE.activePromo}</strong> (${PROMO_CODES[STATE.activePromo]*100}% OFF)</span>
            </div>
            <button type="button" onclick="CartController.removePromo()" class="text-stone-400 hover:text-stone-700 dark:hover:text-stone-200" aria-label="Remove promo">
              <i data-lucide="x" class="w-3.5 h-3.5"></i>
            </button>
          </div>
        `;
      } else {
        promoBadge.innerHTML = '';
      }
    }

    if (totalEl) totalEl.textContent = formatCurrency(finalTotal);

    if (shippingBar && shippingText) {
      const percentage = Math.min(100, Math.round((subtotal / FREE_SHIPPING_THRESHOLD) * 100));
      shippingBar.style.width = `${percentage}%`;

      if (subtotal >= FREE_SHIPPING_THRESHOLD) {
        shippingText.innerHTML = `🎉 <strong class="text-gold-600 dark:text-gold-400">Complimentary Express Shipping Unlocked!</strong>`;
        shippingBar.classList.add('bg-emerald-500');
        shippingBar.classList.remove('bg-gold-500');
      } else {
        const remaining = FREE_SHIPPING_THRESHOLD - subtotal;
        shippingText.innerHTML = `Add <strong>${formatCurrency(remaining)}</strong> more for Complimentary Express Shipping`;
        shippingBar.classList.remove('bg-emerald-500');
        shippingBar.classList.add('bg-gold-500');
      }
    }

    refreshIcons();
  },

  buyNow(productId) {
    const existing = STATE.cart.find(item => item.id === productId);
    if (!existing) {
      this.add(productId, 1);
    }
    this.close();
    QuickOrderController.open();
  },

  checkout() {
    if (STATE.cart.length === 0) {
      showToast('Your bag is currently empty! Please select a product.', 'error');
      return;
    }
    this.close();
    QuickOrderController.open();
  }
};

// ==========================================================================
// 7. WISHLIST CONTROLLER
// ==========================================================================
const WishlistController = {
  init() {
    try {
      const saved = localStorage.getItem(STORAGE_KEYS.WISHLIST);
      STATE.wishlist = saved ? JSON.parse(saved) : [];
    } catch (e) {
      STATE.wishlist = [];
    }

    this.updateBadges();

    document.querySelectorAll('.open-wishlist-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        this.open();
      });
    });

    const backdrop = document.getElementById('wishlist-drawer-backdrop');
    if (backdrop) backdrop.addEventListener('click', () => this.close());

    const closeBtn = document.getElementById('close-wishlist-btn');
    if (closeBtn) closeBtn.addEventListener('click', () => this.close());
  },

  save() {
    localStorage.setItem(STORAGE_KEYS.WISHLIST, JSON.stringify(STATE.wishlist));
    this.updateBadges();
  },

  toggle(productId) {
    const product = PRODUCTS.find(p => p.id === productId);
    if (!product) return;

    const index = STATE.wishlist.indexOf(productId);
    if (index > -1) {
      STATE.wishlist.splice(index, 1);
      showToast(`Removed "${product.name}" from wishlist`, 'info');
    } else {
      STATE.wishlist.push(productId);
      showToast(`Saved "${product.name}" to wishlist`, 'success');
    }

    this.save();
    this.render();
    
    ProductRenderer.renderFeatured();
    ProductRenderer.renderBestSellers(STATE.activeFilter);
  },

  updateBadges() {
    const count = STATE.wishlist.length;
    document.querySelectorAll('.wishlist-count-badge').forEach(badge => {
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

  open() {
    InteractionController.closeMobileMenu();
    CartController.close();
    this.render();
    const drawer = document.getElementById('wishlist-drawer');
    const backdrop = document.getElementById('wishlist-drawer-backdrop');
    if (drawer && backdrop) {
      backdrop.classList.remove('hidden');
      requestAnimationFrame(() => {
        backdrop.classList.remove('opacity-0');
        drawer.classList.remove('translate-x-full');
      });
      document.body.classList.add('overflow-hidden');
    }
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

  render() {
    const container = document.getElementById('wishlist-items-container');
    const emptyState = document.getElementById('wishlist-empty-state');
    if (!container) return;

    if (STATE.wishlist.length === 0) {
      container.innerHTML = '';
      if (emptyState) emptyState.classList.remove('hidden');
      return;
    }

    if (emptyState) emptyState.classList.add('hidden');

    const html = STATE.wishlist.map(id => {
      const product = PRODUCTS.find(p => p.id === id);
      if (!product) return '';

      return `
        <div class="flex items-center gap-4 p-3.5 rounded-xl bg-stone-50 dark:bg-stone-800/50 border border-stone-200/60 dark:border-stone-800">
          <img 
            src="${product.image}" 
            alt="${product.name}" 
            class="w-16 h-20 object-cover object-center rounded-lg bg-stone-200 dark:bg-stone-900 flex-shrink-0"
          />
          <div class="flex-grow min-w-0">
            <h4 class="font-serif text-sm font-medium text-stone-900 dark:text-stone-100 truncate mb-1">
              ${product.name}
            </h4>
            <div class="text-xs font-bold text-stone-900 dark:text-stone-100 mb-2">
              ${formatCurrency(product.price)}
            </div>
            <div class="flex items-center gap-2">
              <button 
                type="button" 
                onclick="CartController.add(${product.id}, 1); WishlistController.toggle(${product.id})"
                class="px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider bg-gold-400 hover:bg-gold-500 text-stone-950 rounded-lg transition-colors shadow-sm"
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
    refreshIcons();
  }
};

// ==========================================================================
// 8. QUICK VIEW MODAL CONTROLLER (With Dynamic Thumbnail Switching)
// ==========================================================================
const QuickViewController = {
  currentProduct: null,
  quantity: 1,

  init() {
    const modal = document.getElementById('quickview-modal');
    const backdrop = document.getElementById('quickview-backdrop');
    const closeBtn = document.getElementById('close-quickview-btn');

    if (backdrop) backdrop.addEventListener('click', () => this.close());
    if (closeBtn) closeBtn.addEventListener('click', () => this.close());

    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
        this.close();
      }
    });
  },

  switchImage(index, url) {
    const mainImg = document.getElementById('quickview-main-image');
    if (mainImg) mainImg.src = url;

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

  open(productId) {
    const product = PRODUCTS.find(p => p.id === productId);
    if (!product) return;

    this.currentProduct = product;
    this.quantity = 1;

    const modal = document.getElementById('quickview-modal');
    const content = document.getElementById('quickview-content');
    if (!modal || !content) return;

    const isWishlisted = STATE.wishlist.includes(product.id);
    const discountPercent = product.originalPrice 
      ? Math.round(((product.originalPrice - product.price) / product.originalPrice) * 100) 
      : 0;

    content.innerHTML = `
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <!-- Gallery with Thumbnail Switcher -->
        <div class="relative flex flex-col gap-3">
          <div class="relative aspect-[4/5] rounded-2xl overflow-hidden bg-stone-100 dark:bg-stone-950 border border-stone-200 dark:border-stone-800 shadow-md">
            <img 
              id="quickview-main-image"
              src="${product.image}" 
              alt="${product.name}" 
              class="w-full h-full object-cover object-center transition-all duration-300"
            />
          </div>
          
          <div class="flex items-center justify-center gap-3">
            <button 
              type="button" 
              onclick="QuickViewController.switchImage(0, '${product.image}')"
              class="quickview-thumb-btn w-14 h-14 rounded-xl border-2 border-gold-500 ring-2 ring-gold-500/30 overflow-hidden shadow-sm transition-all"
            >
              <img src="${product.image}" alt="${product.name} angle 1" class="w-full h-full object-cover" />
            </button>
            <button 
              type="button" 
              onclick="QuickViewController.switchImage(1, '${product.hoverImage}')"
              class="quickview-thumb-btn w-14 h-14 rounded-xl border-2 border-transparent opacity-60 hover:opacity-100 overflow-hidden shadow-sm transition-all"
            >
              <img src="${product.hoverImage}" alt="${product.name} angle 2" class="w-full h-full object-cover" />
            </button>
          </div>
        </div>

        <!-- Product Specs & Actions -->
        <div class="flex flex-col">
          <div class="flex items-center justify-between mb-2">
            <span class="text-xs uppercase tracking-widest font-bold text-gold-600 dark:text-gold-400">
              ${product.categoryLabel}
            </span>
            ${renderStarRating(product.rating, product.reviewsCount)}
          </div>

          <h2 class="font-serif text-2xl sm:text-3xl font-medium text-stone-900 dark:text-stone-100 mb-2">
            ${product.name}
          </h2>

          <div class="flex items-baseline gap-3 mb-4">
            <span class="text-2xl font-bold text-stone-900 dark:text-white">
              ${formatCurrency(product.price)}
            </span>
            ${product.originalPrice ? `
              <span class="text-base text-stone-400 dark:text-stone-500 line-through">
                ${formatCurrency(product.originalPrice)}
              </span>
              <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-rose-600 text-white">
                Save ${discountPercent}%
              </span>
            ` : ''}
          </div>

          <p class="text-sm text-stone-600 dark:text-stone-300 leading-relaxed mb-6 font-light">
            ${product.description}
          </p>

          <!-- Specifications Bullet Points -->
          <div class="border-t border-b border-stone-200 dark:border-stone-800 py-4 mb-6">
            <h4 class="text-xs font-bold uppercase tracking-wider text-stone-900 dark:text-stone-200 mb-2.5">
              Master Artisan Specifications
            </h4>
            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-stone-600 dark:text-stone-400">
              ${product.specs.map(spec => `
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
                >
                  <i data-lucide="minus" class="w-4 h-4"></i>
                </button>
                <span id="quickview-qty" class="w-8 text-center font-bold text-sm text-stone-900 dark:text-stone-100">1</span>
                <button 
                  type="button" 
                  onclick="QuickViewController.changeQty(1)"
                  class="w-8 h-8 flex items-center justify-center text-stone-600 dark:text-stone-300 hover:text-gold-500 transition-colors"
                >
                  <i data-lucide="plus" class="w-4 h-4"></i>
                </button>
              </div>

              <!-- Wishlist -->
              <button 
                type="button" 
                id="quickview-wishlist-btn" onclick="WishlistController.toggle(${product.id}); QuickViewController.toggleWishlistBtn(${product.id});"
                class="p-3 rounded-xl border border-stone-300 dark:border-stone-700 hover:border-rose-500 text-stone-700 dark:text-stone-200 transition-colors flex items-center justify-center"
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
    refreshIcons();
  },

  changeQty(delta) {
    this.quantity = Math.max(1, this.quantity + delta);
    const qtyEl = document.getElementById('quickview-qty');
    if (qtyEl) qtyEl.textContent = this.quantity;
  },

  addToCart() {
    if (this.currentProduct) {
      CartController.add(this.currentProduct.id, this.quantity);
      this.close();
      CartController.open();
    }
  },

  buyNow() {
    if (this.currentProduct) {
      CartController.add(this.currentProduct.id, this.quantity);
      this.close();
      QuickOrderController.open();
    }
  },

  toggleWishlistBtn(productId) {
    const btn = document.getElementById('quickview-wishlist-btn');
    if (!btn) return;
    const isWishlisted = STATE.wishlist.includes(productId);
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
  }
};

// ==========================================================================
// 9. SEARCH CONTROLLER
// ==========================================================================
const SearchController = {
  debounceTimer: null,

  init() {
    const searchModal = document.getElementById('search-modal');
    const searchInput = document.getElementById('search-input');
    const searchBackdrop = document.getElementById('search-backdrop');
    const closeBtn = document.getElementById('close-search-btn');

    document.querySelectorAll('.open-search-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        this.open();
      });
    });

    if (searchBackdrop) searchBackdrop.addEventListener('click', () => this.close());
    if (closeBtn) closeBtn.addEventListener('click', () => this.close());

    if (searchInput) {
      searchInput.addEventListener('input', (e) => {
        clearTimeout(this.debounceTimer);
        this.debounceTimer = setTimeout(() => {
          this.search(e.target.value.trim());
        }, 150);
      });
    }

    document.querySelectorAll('.search-suggestion-tag').forEach(tag => {
      tag.addEventListener('click', () => {
        const query = tag.getAttribute('data-query');
        if (searchInput && query) {
          clearTimeout(this.debounceTimer);
          searchInput.value = query;
          this.search(query);
        }
      });
    });

    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && searchModal && !searchModal.classList.contains('hidden')) {
        this.close();
      }
    });
  },

  open() {
    InteractionController.closeMobileMenu();
    const modal = document.getElementById('search-modal');
    const input = document.getElementById('search-input');
    if (modal) {
      modal.classList.remove('hidden');
      document.body.classList.add('overflow-hidden');
      setTimeout(() => {
        if (input) input.focus();
      }, 100);
      this.search(input ? input.value.trim() : '');
    }
  },

  close() {
    const modal = document.getElementById('search-modal');
    if (modal) {
      modal.classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
    }
  },

  search(query) {
    const resultsContainer = document.getElementById('search-results-container');
    const countEl = document.getElementById('search-count');
    if (!resultsContainer) return;

    if (!query) {
      resultsContainer.innerHTML = `
        <div class="py-12 text-center text-stone-400 dark:text-stone-500">
          <i data-lucide="search" class="w-10 h-10 mx-auto mb-3 opacity-30"></i>
          <p class="text-sm">Search the Kinboni Atelier archive by product name, category, or materials...</p>
        </div>
      `;
      if (countEl) countEl.textContent = 'Explore All Creations';
      refreshIcons();
      return;
    }

    const q = query.toLowerCase();
    const matches = PRODUCTS.filter(p => 
      p.name.toLowerCase().includes(q) ||
      p.category.toLowerCase().includes(q) ||
      p.categoryLabel.toLowerCase().includes(q) ||
      p.description.toLowerCase().includes(q)
    );

    if (countEl) {
      countEl.textContent = `${matches.length} creation${matches.length === 1 ? '' : 's'} discovered`;
    }

    if (matches.length === 0) {
      resultsContainer.innerHTML = `
        <div class="py-12 text-center">
          <i data-lucide="package-search" class="w-10 h-10 mx-auto mb-3 text-stone-400 opacity-40"></i>
          <h4 class="font-serif text-lg font-medium text-stone-900 dark:text-stone-100 mb-1">No Creations Found</h4>
          <p class="text-xs text-stone-500 dark:text-stone-400 max-w-sm mx-auto">
            We couldn't find any creations matching "${query}". Try searching for "Timepiece", "Leather", "Oud", or "Silk".
          </p>
        </div>
      `;
      refreshIcons();
      return;
    }

    resultsContainer.innerHTML = `
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
        ${matches.map(product => `
          <div class="flex items-center gap-3 p-3 rounded-xl bg-stone-50 dark:bg-stone-800/60 border border-stone-200/60 dark:border-stone-700/60 hover:border-gold-500 transition-colors cursor-pointer group" onclick="SearchController.close(); QuickViewController.open(${product.id});">
            <img src="${product.image}" alt="${product.name}" class="w-14 h-16 object-cover rounded-lg bg-stone-200 flex-shrink-0" />
            <div class="min-w-0 flex-grow">
              <span class="text-[10px] uppercase font-bold tracking-wider text-gold-600 dark:text-gold-400">${product.categoryLabel}</span>
              <h5 class="font-serif text-xs font-semibold text-stone-900 dark:text-stone-100 truncate group-hover:text-gold-500 transition-colors">${product.name}</h5>
              <span class="text-xs font-bold text-stone-900 dark:text-white">${formatCurrency(product.price)}</span>
            </div>
            <button 
              type="button" 
              onclick="event.stopPropagation(); CartController.add(${product.id}, 1);" 
              class="w-8 h-8 rounded-full bg-stone-900 text-white dark:bg-white dark:text-stone-950 flex items-center justify-center hover:bg-gold-500 hover:text-stone-950 transition-colors shadow-sm flex-shrink-0"
              aria-label="Add to bag"
            >
              <i data-lucide="plus" class="w-3.5 h-3.5"></i>
            </button>
          </div>
        `).join('')}
      </div>
    `;

    refreshIcons();
  }
};

// ==========================================================================
// 10. PRODUCT RENDERER & FILTERS
// ==========================================================================
const ProductRenderer = {
  renderFeatured() {
    const grid = document.getElementById('featured-products-grid');
    if (!grid) return;

    const featuredList = PRODUCTS.filter(p => p.featured).slice(0, 8);
    grid.innerHTML = featuredList.map(p => createProductCard(p)).join('');
    refreshIcons();
  },

  renderBestSellers(filter = 'all') {
    STATE.activeFilter = filter;
    const grid = document.getElementById('bestsellers-grid');
    if (!grid) return;

    let list = [];
    if (filter === 'all') {
      list = PRODUCTS.filter(p => p.bestSeller);
    } else if (filter === 'new') {
      list = PRODUCTS.filter(p => p.badge === 'NEW');
    } else if (filter === 'sale') {
      list = PRODUCTS.filter(p => p.onSale);
    } else {
      list = PRODUCTS.filter(p => p.category === filter);
    }

    grid.innerHTML = list.map(p => createProductCard(p)).join('');

    document.querySelectorAll('.bestseller-filter-btn').forEach(btn => {
      const btnFilter = btn.getAttribute('data-filter');
      if (btnFilter === filter) {
        btn.classList.add('bg-stone-900', 'text-white', 'dark:bg-gold-400', 'dark:text-stone-950', 'border-transparent', 'shadow-sm');
        btn.classList.remove('bg-transparent', 'text-stone-700', 'dark:text-stone-300', 'border-stone-300', 'dark:border-stone-700');
      } else {
        btn.classList.remove('bg-stone-900', 'text-white', 'dark:bg-gold-400', 'dark:text-stone-950', 'border-transparent', 'shadow-sm');
        btn.classList.add('bg-transparent', 'text-stone-700', 'dark:text-stone-300', 'border-stone-300', 'dark:border-stone-700');
      }
    });

    refreshIcons();
  }
};

// ==========================================================================
// 11. NEWSLETTER & INTERACTION CONTROLLER
// ==========================================================================
const InteractionController = {
  closeMobileMenu() {
    const mobileMenuDrawer = document.getElementById('mobile-menu-drawer');
    const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');
    if (!mobileMenuDrawer || !mobileMenuBackdrop) return;
    mobileMenuDrawer.classList.add('-translate-x-full');
    mobileMenuBackdrop.classList.add('opacity-0');
    setTimeout(() => {
      mobileMenuBackdrop.classList.add('hidden');
    }, 300);
  },

  init() {
    // Newsletter validation
    const newsletterForm = document.getElementById('newsletter-form');
    if (newsletterForm) {
      newsletterForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const emailInput = document.getElementById('newsletter-email');
        const feedbackEl = document.getElementById('newsletter-feedback');
        const email = emailInput ? emailInput.value.trim() : '';

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
          if (feedbackEl) {
            feedbackEl.className = 'mt-3 text-xs text-rose-500 font-medium block animate-fade-in';
            feedbackEl.textContent = 'Please enter a valid email address.';
          }
          return;
        }

        if (feedbackEl) {
          feedbackEl.className = 'mt-3 text-xs text-emerald-500 dark:text-emerald-400 font-semibold block animate-fade-in';
          feedbackEl.innerHTML = `✨ Welcome to The Kinboni Circle! Your VIP invitation and private 20% privilege code (<strong>LUXE20</strong>) have been delivered.`;
        }
        if (emailInput) emailInput.value = '';
        showToast('Subscribed to Kinboni VIP Archive', 'success');
      });
    }

    // Announcement bar dismiss
    const dismissBtn = document.getElementById('dismiss-announcement-btn');
    const announcementBar = document.getElementById('announcement-bar');
    if (dismissBtn && announcementBar) {
      if (sessionStorage.getItem(STORAGE_KEYS.ANNOUNCEMENT) === 'true') {
        announcementBar.classList.add('hidden');
      }

      dismissBtn.addEventListener('click', () => {
        announcementBar.classList.add('h-0', 'opacity-0', 'overflow-hidden', 'py-0');
        setTimeout(() => announcementBar.classList.add('hidden'), 300);
        sessionStorage.setItem(STORAGE_KEYS.ANNOUNCEMENT, 'true');
      });
    }

    // Mobile navigation drawer
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenuDrawer = document.getElementById('mobile-menu-drawer');
    const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');
    const closeMobileMenuBtn = document.getElementById('close-mobile-menu-btn');

    const toggleMobileMenu = (open) => {
      if (!mobileMenuDrawer || !mobileMenuBackdrop) return;
      if (open) {
        mobileMenuBackdrop.classList.remove('hidden');
        requestAnimationFrame(() => {
          mobileMenuBackdrop.classList.remove('opacity-0');
          mobileMenuDrawer.classList.remove('-translate-x-full');
        });
        document.body.classList.add('overflow-hidden');
      } else {
        mobileMenuDrawer.classList.add('-translate-x-full');
        mobileMenuBackdrop.classList.add('opacity-0');
        setTimeout(() => {
          mobileMenuBackdrop.classList.add('hidden');
          document.body.classList.remove('overflow-hidden');
        }, 300);
      }
    };

    if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', () => toggleMobileMenu(true));
    if (closeMobileMenuBtn) closeMobileMenuBtn.addEventListener('click', () => toggleMobileMenu(false));
    if (mobileMenuBackdrop) mobileMenuBackdrop.addEventListener('click', () => toggleMobileMenu(false));

    document.querySelectorAll('.mobile-nav-link').forEach(link => {
      link.addEventListener('click', () => toggleMobileMenu(false));
    });

    // Sticky Header elevation
    const header = document.getElementById('site-header');
    window.addEventListener('scroll', () => {
      if (!header) return;
      if (window.scrollY > 30) {
        header.classList.add('bg-white/95', 'dark:bg-stone-950/95', 'backdrop-blur-md', 'shadow-sm', 'border-b', 'border-stone-200/60', 'dark:border-stone-800/60');
      } else {
        header.classList.remove('bg-white/95', 'dark:bg-stone-950/95', 'backdrop-blur-md', 'shadow-sm', 'border-b', 'border-stone-200/60', 'dark:border-stone-800/60');
      }

      const backToTopBtn = document.getElementById('back-to-top-btn');
      if (backToTopBtn) {
        if (window.scrollY > 400) {
          backToTopBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
        } else {
          backToTopBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
        }
      }
    });

    const backToTopBtn = document.getElementById('back-to-top-btn');
    if (backToTopBtn) {
      backToTopBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
    }

    // Best Sellers filter buttons
    document.querySelectorAll('.bestseller-filter-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const filter = btn.getAttribute('data-filter');
        ProductRenderer.renderBestSellers(filter);
      });
    });

    // Category click cards (scrolls to bestsellers with proper header offset)
    document.querySelectorAll('.category-card-trigger').forEach(card => {
      card.addEventListener('click', () => {
        const category = card.getAttribute('data-category');
        const bestSellersSection = document.getElementById('bestsellers');
        if (bestSellersSection) {
          bestSellersSection.scrollIntoView({ behavior: 'smooth' });
          ProductRenderer.renderBestSellers(category);
          showToast(`Filtered by ${category.toUpperCase()}`, 'info');
        }
      });
    });

    // Account modal demo
    document.querySelectorAll('.open-account-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        showToast('Member Concierge: Welcome back, Patron!', 'info');
      });
    });
  }
};

// ==========================================================================
// 12. FAST 3-FIELD QUICK ORDER CONTROLLER (Express Cash On Delivery)
// ==========================================================================
const QuickOrderController = {
  currentDeliveryFee: 60,

  init() {
    const modal = document.getElementById('checkout-modal');
    const backdrop = document.getElementById('checkout-backdrop');
    const closeBtn = document.getElementById('close-checkout-modal-btn');
    const closeSuccessBtn = document.getElementById('close-success-view-btn');
    const form = document.getElementById('quick-order-form');

    if (backdrop) backdrop.addEventListener('click', () => this.close());
    if (closeBtn) closeBtn.addEventListener('click', () => this.close());
    if (closeSuccessBtn) closeSuccessBtn.addEventListener('click', () => this.close());

    // Delivery zone selection
    const zoneRadios = document.querySelectorAll('input[name="order-delivery-zone"]');
    zoneRadios.forEach(radio => {
      radio.addEventListener('change', (e) => {
        this.updateDeliveryFee(e.target.value);
      });
    });

    // Name real-time input validation
    const nameInput = document.getElementById('order-customer-name');
    if (nameInput) {
      nameInput.addEventListener('input', (e) => {
        if (e.target.value.trim().length >= 2) {
          nameInput.classList.remove('border-rose-500');
          const err = document.getElementById('order-name-error');
          if (err) err.classList.add('hidden');
        }
      });
    }

    // Phone real-time input formatting
    const phoneInput = document.getElementById('order-customer-phone');
    if (phoneInput) {
      phoneInput.addEventListener('input', (e) => {
        const cleaned = e.target.value.replace(/[^\d+]/g, '');
        e.target.value = cleaned;
        if (cleaned.length >= 11) {
          phoneInput.classList.remove('border-rose-500');
          const err = document.getElementById('order-phone-error');
          if (err) err.classList.add('hidden');
        }
      });
    }

    // Address real-time input validation
    const addressInput = document.getElementById('order-customer-address');
    if (addressInput) {
      addressInput.addEventListener('input', (e) => {
        if (e.target.value.trim().length >= 5) {
          addressInput.classList.remove('border-rose-500');
          const err = document.getElementById('order-address-error');
          if (err) err.classList.add('hidden');
        }
      });
    }

    if (form) {
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        this.handleSubmit();
      });
    }

    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
        this.close();
      }
    });
  },

  open() {
    if (STATE.cart.length === 0) {
      showToast('Your shopping bag is currently empty. Please select a product.', 'error');
      return;
    }

    CartController.close();
    QuickViewController.close();

    const modal = document.getElementById('checkout-modal');
    const formView = document.getElementById('checkout-form-view');
    const successView = document.getElementById('checkout-success-view');

    if (!modal || !formView || !successView) return;

    formView.classList.remove('hidden');
    successView.classList.add('hidden');

    this.clearErrors();
    this.renderItemsPreview();
    
    // Set initial zone styling
    const selectedZone = document.querySelector('input[name="order-delivery-zone"]:checked')?.value || 'inside';
    this.updateDeliveryFee(selectedZone);

    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
    refreshIcons();
  },

  close() {
    const modal = document.getElementById('checkout-modal');
    if (modal) {
      modal.classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
    }
  },

  renderItemsPreview() {
    const container = document.getElementById('checkout-items-preview');
    if (!container) return;

    const itemsHtml = STATE.cart.map(item => {
      const product = PRODUCTS.find(p => p.id === item.id);
      if (!product) return '';
      return `
        <div class="flex items-center gap-3.5 p-3 rounded-2xl bg-white dark:bg-stone-900 border border-stone-200/80 dark:border-stone-800 shadow-2xs hover:border-gold-500/30 transition-colors">
          <img 
            src="${product.image}" 
            alt="${product.name}" 
            class="w-14 h-16 sm:w-16 sm:h-20 object-cover object-center rounded-xl bg-stone-100 dark:bg-stone-950 border border-stone-200/60 dark:border-stone-800 flex-shrink-0" 
          />
          <div class="flex-grow min-w-0">
            <span class="text-[9px] uppercase tracking-wider font-bold text-gold-600 dark:text-gold-400 block">
              ${product.categoryLabel}
            </span>
            <h5 class="font-serif text-xs sm:text-sm font-semibold text-stone-900 dark:text-stone-100 truncate">
              ${product.name}
            </h5>
            <div class="flex items-center justify-between mt-1.5 text-xs">
              <span class="text-stone-500 dark:text-stone-400 text-[11px]">
                Qty: <strong class="text-stone-900 dark:text-stone-200">${item.quantity}</strong> × ${formatCurrency(product.price)}
              </span>
              <span class="font-serif font-bold text-stone-900 dark:text-white">
                ${formatCurrency(product.price * item.quantity)}
              </span>
            </div>
          </div>
        </div>
      `;
    }).join('');

    container.innerHTML = itemsHtml;
  },

  updateDeliveryFee(zone) {
    const subtotal = STATE.cart.reduce((sum, item) => {
      const p = PRODUCTS.find(prod => prod.id === item.id);
      return sum + (p ? p.price * item.quantity : 0);
    }, 0);

    const isFree = subtotal >= FREE_SHIPPING_THRESHOLD;
    if (isFree) {
      this.currentDeliveryFee = 0;
    } else {
      this.currentDeliveryFee = (zone === 'outside') ? 120 : 60;
    }

    // Toggle active classes on zone labels
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

  calculateTotals() {
    const subtotalEl = document.getElementById('order-modal-subtotal');
    const discountRow = document.getElementById('order-modal-discount-row');
    const discountEl = document.getElementById('order-modal-discount');
    const shippingEl = document.getElementById('order-modal-shipping');
    const totalEl = document.getElementById('order-modal-total');
    const zoneFeeInside = document.getElementById('zone-fee-inside');
    const zoneFeeOutside = document.getElementById('zone-fee-outside');

    const subtotal = STATE.cart.reduce((sum, item) => {
      const p = PRODUCTS.find(prod => prod.id === item.id);
      return sum + (p ? p.price * item.quantity : 0);
    }, 0);

    let discountAmount = 0;
    if (STATE.activePromo && PROMO_CODES[STATE.activePromo]) {
      discountAmount = Math.round(subtotal * PROMO_CODES[STATE.activePromo]);
    }

    const isFree = subtotal >= FREE_SHIPPING_THRESHOLD;
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

    if (subtotalEl) subtotalEl.textContent = formatCurrency(subtotal);

    if (discountRow && discountEl) {
      if (discountAmount > 0) {
        discountRow.classList.remove('hidden');
        discountEl.textContent = `-${formatCurrency(discountAmount)}`;
      } else {
        discountRow.classList.add('hidden');
      }
    }

    if (shippingEl) {
      shippingEl.textContent = this.currentDeliveryFee === 0 ? 'Free' : formatCurrency(this.currentDeliveryFee);
    }

    if (totalEl) totalEl.textContent = formatCurrency(finalTotal);

    // Update applied promo badge in checkout modal
    const modalPromoBadge = document.getElementById('order-modal-applied-promo');
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
        modalPromoBadge.innerHTML = '';
      }
    }
  },

  applyModalPromo() {
    const input = document.getElementById('order-modal-promo-input');
    const code = (input && input.value) ? String(input.value).trim().toUpperCase() : '';
    if (!code) {
      showToast('Please enter a voucher code (e.g. LUXE20).', 'info');
      return;
    }
    if (PROMO_CODES[code]) {
      STATE.activePromo = code;
      CartController.save();
      this.calculateTotals();
      CartController.render();
      showToast(`Privilege voucher "${code}" applied! ${PROMO_CODES[code] * 100}% privilege deducted.`, 'success');
      if (input) input.value = '';
      refreshIcons();
    } else {
      showToast('Invalid voucher code. Try "LUXE20" for 20% privilege.', 'error');
    }
  },

  removeModalPromo() {
    STATE.activePromo = null;
    CartController.save();
    this.calculateTotals();
    CartController.render();
    showToast('Privilege voucher removed.', 'info');
    refreshIcons();
  },

  clearErrors() {
    const nameErr = document.getElementById('order-name-error');
    const phoneErr = document.getElementById('order-phone-error');
    const addressErr = document.getElementById('order-address-error');

    if (nameErr) { nameErr.textContent = ''; nameErr.classList.add('hidden'); }
    if (phoneErr) { phoneErr.textContent = ''; phoneErr.classList.add('hidden'); }
    if (addressErr) { addressErr.textContent = ''; addressErr.classList.add('hidden'); }

    document.querySelectorAll('#quick-order-form input, #quick-order-form textarea').forEach(el => {
      el.classList.remove('border-rose-500', 'focus:border-rose-500');
    });
  },

  handleSubmit() {
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

    if (hasError) return;

    if (submitBtn && btnText) {
      submitBtn.disabled = true;
      btnText.textContent = 'Processing Bespoke Order...';
    }

    setTimeout(() => {
      const orderId = 'KB-' + Math.floor(100000 + Math.random() * 900000);
      const subtotal = STATE.cart.reduce((sum, item) => {
        const p = PRODUCTS.find(prod => prod.id === item.id);
        return sum + (p ? p.price * item.quantity : 0);
      }, 0);
      let discountAmount = 0;
      if (STATE.activePromo && PROMO_CODES[STATE.activePromo]) {
        discountAmount = Math.round(subtotal * PROMO_CODES[STATE.activePromo]);
      }
      const totalPayable = Math.max(0, subtotal - discountAmount + this.currentDeliveryFee);

      const formView = document.getElementById('checkout-form-view');
      const successView = document.getElementById('checkout-success-view');

      document.getElementById('confirmed-customer-name').textContent = name;
      document.getElementById('confirmed-order-id').textContent = '#' + orderId;
      document.getElementById('confirmed-customer-phone').textContent = phone;
      document.getElementById('confirmed-customer-address').textContent = address;
      document.getElementById('confirmed-order-total').textContent = formatCurrency(totalPayable);

      const itemsListText = STATE.cart.map(item => {
        const p = PRODUCTS.find(prod => prod.id === item.id);
        return p ? `${p.name} (Qty: ${item.quantity})` : '';
      }).filter(Boolean).join(', ');

      const waMsg = `Hello Kinboni Atelier! I have placed a Cash on Delivery order:\n\nOrder Reference: #${orderId}\nName: ${name}\nPhone: ${phone}\nAddress: ${address}\nItems:\n${itemsListText}\nTotal Payable: ${formatCurrency(totalPayable)} (Cash on Delivery)\n\nPlease confirm and dispatch promptly.`;
      
      const waLink = document.getElementById('confirmed-whatsapp-link');
      if (waLink) {
        waLink.href = `https://wa.me/8801711000000?text=${encodeURIComponent(waMsg)}`;
      }

      if (formView) formView.classList.add('hidden');
      if (successView) successView.classList.remove('hidden');

      CartController.clear();

      const form = document.getElementById('quick-order-form');
      if (form) form.reset();

      if (submitBtn && btnText) {
        submitBtn.disabled = false;
        btnText.textContent = 'Confirm Order (Cash on Delivery)';
      }

      showToast(`Order #${orderId} placed successfully!`, 'success');
      refreshIcons();
    }, 600);
  }
};

// ==========================================================================
// 13. GLOBAL COPY PROMO HELPER
// ==========================================================================
function copyPromoCode(code = 'LUXE20') {
  navigator.clipboard.writeText(code).then(() => {
    showToast(`Privilege code "${code}" copied! Use at checkout for discount.`, 'success');
  }).catch(() => {
    showToast(`Code: ${code}`, 'info');
  });
}

// ==========================================================================
// 14. LIVE RECENT SALES POPUP CONTROLLER (15s Loop with Audio Chime)
// ==========================================================================
const LiveSalesController = {
  currentIndex: 0,
  currentProductId: 1,
  timerId: null,
  hideTimerId: null,
  isPaused: false,
  displayDuration: 8500,  // Stays visible for 8.5 seconds
  intervalDuration: 15000, // Repeats every 15 seconds

  buyers: [
    { location: 'Gulshan-2, Dhaka', time: 'Just now' },
    { location: 'Dhanmondi, Dhaka', time: '1 minute ago' },
    { location: 'Banani, Dhaka', time: '2 minutes ago' },
    { location: 'Uttara Sector 7, Dhaka', time: 'Just now' },
    { location: 'GEC Circle, Chittagong', time: '3 minutes ago' },
    { location: 'Sylhet Sadar, Sylhet', time: '1 minute ago' },
    { location: 'Mirpur DOHS, Dhaka', time: '4 minutes ago' },
    { location: 'Motijheel C/A, Dhaka', time: 'Just now' },
    { location: 'Khulna Sadar, Khulna', time: '2 minutes ago' },
    { location: 'Bashundhara R/A, Dhaka', time: '5 minutes ago' }
  ],

  hasUserInteracted: false,
  audioCtx: null,

  openCurrentProduct() {
    const product = PRODUCTS.find(p => p.id === this.currentProductId);
    if (product) {
      this.hide();
      QuickViewController.open(product.id);
    }
  },

  playLuxuryChime() {
    // Only play audio if user has interacted with document to comply with browser autoplay policies
    if (!this.hasUserInteracted) return;

    try {
      const AudioCtx = window.AudioContext || window.webkitAudioContext;
      if (!AudioCtx) return;
      if (!this.audioCtx) {
        this.audioCtx = new AudioCtx();
      }
      const ctx = this.audioCtx;
      if (ctx.state === 'suspended') {
        ctx.resume().catch(() => {});
      }
      if (ctx.state !== 'running') return;

      const osc = ctx.createOscillator();
      const gain = ctx.createGain();

      osc.type = 'sine';
      // Harmonic luxury chime: 587.33Hz (D5) glides up to 880Hz (A5)
      osc.frequency.setValueAtTime(587.33, ctx.currentTime);
      osc.frequency.exponentialRampToValueAtTime(880, ctx.currentTime + 0.08);

      gain.gain.setValueAtTime(0.08, ctx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + 0.35);

      osc.connect(gain);
      gain.connect(ctx.destination);

      osc.start();
      osc.stop(ctx.currentTime + 0.35);
    } catch (e) {
      // Browser autoplay policy fallback
    }
  },

  init() {
    const popup = document.getElementById('live-sales-popup');
    const card = document.getElementById('live-sales-card');
    const closeBtn = document.getElementById('close-live-sale-btn');

    if (!popup || !card) return;

    // Listen for any user gesture to safely unlock audio without console warnings
    const unlockAudio = () => {
      this.hasUserInteracted = true;
      ['click', 'touchstart', 'keydown', 'scroll'].forEach(evt => {
        window.removeEventListener(evt, unlockAudio);
      });
    };
    ['click', 'touchstart', 'keydown', 'scroll'].forEach(evt => {
      window.addEventListener(evt, unlockAudio, { passive: true });
    });

    // Clicking card opens Quick View modal
    card.addEventListener('click', (e) => {
      if (e.target.closest('#close-live-sale-btn')) return;
      this.openCurrentProduct();
    });

    // Dismiss button
    if (closeBtn) {
      closeBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        this.hide();
      });
    }

    // Hover pauses auto-hide
    card.addEventListener('mouseenter', () => {
      this.isPaused = true;
      if (this.hideTimerId) clearTimeout(this.hideTimerId);
    });

    card.addEventListener('mouseleave', () => {
      this.isPaused = false;
      this.scheduleHide(3000);
    });

    // First appearance 3.5 seconds after page load
    setTimeout(() => {
      this.showNext();
      this.timerId = setInterval(() => {
        if (!this.isPaused) {
          this.showNext();
        }
      }, this.intervalDuration);
    }, 3500);
  },

  showNext() {
    const popup = document.getElementById('live-sales-popup');
    const imgEl = document.getElementById('live-sale-image');
    const nameEl = document.getElementById('live-sale-name');
    const priceEl = document.getElementById('live-sale-price');
    const buyerEl = document.getElementById('live-sale-buyer');

    if (!popup || !imgEl || !nameEl || !priceEl || !buyerEl) return;

    const product = PRODUCTS[this.currentIndex];
    const buyer = this.buyers[this.currentIndex % this.buyers.length];

    if (!product) return;

    this.currentProductId = product.id;

    imgEl.src = product.image;
    imgEl.alt = product.name;
    nameEl.textContent = product.name;
    priceEl.textContent = formatCurrency(product.price);
    buyerEl.textContent = `${buyer.location} • ${buyer.time}`;

    // Play gentle audio chime
    this.playLuxuryChime();

    // Slide up with animation
    popup.classList.remove('translate-y-8', 'opacity-0', 'pointer-events-none');
    popup.classList.add('translate-y-0', 'opacity-100');

    refreshIcons();

    // Schedule auto-hide
    this.scheduleHide(this.displayDuration);

    // Loop to next product
    this.currentIndex = (this.currentIndex + 1) % PRODUCTS.length;
  },

  scheduleHide(delay = 8500) {
    if (this.hideTimerId) clearTimeout(this.hideTimerId);
    this.hideTimerId = setTimeout(() => {
      if (!this.isPaused) {
        this.hide();
      }
    }, delay);
  },

  hide() {
    const popup = document.getElementById('live-sales-popup');
    if (!popup) return;
    popup.classList.remove('translate-y-0', 'opacity-100');
    popup.classList.add('translate-y-8', 'opacity-0', 'pointer-events-none');
  }
};

// ==========================================================================
// 14B. TESTIMONIAL SLIDER CONTROLLER (Swiper.js)
// ==========================================================================
const TestimonialSliderController = {
  swiperInstance: null,

  init() {
    const swiperEl = document.querySelector('.testimonial-swiper');
    if (!swiperEl) return;

    if (typeof Swiper === 'undefined') {
      console.warn('Swiper JS is not loaded.');
      return;
    }

    try {
      this.swiperInstance = new Swiper('.testimonial-swiper', {
        slidesPerView: 1,
        spaceBetween: 24,
        loop: true,
        speed: 750,
        grabCursor: true,
        autoplay: {
          delay: 4500,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        },
        pagination: {
          el: '.testimonial-swiper .swiper-pagination',
          clickable: true,
        },
        navigation: {
          nextEl: '#testimonial-next-btn',
          prevEl: '#testimonial-prev-btn',
        },
        breakpoints: {
          640: {
            slidesPerView: 1.5,
            spaceBetween: 24,
          },
          768: {
            slidesPerView: 2,
            spaceBetween: 28,
          },
          1024: {
            slidesPerView: 3,
            spaceBetween: 32,
          },
        },
        on: {
          init: () => {
            setTimeout(refreshIcons, 50);
          }
        }
      });
      refreshIcons();
    } catch (e) {
      console.error('Error initializing Testimonial Swiper:', e);
    }
  }
};

// ==========================================================================
// 15. INITIALIZATION ON DOM READY
// ==========================================================================
document.addEventListener('DOMContentLoaded', () => {
  ThemeController.init();
  CartController.init();
  WishlistController.init();
  QuickViewController.init();
  SearchController.init();
  QuickOrderController.init();
  InteractionController.init();
  LiveSalesController.init();
  TestimonialSliderController.init();

  ProductRenderer.renderFeatured();
  ProductRenderer.renderBestSellers('all');

  refreshIcons();
});

// Export globals for inline event handlers
window.CartController = CartController;
window.WishlistController = WishlistController;
window.QuickViewController = QuickViewController;
window.QuickOrderController = QuickOrderController;
window.SearchController = SearchController;
window.ProductRenderer = ProductRenderer;
window.ThemeController = ThemeController;
window.InteractionController = InteractionController;
window.LiveSalesController = LiveSalesController;
window.TestimonialSliderController = TestimonialSliderController;
window.showToast = showToast;
window.copyPromoCode = copyPromoCode;
