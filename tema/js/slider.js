/* ============================================================
   İPEK MÜHENDİSLİK — SLIDER.JS
   Hero Slider: auto-play, dot navigation, progress bars
   ============================================================ */

'use strict';

const IpekSlider = {

    currentSlide: 0,
    totalSlides: 0,
    interval: null,
    duration: 6000, // 6s per slide
    slides: [],
    dots: [],

    init() {
        this.slides = document.querySelectorAll('.hero-slide');
        this.dots = document.querySelectorAll('.hero-dot');
        this.totalSlides = this.slides.length;

        if (!this.totalSlides) return;

        this.bindDots();
        this.goTo(0);
        this.startAutoPlay();
        this.bindPauseOnHover();
    },

    /**
     * Go to a specific slide
     */
    goTo(index) {
        // Deactivate all
        this.slides.forEach(s => s.classList.remove('active'));
        this.dots.forEach(d => {
            d.classList.remove('active');
            const prog = d.querySelector('.dot-progress');
            if (prog) {
                prog.style.animation = 'none';
                // Force reflow
                prog.offsetHeight;
                prog.style.animation = '';
            }
        });

        this.currentSlide = index;

        // Activate target
        this.slides[index].classList.add('active');
        if (this.dots[index]) {
            this.dots[index].classList.add('active');
        }
    },

    /**
     * Next slide
     */
    next() {
        const nextIndex = (this.currentSlide + 1) % this.totalSlides;
        this.goTo(nextIndex);
    },

    /**
     * Bind dot clicks
     */
    bindDots() {
        this.dots.forEach((dot, i) => {
            dot.addEventListener('click', () => {
                this.goTo(i);
                this.restartAutoPlay();
            });
        });
    },

    /**
     * Start auto-play
     */
    startAutoPlay() {
        this.interval = setInterval(() => this.next(), this.duration);
    },

    /**
     * Restart auto-play (after manual interaction)
     */
    restartAutoPlay() {
        clearInterval(this.interval);
        this.startAutoPlay();
    },

    /**
     * Pause on hover (desktop UX)
     */
    bindPauseOnHover() {
        const hero = document.querySelector('.hero');
        if (!hero) return;

        hero.addEventListener('mouseenter', () => {
            clearInterval(this.interval);
        });

        hero.addEventListener('mouseleave', () => {
            this.startAutoPlay();
        });
    }
};

document.addEventListener('DOMContentLoaded', () => IpekSlider.init());
