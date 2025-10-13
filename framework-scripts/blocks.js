/**
 * Blocks JavaScript
 * Interactive functionality for block components
 */

// Slider Functions
function sliderNext(id) {
    const slider = document.getElementById(id);
    const slides = slider.querySelectorAll('.slide');
    const dots = slider.querySelectorAll('.dot');
    let currentIndex = Array.from(slides).findIndex(slide => slide.classList.contains('active'));
    
    slides[currentIndex].classList.remove('active');
    dots[currentIndex].classList.remove('active');
    
    currentIndex = (currentIndex + 1) % slides.length;
    
    slides[currentIndex].classList.add('active');
    dots[currentIndex].classList.add('active');
}

function sliderPrev(id) {
    const slider = document.getElementById(id);
    const slides = slider.querySelectorAll('.slide');
    const dots = slider.querySelectorAll('.dot');
    let currentIndex = Array.from(slides).findIndex(slide => slide.classList.contains('active'));
    
    slides[currentIndex].classList.remove('active');
    dots[currentIndex].classList.remove('active');
    
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    
    slides[currentIndex].classList.add('active');
    dots[currentIndex].classList.add('active');
}

function sliderGoTo(id, index) {
    const slider = document.getElementById(id);
    const slides = slider.querySelectorAll('.slide');
    const dots = slider.querySelectorAll('.dot');
    const currentIndex = Array.from(slides).findIndex(slide => slide.classList.contains('active'));
    
    slides[currentIndex].classList.remove('active');
    dots[currentIndex].classList.remove('active');
    
    slides[index].classList.add('active');
    dots[index].classList.add('active');
}

// Auto-play sliders
document.addEventListener('DOMContentLoaded', function() {
    const sliders = document.querySelectorAll('.block-slider[data-autoplay="true"]');
    
    sliders.forEach(slider => {
        const interval = parseInt(slider.dataset.interval) || 5000;
        setInterval(() => {
            sliderNext(slider.id);
        }, interval);
    });
});

// Accordion Functions
function toggleAccordion(itemId) {
    const content = document.getElementById(itemId);
    const header = content.previousElementSibling;
    const icon = header.querySelector('.accordion-icon');
    
    if (content.classList.contains('open')) {
        content.classList.remove('open');
        content.style.maxHeight = '0';
        icon.textContent = '+';
    } else {
        content.classList.add('open');
        content.style.maxHeight = content.scrollHeight + 'px';
        icon.textContent = '−';
    }
}

// Tabs Functions
function switchTab(tabsId, index) {
    const tabs = document.getElementById(tabsId);
    const buttons = tabs.querySelectorAll('.tab-button');
    const panes = tabs.querySelectorAll('.tab-pane');
    
    buttons.forEach(btn => btn.classList.remove('active'));
    panes.forEach(pane => pane.classList.remove('active'));
    
    buttons[index].classList.add('active');
    panes[index].classList.add('active');
}

// Smooth scroll for anchor links
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href !== '#!') {
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
});
