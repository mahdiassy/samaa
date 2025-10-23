/**
 * SAMAA UI Enhancements - Glamorous & Interactive
 * Complete redesign with smooth animations and modern interactions
 */

class SAMAAUIEnhancements {
    constructor() {
        this.init();
    }

    init() {
        this.setupScrollAnimations();
        this.setupNavigation();
        this.setupKidsTheme();
        this.setupFormEnhancements();
        this.setupButtonEffects();
        this.setupParallaxEffects();
        this.setupLazyLoading();
        this.setupMobileOptimizations();
        this.setupAccessibility();
        this.setupDropdowns();
        this.setupHoverMicroInteractions();
    }

    /**
     * Scroll-based animations using Intersection Observer
     */
    setupScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    const animationType = element.dataset.animate || 'fade-in-up';
                    const delay = element.dataset.delay || 0;
                    
                    setTimeout(() => {
                        element.classList.add(animationType);
                    }, parseInt(delay));
                    
                    observer.unobserve(element);
                }
            });
        }, observerOptions);

        // Observe all elements with animation data attributes
        document.querySelectorAll('[data-animate]').forEach(el => {
            observer.observe(el);
        });

        // Auto-add animations to common elements
        const autoAnimateSelectors = [
            '.card',
            '.feature-card',
            '.therapist-card',
            '.contact-item',
            '.section-title',
            'h1, h2, h3',
            '.btn'
        ];

        autoAnimateSelectors.forEach(selector => {
            document.querySelectorAll(selector).forEach((el, index) => {
                if (!el.dataset.animate) {
                    el.dataset.animate = 'fade-in-up';
                    el.dataset.delay = index * 100;
                    observer.observe(el);
                }
            });
        });
    }

    /**
     * Card/image hover micro-interactions
     */
    setupHoverMicroInteractions() {
        const hoverables = document.querySelectorAll('.card, .feature-card, .therapist-card, .img-hover');
        hoverables.forEach(el => {
            el.addEventListener('mousemove', (e) => {
                const rect = el.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                el.style.setProperty('--mx', x + 'px');
                el.style.setProperty('--my', y + 'px');
            });
            el.addEventListener('mouseenter', () => {
                el.classList.add('hovering');
            });
            el.addEventListener('mouseleave', () => {
                el.classList.remove('hovering');
            });
        });
    }

    /**
     * Accessible dropdown menus
     */
    setupDropdowns() {
        document.querySelectorAll('.nav-item').forEach(item => {
            const toggle = item.querySelector('.nav-link');
            const menu = item.querySelector('.dropdown-menu');
            if (!toggle || !menu) return;

            // ARIA attributes
            toggle.setAttribute('aria-haspopup', 'true');
            toggle.setAttribute('aria-expanded', 'false');

            // Hover/Focus open
            ['mouseenter', 'focus'].forEach(evt => {
                item.addEventListener(evt, () => {
                    menu.style.opacity = '1';
                    menu.style.visibility = 'visible';
                    toggle.setAttribute('aria-expanded', 'true');
                });
            });

            // Leave/Blur close
            ['mouseleave', 'blur'].forEach(evt => {
                item.addEventListener(evt, (e) => {
                    // Delay to allow moving into submenu
                    setTimeout(() => {
                        if (!item.matches(':hover')) {
                            menu.style.opacity = '';
                            menu.style.visibility = '';
                            toggle.setAttribute('aria-expanded', 'false');
                        }
                    }, 150);
                });
            });

            // Keyboard support
            item.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    menu.style.opacity = '';
                    menu.style.visibility = '';
                    toggle.focus();
                    toggle.setAttribute('aria-expanded', 'false');
                }
            });
        });
    }

    /**
     * Enhanced navigation with scroll effects
     */
    setupNavigation() {
        const navbar = document.querySelector('.navbar');
        const mobileToggle = document.querySelector('.mobile-menu-toggle');
        const navMenu = document.querySelector('.navbar-nav');
        let lastScrollY = window.scrollY;
        let ticking = false;

        if (!navbar) return;

        // Scroll effects
        const updateNavbar = () => {
            const currentScrollY = window.scrollY;
            
            // Add/remove scrolled class
            navbar.classList.toggle('scrolled', currentScrollY > 50);
            
            // Hide/show navbar on scroll
            if (currentScrollY > lastScrollY && currentScrollY > 200) {
                navbar.classList.add('hidden');
            } else {
                navbar.classList.remove('hidden');
            }
            
            lastScrollY = currentScrollY;
            ticking = false;
        };

        const requestTick = () => {
            if (!ticking) {
                requestAnimationFrame(updateNavbar);
                ticking = true;
            }
        };

        window.addEventListener('scroll', requestTick, { passive: true });

        // Mobile menu toggle
        if (mobileToggle && navMenu) {
            mobileToggle.addEventListener('click', (e) => {
                e.preventDefault();
                mobileToggle.classList.toggle('active');
                navMenu.classList.toggle('active');
                document.body.classList.toggle('menu-open');
            });

            // Close menu when clicking on links
            navMenu.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    mobileToggle.classList.remove('active');
                    navMenu.classList.remove('active');
                    document.body.classList.remove('menu-open');
                });
            });
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offsetTop = target.getBoundingClientRect().top + window.pageYOffset - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    /**
     * Kids theme toggle with enhanced animations
     */
    setupKidsTheme() {
        const toggle = document.querySelector('.kids-theme-toggle');
        const toggleSwitch = document.querySelector('.toggle-switch');
        
        if (!toggle || !toggleSwitch) return;

        // Load saved theme preference
        const savedTheme = localStorage.getItem('samaa-kids-theme');
        if (savedTheme === 'enabled') {
            this.enableKidsTheme();
            toggleSwitch.classList.add('active');
        }

        toggle.addEventListener('click', () => {
            if (document.body.classList.contains('kids-theme')) {
                this.disableKidsTheme();
                toggleSwitch.classList.remove('active');
                localStorage.setItem('samaa-kids-theme', 'disabled');
            } else {
                this.enableKidsTheme();
                toggleSwitch.classList.add('active');
                localStorage.setItem('samaa-kids-theme', 'enabled');
            }
        });
    }

    enableKidsTheme() {
        document.body.classList.add('kids-theme');
        
        // Add sparkle animation to elements
        this.addSparkleEffect();
        
        // Show fun message
        this.showNotification('🎨 Kids theme activated! Everything is more colorful now!');
    }

    disableKidsTheme() {
        document.body.classList.remove('kids-theme');
        
        // Remove sparkle effects
        document.querySelectorAll('.sparkle').forEach(el => el.remove());
        
        this.showNotification('✨ Back to elegant mode!');
    }

    addSparkleEffect() {
        const sparkleElements = document.querySelectorAll('.feature-card, .card, .btn-primary');
        
        sparkleElements.forEach(element => {
            const sparkle = document.createElement('div');
            sparkle.className = 'sparkle';
            sparkle.style.cssText = `
                position: absolute;
                top: 10px;
                right: 10px;
                width: 20px;
                height: 20px;
                background: radial-gradient(circle, #FFE66D 0%, transparent 70%);
                border-radius: 50%;
                animation: sparkle 2s ease-in-out infinite;
                pointer-events: none;
                z-index: 1;
            `;
            
            element.style.position = 'relative';
            element.appendChild(sparkle);
        });

        // Add sparkle animation CSS
        if (!document.querySelector('#sparkle-animation')) {
            const style = document.createElement('style');
            style.id = 'sparkle-animation';
            style.textContent = `
                @keyframes sparkle {
                    0%, 100% { opacity: 0; transform: scale(0.5) rotate(0deg); }
                    50% { opacity: 1; transform: scale(1) rotate(180deg); }
                }
            `;
            document.head.appendChild(style);
        }
    }

    /**
     * Enhanced form interactions
     */
    setupFormEnhancements() {
        // Floating label animation
        document.querySelectorAll('.form-floating .form-input, .form-floating .form-textarea').forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', () => {
                if (!input.value) {
                    input.parentElement.classList.remove('focused');
                }
            });

            // Check if input has value on load
            if (input.value) {
                input.parentElement.classList.add('focused');
            }
        });

        // Form validation with smooth feedback
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (e) => {
                const submitBtn = form.querySelector('[type="submit"]');
                if (submitBtn) {
                    submitBtn.classList.add('loading');
                    submitBtn.disabled = true;
                    
                    // Re-enable after 3 seconds (adjust based on actual form handling)
                    setTimeout(() => {
                        submitBtn.classList.remove('loading');
                        submitBtn.disabled = false;
                    }, 3000);
                }
            });
        });

        // Real-time validation
        document.querySelectorAll('.form-input[type="email"]').forEach(input => {
            input.addEventListener('blur', () => {
                const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value);
                input.classList.toggle('valid', isValid && input.value);
                input.classList.toggle('error', !isValid && input.value);
            });
        });

        document.querySelectorAll('.form-input[required], .form-textarea[required]').forEach(input => {
            input.addEventListener('blur', () => {
                const isValid = input.value.trim().length > 0;
                input.classList.toggle('valid', isValid);
                input.classList.toggle('error', !isValid);
            });
        });
    }

    /**
     * Button ripple effects and enhancements
     */
    setupButtonEffects() {
        document.querySelectorAll('.btn').forEach(button => {
            // Add ripple class
            button.classList.add('btn-ripple');

            // Hover sound effect (optional)
            button.addEventListener('mouseenter', () => {
                button.style.transform = 'translateY(-2px) scale(1.02)';
            });

            button.addEventListener('mouseleave', () => {
                button.style.transform = '';
            });

            // Click animation
            button.addEventListener('click', function(e) {
                // Create ripple effect
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(255, 255, 255, 0.3);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                `;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add ripple animation CSS
        if (!document.querySelector('#ripple-animation')) {
            const style = document.createElement('style');
            style.id = 'ripple-animation';
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
    }

    /**
     * Parallax and scroll effects
     */
    setupParallaxEffects() {
        const parallaxElements = document.querySelectorAll('[data-parallax]');
        
        if (parallaxElements.length === 0) return;

        let ticking = false;

        const updateParallax = () => {
            const scrollTop = window.pageYOffset;

            parallaxElements.forEach(element => {
                const speed = parseFloat(element.dataset.parallax) || 0.5;
                const yPos = -(scrollTop * speed);
                element.style.transform = `translate3d(0, ${yPos}px, 0)`;
            });

            ticking = false;
        };

        const requestTick = () => {
            if (!ticking) {
                requestAnimationFrame(updateParallax);
                ticking = true;
            }
        };

        window.addEventListener('scroll', requestTick, { passive: true });
    }

    /**
     * Lazy loading for images and content
     */
    setupLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                img.classList.add('lazy');
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Mobile-specific optimizations
     */
    setupMobileOptimizations() {
        // Touch gesture support
        let touchStartY = 0;
        let touchEndY = 0;

        document.addEventListener('touchstart', (e) => {
            touchStartY = e.changedTouches[0].screenY;
        }, { passive: true });

        document.addEventListener('touchend', (e) => {
            touchEndY = e.changedTouches[0].screenY;
            this.handleGesture();
        }, { passive: true });

        // Optimize animations for mobile
        if (window.innerWidth <= 768) {
            document.documentElement.style.setProperty('--transition', '0.2s ease-out');
            document.documentElement.style.setProperty('--transition-slow', '0.3s ease-out');
        }

        // Reduce motion for better performance on low-end devices
        if (navigator.hardwareConcurrency && navigator.hardwareConcurrency <= 2) {
            document.documentElement.style.setProperty('--transition', '0.1s ease-out');
            document.documentElement.style.setProperty('--transition-slow', '0.2s ease-out');
        }
    }

    handleGesture() {
        const swipeThreshold = 50;
        const diff = touchStartY - touchEndY;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                // Swipe up - could trigger specific actions
                this.onSwipeUp();
            } else {
                // Swipe down - could trigger specific actions  
                this.onSwipeDown();
            }
        }
    }

    onSwipeUp() {
        // Custom swipe up behavior
        console.log('Swipe up detected');
    }

    onSwipeDown() {
        // Custom swipe down behavior
        console.log('Swipe down detected');
    }

    /**
     * Accessibility enhancements
     */
    setupAccessibility() {
        // Focus management
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });

        document.addEventListener('mousedown', () => {
            document.body.classList.remove('keyboard-navigation');
        });

        // ARIA live regions for dynamic content
        const liveRegion = document.createElement('div');
        liveRegion.setAttribute('aria-live', 'polite');
        liveRegion.setAttribute('aria-atomic', 'true');
        liveRegion.className = 'sr-only';
        liveRegion.id = 'live-region';
        document.body.appendChild(liveRegion);

        // Skip link functionality
        const skipLink = document.querySelector('.skip-link');
        if (skipLink) {
            skipLink.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector('#main-content');
                if (target) {
                    target.focus();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        }

        // Announce page changes
        this.announcePageChange();
    }

    announcePageChange() {
        const pageTitle = document.title;
        const liveRegion = document.getElementById('live-region');
        if (liveRegion) {
            liveRegion.textContent = `Page loaded: ${pageTitle}`;
        }
    }

    /**
     * Utility functions
     */
    showNotification(message, type = 'info', duration = 3000) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--color-primary);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            z-index: var(--z-toast);
            transform: translateX(100%);
            transition: transform var(--transition);
            max-width: 300px;
        `;
        
        notification.textContent = message;
        document.body.appendChild(notification);

        // Slide in
        requestAnimationFrame(() => {
            notification.style.transform = 'translateX(0)';
        });

        // Auto remove
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, duration);
    }

    // Smooth page transitions
    initPageTransitions() {
        if (!window.history.pushState) return;

        document.addEventListener('click', (e) => {
            const link = e.target.closest('a');
            if (!link || link.target === '_blank' || link.hostname !== window.location.hostname) {
                return;
            }

            e.preventDefault();
            this.navigateToPage(link.href);
        });
    }

    async navigateToPage(url) {
        // Add loading state
        document.body.classList.add('page-transitioning');
        
        try {
            const response = await fetch(url);
            const html = await response.text();
            const parser = new DOMParser();
            const newDoc = parser.parseFromString(html, 'text/html');
            
            // Update content
            document.title = newDoc.title;
            document.querySelector('main').innerHTML = newDoc.querySelector('main').innerHTML;
            
            // Update URL
            window.history.pushState({}, '', url);
            
            // Reinitialize components
            this.init();
            
        } catch (error) {
            console.error('Navigation error:', error);
            window.location.href = url;
        } finally {
            document.body.classList.remove('page-transitioning');
        }
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new SAMAAUIEnhancements();
    });
} else {
    new SAMAAUIEnhancements();
}

// Global utility functions
window.SAMAA = {
    showNotification: (message, type, duration) => {
        const ui = new SAMAAUIEnhancements();
        ui.showNotification(message, type, duration);
    }
};
