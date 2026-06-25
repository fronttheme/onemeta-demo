/**
 * OneMeta Demo — Frontend Interactions
 * Buildless, vanilla JS (ES6+). No dependencies.
 *
 * @package OneMeta_Demo
 */

(() => {
  'use strict';

  document.addEventListener('DOMContentLoaded', () => {
    initNav();
    initDrawers();
    initXray();
    initThemeToggle();
  });

  /**
   * Sidebar nav — switches the active panel without a page reload.
   */
  function initNav() {
    const links  = document.querySelectorAll('[data-omd-nav-link]');
    const panels = document.querySelectorAll('[data-omd-panel]');

    for (const link of links) {
      link.addEventListener('click', () => {
        const target = link.getAttribute('data-omd-target');

        for (const l of links) {
          l.classList.toggle('is-active', l === link);
        }

        for (const panel of panels) {
          panel.classList.toggle(
            'is-active',
            panel.getAttribute('data-omd-panel') === target
          );
        }

        window.scrollTo({top: 0, behavior: 'smooth'});
      });
    }
  }

  /**
   * "Saved value" drawers — click to expand/collapse.
   */
  function initDrawers() {
    for (const btn of document.querySelectorAll('[data-omd-drawer-toggle]')) {
      btn.addEventListener('click', () => {
        btn.closest('.omd-drawer').classList.toggle('is-open');
      });
    }
  }

  /**
   * X-ray — opens every drawer in the document at once.
   */
  function initXray() {
    const btn = document.querySelector('[data-omd-xray-toggle]');
    if (!btn) {
      return;
    }

    btn.addEventListener('click', () => {
      const drawers   = [...document.querySelectorAll('.omd-drawer')];
      const anyClosed = drawers.some((d) => !d.classList.contains('is-open'));

      for (const d of drawers) {
        d.classList.toggle('is-open', anyClosed);
      }

      btn.textContent = anyClosed
        ? '🔬 X-ray: collapse every drawer'
        : '🔬 X-ray: open every drawer on this page';
    });
  }

  /**
   * Light / dark theme toggle, persisted in localStorage.
   */
  function initThemeToggle() {
    const btn = document.querySelector('[data-omd-theme-toggle]');
    if (!btn) {
      return;
    }

    const stored = window.localStorage.getItem('omd-theme');
    if (stored) {
      document.body.setAttribute('data-omd-theme', stored);
    }

    btn.addEventListener('click', () => {
      const current = document.body.getAttribute('data-omd-theme') || 'light';
      const next    = 'light' === current ? 'dark' : 'light';

      document.body.setAttribute('data-omd-theme', next);
      window.localStorage.setItem('omd-theme', next);
    });
  }
})();