/* ============================================================
   İPEK MÜHENDİSLİK — NAVIGATION.JS
   Enterprise navbar sticky state & mobile menu control
   ============================================================ */

'use strict';

const IpekNav = {

    navbar: null,
    toggler: null,
    collapse: null,
    overlay: null,

    init() {
        this.navbar = document.querySelector('.navbar-floating-container');
        this.toggler = document.querySelector('.navbar-toggler');
        this.collapse = document.querySelector('.navbar-collapse');

        this.stickyHeader();
        this.mobileMenu();
    },

    /**
     * Sticky header state
     */
    stickyHeader() {
        if (!this.navbar) return;

        window.addEventListener('scroll', () => {
            if (window.scrollY > 40) {
                this.navbar.classList.add('shadow-md');
            } else {
                this.navbar.classList.remove('shadow-md');
            }
        }, { passive: true });
    },

    /**
     * Mobile menu
     */
    mobileMenu() {
        if (!this.toggler || !this.collapse) return;

        this.collapse.querySelectorAll('.nav-link-enterprise').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992 && this.collapse.classList.contains('show')) {
                    const bsCollapse = bootstrap.Collapse.getInstance(this.collapse);
                    if (bsCollapse) bsCollapse.hide();
                }
            });
        });
    }
};

document.addEventListener('DOMContentLoaded', () => IpekNav.init());
