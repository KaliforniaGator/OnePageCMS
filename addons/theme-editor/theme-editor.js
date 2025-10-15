/**
 * Theme Editor JavaScript
 * Handles loading, editing, and auto-saving theme properties
 */

(function() {
    'use strict';

    // State
    let themeData = null;
    let originalData = null;
    let defaultData = null; // True default values from theme-defaults.txt
    let saveTimeout = null;
    let isSaving = false;

    // Configuration
    const AUTO_SAVE_DELAY = 1500; // ms
    const API_ENDPOINT = window.THEME_EDITOR_API || '/theme-editor-api';

    // DOM Elements
    const loadingState = document.getElementById('loading-state');
    const errorState = document.getElementById('error-state');
    const errorMessage = document.getElementById('error-message');
    const editorContent = document.getElementById('editor-content');
    const categoriesContainer = document.getElementById('categories-container');
    const searchInput = document.getElementById('search-input');
    const resetBtn = document.getElementById('reset-btn');
    const saveStatus = document.getElementById('save-status');

    /**
     * Initialize the theme editor
     */
    function init() {
        loadTheme();
        setupEventListeners();
    }

    /**
     * Setup event listeners
     */
    function setupEventListeners() {
        // Search functionality
        if (searchInput) {
            searchInput.addEventListener('input', handleSearch);
        }

        // Reset button
        if (resetBtn) {
            resetBtn.addEventListener('click', handleReset);
        }
    }

    /**
     * Load theme data from API
     */
    async function loadTheme() {
        try {
            showLoading();
            
            const response = await fetch(API_ENDPOINT, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            const result = await response.json();

            if (!result.success) {
                throw new Error(result.error || 'Failed to load theme');
            }

            themeData = result.data.variables;
            originalData = JSON.parse(JSON.stringify(themeData)); // Deep clone
            defaultData = result.data.defaults || JSON.parse(JSON.stringify(themeData)); // Default values
            
            renderEditor();
            showEditor();
            updateStatus('ready', 'Ready');

        } catch (error) {
            console.error('Error loading theme:', error);
            showError(error.message);
        }
    }

    /**
     * Save theme data to API
     */
    async function saveTheme() {
        if (isSaving) return;

        try {
            isSaving = true;
            updateStatus('saving', 'Saving...');

            const response = await fetch(API_ENDPOINT, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'save',
                    variables: themeData
                })
            });

            const result = await response.json();

            if (!result.success) {
                throw new Error(result.error || 'Failed to save theme');
            }

            // Update original data to match saved data
            originalData = JSON.parse(JSON.stringify(themeData));
            
            updateStatus('saved', 'Saved');
            
            // Reset to ready after 2 seconds
            setTimeout(() => {
                updateStatus('ready', 'Ready');
            }, 2000);

        } catch (error) {
            console.error('Error saving theme:', error);
            updateStatus('error', 'Save failed');
            
            setTimeout(() => {
                updateStatus('ready', 'Ready');
            }, 3000);
        } finally {
            isSaving = false;
        }
    }

    /**
     * Schedule auto-save
     */
    function scheduleAutoSave() {
        if (saveTimeout) {
            clearTimeout(saveTimeout);
        }

        saveTimeout = setTimeout(() => {
            saveTheme();
        }, AUTO_SAVE_DELAY);
    }

    /**
     * Render the editor interface
     */
    function renderEditor() {
        if (!categoriesContainer) return;

        categoriesContainer.innerHTML = '';

        // Sort categories for better organization
        const categoryOrder = [
            'Primary Colors',
            'Secondary Colors',
            'Success Colors',
            'Danger Colors',
            'Warning Colors',
            'Info Colors',
            'Neutral Colors',
            'Text Colors',
            'Background Colors',
            'Border Colors',
            'Gradients',
            'Shadows',
            'Border Radius',
            'Spacing',
            'Typography',
            'Transitions',
            'Z-Index',
            'Other'
        ];

        const sortedCategories = Object.keys(themeData).sort((a, b) => {
            const indexA = categoryOrder.indexOf(a);
            const indexB = categoryOrder.indexOf(b);
            if (indexA === -1) return 1;
            if (indexB === -1) return -1;
            return indexA - indexB;
        });

        sortedCategories.forEach(category => {
            const properties = themeData[category];
            if (Object.keys(properties).length === 0) return;

            const categorySection = createCategorySection(category, properties);
            categoriesContainer.appendChild(categorySection);
        });
    }

    /**
     * Create a category section
     */
    function createCategorySection(category, properties) {
        const section = document.createElement('div');
        section.className = 'category-section';
        section.dataset.category = category;

        const header = document.createElement('div');
        header.className = 'category-header';
        
        const title = document.createElement('h2');
        title.className = 'category-title';
        title.innerHTML = `
            ${getCategoryIcon(category)}
            <span>${category}</span>
            <span class="category-count">(${Object.keys(properties).length})</span>
        `;

        const toggle = document.createElement('i');
        toggle.className = 'fas fa-chevron-down category-toggle';

        header.appendChild(title);
        header.appendChild(toggle);

        const content = document.createElement('div');
        content.className = 'category-content';

        Object.entries(properties).forEach(([name, value]) => {
            const propertyItem = createPropertyItem(category, name, value);
            content.appendChild(propertyItem);
        });

        // Toggle collapse
        header.addEventListener('click', () => {
            section.classList.toggle('collapsed');
        });

        section.appendChild(header);
        section.appendChild(content);

        return section;
    }

    /**
     * Create a property item
     */
    function createPropertyItem(category, name, value) {
        const item = document.createElement('div');
        item.className = 'property-item';
        item.dataset.property = name;
        item.dataset.category = category;

        const label = document.createElement('div');
        label.className = 'property-label';
        label.innerHTML = `
            <span>${formatPropertyName(name)}</span>
            <span class="property-name">--${name}</span>
        `;

        const inputGroup = document.createElement('div');
        inputGroup.className = 'property-input-group';

        // Determine input type based on value
        const isColor = isColorValue(value);
        const isGradient = value.includes('gradient');
        const isShadow = value.includes('rgba') || value.includes('rgb') && !isGradient;

        if (isColor && !isGradient) {
            // Color input with picker
            const colorWrapper = document.createElement('div');
            colorWrapper.className = 'color-input-wrapper';

            const colorPicker = document.createElement('div');
            colorPicker.className = 'color-picker';
            colorPicker.style.background = value;

            const colorInput = document.createElement('input');
            colorInput.type = 'color';
            colorInput.value = normalizeColorForPicker(value);

            const textInput = document.createElement('input');
            textInput.type = 'text';
            textInput.className = 'property-input';
            textInput.value = value;
            textInput.dataset.original = value;

            colorPicker.addEventListener('click', () => {
                colorInput.click();
            });

            colorInput.addEventListener('input', (e) => {
                const newValue = e.target.value;
                textInput.value = newValue;
                colorPicker.style.background = newValue;
                handlePropertyChange(category, name, newValue);
            });

            textInput.addEventListener('input', (e) => {
                const newValue = e.target.value;
                if (isColorValue(newValue)) {
                    colorPicker.style.background = newValue;
                    try {
                        colorInput.value = normalizeColorForPicker(newValue);
                    } catch (err) {
                        // Invalid color format
                    }
                }
                handlePropertyChange(category, name, newValue);
            });

            colorWrapper.appendChild(colorPicker);
            colorWrapper.appendChild(colorInput);
            colorWrapper.appendChild(textInput);
            inputGroup.appendChild(colorWrapper);

        } else {
            // Text input for other values
            const textInput = document.createElement('input');
            textInput.type = 'text';
            textInput.className = 'property-input';
            textInput.value = value;
            textInput.dataset.original = value;

            textInput.addEventListener('input', (e) => {
                handlePropertyChange(category, name, e.target.value);
            });

            inputGroup.appendChild(textInput);

            // Add preview for certain types
            if (isGradient || isShadow) {
                const preview = document.createElement('div');
                preview.className = 'property-preview';
                const previewBox = document.createElement('div');
                previewBox.className = 'preview-box';
                
                if (isGradient) {
                    previewBox.style.background = value;
                } else if (isShadow) {
                    previewBox.style.boxShadow = value;
                    previewBox.style.background = '#fff';
                }
                
                preview.appendChild(previewBox);
                inputGroup.appendChild(preview);
            }
        }

        // Reset button
        const actions = document.createElement('div');
        actions.className = 'property-actions';
        
        const resetBtn = document.createElement('button');
        resetBtn.className = 'btn-icon';
        resetBtn.innerHTML = '<i class="fas fa-undo"></i>';
        resetBtn.title = 'Reset to original';
        resetBtn.addEventListener('click', () => {
            handlePropertyReset(category, name, item);
        });
        
        actions.appendChild(resetBtn);
        inputGroup.appendChild(actions);

        item.appendChild(label);
        item.appendChild(inputGroup);

        return item;
    }

    /**
     * Handle property change
     */
    function handlePropertyChange(category, name, value) {
        themeData[category][name] = value;
        
        // Update CSS variable in real-time
        document.documentElement.style.setProperty(`--${name}`, value);
        
        // Mark as modified
        const input = document.querySelector(`[data-property="${name}"] .property-input`);
        if (input && input.dataset.original !== value) {
            input.classList.add('modified');
        } else if (input) {
            input.classList.remove('modified');
        }
        
        scheduleAutoSave();
    }

    /**
     * Handle property reset
     */
    function handlePropertyReset(category, name, item) {
        // Use default value if available, otherwise fall back to original
        const defaultValue = (defaultData && defaultData[category] && defaultData[category][name]) 
            ? defaultData[category][name] 
            : originalData[category][name];
        
        themeData[category][name] = defaultValue;
        
        // Update input
        const input = item.querySelector('.property-input');
        if (input) {
            input.value = defaultValue;
            input.classList.remove('modified');
        }
        
        // Update color picker if exists
        const colorPicker = item.querySelector('.color-picker');
        if (colorPicker) {
            colorPicker.style.background = defaultValue;
        }
        
        const colorInput = item.querySelector('input[type="color"]');
        if (colorInput) {
            colorInput.value = normalizeColorForPicker(defaultValue);
        }
        
        // Update preview if exists
        const previewBox = item.querySelector('.preview-box');
        if (previewBox) {
            if (defaultValue.includes('gradient')) {
                previewBox.style.background = defaultValue;
            } else if (defaultValue.includes('rgba') || defaultValue.includes('rgb')) {
                previewBox.style.boxShadow = defaultValue;
            }
        }
        
        // Update CSS variable
        document.documentElement.style.setProperty(`--${name}`, defaultValue);
        
        scheduleAutoSave();
    }

    /**
     * Handle search
     */
    function handleSearch(e) {
        const query = e.target.value.toLowerCase();
        
        document.querySelectorAll('.property-item').forEach(item => {
            const propertyName = item.dataset.property.toLowerCase();
            const formattedName = formatPropertyName(item.dataset.property).toLowerCase();
            
            if (propertyName.includes(query) || formattedName.includes(query)) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
        
        // Hide empty categories
        document.querySelectorAll('.category-section').forEach(section => {
            const visibleItems = section.querySelectorAll('.property-item:not(.hidden)');
            if (visibleItems.length === 0) {
                section.classList.add('hidden');
            } else {
                section.classList.remove('hidden');
            }
        });
    }

    /**
     * Handle reset all
     */
    async function handleReset() {
        if (!confirm('Are you sure you want to reset all properties to their default values? This will restore the original theme.')) {
            return;
        }
        
        try {
            updateStatus('saving', 'Resetting...');
            
            // Call API to reset theme
            const response = await fetch(API_ENDPOINT, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'reset'
                })
            });
            
            const result = await response.json();
            
            if (!result.success) {
                throw new Error(result.error || 'Failed to reset theme');
            }
            
            // Update local data with reset values
            themeData = result.data.variables;
            originalData = JSON.parse(JSON.stringify(themeData));
            
            // Re-render editor
            renderEditor();
            
            // Update all CSS variables
            Object.entries(themeData).forEach(([category, properties]) => {
                Object.entries(properties).forEach(([name, value]) => {
                    document.documentElement.style.setProperty(`--${name}`, value);
                });
            });
            
            updateStatus('saved', 'Reset complete');
            
            setTimeout(() => {
                updateStatus('ready', 'Ready');
            }, 2000);
            
        } catch (error) {
            console.error('Error resetting theme:', error);
            updateStatus('error', 'Reset failed');
            alert('Failed to reset theme: ' + error.message);
            
            setTimeout(() => {
                updateStatus('ready', 'Ready');
            }, 3000);
        }
    }

    /**
     * Utility: Check if value is a color
     */
    function isColorValue(value) {
        return value.startsWith('#') || 
               value.startsWith('rgb') || 
               value.startsWith('hsl') ||
               /^[a-z]+$/i.test(value); // Named colors
    }

    /**
     * Utility: Normalize color for picker
     */
    function normalizeColorForPicker(value) {
        // Color input only accepts hex format
        if (value.startsWith('#')) {
            return value.length === 4 ? 
                '#' + value[1] + value[1] + value[2] + value[2] + value[3] + value[3] : 
                value;
        }
        
        // For rgb/rgba, create a temporary element to get computed color
        const temp = document.createElement('div');
        temp.style.color = value;
        document.body.appendChild(temp);
        const computed = getComputedStyle(temp).color;
        document.body.removeChild(temp);
        
        // Convert rgb to hex
        const rgb = computed.match(/\d+/g);
        if (rgb) {
            return '#' + rgb.slice(0, 3).map(x => {
                const hex = parseInt(x).toString(16);
                return hex.length === 1 ? '0' + hex : hex;
            }).join('');
        }
        
        return '#000000';
    }

    /**
     * Utility: Format property name
     */
    function formatPropertyName(name) {
        return name
            .split('-')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
    }

    /**
     * Utility: Get category icon
     */
    function getCategoryIcon(category) {
        const icons = {
            'Primary Colors': '<i class="fas fa-palette"></i>',
            'Secondary Colors': '<i class="fas fa-palette"></i>',
            'Success Colors': '<i class="fas fa-check-circle"></i>',
            'Danger Colors': '<i class="fas fa-exclamation-triangle"></i>',
            'Warning Colors': '<i class="fas fa-exclamation-circle"></i>',
            'Info Colors': '<i class="fas fa-info-circle"></i>',
            'Neutral Colors': '<i class="fas fa-circle"></i>',
            'Text Colors': '<i class="fas fa-font"></i>',
            'Background Colors': '<i class="fas fa-fill"></i>',
            'Border Colors': '<i class="fas fa-border-style"></i>',
            'Gradients': '<i class="fas fa-gradient"></i>',
            'Shadows': '<i class="fas fa-moon"></i>',
            'Border Radius': '<i class="fas fa-circle-notch"></i>',
            'Spacing': '<i class="fas fa-arrows-alt"></i>',
            'Typography': '<i class="fas fa-text-height"></i>',
            'Transitions': '<i class="fas fa-clock"></i>',
            'Z-Index': '<i class="fas fa-layer-group"></i>',
            'Other': '<i class="fas fa-cog"></i>'
        };
        
        return icons[category] || '<i class="fas fa-cog"></i>';
    }

    /**
     * UI State Management
     */
    function showLoading() {
        if (loadingState) loadingState.style.display = 'flex';
        if (errorState) errorState.style.display = 'none';
        if (editorContent) editorContent.style.display = 'none';
    }

    function showError(message) {
        if (loadingState) loadingState.style.display = 'none';
        if (errorState) errorState.style.display = 'flex';
        if (errorMessage) errorMessage.textContent = message;
        if (editorContent) editorContent.style.display = 'none';
    }

    function showEditor() {
        if (loadingState) loadingState.style.display = 'none';
        if (errorState) errorState.style.display = 'none';
        if (editorContent) editorContent.style.display = 'block';
    }

    function updateStatus(state, text) {
        if (!saveStatus) return;
        
        saveStatus.className = 'status-indicator ' + state;
        const statusText = saveStatus.querySelector('.status-text');
        if (statusText) {
            statusText.textContent = text;
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
