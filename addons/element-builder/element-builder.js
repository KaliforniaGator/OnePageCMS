/**
 * Element Builder
 * Visual editor for header and footer elements
 */

(function() {
    'use strict';

    // Prevent double initialization
    if (window.elementBuilderInitialized) {
        return;
    }
    window.elementBuilderInitialized = true;

    let currentElement = 'header';
    let selectedBlock = null;
    let blockIdCounter = 0;

    // Block templates (subset of page builder blocks suitable for header/footer)
    const blockTemplates = {
        logo: {
            name: 'Logo',
            fields: [
                { name: 'image', label: 'Logo Image URL', type: 'text', default: '/assets/favicon/apple-touch-icon.png' },
                { name: 'text', label: 'Logo Text', type: 'text', default: 'Site Title' },
                { name: 'alt', label: 'Alt Text', type: 'text', default: 'Logo' },
                { name: 'width', label: 'Width', type: 'text', default: '54px' },
                { name: 'height', label: 'Height', type: 'text', default: '54px' },
                { name: 'link', label: 'Link URL', type: 'text', default: '/' },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' }
            ]
        },
        textview: {
            name: 'Text',
            fields: [
                { name: 'content', label: 'Content', type: 'textarea', default: 'Text content' },
                { name: 'type', label: 'Type', type: 'select', options: ['paragraph', 'heading', 'quote'], default: 'paragraph' },
                { name: 'level', label: 'Heading Level', type: 'select', options: ['1', '2', '3', '4', '5', '6'], default: '2', condition: 'type', conditionValue: 'heading' },
                { name: 'text_align', label: 'Text Align', type: 'select', options: ['left', 'center', 'right'], default: 'left' },
                { name: 'text_color', label: 'Text Color', type: 'text', default: '' },
                { name: 'font_size', label: 'Font Size', type: 'text', default: '' },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' }
            ]
        },
        menu: {
            name: 'Menu',
            fields: [
                { name: 'items', label: 'Menu Items', type: 'repeater', default: [{"text":"Home","url":"/","icon":""},{"text":"About","url":"/?page=about","icon":""},{"text":"Contact","url":"/?page=contact","icon":""}] },
                { name: 'show_icons', label: 'Show Icons', type: 'checkbox', default: false },
                { name: 'menu_shape', label: 'Menu Shape', type: 'select', options: ['simple', 'rounded-rect', 'capsule'], default: 'simple' },
                { name: 'orientation', label: 'Orientation', type: 'select', options: ['horizontal', 'vertical'], default: 'horizontal' },
                { name: 'auto_populate', label: 'Auto-Populate from Pages', type: 'checkbox', default: false },
                { name: 'hover_color', label: 'Hover Color', type: 'text', default: '', placeholder: '#3498db' },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' }
            ]
        },
        button: {
            name: 'Button',
            fields: [
                { name: 'text', label: 'Button Text', type: 'text', default: 'Click Me' },
                { name: 'url', label: 'URL', type: 'text', default: '#' },
                { name: 'type', label: 'Type', type: 'select', options: ['primary', 'secondary', 'success', 'danger', 'warning', 'info'], default: 'primary' },
                { name: 'size', label: 'Size', type: 'select', options: ['small', 'medium', 'large'], default: 'medium' },
                { name: 'icon', label: 'Icon Class', type: 'text', default: '' },
                { name: 'alignment', label: 'Alignment', type: 'select', options: ['left', 'center', 'right'], default: 'left' },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' }
            ]
        },
        container: {
            name: 'Container',
            acceptsChildren: true,
            fields: [
                { name: 'width', label: 'Width', type: 'select', options: ['wide', 'narrow', 'full'], default: 'wide' },
                { name: 'display_type', label: 'Display Type', type: 'select', options: ['block', 'flex', 'grid'], default: 'flex' },
                { name: 'horizontal_align', label: 'Horizontal Alignment', type: 'select', options: ['left', 'center', 'right', 'space-between', 'space-around'], default: 'left' },
                { name: 'flow_direction', label: 'Flow Direction', type: 'select', options: ['horizontal', 'vertical'], default: 'horizontal' },
                { name: 'gap', label: 'Gap', type: 'text', default: '1rem', placeholder: 'e.g., 1rem, 20px' },
                { name: 'background_color', label: 'Background Color', type: 'text', default: '' },
                { name: 'padding_all', label: 'Padding', type: 'text', default: '' },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' }
            ]
        }
    };

    // Element-level settings
    const elementSettings = {
        background_color: { label: 'Background Color', type: 'color', default: '' },
        text_color: { label: 'Text Color', type: 'color', default: '' },
        padding_top: { label: 'Padding Top', type: 'text', default: '', placeholder: 'e.g., 1rem, 20px' },
        padding_bottom: { label: 'Padding Bottom', type: 'text', default: '', placeholder: 'e.g., 1rem, 20px' },
        border_bottom: { label: 'Border Bottom', type: 'text', default: '', placeholder: 'e.g., 1px solid #ddd' },
        box_shadow: { label: 'Box Shadow', type: 'text', default: '', placeholder: 'e.g., 0 2px 4px rgba(0,0,0,0.1)' }
    };

    // Initialize
    function init() {
        renderBlocksList();
        renderElementSettings();
        setupCanvasDropZone();
        loadElement(currentElement);
        attachEventListeners();
    }

    // Render blocks list in sidebar
    function renderBlocksList() {
        const blocksList = document.getElementById('eb-blocks-list');
        blocksList.innerHTML = '';

        Object.keys(blockTemplates).forEach(type => {
            const template = blockTemplates[type];
            const blockItem = document.createElement('div');
            blockItem.className = 'eb-block-item';
            blockItem.draggable = true;
            blockItem.dataset.blockType = type;
            blockItem.innerHTML = `<i class="fas fa-grip-vertical"></i> ${template.name}`;
            
            blockItem.addEventListener('dragstart', handleBlockDragStart);
            blocksList.appendChild(blockItem);
        });
    }

    // Render element settings
    function renderElementSettings() {
        const settingsContainer = document.getElementById('eb-element-settings');
        settingsContainer.innerHTML = '';

        Object.keys(elementSettings).forEach(key => {
            const setting = elementSettings[key];
            const field = createFormField(key, setting);
            settingsContainer.appendChild(field);
        });

        // Add change listeners
        settingsContainer.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('change', updateElementStyles);
        });
    }

    // Create repeater item (for menu items)
    function createRepeaterItem(fieldName, item, index) {
        const itemDiv = document.createElement('div');
        itemDiv.className = 'eb-repeater-item';
        
        const fieldsDiv = document.createElement('div');
        fieldsDiv.className = 'eb-repeater-fields';
        
        // Text field with label
        const textGroup = document.createElement('div');
        textGroup.className = 'eb-repeater-field';
        const textLabel = document.createElement('label');
        textLabel.textContent = 'Text';
        textLabel.className = 'eb-repeater-label';
        const textInput = document.createElement('input');
        textInput.type = 'text';
        textInput.placeholder = 'Menu text (e.g., Home)';
        textInput.value = item.text || '';
        textInput.className = 'eb-input';
        textGroup.appendChild(textLabel);
        textGroup.appendChild(textInput);
        fieldsDiv.appendChild(textGroup);
        
        // URL field with label
        const urlGroup = document.createElement('div');
        urlGroup.className = 'eb-repeater-field';
        const urlLabel = document.createElement('label');
        urlLabel.textContent = 'URL';
        urlLabel.className = 'eb-repeater-label';
        const urlInput = document.createElement('input');
        urlInput.type = 'text';
        urlInput.placeholder = 'Link URL (e.g., /?page=about)';
        urlInput.value = item.url || '';
        urlInput.className = 'eb-input';
        urlGroup.appendChild(urlLabel);
        urlGroup.appendChild(urlInput);
        fieldsDiv.appendChild(urlGroup);
        
        // Icon field with label
        const iconGroup = document.createElement('div');
        iconGroup.className = 'eb-repeater-field';
        const iconLabel = document.createElement('label');
        iconLabel.textContent = 'Icon (Optional)';
        iconLabel.className = 'eb-repeater-label';
        const iconInput = document.createElement('input');
        iconInput.type = 'text';
        iconInput.placeholder = 'Icon class (e.g., fas fa-home)';
        iconInput.value = item.icon || '';
        iconInput.className = 'eb-input';
        iconGroup.appendChild(iconLabel);
        iconGroup.appendChild(iconInput);
        fieldsDiv.appendChild(iconGroup);
        
        itemDiv.appendChild(fieldsDiv);
        
        // Remove button
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'eb-btn eb-btn-danger eb-btn-small';
        removeBtn.innerHTML = '<i class="fas fa-minus"></i>';
        removeBtn.onclick = () => itemDiv.remove();
        itemDiv.appendChild(removeBtn);
        
        return itemDiv;
    }

    // Create form field
    function createFormField(name, field, blockData = {}) {
        const div = document.createElement('div');
        div.className = 'eb-form-group';

        const label = document.createElement('label');
        label.textContent = field.label;
        label.htmlFor = `eb-field-${name}`;
        div.appendChild(label);

        let input;
        if (field.type === 'textarea') {
            input = document.createElement('textarea');
            input.rows = 3;
        } else if (field.type === 'select') {
            input = document.createElement('select');
            field.options.forEach(opt => {
                const option = document.createElement('option');
                option.value = opt;
                option.textContent = opt;
                input.appendChild(option);
            });
        } else if (field.type === 'color') {
            // Create color picker with hex input
            const colorWrapper = document.createElement('div');
            colorWrapper.className = 'eb-color-wrapper';
            
            const colorInput = document.createElement('input');
            colorInput.type = 'color';
            colorInput.id = `eb-field-${name}-picker`;
            colorInput.className = 'eb-color-picker';
            colorInput.value = field.default || '#000000';
            
            const textInput = document.createElement('input');
            textInput.type = 'text';
            textInput.id = `eb-field-${name}`;
            textInput.name = name;
            textInput.className = 'eb-color-text';
            textInput.value = field.default || '';
            textInput.placeholder = '#000000';
            
            // Sync color picker with text input
            colorInput.addEventListener('input', () => {
                textInput.value = colorInput.value;
                textInput.dispatchEvent(new Event('change'));
            });
            
            textInput.addEventListener('input', () => {
                if (/^#[0-9A-F]{6}$/i.test(textInput.value)) {
                    colorInput.value = textInput.value;
                }
            });
            
            colorWrapper.appendChild(colorInput);
            colorWrapper.appendChild(textInput);
            div.appendChild(colorWrapper);
            return div;
        } else if (field.type === 'checkbox') {
            input = document.createElement('input');
            input.type = 'checkbox';
            input.checked = field.default || false;
            input.id = `eb-field-${name}`;
            input.name = name;
            
            // Checkbox uses the label already created
            div.appendChild(input);
            return div;
        } else if (field.type === 'repeater') {
            // Create repeater container for menu items
            const repeaterContainer = document.createElement('div');
            repeaterContainer.className = 'eb-repeater';
            repeaterContainer.id = `eb-field-${name}`;
            
            // Get items from block data or use default
            let items = field.default || [];
            // If we're rendering properties for an existing block, use its data
            if (typeof blockData !== 'undefined' && blockData[name]) {
                items = Array.isArray(blockData[name]) ? blockData[name] : 
                        (typeof blockData[name] === 'string' ? JSON.parse(blockData[name]) : []);
            }
            
            items.forEach((item, index) => {
                repeaterContainer.appendChild(createRepeaterItem(name, item, index));
            });
            
            // Add button
            const addBtn = document.createElement('button');
            addBtn.type = 'button';
            addBtn.className = 'eb-btn eb-btn-primary eb-btn-small';
            addBtn.innerHTML = '<i class="fas fa-plus"></i> Add Item';
            addBtn.onclick = () => {
                const newItem = { text: '', url: '', icon: '' };
                const newIndex = repeaterContainer.querySelectorAll('.eb-repeater-item').length;
                const newItemEl = createRepeaterItem(name, newItem, newIndex);
                repeaterContainer.insertBefore(newItemEl, addBtn);
                
                // Add event listeners to new item's inputs
                newItemEl.querySelectorAll('input').forEach(input => {
                    input.addEventListener('input', () => {
                        // Trigger update for the currently selected block
                        if (selectedBlock) {
                            updateBlockData(selectedBlock, name, null);
                        }
                    });
                });
            };
            
            repeaterContainer.appendChild(addBtn);
            div.appendChild(repeaterContainer);
            return div;
        } else {
            input = document.createElement('input');
            input.type = field.type || 'text';
        }

        input.id = `eb-field-${name}`;
        input.name = name;
        input.value = field.default || '';
        if (field.placeholder) input.placeholder = field.placeholder;

        div.appendChild(input);
        return div;
    }

    // Handle block drag start
    function handleBlockDragStart(e) {
        e.dataTransfer.effectAllowed = 'copy';
        e.dataTransfer.setData('blockType', e.target.dataset.blockType);
        e.dataTransfer.setData('text/plain', e.target.dataset.blockType); // Fallback
    }

    // Load element from server
    function loadElement(elementName) {
        fetch(`/addons/element-builder/element-builder-api.php?action=load&element=${elementName}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderCanvas(data.blocks || []);
                    applyElementStyles(data.styles || {});
                } else {
                    console.error('Failed to load element:', data.message);
                    renderCanvas([]);
                }
            })
            .catch(error => {
                console.error('Error loading element:', error);
                renderCanvas([]);
            });
    }

    // Render canvas with blocks
    function renderCanvas(blocks) {
        const canvas = document.getElementById('eb-canvas');
        canvas.innerHTML = '';

        blocks.forEach(block => {
            const blockEl = createCanvasBlock(block);
            canvas.appendChild(blockEl);
        });
    }
    
    // Setup canvas drop zone (called once during init)
    function setupCanvasDropZone() {
        const canvas = document.getElementById('eb-canvas');
        
        canvas.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.stopPropagation();
            e.dataTransfer.dropEffect = 'copy';
            canvas.classList.add('drag-over');
        });
        
        canvas.addEventListener('dragleave', (e) => {
            e.stopPropagation();
            if (e.target === canvas) {
                canvas.classList.remove('drag-over');
            }
        });
        
        canvas.addEventListener('drop', (e) => {
            e.preventDefault();
            canvas.classList.remove('drag-over');
            
            const blockType = e.dataTransfer.getData('text/plain');
            if (blockType && blockTemplates[blockType]) {
                addBlockToCanvas(blockType);
            }
        });
    }

    // Create canvas block element
    function createCanvasBlock(block) {
        const div = document.createElement('div');
        div.className = 'eb-canvas-block';
        div.dataset.blockType = block.type;
        div.dataset.blockData = JSON.stringify(block.data || {});
        div.dataset.blockId = block.id || `block-${blockIdCounter++}`;

        const template = blockTemplates[block.type];
        div.innerHTML = `
            <div class="eb-block-header">
                <span class="eb-block-title">${template.name}</span>
                <div class="eb-block-actions">
                    <button class="eb-block-btn eb-block-edit" title="Edit"><i class="fas fa-edit"></i></button>
                    <button class="eb-block-btn eb-block-delete" title="Delete"><i class="fas fa-trash"></i></button>
                </div>
            </div>
            <div class="eb-block-content">
                ${generateBlockPreview(block)}
            </div>
        `;

        // Add event listeners
        div.querySelector('.eb-block-edit').addEventListener('click', () => selectBlock(div));
        div.querySelector('.eb-block-delete').addEventListener('click', () => deleteBlock(div));

        return div;
    }

    // Generate block preview HTML
    function generateBlockPreview(block) {
        const type = block.type;
        const data = block.data || {};

        switch (type) {
            case 'logo':
                return `<div style="display: flex; align-items: center; gap: 0.5rem;">
                    <img src="${data.image || '/assets/favicon/apple-touch-icon.png'}" alt="${data.alt || 'Logo'}" style="width: ${data.width || '54px'}; height: ${data.height || '54px'};">
                    <span>${data.text || 'Site Title'}</span>
                </div>`;
            case 'textview':
                return `<p>${data.content || 'Text content'}</p>`;
            case 'menu':
                try {
                    const items = Array.isArray(data.items) ? data.items : JSON.parse(data.items || '[]');
                    return `<nav><ul style="list-style: none; display: flex; gap: 1rem; flex-wrap: wrap;">${items.map(item => `<li><a href="${item.url}">${item.text}</a></li>`).join('')}</ul></nav>`;
                } catch (e) {
                    return '<p>Invalid menu data</p>';
                }
            case 'button':
                return `<button class="btn btn-${data.type || 'primary'}">${data.text || 'Click Me'}</button>`;
            case 'container':
                return `<div style="border: 2px dashed #ccc; padding: 1rem; min-height: 50px;">Container (accepts child blocks)</div>`;
            default:
                return `<p>${type}</p>`;
        }
    }

    // Add block to canvas (called from drop handler)
    function addBlockToCanvas(blockType) {
        const block = {
            id: `block-${blockIdCounter++}`,
            type: blockType,
            data: {}
        };

        // Set default values
        const template = blockTemplates[blockType];
        template.fields.forEach(field => {
            block.data[field.name] = field.default || '';
        });

        const blockEl = createCanvasBlock(block);
        document.getElementById('eb-canvas').appendChild(blockEl);
    }

    // Select block
    function selectBlock(blockEl) {
        // Deselect previous
        document.querySelectorAll('.eb-canvas-block').forEach(el => el.classList.remove('selected'));
        
        // Select new
        blockEl.classList.add('selected');
        selectedBlock = blockEl;

        // Show properties
        renderProperties(blockEl);
    }

    // Render properties panel
    function renderProperties(blockEl) {
        const propertiesContent = document.getElementById('eb-properties-content');
        const blockType = blockEl.dataset.blockType;
        const blockData = JSON.parse(blockEl.dataset.blockData || '{}');
        const template = blockTemplates[blockType];

        propertiesContent.innerHTML = '';

        template.fields.forEach(field => {
            const formField = createFormField(field.name, field, blockData);
            
            if (field.type === 'repeater') {
                // Add event listeners to all repeater inputs
                const repeaterInputs = formField.querySelectorAll('.eb-repeater input');
                repeaterInputs.forEach(input => {
                    input.addEventListener('input', () => updateBlockData(blockEl, field.name, null));
                });
            } else {
                const input = formField.querySelector('input, select, textarea');
                if (input) {
                    if (field.type === 'checkbox') {
                        input.checked = blockData[field.name] || field.default || false;
                    } else {
                        input.value = blockData[field.name] || field.default || '';
                    }
                    
                    input.addEventListener('change', () => {
                        const value = field.type === 'checkbox' ? input.checked : input.value;
                        updateBlockData(blockEl, field.name, value);
                    });
                }
            }
            
            propertiesContent.appendChild(formField);
        });
    }

    // Update block data
    function updateBlockData(blockEl, fieldName, value) {
        const blockData = JSON.parse(blockEl.dataset.blockData || '{}');
        
        // Handle repeater fields
        if (fieldName === 'items') {
            const repeaterContainer = document.querySelector(`#eb-field-${fieldName}`);
            if (repeaterContainer && repeaterContainer.classList.contains('eb-repeater')) {
                const items = [];
                repeaterContainer.querySelectorAll('.eb-repeater-item').forEach(item => {
                    const inputs = item.querySelectorAll('input');
                    items.push({
                        text: inputs[0]?.value || '',
                        url: inputs[1]?.value || '',
                        icon: inputs[2]?.value || ''
                    });
                });
                blockData[fieldName] = items; // Store as array, not JSON string
            } else {
                blockData[fieldName] = value;
            }
        } else {
            blockData[fieldName] = value;
        }
        
        blockEl.dataset.blockData = JSON.stringify(blockData);

        // Update preview
        const block = {
            type: blockEl.dataset.blockType,
            data: blockData
        };
        blockEl.querySelector('.eb-block-content').innerHTML = generateBlockPreview(block);
    }

    // Delete block
    function deleteBlock(blockEl) {
        blockEl.remove();
        if (selectedBlock === blockEl) {
            selectedBlock = null;
            document.getElementById('eb-properties-content').innerHTML = '<p class="eb-no-selection">Select a block to edit its properties</p>';
        }
        
        // If no blocks left on canvas, clear properties panel
        const remainingBlocks = document.querySelectorAll('.eb-canvas-block').length;
        if (remainingBlocks === 0) {
            selectedBlock = null;
            document.getElementById('eb-properties-content').innerHTML = '<p class="eb-no-selection">Select a block to edit its properties</p>';
        }
    }

    // Apply element styles
    function applyElementStyles(styles) {
        Object.keys(styles).forEach(key => {
            const input = document.querySelector(`#eb-element-settings input[name="${key}"]`);
            if (input) input.value = styles[key] || '';
        });
    }

    // Update element styles
    function updateElementStyles() {
        // This would update the preview, but for now we'll just save it
    }

    // Save element
    function saveElement() {
        const canvas = document.getElementById('eb-canvas');
        const blocks = Array.from(canvas.querySelectorAll('.eb-canvas-block')).map(block => ({
            id: block.dataset.blockId,
            type: block.dataset.blockType,
            data: JSON.parse(block.dataset.blockData || '{}')
        }));

        const styles = {};
        document.querySelectorAll('#eb-element-settings input').forEach(input => {
            if (input.value) styles[input.name] = input.value;
        });

        const data = {
            action: 'save',
            element: currentElement,
            blocks: blocks,
            styles: styles
        };

        const saveBtn = document.getElementById('eb-save-element');
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

        fetch('/addons/element-builder/element-builder-api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                saveBtn.innerHTML = '<i class="fas fa-check"></i> Saved!';
                setTimeout(() => {
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = '<i class="fas fa-save"></i> Save';
                }, 2000);
            } else {
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="fas fa-save"></i> Save';
                console.error('Error saving element:', data.message);
            }
        })
        .catch(error => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fas fa-save"></i> Save';
            console.error('Error:', error);
        });
    }

    // Preview element
    function previewElement() {
        const iframe = document.getElementById('eb-preview-frame');
        iframe.src = '/';
        document.getElementById('eb-preview-modal').classList.add('active');
    }

    // View source
    function viewSource() {
        const canvas = document.getElementById('eb-canvas');
        const blocks = Array.from(canvas.querySelectorAll('.eb-canvas-block')).map(block => ({
            type: block.dataset.blockType,
            data: JSON.parse(block.dataset.blockData || '{}')
        }));

        const styles = {};
        document.querySelectorAll('#eb-element-settings input').forEach(input => {
            if (input.value) styles[input.name] = input.value;
        });

        fetch('/addons/element-builder/element-builder-api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'generate_code',
                element: currentElement,
                blocks: blocks,
                styles: styles
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('eb-source-code').value = data.code;
                document.getElementById('eb-source-modal').classList.add('active');
            } else {
                alert('Error generating code: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error generating code');
        });
    }

    // Reset element
    function resetElement() {
        if (!confirm('Reset to default? This will delete all custom blocks.')) {
            return;
        }
        
        const resetBtn = document.getElementById('eb-reset-element');
        resetBtn.disabled = true;
        resetBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Resetting...';
        
        fetch('/addons/element-builder/element-builder-api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'reset',
                element: currentElement
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                resetBtn.innerHTML = '<i class="fas fa-check"></i> Reset!';
                setTimeout(() => {
                    resetBtn.disabled = false;
                    resetBtn.innerHTML = '<i class="fas fa-undo"></i> Reset';
                    loadElement(currentElement);
                }, 1000);
            } else {
                resetBtn.disabled = false;
                resetBtn.innerHTML = '<i class="fas fa-undo"></i> Reset';
                console.error('Error resetting element:', data.message);
            }
        })
        .catch(error => {
            resetBtn.disabled = false;
            resetBtn.innerHTML = '<i class="fas fa-undo"></i> Reset';
            console.error('Error:', error);
        });
    }

    // Attach event listeners
    function attachEventListeners() {
        document.getElementById('eb-element-select').addEventListener('change', (e) => {
            currentElement = e.target.value;
            loadElement(currentElement);
        });

        document.getElementById('eb-save-element').addEventListener('click', saveElement);
        document.getElementById('eb-preview-element').addEventListener('click', previewElement);
        document.getElementById('eb-view-source').addEventListener('click', viewSource);
        document.getElementById('eb-reset-element').addEventListener('click', resetElement);

        // Modal close buttons
        document.querySelectorAll('.eb-modal-close').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.closest('.eb-modal').classList.remove('active');
            });
        });

        // Close modal on outside click
        document.querySelectorAll('.eb-modal').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('active');
                }
            });
        });
    }

    // Start when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
