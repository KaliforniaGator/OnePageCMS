/**
 * Sitewide Banner - Client-side injection
 * Injects banner at the top of the page using JavaScript
 */

(function() {
    'use strict';
    
    // Get settings from global addon data
    const settings = window.OnePageCMS?.addonData?.['sitewide-banner'] || {
        message: '🎉 Welcome to our site!',
        backgroundColor: '#4f46e5',
        textColor: '#ffffff',
        dismissible: true
    };
    
    // Check if banner was dismissed in this session
    const isDismissed = sessionStorage.getItem('sitewide_banner_dismissed') === 'true';
    
    if (isDismissed) {
        return;
    }
    
    // Create banner element
    function createBanner() {
        const banner = document.createElement('div');
        banner.className = 'sitewide-banner';
        banner.style.backgroundColor = settings.backgroundColor;
        banner.style.color = settings.textColor;
        
        // Create content
        const content = document.createElement('div');
        content.className = 'sitewide-banner__content';
        content.textContent = settings.message;
        banner.appendChild(content);
        
        // Create close button if dismissible
        if (settings.dismissible) {
            const closeBtn = document.createElement('button');
            closeBtn.className = 'sitewide-banner__close';
            closeBtn.innerHTML = '×';
            closeBtn.setAttribute('aria-label', 'Close banner');
            closeBtn.onclick = function() {
                banner.classList.add('hidden');
                sessionStorage.setItem('sitewide_banner_dismissed', 'true');
            };
            banner.appendChild(closeBtn);
        }
        
        return banner;
    }
    
    // Inject banner at the top of the body
    function injectBanner() {
        const banner = createBanner();
        
        // Insert as first child of body
        if (document.body.firstChild) {
            document.body.insertBefore(banner, document.body.firstChild);
        } else {
            document.body.appendChild(banner);
        }
    }
    
    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', injectBanner);
    } else {
        injectBanner();
    }
})();
