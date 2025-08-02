/**
 * BookShop World Main JavaScript File
 * Handles theme switching, cart functionality, and UI interactions
 */

// Theme Management System
class ThemeManager {
    constructor() {
        this.currentTheme = 'earthy'; // Default theme
        this.themes = {
            'earthy': 'Earthy Natural',
            'dark': 'Dark Mode',
            'summer': 'Summer Bright'
        };
        this.init();
    }

    init() {
        // Load saved theme from localStorage (if available)
        const savedTheme = localStorage.getItem('bookshop-theme');
        if (savedTheme && this.themes[savedTheme]) {
            this.setTheme(savedTheme);
        }
        
        // Set up theme switcher event listeners
        this.setupThemeSwitcher();
        
        // Apply theme to body
        this.applyTheme();
    }

    setTheme(themeName) {
        if (this.themes[themeName]) {
            this.currentTheme = themeName;
            localStorage.setItem('bookshop-theme', themeName);
            this.applyTheme();
            this.updateThemeUI();
        }
    }

    applyTheme() {
        // Remove all theme classes
        document.body.classList.remove('theme-earthy', 'theme-dark', 'theme-summer');
        
        // Add current theme class
        if (this.currentTheme !== 'earthy') {
            document.body.classList.add(`theme-${this.currentTheme}`);
        }
    }

    updateThemeUI() {
        // Update active state in dropdown
        const themeOptions = document.querySelectorAll('[data-theme]');
        themeOptions.forEach(option => {
            option.classList.remove('active');
            if (option.dataset.theme === this.currentTheme) {
                option.classList.add('active');
            }
        });

        // Update theme button text
        const themeButton = document.querySelector('#themeButton');
        if (themeButton) {
            const themeName = this.themes[this.currentTheme];
            themeButton.innerHTML = `<i class="fas fa-palette me-1"></i>${themeName}`;
        }
    }

    setupThemeSwitcher() {
        // Handle theme selection clicks
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-theme]')) {
                e.preventDefault();
                const selectedTheme = e.target.dataset.theme;
                this.setTheme(selectedTheme);
                
