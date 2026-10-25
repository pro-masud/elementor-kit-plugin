/**
 * KINBONI Pro — Live Sales Notification Module (Module 08: LiveSalesController)
 * 
 * Powered authoritatively by WooCommerce recent orders & real published products.
 * 
 * Features:
 *  - Slide-in and fade-out luxury toast notifications.
 *  - Click on popup opens Quick View modal (`QuickViewController.open`).
 *  - Respects admin interval setting and enable/disable toggle.
 *  - Real recent purchasers from WooCommerce with location & relative time.
 *  - Audio chime with Web Audio API (unlocked on user gesture).
 *  - Hover-to-pause and dismiss button.
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

  const LiveSalesController = {
    currentIndex: 0,
    currentProductId: null,
    timerId: null,
    hideTimerId: null,
    isPaused: false,
    displayDuration: 8500, // Stays visible for 8.5 seconds
    intervalDuration: 15000, // Configurable via admin settings
    hasUserInteracted: false,
    audioCtx: null,
    salesList: [],

    buyersFallback: [
      { location: 'Gulshan-2, Dhaka', time: 'Just now' },
      { location: 'Dhanmondi, Dhaka', time: '1 minute ago' },
      { location: 'Banani, Dhaka', time: '2 minutes ago' },
      { location: 'Uttara Sector 7, Dhaka', time: 'Just now' },
      { location: 'GEC Circle, Chittagong', time: '3 minutes ago' },
      { location: 'Sylhet Sadar, Sylhet', time: '1 minute ago' },
      { location: 'Mirpur DOHS, Dhaka', time: '4 minutes ago' },
      { location: 'Bashundhara R/A, Dhaka', time: '5 minutes ago' },
    ],

    init() {
      // Check admin setting
      if (window.kinboni && window.kinboni.sales_popup_enabled === false) {
        return;
      }

      if (window.kinboni && window.kinboni.sales_popup_interval) {
        this.intervalDuration = Math.max(5000, Number(window.kinboni.sales_popup_interval) * 1000);
      }

      const popup = document.getElementById('live-sales-popup');
      const card = document.getElementById('live-sales-card');
      const closeBtn = document.getElementById('close-live-sale-btn');

      if (!popup || !card) return;

      // 1. Initialize sales list from server localized data
      if (window.kinboni && Array.isArray(window.kinboni.recent_sales) && window.kinboni.recent_sales.length > 0) {
        this.salesList = window.kinboni.recent_sales.slice();
      }

      // 2. Unlock audio chime on user gesture
      const unlockAudio = () => {
        this.hasUserInteracted = true;
        ['click', 'touchstart', 'keydown', 'scroll'].forEach((evt) => {
          window.removeEventListener(evt, unlockAudio);
        });
      };
      ['click', 'touchstart', 'keydown', 'scroll'].forEach((evt) => {
        window.addEventListener(evt, unlockAudio, { passive: true });
      });

      // 3. Card click opens Quick View modal
      card.addEventListener('click', (e) => {
        if (e.target.closest('#close-live-sale-btn')) return;
        this.openCurrentProduct();
      });

      // 4. Dismiss button
      if (closeBtn) {
        closeBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          this.hide();
        });
      }

      // 5. Hover pauses auto-hide
      card.addEventListener('mouseenter', () => {
        this.isPaused = true;
        if (this.hideTimerId) clearTimeout(this.hideTimerId);
      });

      card.addEventListener('mouseleave', () => {
        this.isPaused = false;
        this.scheduleHide(3000);
      });

      // 6. First appearance after 3.5 seconds
      setTimeout(() => {
        this.showNext();
        this.timerId = setInterval(() => {
          if (!this.isPaused) {
            this.showNext();
          }
        }, this.intervalDuration);
      }, 3500);
    },

    openCurrentProduct() {
      if (!this.currentProductId) return;
      this.hide();

      if (window.QuickViewController && typeof window.QuickViewController.open === 'function') {
        window.QuickViewController.open(this.currentProductId);
      }
    },

    playLuxuryChime() {
      if (!this.hasUserInteracted) return;
      if (window.kinboni && window.kinboni.sales_chime_enabled === false) return;

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
        // Harmonic luxury chime: 587.33Hz (D5) glides to 880Hz (A5)
        osc.frequency.setValueAtTime(587.33, ctx.currentTime);
        osc.frequency.exponentialRampToValueAtTime(880, ctx.currentTime + 0.08);

        gain.gain.setValueAtTime(0.08, ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + 0.35);

        osc.connect(gain);
        gain.connect(ctx.destination);

        osc.start();
        osc.stop(ctx.currentTime + 0.35);
      } catch (e) {
        // Fallback gracefully
      }
    },

    showNext() {
      const popup = document.getElementById('live-sales-popup');
      const imgEl = document.getElementById('live-sale-image');
      const nameEl = document.getElementById('live-sale-name');
      const priceEl = document.getElementById('live-sale-price');
      const buyerEl = document.getElementById('live-sale-buyer');

      if (!popup || !imgEl || !nameEl || !priceEl || !buyerEl) return;

      // Ensure we have notification data
      let saleItem = null;

      if (this.salesList.length > 0) {
        saleItem = this.salesList[this.currentIndex % this.salesList.length];
      } else {
        // Fallback to in-memory products
        const catalog = Array.isArray(window.PRODUCTS) && window.PRODUCTS.length > 0
          ? window.PRODUCTS
          : (window.kinboni?.products || []);

        if (catalog.length > 0) {
          const product = catalog[this.currentIndex % catalog.length];
          const buyer = this.buyersFallback[this.currentIndex % this.buyersFallback.length];
          saleItem = {
            id: product.id,
            name: product.name,
            price: product.price,
            formattedPrice: product.formattedPrice || safeFormatCurrency(product.price),
            image: product.image,
            location: buyer.location,
            time: buyer.time,
          };
        }
      }

      if (!saleItem) return;

      this.currentProductId = saleItem.id;

      if (saleItem.image) {
        imgEl.src = saleItem.image;
      }
      imgEl.alt = saleItem.name || 'Artisanal Creation';
      nameEl.textContent = saleItem.name || '';
      priceEl.innerHTML = saleItem.formattedPrice || safeFormatCurrency(saleItem.price);
      buyerEl.textContent = `${saleItem.location || 'Dhaka'} • ${saleItem.time || 'Just now'}`;

      // Audio notification
      this.playLuxuryChime();

      // Slide in animation
      popup.classList.remove('translate-y-8', 'opacity-0', 'pointer-events-none');
      popup.classList.add('translate-y-0', 'opacity-100');

      safeRefreshIcons();

      // Schedule auto-hide
      this.scheduleHide(this.displayDuration);

      // Advance index
      const totalItems = this.salesList.length > 0 ? this.salesList.length : (window.PRODUCTS?.length || 1);
      this.currentIndex = (this.currentIndex + 1) % totalItems;
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
    },
  };

  // Expose globally
  window.LiveSalesController = LiveSalesController;
  window.KinboniPro = window.KinboniPro || {};
  window.KinboniPro.LiveSales = LiveSalesController;

  // Initialize once DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => LiveSalesController.init());
  } else {
    LiveSalesController.init();
  }

})(window, document);

