/**
 * KINBONI Pro — Testimonials Carousel Module (Module 09: TestimonialSliderController)
 * 
 * Powered by Swiper.js with:
 *  - Responsive editorial breakpoints (Mobile: 1, Tablet: 2, Desktop: 3).
 *  - Autoplay with pause-on-mouseenter.
 *  - Touch swipe gestures & grab cursor.
 *  - Pagination bullets and custom Atelier navigation buttons.
 *  - Elementor preview live re-initialization hook.
 * 
 * @package KinboniPro
 */

(function(window, document) {
  'use strict';

  function safeRefreshIcons() {
    if (typeof window.refreshIcons === 'function') {
      window.refreshIcons();
    } else if (window.lucide && typeof window.lucide.createIcons === 'function') {
      try { window.lucide.createIcons(); } catch (e) {}
    }
  }

  const TestimonialSliderController = {
    swiperInstance: null,
    retryCount: 0,
    maxRetries: 10,

    init() {
      const swiperEl = document.querySelector('.testimonial-swiper');
      if (!swiperEl) return;

      // If already initialized on this container, don't duplicate
      if (swiperEl.classList.contains('swiper-initialized') && this.swiperInstance) {
        return;
      }

      // If Swiper library is not yet loaded, retry gracefully
      if (typeof window.Swiper === 'undefined') {
        if (this.retryCount < this.maxRetries) {
          this.retryCount++;
          setTimeout(() => this.init(), 150);
        }
        return;
      }

      try {
        this.swiperInstance = new window.Swiper('.testimonial-swiper', {
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
              setTimeout(safeRefreshIcons, 60);
            },
            slideChange: () => {
              setTimeout(safeRefreshIcons, 60);
            },
          },
        });

        safeRefreshIcons();
      } catch (e) {
        console.warn('[KINBONI Testimonials] Swiper initialization notice:', e);
      }
    },

    destroy() {
      if (this.swiperInstance && typeof this.swiperInstance.destroy === 'function') {
        try {
          this.swiperInstance.destroy(true, true);
        } catch (e) {}
        this.swiperInstance = null;
      }
    },
  };

  // Expose globally
  window.TestimonialSliderController = TestimonialSliderController;
  window.KinboniPro = window.KinboniPro || {};
  window.KinboniPro.Testimonials = TestimonialSliderController;

  // Initialize once DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => TestimonialSliderController.init());
  } else {
    TestimonialSliderController.init();
  }

  // Elementor preview live re-initialization hook
  if (window.jQuery) {
    window.jQuery(window).on('elementor/frontend/init', () => {
      if (window.elementorFrontend && window.elementorFrontend.hooks) {
        window.elementorFrontend.hooks.addAction('frontend/element_ready/kinboni_testimonials.default', () => {
          TestimonialSliderController.destroy();
          TestimonialSliderController.init();
        });
      }
    });
  }

})(window, document);

