/**
 * Dainik Bangladesher Kotha - Dark/Light Theme Controller
 * Defaults to Light mode as requested, saves preference in localStorage
 */

(function () {
  'use strict';

  const THEME_KEY = 'bdk_theme_preference';

  function getStoredTheme() {
    return localStorage.getItem(THEME_KEY) || 'light';
  }

  function applyTheme(theme) {
    if (theme === 'dark') {
      document.documentElement.setAttribute('data-theme', 'dark');
      document.body?.setAttribute('data-theme', 'dark');
    } else {
      document.documentElement.removeAttribute('data-theme');
      document.body?.removeAttribute('data-theme');
    }
  }

  // Apply immediately on script load
  const initialTheme = getStoredTheme();
  applyTheme(initialTheme);

  // Setup click listeners when DOM is ready
  function initThemeToggle() {
    applyTheme(getStoredTheme());

    const toggleButtons = document.querySelectorAll('#themeToggleBtn, .theme-toggle-btn, .theme-switch-btn');

    toggleButtons.forEach((btn) => {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        const nextTheme = isDark ? 'light' : 'dark';

        applyTheme(nextTheme);
        localStorage.setItem(THEME_KEY, nextTheme);
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initThemeToggle);
  } else {
    initThemeToggle();
  }
})();
