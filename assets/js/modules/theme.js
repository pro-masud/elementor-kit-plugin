/**
 * KINBONI Pro — Theme Controller Module (Module 07: ThemeController)
 * 
 * Manages Luxury Dark / Light Theme switching with:
 *  - Immediate zero-FOUC initialization.
 *  - LocalStorage persistence (`kinboni_theme_v2`).
 *  - System `prefers-color-scheme` detection and live synchronization.
 *  - HTML root `.dark` class management.
 *  - Dual Sun/Moon icon toggle synchronization across all headers & drawers.
 * 
 * @package KinboniPro
 */

(function(window, document) {
  'use strict';

  const STORAGE_KEY = 'kinboni_theme_v2';
  const LEGACY_STORAGE_KEY = 'kinboni_theme';

  function safeToast(msg, type = 'info') {
    if (typeof window.showToast === 'function') {
      window.showToast(msg, type);
    } else {
      console.log(`[KINBONI] ${type.toUpperCase()}: ${msg}`);
    }
  }

  const ThemeController = {
    isDark: false,

    init() {
      // 1. Detect saved preference or system preference
      const saved = localStorage.getItem(STORAGE_KEY) || localStorage.getItem(LEGACY_STORAGE_KEY);
      const systemPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
      this.isDark = saved ? saved === 'dark' : !!systemPrefersDark;

      // 2. Apply theme immediately
      this.applyTheme(this.isDark);

      // 3. Listen for OS-level dark/light mode changes (if user hasn't explicitly set a preference)
      if (window.matchMedia) {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
          if (!localStorage.getItem(STORAGE_KEY) && !localStorage.getItem(LEGACY_STORAGE_KEY)) {
            this.applyTheme(e.matches);
          }
        });
      }

      // 4. Attach event listeners to all theme toggle buttons across desktop & mobile
      this.bindButtons();
    },

    bindButtons() {
      document.querySelectorAll('.theme-toggle-btn').forEach((btn) => {
        // Prevent duplicate listener attachments
        if (!btn.dataset.themeBound) {
          btn.dataset.themeBound = 'true';
          btn.addEventListener('click', (e) => {
            e.preventDefault();
            this.toggle();
          });
        }
      });
    },

    applyTheme(isDark) {
      this.isDark = !!isDark;
      if (this.isDark) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }

      // Update Sun and Moon icons across all buttons (e.g. desktop header, mobile drawer)
      const sunIcons = document.querySelectorAll('.theme-sun-icon');
      const moonIcons = document.querySelectorAll('.theme-moon-icon');

      if (this.isDark) {
        sunIcons.forEach((el) => el.classList.remove('hidden'));
        moonIcons.forEach((el) => el.classList.add('hidden'));
      } else {
        sunIcons.forEach((el) => el.classList.add('hidden'));
        moonIcons.forEach((el) => el.classList.remove('hidden'));
      }
    },

    toggle() {
      const isDark = document.documentElement.classList.contains('dark');
      const newTheme = !isDark;
      this.applyTheme(newTheme);

      localStorage.setItem(STORAGE_KEY, newTheme ? 'dark' : 'light');
      safeToast(newTheme ? 'Dark Mode Activated' : 'Light Mode Activated', 'info');
    },

    isDarkMode() {
      return document.documentElement.classList.contains('dark');
    },
  };

  // Immediate execution for Zero-FOUC (Flash of Unstyled Content)
  try {
    const saved = localStorage.getItem(STORAGE_KEY) || localStorage.getItem(LEGACY_STORAGE_KEY);
    const systemPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    const initialDark = saved ? saved === 'dark' : !!systemPrefersDark;
    if (initialDark) {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }
  } catch (e) {}

  // Expose globally
  window.ThemeController = ThemeController;
  window.KinboniPro = window.KinboniPro || {};
  window.KinboniPro.Theme = ThemeController;

  // Initialize once DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => ThemeController.init());
  } else {
    ThemeController.init();
  }

})(window, document);

