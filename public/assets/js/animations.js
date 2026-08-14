/*!
 * İpek Harita Mühendislik Sistemleri
 * Developed by Kuzeyoku Software
 */

'use strict';

const IpekAnimations = {

    init() {
        this.scrollReveal();
        this.counterAnimation();
    },

    scrollReveal() {
        const elements = document.querySelectorAll('[data-reveal]');
        if (!elements.length) return;

        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            elements.forEach(el => el.classList.add('revealed'));
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -40px 0px'
        });

        elements.forEach(el => observer.observe(el));
    },

    counterAnimation() {
        const counters = document.querySelectorAll('[data-counter]');
        if (!counters.length) return;

        const animateCounter = (el) => {
            const target = parseInt(el.getAttribute('data-counter'), 10);
            const duration = 2200;
            const startTime = performance.now();

            const easeOutQuart = (t) => 1 - Math.pow(1 - t, 4);

            const update = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const easedProgress = easeOutQuart(progress);
                const currentValue = Math.round(easedProgress * target);

                el.textContent = currentValue.toLocaleString('tr-TR');

                if (progress < 1) {
                    requestAnimationFrame(update);
                }
            };

            requestAnimationFrame(update);
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.3
        });

        counters.forEach(el => observer.observe(el));
    }
};

document.addEventListener('DOMContentLoaded', () => IpekAnimations.init());
