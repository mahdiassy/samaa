/**
 * UI Improvements JavaScript
 * Handles kids theme toggle, form enhancements, and accessibility features
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Kids Theme Toggle Functionality
    initKidsThemeToggle();
    
    // Form Enhancements
    initFormEnhancements();
    
    // Loading states for images
    initImageLoading();
    
    // Make feature cards clickable
    initFeatureCardLinks();
});

/**
 * Initialize Kids Theme Toggle
 */
function initKidsThemeToggle() {
    const kidsToggle = document.getElementById('kids-theme-toggle');
    const themeOverrideStyle = document.getElementById('theme-override-style');
    
    if (!kidsToggle || !themeOverrideStyle) return;
    
    // Load saved preference
    const savedTheme = localStorage.getItem('samaa-kids-theme');
    if (savedTheme === 'kids') {
        kidsToggle.checked = true;
        themeOverrideStyle.href = themeOverrideStyle.dataset.kidsPath;
    }
    
    // Handle toggle change
    kidsToggle.addEventListener('change', function() {
        if (this.checked) {
            themeOverrideStyle.href = themeOverrideStyle.dataset.kidsPath;
            localStorage.setItem('samaa-kids-theme', 'kids');
        } else {
            themeOverrideStyle.href = '';
            localStorage.setItem('samaa-kids-theme', 'default');
        }
    });
}

/**
 * Form Enhancement Functions
 */
function initFormEnhancements() {
    // Add live validation to forms
    const forms = document.querySelectorAll('.accessible-form');
    forms.forEach(form => {
        addFormValidation(form);
    });
    
    // Newsletter form handling
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', handleNewsletterSubmit);
    }
}

function addFormValidation(form) {
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            clearFieldError(this);
        });
    });
}

function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.name;
    let isValid = true;
    let errorMessage = '';
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = `${getFieldLabel(field)} is required.`;
    }
    
    // Email validation
    if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid email address.';
        }
    }
    
    showFieldError(field, isValid ? '' : errorMessage);
    return isValid;
}

function getFieldLabel(field) {
    const label = document.querySelector(`label[for="${field.id}"]`);
    return label ? label.textContent.replace(':', '') : field.name;
}

function showFieldError(field, message) {
    clearFieldError(field);
    
    if (message) {
        field.classList.add('error');
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        errorDiv.setAttribute('role', 'alert');
        field.parentNode.appendChild(errorDiv);
    }
}

function clearFieldError(field) {
    field.classList.remove('error');
    const existingError = field.parentNode.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
}

function handleNewsletterSubmit(e) {
    e.preventDefault();
    
    const email = e.target.querySelector('input[type="email"]').value;
    
    // Simple validation
    if (!email || !email.includes('@')) {
        showNotification('Please enter a valid email address.', 'error');
        return;
    }
    
    // Show success message (in real app, would make API call)
    showNotification('Thank you for subscribing to our newsletter!', 'success');
    e.target.reset();
}

/**
 * Image Loading Enhancement
 */
function initImageLoading() {
    // Add loading states to images
    const lazyImages = document.querySelectorAll('img[loading="lazy"]');
    
    lazyImages.forEach(img => {
        img.addEventListener('load', function() {
            this.style.opacity = '1';
        });
        
        img.addEventListener('error', function() {
            this.alt = 'Image could not be loaded';
            this.style.opacity = '0.5';
        });
    });
}

/**
 * Make Feature Cards Clickable
 */
function initFeatureCardLinks() {
    const featureCards = document.querySelectorAll('.feature-card');
    
    featureCards.forEach((card, index) => {
        card.setAttribute('tabindex', '0');
        card.setAttribute('role', 'button');
        card.setAttribute('aria-label', `Learn more about ${card.querySelector('h3')?.textContent || 'this feature'}`);
        
        card.addEventListener('click', function() {
            // Route to appropriate pages based on card
            switch(index) {
                case 0: // You Share Your Needs
                    window.location.href = '/en/how-it-work';
                    break;
                case 1: // SAMAA Creates Sessions
                    window.location.href = '/en/how-it-work';
                    break;
                case 2: // You Listen, Heal, Grow
                    window.location.href = '/en/therapists';
                    break;
            }
        });
        
        card.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
}

/**
 * Notification System
 */
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existing = document.querySelector('.notification');
    if (existing) {
        existing.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.setAttribute('role', 'alert');
    notification.setAttribute('aria-live', 'assertive');
    
    // Style the notification
    Object.assign(notification.style, {
        position: 'fixed',
        top: '20px',
        right: '20px',
        padding: '16px 24px',
        backgroundColor: type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#007bff',
        color: 'white',
        borderRadius: '8px',
        zIndex: '10000',
        maxWidth: '400px',
        opacity: '0',
        transform: 'translateX(100%)',
        transition: 'all 0.3s ease'
    });
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

/**
 * Contact Form Success Handler
 */
document.addEventListener('DOMContentLoaded', function() {
    // Check for success message from server
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === 'contact') {
        showNotification('Thank you for your message! We\'ll get back to you soon.', 'success');
    }
    
    // Initialize mobile menu functionality
    initMobileMenu();
    
    // Initialize loading states
    initLoadingStates();
});

/**
 * Mobile Menu Functionality
 */
function initMobileMenu() {
    const menuToggle = document.getElementById('menuToggle');
    const menu = document.getElementById('menu');
    const closeMenu = document.getElementById('closeMenu');
    
    if (menuToggle && menu) {
        menuToggle.addEventListener('click', function() {
            menu.classList.toggle('active');
            document.body.style.overflow = menu.classList.contains('active') ? 'hidden' : '';
        });
        
        if (closeMenu) {
            closeMenu.addEventListener('click', function() {
                menu.classList.remove('active');
                document.body.style.overflow = '';
            });
        }
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!menu.contains(e.target) && !menuToggle.contains(e.target)) {
                menu.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }
}

/**
 * Loading States for Forms
 */
function initLoadingStates() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
                
                // Re-enable after 5 seconds as fallback
                setTimeout(() => {
                    submitBtn.classList.remove('loading');
                    submitBtn.disabled = false;
                }, 5000);
            }
        });
    });
}

/**
 * Lazy Loading Enhancement
 */
function initAdvancedLazyLoading() {
    if ('IntersectionObserver' in window) {
        const lazyImages = document.querySelectorAll('img[loading="lazy"]');
        
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        });
        
        lazyImages.forEach(img => imageObserver.observe(img));
    }
}

// Initialize advanced features
document.addEventListener('DOMContentLoaded', function() {
    initAdvancedLazyLoading();
});
