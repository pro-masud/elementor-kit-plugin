/**
 * KINBONI Pro - Interactions & Modals Controller (Module 10)
 *
 * Handles:
 *  - Mobile Menu Drawer (Open/Close with slide animation & backdrop blur)
 *  - Announcement Bar (Dismissal with smooth height collapse & sessionStorage persistence)
 *  - Sticky Header Elevation (Elevation styles on scroll, Back-to-Top reveal)
 *  - VIP Newsletter Subscription (Validation, live feedback, AJAX backend sync, toast alert)
 *  - Member Concierge / Account Modals
 *  - Catalog Filter & Category Card Navigation shortcuts
 *  - Accessibility (Escape key listener, body scroll locking)
 *
 * @package KinboniPro
 */

(function(window, document) {
  'use strict';

  const STORAGE_KEYS = {
    ANNOUNCEMENT: 'kinboni_announcement_v2',
  };

  /**
   * Safe toast notification helper.
   */
  function safeShowToast(message, type) {
    if (typeof window.showToast === 'function') {
      window.showToast(message, type);
    } else if (window.KinboniPro && typeof window.KinboniPro.showToast === 'function') {
      window.KinboniPro.showToast(message, type);
    }
  }

  /**
   * Safe Lucide icon renderer.
   */
  function safeRefreshIcons() {
    if (typeof window.lucide !== 'undefined' && typeof window.lucide.createIcons === 'function') {
      window.lucide.createIcons();
    }
  }

  const InteractionController = {
    isMobileMenuOpen: false,

    /**
     * Open mobile navigation drawer.
     */
    openMobileMenu() {
      const drawer = document.getElementById('mobile-menu-drawer');
      const backdrop = document.getElementById('mobile-menu-backdrop');
      if (!drawer || !backdrop) return;

      this.isMobileMenuOpen = true;
      backdrop.classList.remove('hidden');
      requestAnimationFrame(() => {
        backdrop.classList.remove('opacity-0');
        drawer.classList.remove('-translate-x-full');
      });
      document.body.classList.add('overflow-hidden');
      safeRefreshIcons();
    },

    /**
     * Close mobile navigation drawer.
     */
    closeMobileMenu() {
      const drawer = document.getElementById('mobile-menu-drawer');
      const backdrop = document.getElementById('mobile-menu-backdrop');
      if (!drawer || !backdrop) return;

      this.isMobileMenuOpen = false;
      drawer.classList.add('-translate-x-full');
      backdrop.classList.add('opacity-0');
      setTimeout(() => {
        backdrop.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
      }, 300);
    },

    /**
     * Toggle mobile navigation drawer.
     */
    toggleMobileMenu(open) {
      if (typeof open === 'boolean') {
        open ? this.openMobileMenu() : this.closeMobileMenu();
      } else {
        this.isMobileMenuOpen ? this.closeMobileMenu() : this.openMobileMenu();
      }
    },

    /**
     * Initialize mobile navigation menu drawer and listeners.
     */
    initMobileMenu() {
      const mobileMenuBtn = document.getElementById('mobile-menu-btn');
      const closeMobileMenuBtn = document.getElementById('close-mobile-menu-btn');
      const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');
      const mobileLinksContainer = document.getElementById('mobile-drawer-links');

      // Dynamic Sync: Mirror desktop header navigation links into mobile drawer if available
      const desktopNav = document.querySelector('#site-header nav');
      if (desktopNav && mobileLinksContainer) {
        const desktopLinks = desktopNav.querySelectorAll('a.kb-nav-link');
        if (desktopLinks && desktopLinks.length > 0) {
          mobileLinksContainer.innerHTML = '';
          desktopLinks.forEach((dLink) => {
            const mLink = document.createElement('a');
            mLink.href = dLink.getAttribute('href') || '#';
            if (dLink.getAttribute('target')) {
              mLink.target = dLink.getAttribute('target');
              mLink.rel = dLink.getAttribute('rel') || 'noopener noreferrer';
            }
            mLink.className = 'mobile-nav-link block font-serif text-lg font-medium text-stone-900 dark:text-stone-100 hover:text-gold-600 transition-colors';
            mLink.textContent = dLink.textContent.trim();
            mLink.addEventListener('click', () => this.closeMobileMenu());
            mobileLinksContainer.appendChild(mLink);
          });
        }
      }

      if (mobileMenuBtn) {
        mobileMenuBtn.onclick = (e) => {
          e.preventDefault();
          this.openMobileMenu();
        };
      }

      if (closeMobileMenuBtn) {
        closeMobileMenuBtn.onclick = (e) => {
          e.preventDefault();
          this.closeMobileMenu();
        };
      }

      if (mobileMenuBackdrop) {
        mobileMenuBackdrop.onclick = () => this.closeMobileMenu();
      }

      document.querySelectorAll('.mobile-nav-link').forEach((link) => {
        link.addEventListener('click', () => this.closeMobileMenu());
      });

      // Escape key listener for mobile drawer
      window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && this.isMobileMenuOpen) {
          this.closeMobileMenu();
        }
      });
    },

    /**
     * Initialize sticky header elevation & back-to-top button.
     */
    initStickyHeader() {
      const header = document.getElementById('site-header');
      const backToTopBtn = document.getElementById('back-to-top-btn');

      const handleScroll = () => {
        const scrollY = window.scrollY || window.pageYOffset || 0;

        if (header) {
          if (scrollY > 30) {
            header.classList.add(
              'bg-white/95',
              'dark:bg-stone-950/95',
              'backdrop-blur-md',
              'shadow-sm',
              'border-b',
              'border-stone-200/60',
              'dark:border-stone-800/60'
            );
          } else {
            header.classList.remove(
              'bg-white/95',
              'dark:bg-stone-950/95',
              'backdrop-blur-md',
              'shadow-sm',
              'border-b',
              'border-stone-200/60',
              'dark:border-stone-800/60'
            );
          }
        }

        if (backToTopBtn) {
          if (scrollY > 400) {
            backToTopBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
          } else {
            backToTopBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
          }
        }
      };

      window.addEventListener('scroll', handleScroll, { passive: true });
      handleScroll();

      if (backToTopBtn) {
        backToTopBtn.onclick = (e) => {
          e.preventDefault();
          window.scrollTo({ top: 0, behavior: 'smooth' });
        };
      }
    },

    /**
     * Initialize VIP newsletter subscription form.
     */
    initNewsletter() {
      const newsletterForm = document.getElementById('newsletter-form');
      if (!newsletterForm) return;

      newsletterForm.onsubmit = (e) => {
        // If external action URL is set, let browser submit normally
        if (newsletterForm.getAttribute('action')) {
          return;
        }

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

        const promoCode = newsletterForm.getAttribute('data-promo') || 'LUXE20';
        const customSuccess = newsletterForm.getAttribute('data-success');
        const successHtml =
          customSuccess ||
          `✨ Welcome to The Kinboni Circle! Your VIP invitation and private 20% privilege code (<strong>${promoCode}</strong>) have been delivered.`;

        if (feedbackEl) {
          feedbackEl.className =
            'mt-3 text-xs text-emerald-500 dark:text-emerald-400 font-semibold block animate-fade-in';
          feedbackEl.innerHTML = successHtml;
        }

        if (emailInput) {
          emailInput.value = '';
        }

        safeShowToast('Subscribed to Kinboni VIP Archive', 'success');

        // Async WordPress AJAX storage
        try {
          const ajaxUrl =
            (window.kinboni && window.kinboni.ajax_url) ||
            (window.kinboni_vars && window.kinboni_vars.ajax_url) ||
            '/wp-admin/admin-ajax.php';
          const nonce =
            (window.kinboni && window.kinboni.nonce) ||
            (window.kinboni_vars && window.kinboni_vars.nonce) ||
            '';

          const fd = new FormData();
          fd.append('action', 'kinboni_subscribe_newsletter');
          fd.append('email', email);
          if (promoCode) {
            fd.append('promo_code', promoCode);
          }
          if (nonce) {
            fd.append('nonce', nonce);
          }

          fetch(ajaxUrl, { method: 'POST', body: fd }).catch(() => {});
        } catch (err) {}
      };
    },

    /**
     * Catalog & category filter trigger shortcuts.
     */
    initCatalogShortcuts() {
      document.querySelectorAll('.bestseller-filter-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
          const filter = btn.getAttribute('data-filter');
          if (window.ProductRenderer && typeof window.ProductRenderer.renderBestSellers === 'function') {
            window.ProductRenderer.renderBestSellers(filter);
          }
        });
      });

      document.querySelectorAll('.category-card-trigger').forEach((card) => {
        card.addEventListener('click', () => {
          const category = card.getAttribute('data-category');
          const bestSellersSection = document.getElementById('bestsellers');
          if (bestSellersSection) {
            bestSellersSection.scrollIntoView({ behavior: 'smooth' });
            if (window.ProductRenderer && typeof window.ProductRenderer.renderBestSellers === 'function') {
              window.ProductRenderer.renderBestSellers(category);
            }
            safeShowToast(`Filtered by ${category.toUpperCase()}`, 'info');
          }
        });
      });
    },

    /**
     * Member concierge demo modals & links.
     */
    initAccountConcierge() {
      document.querySelectorAll('.open-account-btn').forEach((btn) => {
        btn.addEventListener('click', (e) => {
          e.preventDefault();
          safeShowToast('Member Concierge: Welcome back, Patron!', 'info');
        });
      });
    },

    /**
     * Full initialization.
     */
    init() {
      this.initMobileMenu();
      this.initStickyHeader();
      this.initNewsletter();
      this.initCatalogShortcuts();
      this.initAccountConcierge();
    },
  };

  // Expose globally
  window.InteractionController = InteractionController;
  window.KinboniPro = window.KinboniPro || {};
  window.KinboniPro.Interactions = InteractionController;

  // Initialize once DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => InteractionController.init());
  } else {
    InteractionController.init();
  }

  // Elementor preview re-initialization hook
  if (window.elementorFrontend && window.elementorFrontend.hooks) {
    window.elementorFrontend.hooks.addAction('frontend/element_ready/kinboni_header.default', () => {
      InteractionController.initStickyHeader();
      InteractionController.initMobileMenu();
      InteractionController.initAccountConcierge();
    });
    window.elementorFrontend.hooks.addAction('frontend/element_ready/kinboni_newsletter.default', () => {
      InteractionController.initNewsletter();
    });
  }

})(window, document);

