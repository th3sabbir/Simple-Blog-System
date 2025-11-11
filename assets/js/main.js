/**
 * Modern Blog System - ES6 JavaScript
 * Elegant interactions and dynamic functionality
 */

// Mobile Menu Toggle
class MobileMenu {
    constructor() {
        this.menuToggle = document.querySelector('.mobile-menu-toggle');
        this.navMenu = document.querySelector('.nav-menu');
        
        if (this.menuToggle && this.navMenu) {
            this.init();
        }
    }

    init() {
        this.menuToggle.addEventListener('click', () => this.toggleMenu());
        
        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.nav-wrapper')) {
                this.closeMenu();
            }
        });

        // Close menu when clicking on a link
        const navLinks = this.navMenu.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => this.closeMenu());
        });
    }

    toggleMenu() {
        this.navMenu.classList.toggle('active');
        this.animateToggle();
    }

    closeMenu() {
        this.navMenu.classList.remove('active');
        this.resetToggle();
    }

    animateToggle() {
        const spans = this.menuToggle.querySelectorAll('span');
        if (this.navMenu.classList.contains('active')) {
            spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
            spans[1].style.opacity = '0';
            spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
        } else {
            this.resetToggle();
        }
    }

    resetToggle() {
        const spans = this.menuToggle.querySelectorAll('span');
        spans.forEach(span => {
            span.style.transform = '';
            span.style.opacity = '';
        });
    }
}

// Smooth Scroll Animation
class SmoothScroll {
    constructor() {
        this.init();
    }

    init() {
        const links = document.querySelectorAll('a[href^="#"]');
        links.forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                if (href !== '#' && href !== '') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });
    }
}

// Form Validation
class FormValidator {
    constructor(formSelector) {
        this.form = document.querySelector(formSelector);
        if (this.form) {
            this.init();
        }
    }

    init() {
        this.form.addEventListener('submit', (e) => {
            if (!this.validateForm()) {
                e.preventDefault();
            }
        });

        // Real-time validation
        const inputs = this.form.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearError(input));
        });
    }

    validateForm() {
        let isValid = true;
        const inputs = this.form.querySelectorAll('input[required], textarea[required]');
        
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isValid = false;
            }
        });

        return isValid;
    }

    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';

        // Required field validation
        if (field.hasAttribute('required') && value === '') {
            isValid = false;
            errorMessage = 'This field is required';
        }

        // Email validation
        if (field.type === 'email' && value !== '') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Please enter a valid email address';
            }
        }

        // Password validation
        if (field.type === 'password' && field.name === 'password' && value !== '' && value.length < 6) {
            isValid = false;
            errorMessage = 'Password must be at least 6 characters long';
        }

        // Confirm password validation
        if (field.name === 'confirm_password' && value !== '') {
            const password = this.form.querySelector('input[name="password"]');
            if (password && value !== password.value) {
                isValid = false;
                errorMessage = 'Passwords do not match';
            }
        }

        if (!isValid) {
            this.showError(field, errorMessage);
        } else {
            this.clearError(field);
        }

        return isValid;
    }

    showError(field, message) {
        this.clearError(field);
        
        field.classList.add('error');
        field.style.borderColor = '#f56565';
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.style.color = '#f56565';
        errorDiv.style.fontSize = '0.875rem';
        errorDiv.style.marginTop = '0.5rem';
        errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;
        
        field.parentElement.appendChild(errorDiv);
    }

    clearError(field) {
        field.classList.remove('error');
        field.style.borderColor = '';
        
        const errorDiv = field.parentElement.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    }
}

// Character Counter for Textarea
class CharacterCounter {
    constructor() {
        this.textareas = document.querySelectorAll('textarea');
        if (this.textareas.length > 0) {
            this.init();
        }
    }

    init() {
        this.textareas.forEach(textarea => {
            const maxLength = textarea.getAttribute('maxlength');
            if (maxLength) {
                this.createCounter(textarea, maxLength);
            }
        });
    }

    createCounter(textarea, maxLength) {
        const counter = document.createElement('div');
        counter.className = 'char-counter';
        counter.style.textAlign = 'right';
        counter.style.fontSize = '0.875rem';
        counter.style.color = '#718096';
        counter.style.marginTop = '0.5rem';
        
        const updateCounter = () => {
            const currentLength = textarea.value.length;
            counter.textContent = `${currentLength} / ${maxLength}`;
            
            if (currentLength >= maxLength * 0.9) {
                counter.style.color = '#ed8936';
            } else {
                counter.style.color = '#718096';
            }
        };

        textarea.addEventListener('input', updateCounter);
        textarea.parentElement.appendChild(counter);
        updateCounter();
    }
}

// Auto-hide Alerts
class AlertManager {
    constructor() {
        this.alerts = document.querySelectorAll('.alert');
        if (this.alerts.length > 0) {
            this.init();
        }
    }

