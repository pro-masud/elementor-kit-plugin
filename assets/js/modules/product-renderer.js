/**
 * KINBONI Pro — Product Renderer & Filtering Module (Module 06: ProductRenderer)
 * 
 * Powered authoritatively by WooCommerce & Storefront Data:
 *  - #featured-products-grid
 *  - #bestsellers-grid
 *  - Category tab filtering (All, Timepieces, Leather, Fragrance, Jewelry, Eyewear, etc.)
 *  - Empty states ("No Products Added Yet")
 *  - Dynamic product card generation with dual-image hover & action triggers
 * 
 * @package KinboniPro
 */

(function(window, document) {
  'use strict';

  function safeFormatCurrency(amount) {
    if (typeof window.formatCurrency === 'function') {
      return window.formatCurrency(amount);
    }
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

  function getProductsList() {
    if (Array.isArray(window.PRODUCTS) && window.PRODUCTS.length > 0) {
      return window.PRODUCTS;
    }
    if (window.kinboni && Array.isArray(window.kinboni.products) && window.kinboni.products.length > 0) {
      window.PRODUCTS = window.kinboni.products.slice();
      return window.PRODUCTS;
    }
    return [];
  }

  function isProductWishlisted(productId) {
    const idNum = Number(productId);
    if (window.KinboniPro?.Wishlist && typeof window.KinboniPro.Wishlist.has === 'function') {
      return window.KinboniPro.Wishlist.has(idNum);
    }
    if (window.STATE && Array.isArray(window.STATE.wishlist)) {
      return window.STATE.wishlist.includes(idNum) || window.STATE.wishlist.includes(productId);
    }
    return false;
  }

  function renderStarRating(rating, reviewsCount) {
    if (typeof window.renderStarRating === 'function') {
      return window.renderStarRating(rating, reviewsCount);
    }
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

  function createProductCard(product) {
    if (!product) return '';
    const id = product.id;
    const isWishlisted = isProductWishlisted(id);
    const regularPrice = product.originalPrice || product.regularPrice || null;
    const currentPrice = typeof product.price === 'number' ? product.price : parseFloat(product.price_raw || product.price || 0);
    const hasDiscount = regularPrice && regularPrice > currentPrice;
    const discountPercent = hasDiscount
      ? Math.round(((regularPrice - currentPrice) / regularPrice) * 100)
      : 0;

    const mainImg = product.image || '';
    const hoverImg = product.hoverImage || mainImg;
    const categoryLabel = product.categoryLabel || product.badge || 'Fine Collection';

    return `
      <div class="group relative flex flex-col bg-white dark:bg-stone-900 border border-stone-200/80 dark:border-stone-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-luxury dark:hover:shadow-luxury-dark hover:border-gold-500/40 dark:hover:border-gold-500/40 transition-all duration-500" data-product-id="${id}">
        
        <!-- Image Container -->
        <div class="relative w-full aspect-[4/5] bg-stone-100 dark:bg-stone-950 overflow-hidden cursor-pointer" onclick="QuickViewController.open(${id})">
          <!-- Main Image -->
          <img 
            src="${mainImg}" 
            alt="${escapeHtml(product.name)}" 
            loading="lazy"
            class="w-full h-full object-cover object-center transition-all duration-700 ease-out group-hover:scale-105"
          />

          <!-- Secondary Hover Image -->
          <img 
            src="${hoverImg}" 
            alt="${escapeHtml(product.name)} alternate angle" 
            loading="lazy"
            class="absolute inset-0 w-full h-full object-cover object-center opacity-0 transition-opacity duration-700 ease-out group-hover:opacity-100 group-hover:scale-105 pointer-events-none"
          />

          <!-- Badges -->
          <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10 pointer-events-none">
            ${
              product.badge
                ? `
              <span class="inline-block px-2.5 py-1 text-[9px] font-bold uppercase tracking-[0.2em] rounded-full bg-stone-950/90 text-stone-100 dark:bg-white/95 dark:text-stone-950 shadow-md backdrop-blur-sm border border-white/10 dark:border-stone-900/10">
                ${escapeHtml(product.badge)}
              </span>
            `
                : ''
            }
            ${
              discountPercent > 0
                ? `
              <span class="inline-block px-2 py-0.5 text-[9px] font-bold tracking-wider rounded-full bg-rose-600 text-white shadow-md">
                -${discountPercent}%
              </span>
            `
                : ''
            }
          </div>

          <!-- Wishlist Button -->
          <button 
            type="button"
            onclick="event.stopPropagation(); WishlistController.toggle(${id})"
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
              onclick="event.stopPropagation(); QuickViewController.open(${id})"
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
              ${escapeHtml(categoryLabel)}
            </span>
            ${renderStarRating(product.rating, product.reviewsCount)}
          </div>

          <!-- Title -->
          <h3 class="font-serif text-sm sm:text-base font-medium text-stone-900 dark:text-stone-100 leading-snug line-clamp-2 min-h-[2.5rem] sm:min-h-[2.75rem] mb-2 group-hover:text-gold-600 dark:group-hover:text-gold-400 transition-colors">
            <a href="javascript:void(0)" onclick="QuickViewController.open(${id})">
              ${escapeHtml(product.name)}
            </a>
          </h3>

          <!-- Price Container -->
          <div class="flex items-baseline gap-2 mb-3">
            <span class="font-serif text-base sm:text-lg font-bold text-stone-900 dark:text-white">
              ${safeFormatCurrency(currentPrice)}
            </span>
            ${
              hasDiscount
                ? `
              <span class="text-xs text-stone-400 dark:text-stone-500 line-through font-normal">
                ${safeFormatCurrency(regularPrice)}
              </span>
              <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 ml-auto">
                Save ${safeFormatCurrency(regularPrice - currentPrice)}
              </span>
            `
                : ''
            }
          </div>

          <!-- Action Buttons -->
          <div class="flex items-center gap-2 mt-auto pt-3 border-t border-stone-100 dark:border-stone-800/80">
            <button 
              type="button" 
              onclick="CartController.add(${id}, 1)"
              class="flex-1 py-2.5 px-2 rounded-xl bg-stone-100 dark:bg-stone-800 hover:bg-stone-200 dark:hover:bg-stone-700 text-stone-900 dark:text-stone-100 text-xs font-semibold transition-all duration-200 flex items-center justify-center gap-1.5 active:scale-95"
              title="Add to shopping bag"
            >
              <i data-lucide="shopping-bag" class="w-3.5 h-3.5 flex-shrink-0 text-stone-600 dark:text-stone-300"></i>
              <span class="whitespace-nowrap">Add to Bag</span>
            </button>

            <button 
              type="button" 
              onclick="CartController.buyNow(${id})"
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

  function escapeHtml(str) {
    if (!str) return '';
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  const ProductRenderer = {
    activeFilter: 'all',

    init() {
      // 1. Category Filter Tabs in Best Sellers Section
      document.querySelectorAll('.bestseller-filter-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
          const filter = btn.getAttribute('data-filter');
          if (filter) {
            this.renderBestSellers(filter);
          }
        });
      });

      // 2. Category Cards Click Triggers (scrolls smoothly to #bestsellers)
      document.querySelectorAll('.category-card-trigger').forEach((card) => {
        card.addEventListener('click', () => {
          const category = card.getAttribute('data-category');
          const bestSellersSection = document.getElementById('bestsellers');
          if (bestSellersSection && category) {
            bestSellersSection.scrollIntoView({ behavior: 'smooth' });
            this.renderBestSellers(category);
            safeToast(`Filtered by ${category.toUpperCase()}`, 'info');
          }
        });
      });

      // 3. Render initial catalog grids
      this.renderFeatured();
      this.renderBestSellers('all');
    },

    renderFeatured() {
      const grid = document.getElementById('featured-products-grid');
      if (!grid) return;

      const products = getProductsList();

      if (!products || products.length === 0) {
        const adminUrl = (window.kinboni && window.kinboni.admin_url)
          ? window.kinboni.admin_url
          : '/wp-admin/admin.php?page=kinboni-pro#products';

        grid.innerHTML = `
          <div class="col-span-full py-16 px-6 text-center border-2 border-dashed border-stone-200 dark:border-stone-800 rounded-2xl bg-stone-50/50 dark:bg-stone-900/40">
            <div class="w-14 h-14 rounded-full bg-gold-500/10 text-gold-500 mx-auto flex items-center justify-center mb-4">
              <i data-lucide="package-plus" class="w-7 h-7"></i>
            </div>
            <h3 class="font-serif text-xl sm:text-2xl font-medium text-stone-900 dark:text-white mb-2">No Products Added Yet</h3>
            <p class="text-xs sm:text-sm text-stone-500 dark:text-stone-400 max-w-md mx-auto mb-6">
              Create products in your KINBONI Pro Dashboard or run the 1-Click Demo Import to showcase your creations here.
            </p>
            <div class="flex items-center justify-center gap-3 flex-wrap">
              <a href="${adminUrl}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-gold-400 hover:bg-gold-500 text-stone-950 text-xs font-bold uppercase tracking-wider transition-all shadow-sm hover:scale-105 active:scale-95">
                <i data-lucide="plus" class="w-4 h-4"></i> Add Products in Dashboard
              </a>
            </div>
          </div>
        `;
        safeRefreshIcons();
        return;
      }

      const featuredList = products.filter((p) => p.featured).slice(0, 8);
      const displayList = featuredList.length > 0 ? featuredList : products.slice(0, 8);
      grid.innerHTML = displayList.map((p) => createProductCard(p)).join('');
      safeRefreshIcons();
    },

    renderBestSellers(filter = 'all') {
      this.activeFilter = filter;
      if (window.STATE) {
        window.STATE.activeFilter = filter;
      }

      const grid = document.getElementById('bestsellers-grid');
      if (!grid) return;

      const products = getProductsList();

      if (!products || products.length === 0) {
        const adminUrl = (window.kinboni && window.kinboni.admin_url)
          ? window.kinboni.admin_url
          : '/wp-admin/admin.php?page=kinboni-pro#products';

        grid.innerHTML = `
          <div class="col-span-full py-16 px-6 text-center border-2 border-dashed border-stone-200 dark:border-stone-800 rounded-2xl bg-stone-50/50 dark:bg-stone-900/40">
            <div class="w-14 h-14 rounded-full bg-gold-500/10 text-gold-500 mx-auto flex items-center justify-center mb-4">
              <i data-lucide="package-plus" class="w-7 h-7"></i>
            </div>
            <h3 class="font-serif text-xl sm:text-2xl font-medium text-stone-900 dark:text-white mb-2">No Products in Catalogue</h3>
            <p class="text-xs sm:text-sm text-stone-500 dark:text-stone-400 max-w-md mx-auto mb-6">
              Add creations from your KINBONI Pro Dashboard to showcase them across your atelier collections.
            </p>
            <div class="flex items-center justify-center gap-3 flex-wrap">
              <a href="${adminUrl}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-gold-400 hover:bg-gold-500 text-stone-950 text-xs font-bold uppercase tracking-wider transition-all shadow-sm hover:scale-105 active:scale-95">
                <i data-lucide="plus" class="w-4 h-4"></i> Add Products in Dashboard
              </a>
            </div>
          </div>
        `;
        safeRefreshIcons();
        return;
      }

      const fLower = (filter || 'all').toLowerCase();
      let list = [];

      if (fLower === 'all') {
        list = products.filter((p) => p.bestSeller);
        if (list.length === 0) list = products;
      } else if (fLower === 'new') {
        list = products.filter((p) => (p.badge || '').toUpperCase() === 'NEW');
      } else if (fLower === 'sale') {
        list = products.filter((p) => p.onSale || (p.originalPrice && p.originalPrice > p.price));
      } else {
        list = products.filter((p) => {
          const pCat = (p.category || '').toLowerCase();
          const pCatLabel = (p.categoryLabel || '').toLowerCase();
          const pCats = Array.isArray(p.categories) ? p.categories.map((c) => String(c).toLowerCase()) : [];
          return pCat === fLower || pCatLabel === fLower || pCats.includes(fLower);
        });
      }

      if (list.length === 0) {
        grid.innerHTML = `
          <div class="col-span-full py-12 px-4 text-center border border-dashed border-stone-200 dark:border-stone-800 rounded-2xl bg-stone-50/30 dark:bg-stone-900/20">
            <p class="text-sm text-stone-500 dark:text-stone-400">No creations found under this discipline filter.</p>
          </div>
        `;
      } else {
        grid.innerHTML = list.map((p) => createProductCard(p)).join('');
      }

      // Update active filter pill style
      document.querySelectorAll('.bestseller-filter-btn').forEach((btn) => {
        const btnFilter = (btn.getAttribute('data-filter') || '').toLowerCase();
        if (btnFilter === fLower) {
          btn.classList.add(
            'bg-stone-900',
            'text-white',
            'dark:bg-gold-400',
            'dark:text-stone-950',
            'border-transparent',
            'shadow-sm',
          );
          btn.classList.remove(
            'bg-transparent',
            'text-stone-700',
            'dark:text-stone-300',
            'border-stone-300',
            'dark:border-stone-700',
          );
        } else {
          btn.classList.remove(
            'bg-stone-900',
            'text-white',
            'dark:bg-gold-400',
            'dark:text-stone-950',
            'border-transparent',
            'shadow-sm',
          );
          btn.classList.add(
            'bg-transparent',
            'text-stone-700',
            'dark:text-stone-300',
            'border-stone-300',
            'dark:border-stone-700',
          );
        }
      });

      safeRefreshIcons();
    },

    setProducts(newProducts) {
      if (Array.isArray(newProducts)) {
        window.PRODUCTS = newProducts.slice();
        this.renderFeatured();
        this.renderBestSellers(this.activeFilter);
      }
    },
  };

  // Expose globally
  window.createProductCard = createProductCard;
  window.ProductRenderer = ProductRenderer;
  window.KinboniPro = window.KinboniPro || {};
  window.KinboniPro.ProductRenderer = ProductRenderer;

  // Initialize once DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => ProductRenderer.init());
  } else {
    ProductRenderer.init();
  }

})(window, document);
