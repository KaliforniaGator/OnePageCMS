/**
 * Addon Manager JavaScript
 * Handles loading, toggling, and configuring addons
 */

(function() {
    'use strict';

    // State
    let addonsData = [];
    let filteredAddons = [];
    let currentFilter = 'all';
    let saveTimeout = null;
    let isSaving = false;

    // Configuration
    const AUTO_SAVE_DELAY = 1500; // ms
    const API_URL = '/addons/addon-manager/addon-manager-api.php';

    // DOM Elements
    const addonsContainer = document.getElementById('addons-container');
    const searchInput = document.getElementById('search-input');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const saveStatus = document.getElementById('save-status');

    /**
     * Initialize the addon manager
     */
    function init() {
        loadAddons();
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

        // Filter buttons
        filterButtons.forEach(btn => {
            btn.addEventListener('click', handleFilter);
        });
    }

    /**
     * Load addons from window data
     */
    function loadAddons() {
        try {
            // Get addons data from window (loaded by PHP)
            addonsData = window.ADDONS_DATA || [];
            filteredAddons = [...addonsData];
            
            renderAddons();
            updateStatus('ready', 'Ready');

        } catch (error) {
            console.error('Error loading addons:', error);
            alert('Failed to load addons: ' + error.message);
        }
    }

    /**
     * Render addons grid
     */
    function renderAddons() {
        if (!addonsContainer) return;

        addonsContainer.innerHTML = '';

        if (filteredAddons.length === 0) {
            addonsContainer.innerHTML = `
                <div class="no-addons">
                    <i class="fas fa-inbox"></i>
                    <p>No addons found</p>
                </div>
            `;
            return;
        }

        filteredAddons.forEach(addon => {
            const addonCard = createAddonCard(addon);
            addonsContainer.appendChild(addonCard);
        });
    }

    /**
     * Create addon card
     */
    function createAddonCard(addon) {
        const card = document.createElement('div');
        card.className = 'addon-card' + (addon.enabled ? ' enabled' : ' disabled');
        card.dataset.addonId = addon.id;

        // Header
        const header = document.createElement('div');
        header.className = 'addon-header';

        const titleSection = document.createElement('div');
        titleSection.className = 'addon-title-section';

        const icon = document.createElement('div');
        icon.className = 'addon-icon';
        const iconClass = getAddonIcon(addon);
        icon.innerHTML = `<i class="${iconClass}"></i>`;

        const titleInfo = document.createElement('div');
        titleInfo.className = 'addon-title-info';
        titleInfo.innerHTML = `
            <h3>${addon.name}</h3>
            <span class="addon-version">v${addon.version}</span>
        `;

        titleSection.appendChild(icon);
        titleSection.appendChild(titleInfo);

        const toggle = document.createElement('label');
        toggle.className = 'addon-toggle';
        toggle.innerHTML = `
            <input type="checkbox" ${addon.enabled ? 'checked' : ''} 
                   onchange="window.toggleAddon('${addon.id}', this.checked)">
            <span class="toggle-slider"></span>
        `;

        header.appendChild(titleSection);
        header.appendChild(toggle);

        // Body
        const body = document.createElement('div');
        body.className = 'addon-body';

        const description = document.createElement('p');
        description.className = 'addon-description';
        description.textContent = addon.description || 'No description available';

        const meta = document.createElement('div');
        meta.className = 'addon-meta';
        meta.innerHTML = `
            <span class="addon-type">
                <i class="fas fa-tag"></i> ${addon.type || 'utility'}
            </span>
            ${addon.author ? `<span class="addon-author"><i class="fas fa-user"></i> ${addon.author}</span>` : ''}
        `;

        body.appendChild(description);
        body.appendChild(meta);

        // Settings section (if addon has settings)
        if (addon.settings && Object.keys(addon.settings).length > 0) {
            const settingsSection = createSettingsSection(addon);
            body.appendChild(settingsSection);
        }

        card.appendChild(header);
        card.appendChild(body);

        return card;
    }

    /**
     * Create settings section for addon
     */
    function createSettingsSection(addon) {
        const section = document.createElement('div');
        section.className = 'addon-settings';

        const header = document.createElement('div');
        header.className = 'settings-header';
        header.innerHTML = `
            <h4><i class="fas fa-cog"></i> Settings</h4>
            <button class="btn-icon settings-toggle" onclick="window.toggleSettings('${addon.id}')">
                <i class="fas fa-chevron-down"></i>
            </button>
        `;

        const content = document.createElement('div');
        content.className = 'settings-content';
        content.id = `settings-${addon.id}`;

        Object.entries(addon.settings).forEach(([key, value]) => {
            const settingItem = createSettingItem(addon.id, key, value);
            content.appendChild(settingItem);
        });

        section.appendChild(header);
        section.appendChild(content);

        return section;
    }

    /**
     * Create individual setting item
     */
    function createSettingItem(addonId, key, value) {
        const item = document.createElement('div');
        item.className = 'setting-item';

        const label = document.createElement('label');
        label.className = 'setting-label';
        label.textContent = formatSettingName(key);

        const inputWrapper = document.createElement('div');
        inputWrapper.className = 'setting-input-wrapper';

        let input;

        if (typeof value === 'boolean') {
            input = document.createElement('label');
            input.className = 'setting-toggle';
            input.innerHTML = `
                <input type="checkbox" ${value ? 'checked' : ''} 
                       onchange="window.updateSetting('${addonId}', '${key}', this.checked)">
                <span class="toggle-slider small"></span>
            `;
        } else if (key.toLowerCase().includes('color')) {
            const colorWrapper = document.createElement('div');
            colorWrapper.className = 'color-input-wrapper';

            const colorPicker = document.createElement('div');
            colorPicker.className = 'color-picker';
            colorPicker.style.background = value;

            const colorInput = document.createElement('input');
            colorInput.type = 'color';
            colorInput.value = value;
            colorInput.addEventListener('change', (e) => {
                colorPicker.style.background = e.target.value;
                textInput.value = e.target.value;
                updateSetting(addonId, key, e.target.value);
            });

            const textInput = document.createElement('input');
            textInput.type = 'text';
            textInput.className = 'setting-input';
            textInput.value = value;
            textInput.addEventListener('input', (e) => {
                colorPicker.style.background = e.target.value;
                colorInput.value = e.target.value;
                updateSetting(addonId, key, e.target.value);
            });

            colorPicker.addEventListener('click', () => colorInput.click());

            colorWrapper.appendChild(colorPicker);
            colorWrapper.appendChild(colorInput);
            colorWrapper.appendChild(textInput);
            input = colorWrapper;
        } else {
            input = document.createElement('input');
            input.type = 'text';
            input.className = 'setting-input';
            input.value = value;
            input.addEventListener('input', (e) => {
                updateSetting(addonId, key, e.target.value);
            });
        }

        inputWrapper.appendChild(input);

        item.appendChild(label);
        item.appendChild(inputWrapper);

        return item;
    }

    /**
     * Toggle addon enabled/disabled
     */
    window.toggleAddon = async function(addonId, enabled) {
        try {
            updateStatus('saving', 'Saving...');

            const response = await fetch(API_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'toggle',
                    addon_id: addonId,
                    enabled: enabled
                })
            });

            const result = await response.json();

            if (!result.success) {
                throw new Error(result.error || 'Failed to toggle addon');
            }

            // Update local data
            const addon = addonsData.find(a => a.id === addonId);
            if (addon) {
                addon.enabled = enabled;
            }

            // Update card appearance
            const card = document.querySelector(`[data-addon-id="${addonId}"]`);
            if (card) {
                card.className = 'addon-card' + (enabled ? ' enabled' : ' disabled');
            }

            updateStatus('saved', 'Saved');
            
            setTimeout(() => {
                updateStatus('ready', 'Ready');
            }, 2000);

        } catch (error) {
            console.error('Error toggling addon:', error);
            updateStatus('error', 'Save failed');
            alert('Failed to toggle addon: ' + error.message);
            
            // Revert checkbox
            const card = document.querySelector(`[data-addon-id="${addonId}"]`);
            if (card) {
                const checkbox = card.querySelector('input[type="checkbox"]');
                if (checkbox) {
                    checkbox.checked = !enabled;
                }
            }
            
            setTimeout(() => {
                updateStatus('ready', 'Ready');
            }, 3000);
        }
    };

    /**
     * Update addon setting
     */
    window.updateSetting = function(addonId, key, value) {
        // Update local data
        const addon = addonsData.find(a => a.id === addonId);
        if (addon && addon.settings) {
            addon.settings[key] = value;
        }

        // Schedule auto-save
        scheduleAutoSave(addonId);
    };

    /**
     * Schedule auto-save for settings
     */
    function scheduleAutoSave(addonId) {
        if (saveTimeout) {
            clearTimeout(saveTimeout);
        }

        saveTimeout = setTimeout(() => {
            saveSettings(addonId);
        }, AUTO_SAVE_DELAY);
    }

    /**
     * Save addon settings
     */
    async function saveSettings(addonId) {
        if (isSaving) return;

        try {
            isSaving = true;
            updateStatus('saving', 'Saving...');

            const addon = addonsData.find(a => a.id === addonId);
            if (!addon) {
                throw new Error('Addon not found');
            }

            const response = await fetch(API_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'update_settings',
                    addon_id: addonId,
                    settings: addon.settings
                })
            });

            const result = await response.json();

            if (!result.success) {
                throw new Error(result.error || 'Failed to save settings');
            }

            updateStatus('saved', 'Saved');
            
            setTimeout(() => {
                updateStatus('ready', 'Ready');
            }, 2000);

        } catch (error) {
            console.error('Error saving settings:', error);
            updateStatus('error', 'Save failed');
            
            setTimeout(() => {
                updateStatus('ready', 'Ready');
            }, 3000);
        } finally {
            isSaving = false;
        }
    }

    /**
     * Toggle settings visibility
     */
    window.toggleSettings = function(addonId) {
        const content = document.getElementById(`settings-${addonId}`);
        const button = content.previousElementSibling.querySelector('.settings-toggle i');
        
        if (content.style.display === 'none' || !content.style.display) {
            content.style.display = 'block';
            button.style.transform = 'rotate(180deg)';
        } else {
            content.style.display = 'none';
            button.style.transform = 'rotate(0deg)';
        }
    };

    /**
     * Handle search
     */
    function handleSearch(e) {
        const query = e.target.value.toLowerCase();
        
        filteredAddons = addonsData.filter(addon => {
            const matchesSearch = addon.name.toLowerCase().includes(query) ||
                                (addon.description && addon.description.toLowerCase().includes(query)) ||
                                addon.id.toLowerCase().includes(query);
            
            const matchesFilter = currentFilter === 'all' ||
                                (currentFilter === 'enabled' && addon.enabled) ||
                                (currentFilter === 'disabled' && !addon.enabled);
            
            return matchesSearch && matchesFilter;
        });
        
        renderAddons();
    }

    /**
     * Handle filter
     */
    function handleFilter(e) {
        const button = e.currentTarget;
        const filter = button.dataset.filter;
        
        // Update active state
        filterButtons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
        
        currentFilter = filter;
        
        // Apply filter
        const query = searchInput ? searchInput.value.toLowerCase() : '';
        
        filteredAddons = addonsData.filter(addon => {
            const matchesSearch = !query || 
                                addon.name.toLowerCase().includes(query) ||
                                (addon.description && addon.description.toLowerCase().includes(query)) ||
                                addon.id.toLowerCase().includes(query);
            
            const matchesFilter = filter === 'all' ||
                                (filter === 'enabled' && addon.enabled) ||
                                (filter === 'disabled' && !addon.enabled);
            
            return matchesSearch && matchesFilter;
        });
        
        renderAddons();
    }

    /**
     * Utility: Format setting name
     */
    function formatSettingName(name) {
        return name
            .split(/(?=[A-Z])|_|-/)
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
    }

    /**
     * Utility: Get addon icon
     */
    function getAddonIcon(addon) {
        if (addon.load && addon.load.page && addon.load.page.menu && addon.load.page.menu.icon) {
            return addon.load.page.menu.icon;
        }
        
        const typeIcons = {
            'page': 'fas fa-file',
            'utility': 'fas fa-tools',
            'widget': 'fas fa-th-large',
            'integration': 'fas fa-plug'
        };
        
        return typeIcons[addon.type] || 'fas fa-puzzle-piece';
    }

    /**
     * UI State Management
     */
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