    init() {
        this.alerts.forEach(alert => {
            // Make alerts dismissible
            if (!alert.querySelector('.alert-close')) {
                const closeBtn = document.createElement('button');
                closeBtn.className = 'alert-close';
                closeBtn.innerHTML = '<i class="fas fa-times"></i>';
                closeBtn.style.marginLeft = 'auto';
                closeBtn.style.background = 'none';
                closeBtn.style.border = 'none';
                closeBtn.style.cursor = 'pointer';
                closeBtn.style.fontSize = '1.25rem';
                closeBtn.style.padding = '0';
                closeBtn.style.color = 'inherit';
                
                closeBtn.addEventListener('click', () => {
                    this.dismissAlert(alert);
                });
                
                alert.appendChild(closeBtn);
            }

            // Auto-hide success alerts after 5 seconds
            if (alert.classList.contains('alert-success')) {
                setTimeout(() => {
                    this.dismissAlert(alert);
                }, 5000);
            }
        });
    }

    dismissAlert(alert) {
        alert.style.transition = 'all 0.3s ease-out';
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
            alert.remove();
        }, 300);
    }
}

// Lazy Loading for Images (if we add images later)
class LazyLoader {
    constructor() {
        this.images = document.querySelectorAll('img[data-src]');
        if (this.images.length > 0) {
            this.init();
        }
    }

    init() {
        const options = {
            root: null,
            rootMargin: '50px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        }, options);

        this.images.forEach(img => observer.observe(img));
    }
}

// Reading Progress Bar (for post detail pages)
class ReadingProgress {
    constructor() {
        if (document.querySelector('.post-detail')) {
            this.init();
        }
    }

    init() {
        const progressBar = document.createElement('div');
        progressBar.className = 'reading-progress';
        progressBar.style.position = 'fixed';
        progressBar.style.top = '0';
        progressBar.style.left = '0';
        progressBar.style.width = '0%';
        progressBar.style.height = '4px';
        progressBar.style.background = 'linear-gradient(90deg, #0C3C78, #1565C0)';
        progressBar.style.zIndex = '9999';
        progressBar.style.transition = 'width 0.1s ease-out';
        
        document.body.appendChild(progressBar);

        window.addEventListener('scroll', () => {
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight - windowHeight;
            const scrolled = window.scrollY;
            const progress = (scrolled / documentHeight) * 100;
            
            progressBar.style.width = `${progress}%`;
        });
    }
}

// Back to Top Button
class BackToTop {
    constructor() {
        this.init();
    }

    init() {
        const button = document.createElement('button');
        button.className = 'back-to-top';
        button.innerHTML = '<i class="fas fa-arrow-up"></i>';
        button.setAttribute('aria-label', 'Back to top');
        
        // Styling
        Object.assign(button.style, {
            position: 'fixed',
            bottom: '30px',
            right: '30px',
            width: '50px',
            height: '50px',
            borderRadius: '50%',
            background: 'linear-gradient(135deg, #0C3C78, #1565C0)',
            color: 'white',
            border: 'none',
            cursor: 'pointer',
            fontSize: '1.25rem',
            boxShadow: '0 4px 6px rgba(0, 0, 0, 0.1)',
            opacity: '0',
            visibility: 'hidden',
            transition: 'all 0.3s ease',
            zIndex: '1000'
        });

        document.body.appendChild(button);

        // Show/hide on scroll
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                button.style.opacity = '1';
                button.style.visibility = 'visible';
            } else {
                button.style.opacity = '0';
                button.style.visibility = 'hidden';
            }
        });

        // Scroll to top on click
        button.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Hover effect
        button.addEventListener('mouseenter', () => {
            button.style.transform = 'translateY(-5px)';
            button.style.boxShadow = '0 6px 12px rgba(0, 0, 0, 0.15)';
        });

        button.addEventListener('mouseleave', () => {
            button.style.transform = 'translateY(0)';
            button.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
        });
    }
}

// Confirmation Dialog Enhancement
const confirmDelete = (message) => {
    return confirm(message || 'Are you sure you want to delete this item?');
};

// Initialize all components when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Initialize mobile menu
    new MobileMenu();

    // Initialize smooth scroll
    new SmoothScroll();

    // Initialize form validation
    new FormValidator('.auth-form');
    new FormValidator('.post-form');
    new FormValidator('.comment-form');

    // Initialize character counter
    new CharacterCounter();

    // Initialize alert manager
    new AlertManager();

    // Initialize lazy loading
    new LazyLoader();

    // Initialize reading progress
    new ReadingProgress();

    // Initialize back to top button
    new BackToTop();

    // Add animation on scroll for cards
    const observeElements = document.querySelectorAll('.post-card, .stat-card, .featured-post');
    
    if (observeElements.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '0';
                    entry.target.style.transform = 'translateY(30px)';
                    
                    setTimeout(() => {
                        entry.target.style.transition = 'all 0.6s ease-out';
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, 100);
                    
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        observeElements.forEach(el => observer.observe(el));
    }

    // Add typing effect to hero title (optional)
    const heroTitle = document.querySelector('.hero-title');
    if (heroTitle && heroTitle.dataset.typing === 'true') {
        const text = heroTitle.textContent;
        heroTitle.textContent = '';
        let i = 0;
        
        const typeWriter = () => {
            if (i < text.length) {
                heroTitle.textContent += text.charAt(i);
                i++;
                setTimeout(typeWriter, 50);
            }
        };
        
        typeWriter();
    }

    console.log('%c🎨 ModernBlog System Loaded Successfully!', 'color: #0C3C78; font-size: 16px; font-weight: bold;');
});

// Export for use in other modules if needed
export { MobileMenu, FormValidator, AlertManager, ReadingProgress, BackToTop };
