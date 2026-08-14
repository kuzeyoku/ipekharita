/* ============================================================
   İPEK MÜHENDİSLİK — MAIN.JS
   Enterprise UI Components: Accordions, Filters, Scroll Progress, Counters, Compare Slider, Cursor Spotlight
   ============================================================ */

'use strict';

const IpekApp = {
    init() {
        this.initStickyHeader();
        this.smoothScroll();
        this.initScrollProgress();
        this.initBackToTop();
        this.initAccordions();
        this.initFilterPills();
        this.initChipSelectors();
        this.initCounters();
        this.initCompareSlider();
        this.initCursorSpotlight();
        this.activeNavLink();
    },

    /**
     * Enterprise Fixed Header System Scroll Handler
     */
    initStickyHeader() {
        const header = document.querySelector('.site-header-fixed') || document.querySelector('.navbar-floating-container');
        if (!header) return;

        const handleScroll = () => {
            if (window.scrollY > 25) {
                header.classList.add('header-scrolled', 'navbar-scrolled');
            } else {
                header.classList.remove('header-scrolled', 'navbar-scrolled');
            }
        };

        window.addEventListener('scroll', handleScroll, { passive: true });
        handleScroll();
    },

    /**
     * Smooth scroll for anchor links
     */
    smoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', (e) => {
                const targetId = link.getAttribute('href');
                if (targetId === '#') return;
                
                const targetEl = document.querySelector(targetId);
                if (targetEl) {
                    e.preventDefault();
                    const headerHeight = 80;
                    const targetPos = targetEl.getBoundingClientRect().top + window.scrollY - headerHeight;
                    
                    window.scrollTo({
                        top: targetPos,
                        behavior: 'smooth'
                    });
                }
            });
        });
    },

    /**
     * Global Scroll Progress Indicator
     */
    initScrollProgress() {
        let progressBar = document.getElementById('scroll-progress');
        if (!progressBar) {
            progressBar = document.createElement('div');
            progressBar.id = 'scroll-progress';
            document.body.appendChild(progressBar);
        }

        window.addEventListener('scroll', () => {
            const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            progressBar.style.width = scrolled + '%';
        }, { passive: true });
    },

    /**
     * Floating Back to Top Capsule Button
     */
    initBackToTop() {
        let btn = document.getElementById('back-to-top');
        if (!btn) {
            btn = document.createElement('button');
            btn.id = 'back-to-top';
            btn.setAttribute('aria-label', 'Yukarı Çık');
            btn.innerHTML = '<i class="fa-solid fa-arrow-up"></i>';
            document.body.appendChild(btn);
        }

        window.addEventListener('scroll', () => {
            if (window.scrollY > 350) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        }, { passive: true });

        btn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    },

    /**
     * Engineering Technical FAQ Accordions
     */
    initAccordions() {
        document.querySelectorAll('.accordion-header-enterprise').forEach(header => {
            header.addEventListener('click', () => {
                const item = header.parentElement;
                const body = item.querySelector('.accordion-body-enterprise');
                const isOpen = item.classList.contains('active');

                // Close siblings if in same accordion container
                const container = item.closest('.accordion-enterprise');
                if (container) {
                    container.querySelectorAll('.accordion-item-enterprise').forEach(sibling => {
                        sibling.classList.remove('active');
                        const sibBody = sibling.querySelector('.accordion-body-enterprise');
                        if (sibBody) sibBody.style.maxHeight = null;
                    });
                }

                if (!isOpen) {
                    item.classList.add('active');
                    if (body) {
                        body.style.maxHeight = body.scrollHeight + 'px';
                    }
                }
            });
        });
    },

    /**
     * Project Category Filter Pills
     */
    initFilterPills() {
        const pills = document.querySelectorAll('.filter-pill-enterprise');
        const cards = document.querySelectorAll('[data-category]');

        pills.forEach(pill => {
            pill.addEventListener('click', () => {
                pills.forEach(p => p.classList.remove('active'));
                pill.classList.add('active');

                const filter = pill.getAttribute('data-filter');

                cards.forEach(card => {
                    const cat = card.getAttribute('data-category');
                    if (filter === 'all' || cat === filter) {
                        card.style.display = '';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'scale(1)';
                        }, 50);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 250);
                    }
                });
            });
        });
    },

    /**
     * Service Selection Chips for Contact/RFP Forms
     */
    initChipSelectors() {
        document.querySelectorAll('.chip-select-enterprise').forEach(chip => {
            chip.addEventListener('click', () => {
                chip.classList.toggle('selected');
            });
        });
    },

    /**
     * Number Counter Animation when scrolled into view
     */
    initCounters() {
        const counters = document.querySelectorAll('.stat-card-number[data-count]');
        if (counters.length === 0) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.getAttribute('data-count'), 10);
                    const prefix = el.getAttribute('data-prefix') || '';
                    const suffix = el.getAttribute('data-suffix') || '';
                    let count = 0;
                    const step = Math.max(1, Math.floor(target / 40));

                    const timer = setInterval(() => {
                        count += step;
                        if (count >= target) {
                            count = target;
                            clearInterval(timer);
                        }
                        el.textContent = `${prefix}${count.toLocaleString('tr-TR')}${suffix}`;
                    }, 30);

                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.4 });

        counters.forEach(c => observer.observe(c));
    },

    /**
     * 22/a Kadastro Before / After Comparison Slider Logic
     */
    initCompareSlider() {
        const wrappers = document.querySelectorAll('.compare-slider-wrapper');
        wrappers.forEach(wrapper => {
            const handle = wrapper.querySelector('.compare-handle');
            const afterLayer = wrapper.querySelector('.compare-after');
            if (!handle || !afterLayer) return;

            let isDragging = false;

            const setPosition = (x) => {
                const rect = wrapper.getBoundingClientRect();
                let offsetX = x - rect.left;
                if (offsetX < 0) offsetX = 0;
                if (offsetX > rect.width) offsetX = rect.width;

                const percent = (offsetX / rect.width) * 100;
                handle.style.left = percent + '%';
                afterLayer.style.width = percent + '%';
            };

            const onStart = (e) => {
                isDragging = true;
                const pageX = e.touches ? e.touches[0].pageX : e.pageX;
                setPosition(pageX);
            };

            const onMove = (e) => {
                if (!isDragging) return;
                const pageX = e.touches ? e.touches[0].pageX : e.pageX;
                setPosition(pageX);
            };

            const onEnd = () => {
                isDragging = false;
            };

            wrapper.addEventListener('mousedown', onStart);
            wrapper.addEventListener('touchstart', onStart, { passive: true });
            window.addEventListener('mousemove', onMove);
            window.addEventListener('touchmove', onMove, { passive: true });
            window.addEventListener('mouseup', onEnd);
            window.addEventListener('touchend', onEnd);
        });
    },

    /**
     * Ambient Cursor Spotlight Tracking Effect on Dark Containers
     */
    initCursorSpotlight() {
        const darkContainers = document.querySelectorAll('.hero-enterprise, .cta-enterprise');
        darkContainers.forEach(container => {
            container.addEventListener('mousemove', (e) => {
                const rect = container.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                container.style.setProperty('--mouse-x', `${x}px`);
                container.style.setProperty('--mouse-y', `${y}px`);
            });
        });
    },

    /**
     * Highlight active nav link
     */
    activeNavLink() {
        const currentPath = window.location.pathname.split('/').pop() || 'index.html';
        document.querySelectorAll('.navbar-nav .nav-link-enterprise').forEach(link => {
            const href = link.getAttribute('href');
            if (href === currentPath || (currentPath === '' && href === 'index.html')) {
                link.classList.add('active');
            }
        });
    }
};

// Boot
document.addEventListener('DOMContentLoaded', () => IpekApp.init());
