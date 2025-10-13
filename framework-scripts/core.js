/**
 * OnePage CMS - Framework Core JavaScript
 * Minimal core functionality - designed to not conflict with user scripts
 */

(function() {
    'use strict';
    
    // Framework object - namespaced to avoid conflicts
    // Preserve existing properties (like addonRoutes set by inline script)
    window.OnePageCMS = window.OnePageCMS || {};
    
    // Extend with framework methods
    Object.assign(window.OnePageCMS, {
        version: '1.0.0',
        
        /**
         * Initialize the framework
         */
        init: function() {
            // Silent initialization - no console logs to avoid clutter
            this.markAddonLinks();
            this.highlightCurrentPage();
            this.initPageTransitions();
            this.initBrowserNavigation();
            this.initAlerts();
        },
        
        /**
         * Mark addon links with data-no-ajax attribute
         * This ensures addon pages load with full page refresh to load their scripts
         */
        markAddonLinks: function() {
            if (!this.addonRoutes || this.addonRoutes.length === 0) {
                return;
            }
            
            // Find all links that point to addon routes
            const allLinks = document.querySelectorAll('a[href*="?page="]');
            
            allLinks.forEach(function(link) {
                const href = link.getAttribute('href');
                if (!href) return;
                
                // Extract the page parameter value
                const match = href.match(/[?&]page=([^&]+)/);
                if (match && match[1]) {
                    const pageRoute = match[1];
                    
                    // Check if this route matches any addon route
                    if (window.OnePageCMS.addonRoutes.includes(pageRoute)) {
                        link.setAttribute('data-no-ajax', '');
                    }
                }
            });
        },
        
        /**
         * Initialize alert functionality
         */
        initAlerts: function() {
            // Auto-dismiss toasts with duration
            const toasts = document.querySelectorAll('.alert-style-toast[data-duration]');
            toasts.forEach(function(toast) {
                const duration = parseInt(toast.getAttribute('data-duration'));
                if (duration > 0) {
                    setTimeout(function() {
                        window.dismissAlert(toast.id);
                    }, duration);
                }
            });
        },
        
        /**
         * Highlight current page in navigation (optional helper)
         */
        highlightCurrentPage: function() {
            const currentUrl = window.location.href;
            const navLinks = document.querySelectorAll('.main-nav a');
            
            navLinks.forEach(function(link) {
                if (link.href === currentUrl) {
                    link.classList.add('active');
                }
            });
        },
        
        /**
         * Utility: Get query parameter
         */
        getQueryParam: function(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        },
        
        /**
         * Initialize page transitions
         */
        initPageTransitions: function() {
            const pageContainer = document.getElementById('page-container');
            if (!pageContainer) return;
            
            // Check if any transition class is present
            const transitionClass = this.getTransitionClass(pageContainer);
            if (!transitionClass) return;
            
            // Handle internal link clicks for smooth transitions
            this.attachTransitionListeners(pageContainer, transitionClass);
        },
        
        /**
         * Get the transition class from the page container
         */
        getTransitionClass: function(pageContainer) {
            const classes = pageContainer.className.split(' ');
            for (let i = 0; i < classes.length; i++) {
                if (classes[i].startsWith('page-transition-')) {
                    return classes[i];
                }
            }
            return null;
        },
        
        /**
         * Attach transition listeners to internal links
         */
        attachTransitionListeners: function(pageContainer, transitionClass) {
            const self = this;
            
            // Get all internal links
            const internalLinks = document.querySelectorAll('a[href^="/?page="], a[href^="?page="]');
            
            internalLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    // Skip AJAX loading if data-no-ajax attribute is present
                    if (this.hasAttribute('data-no-ajax')) {
                        return; // Allow normal navigation
                    }
                    
                    // Only apply transition if not opening in new tab
                    if (!e.ctrlKey && !e.metaKey && !e.shiftKey) {
                        e.preventDefault();
                        const href = this.getAttribute('href');
                        
                        // Get animation duration based on transition type
                        let duration = 400; // default
                        if (transitionClass.includes('flip') || 
                            transitionClass.includes('inverse-flip') || 
                            transitionClass.includes('vertical-flip')) {
                            duration = 500;
                        }
                        
                        // Add exit animation
                        pageContainer.classList.add('page-transition-out');
                        
                        // Load new page content via AJAX
                        setTimeout(function() {
                            self.loadPageContent(href, pageContainer, transitionClass);
                        }, duration);
                    }
                });
            });
        },
        
        /**
         * Load page content via AJAX
         */
        loadPageContent: function(url, pageContainer, transitionClass) {
            const self = this;
            
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    // Parse the HTML
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    // Get the new page content
                    const newContent = doc.querySelector('#page-container');
                    if (newContent) {
                        // Update the page container content
                        pageContainer.innerHTML = newContent.innerHTML;
                        
                        // Force a reflow to ensure the animation triggers
                        void pageContainer.offsetWidth;
                        
                        // Remove exit animation and add entry animation
                        pageContainer.classList.remove('page-transition-out');
                        
                        // Use requestAnimationFrame to ensure the class is added after the DOM update
                        requestAnimationFrame(function() {
                            pageContainer.classList.add(transitionClass);
                        });
                        
                        // Update browser history
                        window.history.pushState({}, '', url);
                        
                        // Update page title
                        const newTitle = doc.querySelector('title');
                        if (newTitle) {
                            document.title = newTitle.textContent;
                        }
                        
                        // Re-attach transition listeners to new links
                        self.attachTransitionListeners(pageContainer, transitionClass);
                        
                        // Mark addon links in the new content
                        self.markAddonLinks();
                        
                        // Scroll to top
                        window.scrollTo(0, 0);
                        
                        // Update active navigation
                        self.highlightCurrentPage();
                    }
                })
                .catch(error => {
                    console.error('Error loading page:', error);
                    // Fallback to normal navigation
                    window.location.href = url;
                });
        },
        
        /**
         * Handle browser back/forward navigation
         */
        initBrowserNavigation: function() {
            const self = this;
            const pageContainer = document.getElementById('page-container');
            
            if (!pageContainer) return;
            
            const transitionClass = this.getTransitionClass(pageContainer);
            if (!transitionClass) return;
            
            window.addEventListener('popstate', function(event) {
                // Reload the page content without full refresh
                self.loadPageContent(window.location.href, pageContainer, transitionClass);
            });
        }
    });
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            OnePageCMS.init();
        });
    } else {
        OnePageCMS.init();
    }
    
    /**
     * Global function to dismiss alerts
     * Can be called from inline onclick handlers
     */
    window.dismissAlert = function(alertId) {
        const alert = document.getElementById(alertId);
        if (!alert) return;
        
        // Add dismissing class for animation
        alert.classList.add('alert-dismissing');
        
        // Remove the alert after animation completes
        setTimeout(function() {
            alert.remove();
        }, 300);
    };
})();
