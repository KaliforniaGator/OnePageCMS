/**
 * OnePage CMS - Framework Core JavaScript
 * Minimal core functionality - designed to not conflict with user scripts
 */

(function() {
    'use strict';
    
    // Framework object - namespaced to avoid conflicts
    window.OnePageCMS = window.OnePageCMS || {
        version: '1.0.0',
        
        /**
         * Initialize the framework
         */
        init: function() {
            // Silent initialization - no console logs to avoid clutter
            this.highlightCurrentPage();
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
        }
    };
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            OnePageCMS.init();
        });
    } else {
        OnePageCMS.init();
    }
})();
