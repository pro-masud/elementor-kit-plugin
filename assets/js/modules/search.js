/**
 * KINBONI Pro — Live Product Search Module (Module 05: SearchController)
 * 
 * Powered authoritatively by WooCommerce & WP AJAX endpoint:
 *  - kinboni_search_products
 * 
 * Features:
 *  - Full-screen search modal with auto input focus.
 *  - 150ms debounce with request cancellation (AbortController).
 *  - Instant optimistic client-side filtering + live WooCommerce backend search.
 *  - Search suggestion tags click handler.
 *  - Luxury results grid with Quick View modal & Add to Bag actions.
 *  - Accessible keyboard navigation (Escape to close).
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

  function safeRefreshIcons() {
    if (typeof window.refreshIcons === 'function') {
      window.refreshIcons();
    } else if (window.lucide && typeof window.lucide.createIcons === 'function') {
      try { window.lucide.createIcons(); } catch (e) {}
    }
  }

  const SearchController = {
    debounceTimer: null,
    currentAbortController: null,
    lastQuery: '',

    init() {
      const searchModal = document.getElementById('search-modal');
      const searchInput = document.getElementById('search-input');
      const searchBackdrop = document.getElementById('search-backdrop');
      const closeBtn = document.getElementById('close-search-btn');

      // 1. Open search triggers
      document.querySelectorAll('.open-search-btn').forEach((btn) => {
        btn.addEventListener('click', (e) => {
          e.preventDefault();
          this.open();
        });
      });

      // 2. Backdrop & Close Button
      if (searchBackdrop) {
        searchBackdrop.addEventListener('click', () => this.close());
      }
      if (closeBtn) {
        closeBtn.addEventListener('click', () => this.close());
      }

      // 3. Search input with 150ms debounce
      if (searchInput) {
        searchInput.addEventListener('input', (e) => {
          clearTimeout(this.debounceTimer);
          this.debounceTimer = setTimeout(() => {
            this.search(e.target.value.trim());
          }, 150);
        });
      }

      // 4. Suggestion tags
      document.querySelectorAll('.search-suggestion-tag').forEach((tag) => {
        tag.addEventListener('click', () => {
          const query = tag.getAttribute('data-query');
          if (searchInput && query) {
            clearTimeout(this.debounceTimer);
            searchInput.value = query;
            this.search(query);
          }
        });
      });

      // 5. Escape key to close
      window.addEventListener('keydown', (e) => {
        if (
          e.key === 'Escape' &&
          searchModal &&
          !searchModal.classList.contains('hidden')
        ) {
          this.close();
        }
      });
    },

    open() {
      if (window.InteractionController && typeof window.InteractionController.closeMobileMenu === 'function') {
        window.InteractionController.closeMobileMenu();
      }

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

      this.lastQuery = query;

      // Empty query state
      if (!query) {
        resultsContainer.innerHTML = `
          <div class="py-12 text-center text-stone-400 dark:text-stone-500">
            <i data-lucide="search" class="w-10 h-10 mx-auto mb-3 opacity-30"></i>
            <p class="text-sm">Search the Kinboni Atelier archive by product name, category, or materials...</p>
          </div>
        `;
        if (countEl) countEl.textContent = 'Explore All Creations';
        safeRefreshIcons();
        return;
      }

      const q = query.toLowerCase();

      // 1. Instant Optimistic Filter from In-Memory PRODUCTS
      let localMatches = [];
      const catalog = Array.isArray(window.PRODUCTS) ? window.PRODUCTS : (window.kinboni?.products || []);
      if (Array.isArray(catalog) && catalog.length > 0) {
        localMatches = catalog.filter((p) => {
          const name = (p.name || '').toLowerCase();
          const cat = (p.category || '').toLowerCase();
          const catLabel = (p.categoryLabel || '').toLowerCase();
          const desc = (p.description || '').toLowerCase();
          return name.includes(q) || cat.includes(q) || catLabel.includes(q) || desc.includes(q);
        });
      }

      if (localMatches.length > 0) {
        this.renderResults(localMatches, query);
      } else {
        // Show lightweight loading state while server responds
        resultsContainer.innerHTML = `
          <div class="py-12 text-center text-stone-400 dark:text-stone-500 animate-pulse">
            <i data-lucide="loader-2" class="w-8 h-8 mx-auto mb-3 animate-spin text-gold-500"></i>
            <p class="text-sm">Searching the Kinboni Atelier archive...</p>
          </div>
        `;
        if (countEl) countEl.textContent = 'Searching creations...';
        safeRefreshIcons();
      }

      // 2. Authoritative WooCommerce Server Search
      this.fetchServerSearch(query);
    },

    fetchServerSearch(query) {
      if (this.currentAbortController) {
        this.currentAbortController.abort();
      }
      this.currentAbortController = new AbortController();

      const ajaxUrl = (window.kinboni && window.kinboni.ajax_url)
        ? window.kinboni.ajax_url
        : '/wp-admin/admin-ajax.php';
      const nonce = (window.kinboni && window.kinboni.nonce)
        ? window.kinboni.nonce
        : '';

      const fd = new FormData();
      fd.append('action', 'kinboni_search_products');
      fd.append('query', query);
      if (nonce) fd.append('nonce', nonce);

      fetch(ajaxUrl, {
        method: 'POST',
        body: fd,
        signal: this.currentAbortController.signal,
      })
        .then((res) => res.json())
        .then((res) => {
          // If query has changed in the meantime, ignore old responses
          if (this.lastQuery !== query) return;

          if (res.success && res.data && Array.isArray(res.data.results)) {
            const serverMatches = res.data.results;
            this.renderResults(serverMatches, query);

            // Register newly discovered products into global PRODUCTS for seamless Quick View
            if (typeof window.registerProduct === 'function') {
              serverMatches.forEach((prod) => window.registerProduct(prod));
            }
          }
        })
        .catch((err) => {
          if (err.name !== 'AbortError') {
            console.error('[KINBONI Search] Request error:', err);
          }
        });
    },

    renderResults(matches, query) {
      const resultsContainer = document.getElementById('search-results-container');
      const countEl = document.getElementById('search-count');
      if (!resultsContainer) return;

      if (countEl) {
        countEl.textContent = `${matches.length} creation${matches.length === 1 ? '' : 's'} discovered`;
      }

      if (matches.length === 0) {
        resultsContainer.innerHTML = `
          <div class="py-12 text-center">
            <i data-lucide="package-search" class="w-10 h-10 mx-auto mb-3 text-stone-400 opacity-40"></i>
            <h4 class="font-serif text-lg font-medium text-stone-900 dark:text-stone-100 mb-1">No Creations Found</h4>
            <p class="text-xs text-stone-500 dark:text-stone-400 max-w-sm mx-auto">
              We couldn't find any creations matching "${escapeHtml(query)}". Try searching for "Timepiece", "Leather", "Oud", or "Silk".
            </p>
          </div>
        `;
        safeRefreshIcons();
        return;
      }

      resultsContainer.innerHTML = `
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
          ${matches
            .map((product) => {
              const formattedPrice = product.formattedPrice || safeFormatCurrency(product.price);
              const categoryLabel = product.categoryLabel || product.badge || 'Fine Collection';
              const imgUrl = product.image || '';

              return `
                <div 
                  class="flex items-center gap-3 p-3 rounded-xl bg-stone-50 dark:bg-stone-800/60 border border-stone-200/60 dark:border-stone-700/60 hover:border-gold-500 transition-colors cursor-pointer group" 
                  onclick="SearchController.close(); QuickViewController.open(${product.id});"
                >
                  <img src="${imgUrl}" alt="${escapeHtml(product.name)}" class="w-14 h-16 object-cover rounded-lg bg-stone-200 dark:bg-stone-700 flex-shrink-0" />
                  <div class="min-w-0 flex-grow">
                    <span class="text-[10px] uppercase font-bold tracking-wider text-gold-600 dark:text-gold-400">${escapeHtml(categoryLabel)}</span>
                    <h5 class="font-serif text-xs font-semibold text-stone-900 dark:text-stone-100 truncate group-hover:text-gold-500 transition-colors">${escapeHtml(product.name)}</h5>
                    <span class="text-xs font-bold text-stone-900 dark:text-white">${formattedPrice}</span>
                  </div>
                  <button 
                    type="button" 
                    onclick="event.stopPropagation(); CartController.add(${product.id}, 1);" 
                    class="w-8 h-8 rounded-full bg-stone-900 text-white dark:bg-white dark:text-stone-950 flex items-center justify-center hover:bg-gold-500 hover:text-stone-950 transition-colors shadow-sm flex-shrink-0 active:scale-90"
                    aria-label="Add to bag"
                  >
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                  </button>
                </div>
              `;
            })
            .join('')}
        </div>
      `;

      safeRefreshIcons();
    },
  };

  function escapeHtml(str) {
    if (!str) return '';
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  // Expose globally
  window.SearchController = SearchController;
  window.KinboniPro = window.KinboniPro || {};
  window.KinboniPro.Search = SearchController;

  // Initialize once DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => SearchController.init());
  } else {
    SearchController.init();
  }

})(window, document);

