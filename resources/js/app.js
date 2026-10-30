/**
 * Shahzad Labs — Frontend Logic
 * Handles: mobile nav, project filtering, AJAX contact form,
 * scroll-reveal animations, and counter animations.
 */

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// ── DOM Ready ─────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    initMobileNav();
    initProjectFilters();
    initContactForm();
    initScrollReveal();
    initCounterAnimation();
    initSmoothScroll();
    initCopyEmail();
    initNavScrollSpy();
});

// ── Mobile Hamburger Navigation ──────────────────────────────────────
function initMobileNav() {
    const toggle = document.getElementById('mobile-nav-toggle');
    const menu = document.getElementById('mobile-menu');
    const overlay = document.getElementById('mobile-overlay');

    if (!toggle || !menu) return;

    const openIcon = toggle.querySelector('.icon-open');
    const closeIcon = toggle.querySelector('.icon-close');

    function openMenu() {
        menu.classList.remove('translate-x-full');
        menu.classList.add('translate-x-0');
        overlay?.classList.remove('hidden');
        openIcon?.classList.add('hidden');
        closeIcon?.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
        menu.classList.add('translate-x-full');
        menu.classList.remove('translate-x-0');
        overlay?.classList.add('hidden');
        openIcon?.classList.remove('hidden');
        closeIcon?.classList.add('hidden');
        document.body.style.overflow = '';
    }

    toggle.addEventListener('click', () => {
        menu.classList.contains('translate-x-full') ? openMenu() : closeMenu();
    });

    overlay?.addEventListener('click', closeMenu);

    // Close on nav link click
    menu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', closeMenu);
    });
}

// ── Project Filtering (no page reload) ───────────────────────────────
function initProjectFilters() {
    const buttons = document.querySelectorAll('[data-filter]');
    const cards = document.querySelectorAll('[data-category]');

    if (!buttons.length || !cards.length) return;

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.dataset.filter;

            // Update active button
            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Filter cards with animation
            cards.forEach(card => {
                const matches = filter === 'all' || card.dataset.category === filter;

                if (matches) {
                    card.style.display = '';
                    requestAnimationFrame(() => {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.95) translateY(10px)';
                        requestAnimationFrame(() => {
                            card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                            card.style.opacity = '1';
                            card.style.transform = 'scale(1) translateY(0)';
                        });
                    });
                } else {
                    card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.95)';
                    setTimeout(() => { card.style.display = 'none'; }, 300);
                }
            });
        });
    });
}

// ── AJAX Contact Form ────────────────────────────────────────────────
function initContactForm() {
    const form = document.getElementById('contact-form');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Clear previous errors
        form.querySelectorAll('.field-error').forEach(el => el.textContent = '');

        const submitBtn = form.querySelector('button[type="submit"]');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoader = submitBtn.querySelector('.btn-loader');

        // Show loading state
        submitBtn.disabled = true;
        btnText?.classList.add('hidden');
        btnLoader?.classList.remove('hidden');

        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showToast(data.message, 'success');
                form.reset();
            } else if (response.status === 422 && data.errors) {
                // Validation errors
                Object.entries(data.errors).forEach(([field, messages]) => {
                    const errorEl = form.querySelector(`[data-error="${field}"]`);
                    if (errorEl) errorEl.textContent = messages[0];
                });
                showToast('Please fix the highlighted errors.', 'error');
            } else {
                showToast(data.message || 'Something went wrong. Please try again.', 'error');
            }
        } catch (err) {
            showToast('Network error. Please check your connection.', 'error');
        } finally {
            submitBtn.disabled = false;
            btnText?.classList.remove('hidden');
            btnLoader?.classList.add('hidden');
        }
    });

    // Real-time validation
    form.querySelectorAll('input, textarea').forEach(input => {
        input.addEventListener('blur', () => {
            validateField(input);
        });
    });
}

function validateField(input) {
    const errorEl = input.closest('.form-group')?.querySelector('.field-error');
    if (!errorEl) return;

    let message = '';

    if (input.required && !input.value.trim()) {
        message = `${input.dataset.label || 'This field'} is required.`;
    } else if (input.type === 'email' && input.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value)) {
        message = 'Please enter a valid email address.';
    } else if (input.maxLength > 0 && input.value.length > input.maxLength) {
        message = `Maximum ${input.maxLength} characters allowed.`;
    }

    errorEl.textContent = message;
}

// ── Toast Notifications ──────────────────────────────────────────────
function showToast(message, type = 'success') {
    // Remove existing toasts
    document.querySelectorAll('.toast').forEach(t => t.remove());

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <div class="flex items-center gap-3">
            <span class="text-lg">${type === 'success' ? '✓' : '✕'}</span>
            <span>${message}</span>
        </div>
    `;

    toast.style.transform = 'translateX(120%)';
    document.body.appendChild(toast);

    requestAnimationFrame(() => {
        toast.style.transform = 'translateX(0)';
    });

    setTimeout(() => {
        toast.style.transform = 'translateX(120%)';
        setTimeout(() => toast.remove(), 500);
    }, 5000);
}

// ── Scroll-Reveal Animation ──────────────────────────────────────────
function initScrollReveal() {
    const elements = document.querySelectorAll('.reveal');
    if (!elements.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                // Stagger the reveal
                setTimeout(() => {
                    entry.target.classList.add('revealed');
                }, index * 80);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    elements.forEach(el => observer.observe(el));
}

// ── Counter Animation ────────────────────────────────────────────────
function initCounterAnimation() {
    const counters = document.querySelectorAll('[data-counter]');
    if (!counters.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(el => observer.observe(el));
}

function animateCounter(el) {
    const target = parseInt(el.dataset.counter, 10);
    const suffix = el.dataset.suffix || '';
    const duration = 2000;
    const start = performance.now();

    function update(now) {
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3); // easeOutCubic
        const current = Math.round(eased * target);
        el.textContent = current + suffix;

        if (progress < 1) requestAnimationFrame(update);
    }

    requestAnimationFrame(update);
}

// ── Smooth Scroll for anchor links ───────────────────────────────────
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', (e) => {
            const target = document.querySelector(link.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
}

// ── Copy Email to Clipboard ──────────────────────────────────────────
function initCopyEmail() {
    const copyBtn = document.getElementById('copy-email');
    if (!copyBtn) return;

    copyBtn.addEventListener('click', async () => {
        try {
            await navigator.clipboard.writeText('info@shahzadlabs.com');
            const originalText = copyBtn.innerHTML;
            copyBtn.innerHTML = `
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Copied!</span>
            `;
            copyBtn.classList.add('!bg-accent-500/20', '!text-accent-400', '!border-accent-500/30');
            setTimeout(() => {
                copyBtn.innerHTML = originalText;
                copyBtn.classList.remove('!bg-accent-500/20', '!text-accent-400', '!border-accent-500/30');
            }, 2000);
        } catch {
            showToast('Failed to copy email.', 'error');
        }
    });
}

// ── Nav Scroll Spy ───────────────────────────────────────────────────
function initNavScrollSpy() {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-spy-link');

    if (!sections.length || !navLinks.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.id;
                navLinks.forEach(link => {
                    link.classList.toggle('text-brand-400', link.getAttribute('href') === `#${id}`);
                    link.classList.toggle('text-surface-200/70', link.getAttribute('href') !== `#${id}`);
                });
            }
        });
    }, { threshold: 0.3, rootMargin: '-80px 0px -50% 0px' });

    sections.forEach(section => observer.observe(section));
}