                // Add visual feedback
                this.showThemeChangeNotification(this.themes[selectedTheme]);
            }
        });
    }

    showThemeChangeNotification(themeName) {
        // Create temporary notification
        const notification = document.createElement('div');
        notification.className = 'alert alert-success position-fixed';
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 250px;';
        notification.innerHTML = `
            <i class="fas fa-palette me-2"></i>
            Theme changed to ${themeName}
            <button type="button" class="btn-close ms-2" onclick="this.parentElement.remove()"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 3000);
    }
}

// Shopping Cart Functionality
class ShoppingCart {
    constructor() {
        this.init();
    }

    init() {
        // Set up add to cart buttons
        this.setupAddToCartButtons();
        
        // Set up cart update functionality
        this.setupCartUpdates();
    }

    setupAddToCartButtons() {
        document.addEventListener('click', (e) => {
            if (e.target.matches('.add-to-cart-btn') || e.target.closest('.add-to-cart-btn')) {
                e.preventDefault();
                const button = e.target.closest('.add-to-cart-btn') || e.target;
                const productId = button.dataset.productId;
                
                if (productId) {
                    this.addToCart(productId);
                }
            }
        });
    }

    setupCartUpdates() {
        // Handle quantity updates
        document.addEventListener('change', (e) => {
            if (e.target.matches('.cart-quantity')) {
                this.updateCartQuantity(e.target);
            }
        });
    }

    addToCart(productId, quantity = 1, format = 'paperback') {
        // Check if user is logged in
        if (!window.isLoggedIn) {
            this.showNotification('Please login first!', 'warning');
            window.location.href = 'login.php';
            return;
        }

        // Show loading state
        this.showLoadingState();

        // Send AJAX request
        fetch('ajax/add-to-cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                product_id: parseInt(productId),
                quantity: parseInt(quantity),
                format: format
            })
        })
        .then(response => response.json())
        .then(data => {
            this.hideLoadingState();
            
            if (data.success) {
                this.showNotification('Book added to cart!', 'success');
                this.updateCartCount(data.cart_count);
                this.animateCartIcon();
            } else {
                this.showNotification(data.message || 'Error adding book to cart', 'danger');
            }
        })
        .catch(error => {
            this.hideLoadingState();
            console.error('Cart error:', error);
            this.showNotification('Error adding book to cart', 'danger');
        });
    }

    updateCartQuantity(input) {
        const cartId = input.dataset.cartId;
        const newQuantity = parseInt(input.value);
        
        if (newQuantity < 0) {
            input.value = 0;
            return;
        }

        // Visual feedback
        input.style.backgroundColor = '#fff3cd';
        
        // Reset background after a moment
        setTimeout(() => {
            input.style.backgroundColor = '';
        }, 1000);
    }

    updateCartCount(count) {
        const cartBadges = document.querySelectorAll('.cart-count');
        cartBadges.forEach(badge => {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'inline' : 'none';
        });
    }

    animateCartIcon() {
        const cartIcon = document.querySelector('.cart-icon');
        if (cartIcon) {
            cartIcon.classList.add('animate__animated', 'animate__bounceIn');
            setTimeout(() => {
                cartIcon.classList.remove('animate__animated', 'animate__bounceIn');
            }, 1000);
        }
    }

    showLoadingState() {
        document.body.classList.add('loading');
    }

    hideLoadingState() {
        document.body.classList.remove('loading');
    }

    showNotification(message, type = 'info') {
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'warning' ? 'alert-warning' :
                          type === 'danger' ? 'alert-danger' : 'alert-info';
        
        const notification = document.createElement('div');
        notification.className = `alert ${alertClass} position-fixed fade-in`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            <i class="fas fa-shopping-cart me-2"></i>${message}
            <button type="button" class="btn-close ms-2" onclick="this.parentElement.remove()"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 3000);
    }
}

// Search Enhancement
class SearchEnhancer {
    constructor() {
        this.init();
    }

    init() {
        this.setupSearchSuggestions();
        this.setupSearchHistory();
    }

    setupSearchSuggestions() {
        const searchInput = document.querySelector('input[name="q"]');
        if (!searchInput) return;

        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.trim();
            if (query.length >= 2) {
                this.showSearchSuggestions(query);
            } else {
                this.hideSearchSuggestions();
            }
        });

        // Hide suggestions when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.search-suggestions')) {
                this.hideSearchSuggestions();
            }
        });
    }

    setupSearchHistory() {
        // Save search terms to localStorage
        const searchForms = document.querySelectorAll('form[action*="search"]');
        searchForms.forEach(form => {
            form.addEventListener('submit', (e) => {
                const query = form.querySelector('input[name="q"]').value.trim();
                if (query) {
                    this.saveSearchTerm(query);
                }
            });
        });
    }

    saveSearchTerm(term) {
        let searchHistory = JSON.parse(localStorage.getItem('search-history') || '[]');
        
        // Remove if already exists
        searchHistory = searchHistory.filter(item => item !== term);
        
        // Add to beginning
        searchHistory.unshift(term);
        
        // Keep only last 5 searches
        searchHistory = searchHistory.slice(0, 5);
        
        localStorage.setItem('search-history', JSON.stringify(searchHistory));
    }

    showSearchSuggestions(query) {
        // Simple suggestions based on common book terms
        const suggestions = [
            'mystery books', 'romance novels', 'science fiction',
            'fantasy books', 'bestsellers', 'new releases'
        ].filter(suggestion => suggestion.includes(query.toLowerCase()));

        if (suggestions.length > 0) {
            console.log('Search suggestions:', suggestions);
            // In a real app, you'd create a dropdown with these suggestions
        }
    }

    hideSearchSuggestions() {
        // Hide suggestion dropdown
        const suggestionsDiv = document.querySelector('.search-suggestions');
        if (suggestionsDiv) {
            suggestionsDiv.remove();
        }
    }
}

// UI Enhancements
class UIEnhancer {
    constructor() {
        this.init();
    }

    init() {
        this.setupScrollEffects();
        this.setupImageLazyLoading();
        this.setupFormValidation();
        this.setupToolips();
    }

    setupScrollEffects() {
        // Add scroll-to-top button
        this.createScrollToTopButton();
        
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (navbar) {
                if (window.scrollY > 100) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            }
        });
    }

    createScrollToTopButton() {
        const scrollBtn = document.createElement('button');
        scrollBtn.className = 'btn btn-primary position-fixed';
        scrollBtn.style.cssText = 'bottom: 20px; right: 20px; z-index: 1000; border-radius: 50%; width: 50px; height: 50px; display: none;';
        scrollBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
        scrollBtn.title = 'Back to top';
        
        scrollBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollBtn.style.display = 'block';
            } else {
                scrollBtn.style.display = 'none';
            }
        });
        
        document.body.appendChild(scrollBtn);
    }

    setupImageLazyLoading() {
        // Simple lazy loading for images
        const images = document.querySelectorAll('img[data-src]');
        
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    observer.unobserve(img);
                }
            });
        });

        images.forEach(img => imageObserver.observe(img));
    }

    setupFormValidation() {
        // Enhanced form validation
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    this.showFormError('Please fill in all required fields');
                }
            });
        });
    }

    setupToolips() {
        // Initialize Bootstrap tooltips if available
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    }

    showFormError(message) {
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger';
        alert.textContent = message;
        
        const form = document.querySelector('form');
        if (form) {
            form.insertBefore(alert, form.firstChild);
            setTimeout(() => alert.remove(), 3000);
        }
    }
}

// Global Add to Cart Function (for backward compatibility)
function addToCart(productId, quantity = 1, format = 'paperback') {
    if (window.shoppingCart) {
        window.shoppingCart.addToCart(productId, quantity, format);
    }
}

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all modules
    window.themeManager = new ThemeManager();
    window.shoppingCart = new ShoppingCart();
    window.searchEnhancer = new SearchEnhancer();
    window.uiEnhancer = new UIEnhancer();
    
    // Add global login status (to be set by PHP)
    window.isLoggedIn = document.body.dataset.loggedIn === 'true';
    
    // Add fade-in animation to main content
    const mainContent = document.querySelector('main');
    if (mainContent) {
        mainContent.classList.add('fade-in');
    }
    
    console.log('📚 BookShop World JavaScript initialized successfully!');
});

// Export for module usage (if needed)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        ThemeManager,
        ShoppingCart,
        SearchEnhancer,
        UIEnhancer
    };
}