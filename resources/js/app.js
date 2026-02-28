import './bootstrap';
import Lenis from 'lenis';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Splitting from 'splitting';
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

// ─── Alpine ──────────────────────────────────────────────
Alpine.plugin(intersect);
window.Alpine = Alpine;
Alpine.start();

// ─── GSAP ────────────────────────────────────────────────
gsap.registerPlugin(ScrollTrigger);

// ─── Smooth Scroll (Lenis) ──────────────────────────────
const lenis = new Lenis({ lerp: 0.08, smoothWheel: true });
lenis.on('scroll', ScrollTrigger.update);
gsap.ticker.add((time) => lenis.raf(time * 1000));
gsap.ticker.lagSmoothing(0);

// ─── Text Splitting ─────────────────────────────────────
Splitting();

// ─── Custom Cursor ──────────────────────────────────────
const cursor = document.getElementById('cursor');
if (cursor) {
    const xTo = gsap.quickTo(cursor, 'x', { duration: 0.4, ease: 'power2.out' });
    const yTo = gsap.quickTo(cursor, 'y', { duration: 0.4, ease: 'power2.out' });

    window.addEventListener('mousemove', (e) => {
        xTo(e.clientX - 10);
        yTo(e.clientY - 10);
    });

    document.querySelectorAll('a, button, [data-magnetic]').forEach(el => {
        el.addEventListener('mouseenter', () => cursor.classList.add('scale-[3]', 'opacity-50'));
        el.addEventListener('mouseleave', () => cursor.classList.remove('scale-[3]', 'opacity-50'));
    });
}

// ─── Page Loader ────────────────────────────────────────
const loader = document.getElementById('loader');
const loaderCount = document.getElementById('loader-count');
if (loader) {
    const obj = { val: 0 };
    gsap.to(obj, {
        val: 100, duration: 1.5, ease: 'power2.inOut',
        onUpdate: () => { loaderCount.textContent = Math.round(obj.val); },
        onComplete: () => {
            gsap.to(loader, {
                clipPath: 'inset(0 0 100% 0)', duration: 0.8, ease: 'power3.inOut',
                onComplete: () => loader.remove()
            });
        }
    });
}

// ─── Scroll-driven Animations ───────────────────────────
function initAnimations() {
    // [data-animate="fade-up"]
    gsap.utils.toArray('[data-animate="fade-up"]').forEach(el => {
        gsap.from(el, {
            y: 60, opacity: 0, duration: 1, ease: 'power2.out',
            scrollTrigger: { trigger: el, start: 'top 85%' }
        });
    });

    // [data-animate="fade-in"]
    gsap.utils.toArray('[data-animate="fade-in"]').forEach(el => {
        gsap.from(el, {
            opacity: 0, duration: 1.2, ease: 'power2.out',
            scrollTrigger: { trigger: el, start: 'top 85%' }
        });
    });

    // [data-animate="stagger"] — children in sequence
    gsap.utils.toArray('[data-animate="stagger"]').forEach(parent => {
        gsap.from(parent.children, {
            y: 40, opacity: 0, duration: 0.8, stagger: 0.12,
            ease: 'power2.out',
            scrollTrigger: { trigger: parent, start: 'top 80%' }
        });
    });

    // [data-parallax] — parallax effect
    gsap.utils.toArray('[data-parallax]').forEach(el => {
        gsap.to(el, {
            y: el.dataset.parallax || -30, ease: 'none',
            scrollTrigger: { trigger: el, start: 'top bottom', end: 'bottom top', scrub: 1 }
        });
    });

    // .line-inner — hero text reveal
    gsap.utils.toArray('.line-inner').forEach((line, i) => {
        gsap.from(line, { y: '110%', duration: 1.2, delay: i * 0.15, ease: 'power3.out' });
    });

    // [data-reveal="words"] — word-by-word opacity
    gsap.utils.toArray('[data-reveal="words"]').forEach(block => {
        const words = block.querySelectorAll('.word');
        ScrollTrigger.create({
            trigger: block, start: 'top 70%', end: 'bottom 50%',
            onUpdate: (self) => {
                words.forEach((w, i) => {
                    w.style.opacity = self.progress > (i / words.length) ? 1 : 0.15;
                });
            }
        });
    });

    // [data-magnetic] — magnetic buttons
    document.querySelectorAll('[data-magnetic]').forEach(btn => {
        btn.addEventListener('mousemove', (e) => {
            const r = btn.getBoundingClientRect();
            gsap.to(btn, {
                x: (e.clientX - r.left - r.width / 2) * 0.3,
                y: (e.clientY - r.top - r.height / 2) * 0.3,
                duration: 0.4, ease: 'power2.out'
            });
        });
        btn.addEventListener('mouseleave', () => {
            gsap.to(btn, { x: 0, y: 0, duration: 0.6, ease: 'elastic.out(1, 0.5)' });
        });
    });

    // [data-img-reveal] — image clip reveal
    gsap.utils.toArray('[data-img-reveal]').forEach(el => {
        gsap.from(el, {
            clipPath: 'inset(100% 0 0 0)', duration: 1.2, ease: 'power3.inOut',
            scrollTrigger: { trigger: el, start: 'top 80%' }
        });
    });

    // [data-count] — number counter
    gsap.utils.toArray('[data-count]').forEach(el => {
        const target = parseInt(el.dataset.count);
        const obj = { val: 0 };
        gsap.to(obj, {
            val: target, duration: 2, ease: 'power2.out',
            scrollTrigger: { trigger: el, start: 'top 85%' },
            onUpdate: () => { el.textContent = Math.round(obj.val) + (el.dataset.suffix || ''); }
        });
    });
}

initAnimations();
