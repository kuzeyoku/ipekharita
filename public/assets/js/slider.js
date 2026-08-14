/*!
 * İpek Harita Mühendislik Sistemleri
 * Developed by Kuzeyoku Software
 */

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

    goTo(index) {
        this.slides.forEach(s => s.classList.remove('active'));
        this.dots.forEach(d => {
            d.classList.remove('active');
            const prog = d.querySelector('.dot-progress');
            if (prog) {
                prog.style.animation = 'none';
                prog.offsetHeight;
                prog.style.animation = '';
            }
        });

        this.currentSlide = index;

        this.slides[index].classList.add('active');
        if (this.dots[index]) {
            this.dots[index].classList.add('active');
        }
    },

    next() {
        const nextIndex = (this.currentSlide + 1) % this.totalSlides;
        this.goTo(nextIndex);
    },

    bindDots() {
        this.dots.forEach((dot, i) => {
            dot.addEventListener('click', () => {
                this.goTo(i);
                this.restartAutoPlay();
            });
        });
    },

    startAutoPlay() {
        this.interval = setInterval(() => this.next(), this.duration);
    },

    restartAutoPlay() {
        clearInterval(this.interval);
        this.startAutoPlay();
    },

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
