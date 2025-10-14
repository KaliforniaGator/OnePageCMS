/**
 * Page Builder JavaScript
 * Handles drag-and-drop, block editing, and page management
 */

(function() {
    'use strict';

    // State
    let currentPage = null;
    let currentEditingBlock = null;
    let blockCounter = 0;

    // Common fields for all blocks (optimized with conditional rendering)
    const commonFields = [
        { name: 'padding_type', label: 'Padding Type', type: 'select', options: ['none', 'all', 'individual'], default: 'none' },
        { name: 'padding_all', label: 'Padding (All Sides)', type: 'text', default: '', condition: 'padding_type', conditionValue: 'all' },
        { name: 'padding_top', label: 'Padding Top', type: 'text', default: '', condition: 'padding_type', conditionValue: 'individual' },
        { name: 'padding_right', label: 'Padding Right', type: 'text', default: '', condition: 'padding_type', conditionValue: 'individual' },
        { name: 'padding_bottom', label: 'Padding Bottom', type: 'text', default: '', condition: 'padding_type', conditionValue: 'individual' },
        { name: 'padding_left', label: 'Padding Left', type: 'text', default: '', condition: 'padding_type', conditionValue: 'individual' },
        { name: 'margin_type', label: 'Margin Type', type: 'select', options: ['none', 'all', 'individual'], default: 'none' },
        { name: 'margin_all', label: 'Margin (All Sides)', type: 'text', default: '', condition: 'margin_type', conditionValue: 'all' },
        { name: 'margin_top', label: 'Margin Top', type: 'text', default: '', condition: 'margin_type', conditionValue: 'individual' },
        { name: 'margin_right', label: 'Margin Right', type: 'text', default: '', condition: 'margin_type', conditionValue: 'individual' },
        { name: 'margin_bottom', label: 'Margin Bottom', type: 'text', default: '', condition: 'margin_type', conditionValue: 'individual' },
        { name: 'margin_left', label: 'Margin Left', type: 'text', default: '', condition: 'margin_type', conditionValue: 'individual' },
        { name: 'width', label: 'Width', type: 'dimension', default: '', units: ['px', '%', 'em', 'rem', 'vw', 'auto'] },
        { name: 'height', label: 'Height', type: 'dimension', default: '', units: ['px', '%', 'em', 'rem', 'vh', 'auto'] },
        { name: 'use_min_width', label: 'Use Min Width', type: 'checkbox', default: false },
        { name: 'min_width', label: 'Min Width', type: 'dimension', default: '', units: ['px', '%', 'em', 'rem', 'vw'], condition: 'use_min_width', conditionValue: true },
        { name: 'use_max_width', label: 'Use Max Width', type: 'checkbox', default: false },
        { name: 'max_width', label: 'Max Width', type: 'dimension', default: '', units: ['px', '%', 'em', 'rem', 'vw'], condition: 'use_max_width', conditionValue: true },
        { name: 'use_min_height', label: 'Use Min Height', type: 'checkbox', default: false },
        { name: 'min_height', label: 'Min Height', type: 'dimension', default: '', units: ['px', '%', 'em', 'rem', 'vh'], condition: 'use_min_height', conditionValue: true },
        { name: 'use_max_height', label: 'Use Max Height', type: 'checkbox', default: false },
        { name: 'max_height', label: 'Max Height', type: 'dimension', default: '', units: ['px', '%', 'em', 'rem', 'vh'], condition: 'use_max_height', conditionValue: true }
    ];

    // Block Templates with default configurations
    const blockTemplates = {
        container: {
            name: 'Container',
            defaultContent: '<p>Container content goes here</p>',
            acceptsChildren: true,
            fields: [
                { name: 'width', label: 'Width', type: 'select', options: ['wide', 'narrow', 'full'], default: 'wide' },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' },
                ...commonFields
            ]
        },
        textview: {
            name: 'Text View',
            defaultContent: '<p>Sample text content</p>',
            fields: [
                { name: 'content', label: 'Content', type: 'textarea', default: 'Sample text content' },
                { name: 'type', label: 'Type', type: 'select', options: ['paragraph', 'heading', 'quote', 'code'], default: 'paragraph' },
                { name: 'level', label: 'Heading Level (if heading)', type: 'number', default: 2 },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' },
                { name: 'font_family', label: 'Font Family', type: 'text', default: '' },
                { name: 'font_size', label: 'Font Size', type: 'text', default: '' },
                { name: 'font_weight', label: 'Font Weight', type: 'select', options: ['normal', 'bold', '100', '200', '300', '400', '500', '600', '700', '800', '900'], default: 'normal' },
                ...commonFields
            ]
        },
        button: {
            name: 'Button',
            defaultContent: '<a href="#" class="btn btn-primary">Click Me</a>',
            fields: [
                { name: 'text', label: 'Button Text', type: 'text', default: 'Click Me' },
                { name: 'url', label: 'URL', type: 'text', default: '#' },
                { name: 'type', label: 'Style', type: 'select', options: ['primary', 'secondary', 'success', 'danger', 'outline'], default: 'primary' },
                { name: 'size', label: 'Size', type: 'select', options: ['small', 'medium', 'large'], default: 'medium' },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' },
                ...commonFields
            ]
        },
        buttongroup: {
            name: 'Button Group',
            defaultContent: '<div class="btn-group"><a href="#" class="btn btn-primary">Button 1</a><a href="#" class="btn btn-secondary">Button 2</a></div>',
            fields: [
                { name: 'buttons', label: 'Buttons', type: 'repeater', default: [{text: 'Button 1', url: '#', type: 'primary'}, {text: 'Button 2', url: '#', type: 'secondary'}] },
                { name: 'alignment', label: 'Alignment', type: 'select', options: ['left', 'center', 'right'], default: 'left' },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' },
                ...commonFields
            ]
        },
        card: {
            name: 'Card',
            defaultContent: '<div class="card"><h3>Card Title</h3><p>Card content</p></div>',
            fields: [
                { name: 'title', label: 'Title', type: 'text', default: 'Card Title' },
                { name: 'content', label: 'Content', type: 'textarea', default: 'Card content goes here' },
                { name: 'footer', label: 'Footer', type: 'text', default: '' },
                { name: 'icon', label: 'Icon (e.g., fas fa-home)', type: 'text', default: '' },
                { name: 'icon_shape', label: 'Icon Shape', type: 'select', options: ['circle', 'square', 'rounded', 'none'], default: 'none' },
                { name: 'icon_color', label: 'Icon Color', type: 'text', default: '' },
                { name: 'spacing', label: 'Spacing', type: 'text', default: '' },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' },
                ...commonFields
            ]
        },
        alert: {
            name: 'Alert',
            defaultContent: '<div class="alert alert-info">This is an alert message</div>',
            fields: [
                { name: 'message', label: 'Message', type: 'textarea', default: 'This is an alert message' },
                { name: 'title', label: 'Title (optional)', type: 'text', default: '' },
                { name: 'alert_id', label: 'Alert ID', type: 'text', default: '' },
                { name: 'alert_type', label: 'Alert Type', type: 'select', options: ['toast', 'popup', 'alert'], default: 'alert' },
                { name: 'alert_theme', label: 'Alert Theme', type: 'select', options: ['success', 'danger', 'info', 'warning', 'primary', 'secondary'], default: 'info' },
                { name: 'dismissable', label: 'Dismissable', type: 'checkbox', default: true },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' },
                ...commonFields
            ]
        },
        hero: {
            name: 'Hero',
            defaultContent: '<div class="hero"><h1>Hero Title</h1><p>Hero subtitle</p></div>',
            fields: [
                { name: 'title', label: 'Title', type: 'text', default: 'Hero Title' },
                { name: 'subtitle', label: 'Subtitle', type: 'text', default: 'Hero subtitle' },
                { name: 'type', label: 'Type', type: 'select', options: ['default', 'gradient', 'split', 'minimal'], default: 'default' },
                { name: 'background', label: 'Background Image URL', type: 'text', default: '' },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' },
                ...commonFields
            ]
        },
        list: {
            name: 'List',
            defaultContent: '<ul><li>Item 1</li><li>Item 2</li><li>Item 3</li></ul>',
            fields: [
                { name: 'items', label: 'List Items (one per line)', type: 'textarea', default: 'Item 1\nItem 2\nItem 3' },
                { name: 'type', label: 'List Type', type: 'select', options: ['ul', 'ol'], default: 'ul' },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' },
                ...commonFields
            ]
        },
        form: {
            name: 'Form',
            defaultContent: '<form><input type="text" placeholder="Name"><button>Submit</button></form>',
            acceptsChildren: true,
            fields: [
                { name: 'action', label: 'Form Action URL', type: 'text', default: '#' },
                { name: 'method', label: 'Method', type: 'select', options: ['POST', 'GET'], default: 'POST' },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' },
                ...commonFields
            ]
        },
        accordion: {
            name: 'Accordion',
            defaultContent: '<div class="accordion"><div class="accordion-item"><h3>Section 1</h3><p>Content 1</p></div></div>',
            fields: [
                { name: 'sections', label: 'Accordion Sections', type: 'repeater', default: [{title: 'Section 1', content: 'Content 1'}] },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' },
                ...commonFields
            ]
        },
        slider: {
            name: 'Slider',
            defaultContent: '<div class="slider">Slider placeholder</div>',
            fields: [
                { name: 'slides', label: 'Slides', type: 'repeater', default: [{src: 'https://placehold.co/800x400', alt: 'Slide 1', caption: ''}] },
                { name: 'show_arrows', label: 'Show Arrows', type: 'checkbox', default: true },
                { name: 'show_dots', label: 'Show Dots', type: 'checkbox', default: true },
                { name: 'show_caption', label: 'Show Caption', type: 'checkbox', default: true },
                { name: 'transition', label: 'Slider Transition', type: 'select', options: ['fade', 'slide', 'zoom'], default: 'slide' },
                { name: 'autoplay', label: 'Auto Play', type: 'checkbox', default: true },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' },
                ...commonFields
            ]
        },
        menu: {
            name: 'Menu',
            defaultContent: '<nav><a href="#">Home</a><a href="#">About</a><a href="#">Contact</a></nav>',
            fields: [
                { name: 'items', label: 'Menu Items', type: 'repeater', default: [{text: 'Home', url: '#', icon: ''}, {text: 'About', url: '#', icon: ''}, {text: 'Contact', url: '#', icon: ''}] },
                { name: 'show_icons', label: 'Show Icons', type: 'checkbox', default: false },
                { name: 'menu_shape', label: 'Menu Shape', type: 'select', options: ['simple', 'rounded-rect', 'capsule'], default: 'simple' },
                { name: 'orientation', label: 'Orientation', type: 'select', options: ['horizontal', 'vertical'], default: 'horizontal' },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' },
                ...commonFields
            ]
        },
        media: {
            name: 'Media',
            defaultContent: '<img src="https://placehold.co/600x400" alt="Placeholder">',
            fields: [
                { name: 'src', label: 'Image URL', type: 'text', default: 'https://placehold.co/600x400' },
                { name: 'alt', label: 'Alt Text', type: 'text', default: 'Image' },
                { name: 'caption', label: 'Caption', type: 'text', default: '' },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' },
                ...commonFields
            ]
        },
        social: {
            name: 'Social',
            defaultContent: '<div class="social-buttons">Social buttons</div>',
            fields: [
                { name: 'buttons', label: 'Social Buttons', type: 'repeater', default: [{name: 'Facebook', icon: 'fab fa-facebook', url: '#'}, {name: 'Twitter', icon: 'fab fa-twitter', url: '#'}] },
                { name: 'style', label: 'Style', type: 'select', options: ['icon', 'text', 'both'], default: 'icon' },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' },
                ...commonFields
            ]
        },
        logo: {
            name: 'Logo',
            defaultContent: '<div class="logo">LOGO</div>',
            fields: [
                { name: 'type', label: 'Type', type: 'select', options: ['image', 'text', 'both'], default: 'text' },
                { name: 'text', label: 'Logo Text', type: 'text', default: 'LOGO' },
                { name: 'text_font', label: 'Text Font', type: 'text', default: '' },
                { name: 'text_size', label: 'Text Size', type: 'text', default: '' },
                { name: 'image_url', label: 'Image URL', type: 'text', default: '' },
                { name: 'image_width', label: 'Image Width', type: 'dimension', default: '', units: ['px', '%', 'em', 'rem', 'vw', 'auto'] },
                { name: 'image_height', label: 'Image Height', type: 'dimension', default: '', units: ['px', '%', 'em', 'rem', 'vh', 'auto'] },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' },
                ...commonFields
            ]
        },
        markdown: {
            name: 'Markdown',
            defaultContent: '<div class="markdown-content">Markdown content</div>',
            fields: [
                { name: 'content', label: 'Markdown File Path', type: 'text', default: 'documentation/README.md' },
                { name: 'class', label: 'CSS Class', type: 'text', default: '' },
                ...commonFields
            ]
        },
        // Form Field Blocks
        checkbox: {
            name: 'Checkbox',
            defaultContent: '<input type="checkbox">',
            fields: [
                { name: 'name', label: 'Name', type: 'text', default: 'checkbox' },
                { name: 'label', label: 'Label', type: 'text', default: 'Checkbox Label' },
                { name: 'value', label: 'Value', type: 'text', default: '1' },
                { name: 'checked', label: 'Checked by Default', type: 'checkbox', default: false },
                { name: 'required', label: 'Required', type: 'checkbox', default: false },
                ...commonFields
            ]
        },
        inputfield: {
            name: 'Input Field',
            defaultContent: '<input type="text">',
            fields: [
                { name: 'name', label: 'Name', type: 'text', default: 'input' },
                { name: 'label', label: 'Label', type: 'text', default: 'Input Label' },
                { name: 'placeholder', label: 'Placeholder', type: 'text', default: '' },
                { name: 'value', label: 'Default Value', type: 'text', default: '' },
                { name: 'input_type', label: 'Input Type', type: 'select', options: ['text', 'email', 'tel', 'url', 'number'], default: 'text' },
                { name: 'required', label: 'Required', type: 'checkbox', default: false },
                ...commonFields
            ]
        },
        radiobuttons: {
            name: 'Radio Buttons',
            defaultContent: '<input type="radio">',
            fields: [
                { name: 'name', label: 'Name', type: 'text', default: 'radio' },
                { name: 'label', label: 'Label', type: 'text', default: 'Radio Group Label' },
                { name: 'options', label: 'Options', type: 'repeater', default: [{label: 'Option 1', value: '1'}, {label: 'Option 2', value: '2'}] },
                { name: 'required', label: 'Required', type: 'checkbox', default: false },
                ...commonFields
            ]
        },
        datepicker: {
            name: 'Date Picker',
            defaultContent: '<input type="date">',
            fields: [
                { name: 'name', label: 'Name', type: 'text', default: 'date' },
                { name: 'label', label: 'Label', type: 'text', default: 'Date' },
                { name: 'required', label: 'Required', type: 'checkbox', default: false },
                ...commonFields
            ]
        },
        timepicker: {
            name: 'Time Picker',
            defaultContent: '<input type="time">',
            fields: [
                { name: 'name', label: 'Name', type: 'text', default: 'time' },
                { name: 'label', label: 'Label', type: 'text', default: 'Time' },
                { name: 'required', label: 'Required', type: 'checkbox', default: false },
                ...commonFields
            ]
        },
        datetimepicker: {
            name: 'Date Time Picker',
            defaultContent: '<input type="datetime-local">',
            fields: [
                { name: 'name', label: 'Name', type: 'text', default: 'datetime' },
                { name: 'label', label: 'Label', type: 'text', default: 'Date & Time' },
                { name: 'required', label: 'Required', type: 'checkbox', default: false },
                ...commonFields
            ]
        },
        fileupload: {
            name: 'File Upload',
            defaultContent: '<input type="file">',
            fields: [
                { name: 'name', label: 'Name', type: 'text', default: 'file' },
                { name: 'label', label: 'Label', type: 'text', default: 'Upload File' },
                { name: 'accept', label: 'Accepted File Types', type: 'text', default: '' },
                { name: 'multiple', label: 'Allow Multiple Files', type: 'checkbox', default: false },
                { name: 'required', label: 'Required', type: 'checkbox', default: false },
                ...commonFields
            ]
        },
        passwordfield: {
            name: 'Password Field',
            defaultContent: '<input type="password">',
            fields: [
                { name: 'name', label: 'Name', type: 'text', default: 'password' },
                { name: 'label', label: 'Label', type: 'text', default: 'Password' },
                { name: 'placeholder', label: 'Placeholder', type: 'text', default: '' },
                { name: 'required', label: 'Required', type: 'checkbox', default: false },
                ...commonFields
            ]
        },
        selectfield: {
            name: 'Select Field',
            defaultContent: '<select></select>',
            fields: [
                { name: 'name', label: 'Name', type: 'text', default: 'select' },
                { name: 'label', label: 'Label', type: 'text', default: 'Select Option' },
                { name: 'options', label: 'Options', type: 'repeater', default: [{label: 'Option 1', value: '1'}, {label: 'Option 2', value: '2'}] },
                { name: 'required', label: 'Required', type: 'checkbox', default: false },
                ...commonFields
            ]
        },
        textareafield: {
            name: 'Text Area',
            defaultContent: '<textarea></textarea>',
            fields: [
                { name: 'name', label: 'Name', type: 'text', default: 'textarea' },
                { name: 'label', label: 'Label', type: 'text', default: 'Text Area Label' },
                { name: 'placeholder', label: 'Placeholder', type: 'text', default: '' },
                { name: 'rows', label: 'Rows', type: 'number', default: 4 },
                { name: 'required', label: 'Required', type: 'checkbox', default: false },
                ...commonFields
            ]
        },
        togglefield: {
            name: 'Toggle',
            defaultContent: '<input type="checkbox" class="toggle">',
            fields: [
                { name: 'name', label: 'Name', type: 'text', default: 'toggle' },
                { name: 'label', label: 'Label', type: 'text', default: 'Toggle Label' },
                { name: 'checked', label: 'Checked by Default', type: 'checkbox', default: false },
                ...commonFields
            ]
        },
        clearbutton: {
            name: 'Clear Button',
            defaultContent: '<button type="reset">Clear</button>',
            fields: [
                { name: 'text', label: 'Button Text', type: 'text', default: 'Clear' },
                { name: 'style', label: 'Style', type: 'select', options: ['primary', 'secondary', 'danger', 'outline'], default: 'secondary' },
                ...commonFields
            ]
        },
        submitbutton: {
            name: 'Submit Button',
            defaultContent: '<button type="submit">Submit</button>',
            fields: [
                { name: 'text', label: 'Button Text', type: 'text', default: 'Submit' },
                { name: 'style', label: 'Style', type: 'select', options: ['primary', 'secondary', 'success', 'danger', 'outline'], default: 'primary' },
                ...commonFields
            ]
        },
    };

    // Universal Block Preview Renderer - Works for ALL blocks
    function renderBlockPreview(blockType, blockData) {
        var template = blockTemplates[blockType];
        if (!template) {
            return '<pre style="font-size: 0.85rem; color: #666;">' + JSON.stringify(blockData, null, 2) + '</pre>';
        }
        
        var html = '<div class="block-preview" style="padding: 0.5rem; background: #f8f9fa; border-radius: 4px;">';
        html += '<strong style="color: #007bff;">' + template.name + '</strong><br>';
        html += '<div style="margin-top: 0.5rem; font-size: 0.9rem;">';
        
        // Show ALL fields with values (including empty strings for visibility)
        var hasContent = false;
        template.fields.forEach(function(field) {
            var value = blockData[field.name];
            // Skip layout/styling fields but show everything else
            if (field.name !== 'class' && field.name !== 'id' && !field.name.includes('margin') && !field.name.includes('padding') && !field.name.includes('width') && !field.name.includes('height')) {
                // Show field if it has a value (including false for checkboxes)
                if (value !== undefined && value !== null && value !== '') {
                    hasContent = true;
                    var displayValue = value;
                    if (typeof value === 'boolean') {
                        displayValue = value ? 'Yes' : 'No';
                    } else if (typeof value === 'object') {
                        displayValue = JSON.stringify(value);
                    } else if (String(value).length > 50) {
                        displayValue = String(value).substring(0, 50) + '...';
                    }
                    html += '<div><strong>' + field.label + ':</strong> ' + displayValue + '</div>';
                } else if (typeof value === 'boolean') {
                    // Always show boolean fields
                    hasContent = true;
                    html += '<div><strong>' + field.label + ':</strong> ' + (value ? 'Yes' : 'No') + '</div>';
                }
            }
        });
        
        if (!hasContent) {
            html += '<em style="color: #999;">No content yet - start editing fields</em>';
        }
        
        html += '</div></div>';
        return html;
    }
    
    // Build inline styles from block data
    function buildInlineStyles(blockData) {
        var styles = [];
        
        // Padding
        if (blockData.padding_type === 'all' && blockData.padding_all) {
            styles.push('padding: ' + blockData.padding_all);
        } else if (blockData.padding_type === 'individual') {
            if (blockData.padding_top) styles.push('padding-top: ' + blockData.padding_top);
            if (blockData.padding_right) styles.push('padding-right: ' + blockData.padding_right);
            if (blockData.padding_bottom) styles.push('padding-bottom: ' + blockData.padding_bottom);
            if (blockData.padding_left) styles.push('padding-left: ' + blockData.padding_left);
        }
        
        // Margin
        if (blockData.margin_type === 'all' && blockData.margin_all) {
            styles.push('margin: ' + blockData.margin_all);
        } else if (blockData.margin_type === 'individual') {
            if (blockData.margin_top) styles.push('margin-top: ' + blockData.margin_top);
            if (blockData.margin_right) styles.push('margin-right: ' + blockData.margin_right);
            if (blockData.margin_bottom) styles.push('margin-bottom: ' + blockData.margin_bottom);
            if (blockData.margin_left) styles.push('margin-left: ' + blockData.margin_left);
        }
        
        // Width and Height
        if (blockData.width) styles.push('width: ' + blockData.width);
        if (blockData.height) styles.push('height: ' + blockData.height);
        
        // Min/Max Width
        if (blockData.use_min_width && blockData.min_width) {
            styles.push('min-width: ' + blockData.min_width);
        }
        if (blockData.use_max_width && blockData.max_width) {
            styles.push('max-width: ' + blockData.max_width);
        }
        
        // Min/Max Height
        if (blockData.use_min_height && blockData.min_height) {
            styles.push('min-height: ' + blockData.min_height);
        }
        if (blockData.use_max_height && blockData.max_height) {
            styles.push('max-height: ' + blockData.max_height);
        }
        
        return styles.join('; ');
    }
    
    // Update block preview
    function updateBlockPreview(blockElement, blockData) {
        var contentDiv = blockElement.querySelector('.pb-block-content');
        if (contentDiv && !contentDiv.querySelector('.pb-container-children')) {
            contentDiv.innerHTML = renderBlockPreview(blockElement.dataset.blockType, blockData);
            
            // Apply inline styles to the block element
            var inlineStyles = buildInlineStyles(blockData);
            if (inlineStyles) {
                blockElement.style.cssText = inlineStyles;
            } else {
                blockElement.style.cssText = '';
            }
        }
    }
    
    // Collect current form data
    function collectFormData() {
        var formContainer = document.getElementById('pb-editor-form');
        if (!formContainer) {
            console.warn('Form container not found');
            return {};
        }
        var blockData = {};
        
        // Regular fields
        formContainer.querySelectorAll('input:not([name*="["]):not(.pb-dimension-input), textarea:not([name*="["]), select:not([name*="["]):not(.pb-unit-select)').forEach(function(field) {
            if (field.name) {
                if (field.type === 'checkbox') {
                    blockData[field.name] = field.checked;
                } else {
                    blockData[field.name] = field.value;
                }
            }
        });
        
        // Dimension fields
        formContainer.querySelectorAll('.pb-dimension-wrapper').forEach(function(wrapper) {
            var valueInput = wrapper.querySelector('.pb-dimension-input');
            var unitSelect = wrapper.querySelector('.pb-unit-select');
            if (valueInput && unitSelect && valueInput.name) {
                var value = valueInput.value.trim();
                var unit = unitSelect.value;
                if (value) {
                    blockData[valueInput.name] = value + unit;
                } else if (unit === 'auto') {
                    blockData[valueInput.name] = 'auto';
                }
            }
        });
        
        // Repeater fields
        formContainer.querySelectorAll('.pb-repeater-container').forEach(function(container) {
            var fieldName = container.dataset.fieldName;
            var items = [];
            container.querySelectorAll('.pb-repeater-item').forEach(function(item) {
                var itemData = {};
                item.querySelectorAll('input, textarea, select').forEach(function(field) {
                    var match = field.name.match(/\[(\d+)\]\[(\w+)\]/);
                    if (match) {
                        var fieldName = match[2];
                        if (field.type === 'checkbox' || field.type === 'radio') {
                            itemData[fieldName] = field.checked;
                        } else {
                            itemData[fieldName] = field.value;
                        }
                    }
                });
                items.push(itemData);
            });
            blockData[fieldName] = items;
        });
        
        return blockData;
    }
    
    // Real-time preview update handler
    function handlePreviewUpdate() {
        if (!currentEditingBlock) {
            console.warn('No block being edited');
            return;
        }
        var liveData = collectFormData();
        console.log('Preview update - collected data:', liveData);
        updateBlockPreview(currentEditingBlock, liveData);
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', init);

    function init() {
        console.log('Page Builder: Initializing...');
        setupDragAndDrop();
        setupMenuButtons();
        setupModals();
        removePlaceholder();
        console.log('Page Builder: Initialized successfully');
    }

    // Drag and Drop Setup
    function setupDragAndDrop() {
        const blockItems = document.querySelectorAll('.pb-block-item');
        const canvas = document.getElementById('pb-canvas');

        console.log('Setting up drag and drop for', blockItems.length, 'blocks');
        console.log('Canvas element:', canvas);

        // Make block items draggable
        blockItems.forEach(item => {
            item.addEventListener('dragstart', handleDragStart);
            item.addEventListener('dragend', handleDragEnd);
        });

        // Canvas drop zone
        if (canvas) {
            canvas.addEventListener('dragover', handleDragOver);
            canvas.addEventListener('drop', handleDrop);
            canvas.addEventListener('dragleave', handleDragLeave);
            console.log('Canvas drop zone configured');
        } else {
            console.error('Canvas element not found!');
        }
    }

    function handleDragStart(e) {
        const blockType = e.target.dataset.blockType;
        e.dataTransfer.effectAllowed = 'copy';
        e.dataTransfer.setData('text/plain', blockType);
        e.dataTransfer.setData('blockType', blockType);
    }

    function handleDragEnd(e) {
        e.target.style.opacity = '1';
    }

    function handleDragOver(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'copy';
        e.currentTarget.classList.add('drag-over');
    }

    function handleDragLeave(e) {
        if (e.target.id === 'pb-canvas') {
            e.currentTarget.classList.remove('drag-over');
        }
    }

    function handleDrop(e) {
        e.preventDefault();
        e.currentTarget.classList.remove('drag-over');
        
        const blockType = e.dataTransfer.getData('text/plain');
        console.log('Drop event - Block type:', blockType);
        if (blockType) {
            addBlockToCanvas(blockType);
        } else {
            console.warn('No block type found in drop event');
        }
    }

    // Add Block to Canvas
    function addBlockToCanvas(blockType, blockData = null, children = null, isLoading = false) {
        console.log('Adding block to canvas:', blockType, 'isLoading:', isLoading);
        removePlaceholder();
        
        const canvas = document.getElementById('pb-canvas');
        const template = blockTemplates[blockType];
        
        if (!template) {
            console.error('Unknown block type:', blockType);
            return;
        }
        
        console.log('Block template found:', template.name);

        const blockId = 'block-' + (++blockCounter);
        const blockElement = document.createElement('div');
        blockElement.className = 'pb-canvas-block';
        blockElement.dataset.blockId = blockId;
        blockElement.dataset.blockType = blockType;
        
        // Add container class if it's a container
        if (blockType === 'container') {
            blockElement.classList.add('pb-container-block');
        }

        // Store block data
        if (blockData) {
            blockElement.dataset.blockData = JSON.stringify(blockData);
        } else {
            const defaultData = {};
            template.fields.forEach(field => {
                defaultData[field.name] = field.default;
            });
            blockElement.dataset.blockData = JSON.stringify(defaultData);
        }

        // Create block content
        const contentHTML = template.acceptsChildren 
            ? '<div class="pb-container-children"></div>'
            : template.defaultContent;
            
        blockElement.innerHTML = `
            <div class="pb-block-label">${template.name}</div>
            <div class="pb-block-controls">
                <button class="pb-block-control-btn move" title="Move">
                    <i class="fas fa-grip-vertical"></i>
                </button>
                <button class="pb-block-control-btn edit" title="Edit" onclick="pageBuilder.editBlock('${blockId}')">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="pb-block-control-btn delete" title="Delete" onclick="pageBuilder.deleteBlock('${blockId}')">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="pb-block-content">
                ${contentHTML}
            </div>
        `;

        canvas.appendChild(blockElement);
        
        // If container, make it accept drops
        if (template.acceptsChildren) {
            setupContainerDropZone(blockElement);
            
            // Load children if provided
            if (children && children.length > 0) {
                console.log('Loading', children.length, 'children into container');
                const childrenContainer = blockElement.querySelector('.pb-container-children');
                children.forEach(child => {
                    console.log('Loading child:', child.type, child.data);
                    const childBlock = createChildBlockFromData(child.type, child.data);
                    childrenContainer.appendChild(childBlock);
                });
            }
        } else {
            // Render initial preview for non-container blocks
            var initialData = blockData || {};
            template.fields.forEach(function(field) {
                if (initialData[field.name] === undefined && field.default !== undefined) {
                    initialData[field.name] = field.default;
                }
            });
            updateBlockPreview(blockElement, initialData);
        }
        
        // Make block sortable
        makeBlockSortable(blockElement);
        
        // Auto-save after adding block (but not when loading from file)
        if (!isLoading) {
            autoSavePage();
        }
    }
    
    // Setup Container Drop Zone
    function setupContainerDropZone(containerBlock) {
        const dropZone = containerBlock.querySelector('.pb-container-children');
        
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            containerBlock.classList.add('drag-over');
        });
        
        dropZone.addEventListener('dragleave', function(e) {
            e.stopPropagation();
            containerBlock.classList.remove('drag-over');
        });
        
        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            containerBlock.classList.remove('drag-over');
            
            const blockType = e.dataTransfer.getData('blockType');
            if (blockType) {
                // Create child block
                const childBlock = createChildBlock(blockType);
                dropZone.appendChild(childBlock);
                
                // Auto-save after adding child block
                autoSavePage();
            }
        });
    }
    
    // Create Child Block (simplified version for containers)
    function createChildBlock(blockType) {
        const template = blockTemplates[blockType];
        const blockId = 'block-' + (++blockCounter);
        
        const blockElement = document.createElement('div');
        blockElement.className = 'pb-canvas-block pb-child-block';
        blockElement.dataset.blockId = blockId;
        blockElement.dataset.blockType = blockType;
        
        const defaultData = {};
        template.fields.forEach(field => {
            defaultData[field.name] = field.default;
        });
        blockElement.dataset.blockData = JSON.stringify(defaultData);
        
        blockElement.innerHTML = `
            <div class="pb-block-label">${template.name}</div>
            <div class="pb-block-controls">
                <button class="pb-block-control-btn edit" title="Edit" onclick="pageBuilder.editBlock('${blockId}')">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="pb-block-control-btn delete" title="Delete" onclick="pageBuilder.deleteBlock('${blockId}')">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="pb-block-content">
                ${template.defaultContent}
            </div>
        `;
        
        return blockElement;
    }
    
    // Create Child Block From Data (for loading saved pages)
    function createChildBlockFromData(blockType, blockData) {
        const template = blockTemplates[blockType];
        const blockId = 'block-' + (++blockCounter);
        
        const blockElement = document.createElement('div');
        blockElement.className = 'pb-canvas-block pb-child-block';
        blockElement.dataset.blockId = blockId;
        blockElement.dataset.blockType = blockType;
        blockElement.dataset.blockData = JSON.stringify(blockData);
        
        blockElement.innerHTML = `
            <div class="pb-block-label">${template.name}</div>
            <div class="pb-block-controls">
                <button class="pb-block-control-btn edit" title="Edit" onclick="pageBuilder.editBlock('${blockId}')">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="pb-block-control-btn delete" title="Delete" onclick="pageBuilder.deleteBlock('${blockId}')">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="pb-block-content">
                <pre style="font-size: 0.85rem; color: #666;">${JSON.stringify(blockData, null, 2)}</pre>
            </div>
        `;
        
        return blockElement;
    }

    // Make blocks sortable
    function makeBlockSortable(blockElement) {
        const moveBtn = blockElement.querySelector('.pb-block-control-btn.move');
        if (!moveBtn) return;
        
        let draggedElement = null;
        
        moveBtn.addEventListener('mousedown', function(e) {
            e.preventDefault();
            draggedElement = blockElement;
            blockElement.style.opacity = '0.5';
            blockElement.style.cursor = 'grabbing';
            
            const canvas = document.getElementById('pb-canvas');
            const blocks = Array.from(canvas.querySelectorAll('.pb-canvas-block:not(.pb-child-block)'));
            
            function onMouseMove(e) {
                if (!draggedElement) return;
                
                // Find which block we're hovering over
                blocks.forEach(block => {
                    if (block === draggedElement) return;
                    
                    const rect = block.getBoundingClientRect();
                    const midpoint = rect.top + rect.height / 2;
                    
                    if (e.clientY < midpoint) {
                        canvas.insertBefore(draggedElement, block);
                    } else if (e.clientY > midpoint) {
                        canvas.insertBefore(draggedElement, block.nextSibling);
                    }
                });
            }

            function onMouseUp() {
                if (draggedElement) {
                    draggedElement.style.opacity = '1';
                    draggedElement.style.cursor = 'default';
                    draggedElement = null;
                    
                    // Auto-save after rearranging
                    autoSavePage();
                }
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);
            }

            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        });
    }

    // Create Repeater Item
    function createRepeaterItem(fieldName, item, index, blockType) {
        const itemDiv = document.createElement('div');
        itemDiv.className = 'pb-repeater-item';
        itemDiv.dataset.index = index;
        
        if (blockType === 'accordion') {
            itemDiv.innerHTML = `
                <div class="pb-repeater-fields">
                    <input type="text" class="pb-input" name="${fieldName}[${index}][title]" value="${item.title || ''}" placeholder="Section Title">
                    <textarea class="pb-textarea" name="${fieldName}[${index}][content]" placeholder="Section Content">${item.content || ''}</textarea>
                </div>
                <button type="button" class="pb-btn pb-btn-danger pb-btn-small pb-repeater-remove">
                    <i class="fas fa-minus"></i>
                </button>
            `;
        } else if (blockType === 'slider') {
            itemDiv.innerHTML = `
                <div class="pb-repeater-fields">
                    <input type="text" class="pb-input" name="${fieldName}[${index}][src]" value="${item.src || ''}" placeholder="Image URL">
                    <input type="text" class="pb-input" name="${fieldName}[${index}][alt]" value="${item.alt || ''}" placeholder="Alt Text">
                    <input type="text" class="pb-input" name="${fieldName}[${index}][caption]" value="${item.caption || ''}" placeholder="Caption">
                </div>
                <button type="button" class="pb-btn pb-btn-danger pb-btn-small pb-repeater-remove">
                    <i class="fas fa-minus"></i>
                </button>
            `;
        } else if (blockType === 'buttongroup') {
            itemDiv.innerHTML = `
                <div class="pb-repeater-fields">
                    <input type="text" class="pb-input" name="${fieldName}[${index}][text]" value="${item.text || ''}" placeholder="Button Text">
                    <input type="text" class="pb-input" name="${fieldName}[${index}][url]" value="${item.url || ''}" placeholder="URL">
                    <select class="pb-select-input" name="${fieldName}[${index}][type]">
                        <option value="primary" ${item.type === 'primary' ? 'selected' : ''}>Primary</option>
                        <option value="secondary" ${item.type === 'secondary' ? 'selected' : ''}>Secondary</option>
                        <option value="success" ${item.type === 'success' ? 'selected' : ''}>Success</option>
                        <option value="danger" ${item.type === 'danger' ? 'selected' : ''}>Danger</option>
                        <option value="outline" ${item.type === 'outline' ? 'selected' : ''}>Outline</option>
                    </select>
                </div>
                <button type="button" class="pb-btn pb-btn-danger pb-btn-small pb-repeater-remove">
                    <i class="fas fa-minus"></i>
                </button>
            `;
        } else if (blockType === 'menu') {
            itemDiv.innerHTML = `
                <div class="pb-repeater-fields">
                    <input type="text" class="pb-input" name="${fieldName}[${index}][text]" value="${item.text || ''}" placeholder="Menu Text">
                    <input type="text" class="pb-input" name="${fieldName}[${index}][url]" value="${item.url || ''}" placeholder="URL">
                    <input type="text" class="pb-input" name="${fieldName}[${index}][icon]" value="${item.icon || ''}" placeholder="Icon (e.g., fas fa-home)">
                </div>
                <button type="button" class="pb-btn pb-btn-danger pb-btn-small pb-repeater-remove">
                    <i class="fas fa-minus"></i>
                </button>
            `;
        } else if (blockType === 'social') {
            itemDiv.innerHTML = `
                <div class="pb-repeater-fields">
                    <input type="text" class="pb-input" name="${fieldName}[${index}][name]" value="${item.name || ''}" placeholder="Name (e.g., Facebook)">
                    <input type="text" class="pb-input" name="${fieldName}[${index}][icon]" value="${item.icon || ''}" placeholder="Icon (e.g., fab fa-facebook)">
                    <input type="text" class="pb-input" name="${fieldName}[${index}][url]" value="${item.url || ''}" placeholder="URL">
                </div>
                <button type="button" class="pb-btn pb-btn-danger pb-btn-small pb-repeater-remove">
                    <i class="fas fa-minus"></i>
                </button>
            `;
        } else if (blockType === 'radiobuttons' || blockType === 'selectfield') {
            itemDiv.innerHTML = `
                <div class="pb-repeater-fields">
                    <input type="text" class="pb-input" name="${fieldName}[${index}][label]" value="${item.label || ''}" placeholder="Label">
                    <input type="text" class="pb-input" name="${fieldName}[${index}][value]" value="${item.value || ''}" placeholder="Value">
                </div>
                <button type="button" class="pb-btn pb-btn-danger pb-btn-small pb-repeater-remove">
                    <i class="fas fa-minus"></i>
                </button>
            `;
        }
        
        // Remove button handler
        itemDiv.querySelector('.pb-repeater-remove').onclick = function() {
            itemDiv.remove();
            handlePreviewUpdate();
        };
        
        // Add real-time preview listeners to all inputs in repeater
        itemDiv.querySelectorAll('input, textarea, select').forEach(function(field) {
            if (field.type === 'text' || field.type === 'url' || field.tagName === 'TEXTAREA') {
                field.addEventListener('input', handlePreviewUpdate);
            } else {
                field.addEventListener('change', handlePreviewUpdate);
            }
        });
        
        return itemDiv;
    }

    // Parse dimension value (e.g., "100px" -> {value: "100", unit: "px"})
    function parseDimensionValue(dimensionStr) {
        if (!dimensionStr) return { value: '', unit: 'px' };
        
        const match = dimensionStr.match(/^([\d.]+)(.*)$/);
        if (match) {
            return {
                value: match[1],
                unit: match[2] || 'px'
            };
        }
        
        // Check if it's just a unit like "auto"
        if (isNaN(dimensionStr)) {
            return { value: '', unit: dimensionStr };
        }
        
        return { value: dimensionStr, unit: 'px' };
    }
    
    // Update conditional fields based on condition changes
    function updateConditionalFields(form, changedFieldName, newValue, blockData) {
        const blockElement = currentEditingBlock;
        const blockType = blockElement.dataset.blockType;
        const template = blockTemplates[blockType];
        
        // First, save all current form values to blockData
        const formContainer = document.getElementById('pb-editor-form');
        
        // Save dimension fields
        formContainer.querySelectorAll('.pb-dimension-wrapper').forEach(wrapper => {
            const valueInput = wrapper.querySelector('.pb-dimension-input');
            const unitSelect = wrapper.querySelector('.pb-unit-select');
            
            if (valueInput && unitSelect && valueInput.name) {
                const value = valueInput.value.trim();
                const unit = unitSelect.value;
                
                if (value) {
                    blockData[valueInput.name] = value + unit;
                } else if (unit === 'auto') {
                    blockData[valueInput.name] = 'auto';
                } else {
                    blockData[valueInput.name] = '';
                }
            }
        });
        
        // Save regular fields
        formContainer.querySelectorAll('input:not([name*="["]):not(.pb-dimension-input), textarea:not([name*="["]), select:not([name*="["]):not(.pb-unit-select)').forEach(field => {
            if (field.name && field.name !== changedFieldName) {
                if (field.type === 'checkbox') {
                    blockData[field.name] = field.checked;
                } else {
                    blockData[field.name] = field.value;
                }
            }
        });
        
        // Update the changed field value
        blockData[changedFieldName] = newValue;
        
        // Update the block's stored data
        blockElement.dataset.blockData = JSON.stringify(blockData);
        
        // Rebuild form with updated conditions
        editBlock(blockElement.dataset.blockId);
        
        // Trigger preview update after form is rebuilt
        setTimeout(function() {
            handlePreviewUpdate();
        }, 100);
    }

    // Edit Block
    function editBlock(blockId) {
        const blockElement = document.querySelector(`[data-block-id="${blockId}"]`);
        if (!blockElement) return;

        const blockType = blockElement.dataset.blockType;
        const template = blockTemplates[blockType];
        const blockData = JSON.parse(blockElement.dataset.blockData || '{}');

        currentEditingBlock = blockElement;

        // Build form
        const form = document.getElementById('pb-editor-form');
        form.innerHTML = '';

        template.fields.forEach(field => {
            // Check if field has a condition
            if (field.condition) {
                const conditionField = field.condition;
                const conditionValue = field.conditionValue;
                
                // Get current value, or use the default from the condition field
                let currentValue = blockData[conditionField];
                
                // If no value exists, check if there's a default for the condition field
                if (currentValue === undefined) {
                    const conditionFieldDef = template.fields.find(f => f.name === conditionField);
                    if (conditionFieldDef) {
                        currentValue = conditionFieldDef.default;
                    }
                }
                
                // Skip this field if condition is not met
                if (currentValue !== conditionValue) {
                    return;
                }
            }
            
            const formGroup = document.createElement('div');
            formGroup.className = 'pb-form-group';
            if (field.condition) {
                formGroup.dataset.condition = field.condition;
                formGroup.dataset.conditionValue = field.conditionValue;
            }

            // Don't add label for checkboxes yet (will be added with input)
            let input;
            if (field.type === 'checkbox') {
                // Handle checkbox specially - create label wrapper
                const checkboxLabel = document.createElement('label');
                checkboxLabel.style.display = 'flex';
                checkboxLabel.style.alignItems = 'center';
                checkboxLabel.style.cursor = 'pointer';
                
                input = document.createElement('input');
                input.type = 'checkbox';
                input.name = field.name;
                input.checked = blockData[field.name] !== undefined ? blockData[field.name] : field.default;
                
                const labelText = document.createElement('span');
                labelText.textContent = field.label;
                labelText.style.marginLeft = '0.5rem';
                
                checkboxLabel.appendChild(input);
                checkboxLabel.appendChild(labelText);
                formGroup.appendChild(checkboxLabel);
                
                // Add change listener for conditional fields
                input.addEventListener('change', function() {
                    updateConditionalFields(form, field.name, this.checked, blockData);
                });
                
                // Add real-time preview listener
                input.addEventListener('change', handlePreviewUpdate);
                
                form.appendChild(formGroup);
                return;
            }

            const label = document.createElement('label');
            label.textContent = field.label;
            formGroup.appendChild(label);

            if (field.type === 'repeater') {
                // Create repeater container
                const repeaterContainer = document.createElement('div');
                repeaterContainer.className = 'pb-repeater-container';
                repeaterContainer.dataset.fieldName = field.name;
                
                const items = blockData[field.name] || field.default || [];
                items.forEach((item, index) => {
                    repeaterContainer.appendChild(createRepeaterItem(field.name, item, index, blockType));
                });
                
                // Add button
                const addBtn = document.createElement('button');
                addBtn.type = 'button';
                addBtn.className = 'pb-btn pb-btn-success pb-btn-small';
                const addLabel = blockType === 'accordion' ? 'Section' : 
                               blockType === 'slider' ? 'Slide' : 
                               blockType === 'buttongroup' ? 'Button' :
                               blockType === 'menu' ? 'Menu Item' :
                               blockType === 'social' ? 'Social Button' :
                               (blockType === 'radiobuttons' || blockType === 'selectfield') ? 'Option' : 'Item';
                addBtn.innerHTML = '<i class="fas fa-plus"></i> Add ' + addLabel;
                addBtn.onclick = () => {
                    let newItem;
                    if (blockType === 'accordion') {
                        newItem = {title: 'New Section', content: 'Content'};
                    } else if (blockType === 'slider') {
                        newItem = {src: 'https://placehold.co/800x400', alt: 'New Slide', caption: ''};
                    } else if (blockType === 'buttongroup') {
                        newItem = {text: 'New Button', url: '#', type: 'primary'};
                    } else if (blockType === 'menu') {
                        newItem = {text: 'Menu Item', url: '#', icon: ''};
                    } else if (blockType === 'social') {
                        newItem = {name: 'Social', icon: 'fab fa-link', url: '#'};
                    } else if (blockType === 'radiobuttons' || blockType === 'selectfield') {
                        newItem = {label: 'Option', value: ''};
                    }
                    repeaterContainer.appendChild(createRepeaterItem(field.name, newItem, repeaterContainer.children.length, blockType));
                    handlePreviewUpdate();
                };
                
                formGroup.appendChild(repeaterContainer);
                formGroup.appendChild(addBtn);
                form.appendChild(formGroup);
                return;
            } else if (field.type === 'textarea') {
                input = document.createElement('textarea');
                input.className = 'pb-textarea';
                input.value = blockData[field.name] || field.default;
            } else if (field.type === 'dimension') {
                // Create dimension input with unit dropdown
                const dimensionWrapper = document.createElement('div');
                dimensionWrapper.className = 'pb-dimension-wrapper';
                
                input = document.createElement('input');
                input.type = 'text';
                input.className = 'pb-input pb-dimension-input';
                input.placeholder = 'Value';
                
                // Parse existing value
                const existingValue = blockData[field.name] || field.default || '';
                const parsedDimension = parseDimensionValue(existingValue);
                input.value = parsedDimension.value;
                
                const unitSelect = document.createElement('select');
                unitSelect.className = 'pb-select-input pb-unit-select';
                unitSelect.name = field.name + '_unit';
                
                field.units.forEach(unit => {
                    const option = document.createElement('option');
                    option.value = unit;
                    option.textContent = unit;
                    if (parsedDimension.unit === unit) {
                        option.selected = true;
                    }
                    unitSelect.appendChild(option);
                });
                
                dimensionWrapper.appendChild(input);
                dimensionWrapper.appendChild(unitSelect);
                
                input.name = field.name;
                
                // Add real-time preview listeners for dimension fields
                input.addEventListener('input', handlePreviewUpdate);
                unitSelect.addEventListener('change', handlePreviewUpdate);
                
                formGroup.appendChild(dimensionWrapper);
                form.appendChild(formGroup);
                return;
            } else if (field.type === 'select') {
                input = document.createElement('select');
                input.className = 'pb-select-input';
                field.options.forEach(opt => {
                    const option = document.createElement('option');
                    option.value = opt;
                    option.textContent = opt;
                    if (blockData[field.name] === opt || (!blockData[field.name] && field.default === opt)) {
                        option.selected = true;
                    }
                    input.appendChild(option);
                });
                
                // Add change listener for conditional fields
                input.addEventListener('change', function() {
                    updateConditionalFields(form, field.name, this.value, blockData);
                });
            } else {
                input = document.createElement('input');
                input.type = field.type || 'text';
                input.className = 'pb-input';
                input.value = blockData[field.name] || field.default;
            }

            input.name = field.name;
            
            // Attach real-time preview listeners
            if (field.type === 'textarea' || field.type === 'text' || field.type === 'number' || field.type === 'url' || field.type === 'email') {
                input.addEventListener('input', handlePreviewUpdate);
            } else if (field.type === 'select' || field.type === 'checkbox' || field.type === 'radio') {
                input.addEventListener('change', handlePreviewUpdate);
            }
            
            formGroup.appendChild(input);
            form.appendChild(formGroup);
        });

        // Show properties sidebar
        const sidebar = document.getElementById('pb-properties-sidebar');
        sidebar.classList.add('active');
        
        // Remove empty state if present
        const emptyState = sidebar.querySelector('.pb-properties-empty');
        if (emptyState) {
            emptyState.style.display = 'none';
        }
        
        // Initial preview render
        setTimeout(function() {
            if (currentEditingBlock) {
                console.log('Initial preview render for:', blockType, blockData);
                updateBlockPreview(currentEditingBlock, blockData);
            }
        }, 100);
    }

    // Save Block
    function saveBlock() {
        if (!currentEditingBlock) {
            console.error('No block being edited');
            return;
        }

        const formContainer = document.getElementById('pb-editor-form');
        const blockData = {};

        console.log('Saving block...');

        // Handle repeater fields
        formContainer.querySelectorAll('.pb-repeater-container').forEach(container => {
            const fieldName = container.dataset.fieldName;
            const items = [];
            
            container.querySelectorAll('.pb-repeater-item').forEach(item => {
                const itemData = {};
                item.querySelectorAll('input, textarea, select').forEach(field => {
                    const match = field.name.match(/\[(\d+)\]\[(\w+)\]/);
                    if (match) {
                        const fieldName = match[2];
                        if (field.type === 'checkbox' || field.type === 'radio') {
                            itemData[fieldName] = field.checked;
                        } else {
                            itemData[fieldName] = field.value;
                        }
                    }
                });
                items.push(itemData);
            });
            
            blockData[fieldName] = items;
        });

        // Handle dimension fields (combine value and unit)
        formContainer.querySelectorAll('.pb-dimension-wrapper').forEach(wrapper => {
            const valueInput = wrapper.querySelector('.pb-dimension-input');
            const unitSelect = wrapper.querySelector('.pb-unit-select');
            
            if (valueInput && unitSelect && valueInput.name) {
                const value = valueInput.value.trim();
                const unit = unitSelect.value;
                
                // Combine value and unit (e.g., "100" + "px" = "100px")
                if (value) {
                    blockData[valueInput.name] = value + unit;
                } else if (unit === 'auto') {
                    blockData[valueInput.name] = 'auto';
                } else {
                    blockData[valueInput.name] = '';
                }
            }
        });

        // Handle regular input fields (not in repeaters or dimensions)
        formContainer.querySelectorAll('input:not([name*="["]):not(.pb-dimension-input), textarea:not([name*="["]), select:not([name*="["]):not(.pb-unit-select)').forEach(field => {
            if (field.name) {
                if (field.type === 'checkbox') {
                    blockData[field.name] = field.checked;
                } else {
                    blockData[field.name] = field.value;
                }
                console.log('Field:', field.name, '=', field.value);
            }
        });

        console.log('Block data to save:', blockData);
        currentEditingBlock.dataset.blockData = JSON.stringify(blockData);

        // Update visual preview
        updateBlockPreview(currentEditingBlock, blockData);

        // Don't close sidebar - keep it open for further editing
        // User can close manually if desired
        
        // Auto-save after editing
        autoSavePage();
        
        // Show feedback
        const saveBtn = document.getElementById('pb-save-block');
        const originalText = saveBtn.innerHTML;
        saveBtn.innerHTML = '<i class="fas fa-check"></i> Saved!';
        saveBtn.style.background = '#27ae60';
        setTimeout(function() {
            saveBtn.innerHTML = originalText;
            saveBtn.style.background = '';
        }, 1500);
    }
    
    // Auto-save function
    function autoSavePage() {
        if (!currentPage) {
            console.warn('Cannot auto-save: no current page');
            return;
        }
        
        console.log('Auto-saving page:', currentPage);
        const canvas = document.getElementById('pb-canvas');
        const blocks = Array.from(canvas.querySelectorAll('.pb-canvas-block:not(.pb-child-block)'));
        
        console.log('Number of blocks to save:', blocks.length);
        
        const pageData = blocks.map(block => {
            const blockObj = {
                type: block.dataset.blockType,
                data: JSON.parse(block.dataset.blockData || '{}')
            };
            
            console.log('Block:', blockObj.type, 'Data:', blockObj.data);
            
            // If container, get children
            const childrenContainer = block.querySelector('.pb-container-children');
            if (childrenContainer) {
                const children = Array.from(childrenContainer.querySelectorAll('.pb-child-block'));
                blockObj.children = children.map(child => ({
                    type: child.dataset.blockType,
                    data: JSON.parse(child.dataset.blockData || '{}')
                }));
                console.log('Container has', blockObj.children.length, 'children');
            }
            
            return blockObj;
        });

        console.log('Sending to API:', pageData);

        fetch('/addons/page-builder/page-builder-api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'save',
                pageName: currentPage,
                blocks: pageData
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Auto-saved successfully');
                console.log('Saved', data.blockCount, 'blocks,', data.bytes, 'bytes');
                console.log('Preview of saved code:', data.preview);
                // Show brief success indicator
                showSaveIndicator();
            } else {
                console.error('Auto-save failed:', data.error);
            }
        })
        .catch(error => {
            console.error('Auto-save error:', error);
        });
    }
    
    // Show save indicator
    function showSaveIndicator() {
        const indicator = document.createElement('div');
        indicator.style.cssText = 'position: fixed; top: 70px; right: 20px; background: #27ae60; color: white; padding: 0.5rem 1rem; border-radius: 4px; z-index: 10000; font-size: 0.9rem;';
        indicator.innerHTML = '<i class="fas fa-check"></i> Saved';
        document.body.appendChild(indicator);
        
        setTimeout(() => {
            indicator.style.opacity = '0';
            indicator.style.transition = 'opacity 0.3s';
            setTimeout(() => indicator.remove(), 300);
        }, 2000);
    }

    // Delete Block
    function deleteBlock(blockId) {
        const blockElement = document.querySelector(`[data-block-id="${blockId}"]`);
        if (blockElement) {
            blockElement.remove();
            checkIfCanvasEmpty();
            
            // Auto-save after deleting
            autoSavePage();
        }
    }

    // Menu Buttons
    function setupMenuButtons() {
        const newPageBtn = document.getElementById('pb-new-page');
        if (newPageBtn) {
            newPageBtn.addEventListener('click', showNewPageModal);
            console.log('New Page button listener attached');
        } else {
            console.error('New Page button not found!');
        }
        
        document.getElementById('pb-save-page').addEventListener('click', savePage);
        document.getElementById('pb-preview-page').addEventListener('click', previewPage);
        document.getElementById('pb-view-source').addEventListener('click', viewSourceCode);
        document.getElementById('pb-delete-page').addEventListener('click', deletePage);
        document.getElementById('pb-page-select').addEventListener('change', loadPage);
    }

    // New Page
    function showNewPageModal() {
        console.log('showNewPageModal called');
        const modal = document.getElementById('pb-new-page-modal');
        if (modal) {
            modal.classList.add('active');
            document.getElementById('pb-new-page-name').value = '';
            console.log('Modal should be visible now');
        } else {
            console.error('Modal not found!');
        }
    }

    function createNewPage() {
        const pageName = document.getElementById('pb-new-page-name').value.trim();
        
        if (!pageName) {
            alert('Please enter a page name');
            return;
        }

        if (!/^[a-z0-9-]+$/.test(pageName)) {
            alert('Page name can only contain lowercase letters, numbers, and hyphens');
            return;
        }

        currentPage = pageName;
        document.getElementById('pb-current-page-name').textContent = pageName;
        document.getElementById('pb-canvas').innerHTML = '';
        removePlaceholder();
        
        closeNewPageModal();
        
        // Auto-save the new empty page
        autoSavePage();
    }

    // Save Page
    function savePage() {
        if (!currentPage) {
            alert('Please create or select a page first');
            return;
        }

        const canvas = document.getElementById('pb-canvas');
        const blocks = Array.from(canvas.querySelectorAll('.pb-canvas-block:not(.pb-child-block)'));
        
        const pageData = blocks.map(block => {
            const blockObj = {
                type: block.dataset.blockType,
                data: JSON.parse(block.dataset.blockData || '{}')
            };
            
            // If container, get children
            const childrenContainer = block.querySelector('.pb-container-children');
            if (childrenContainer) {
                const children = Array.from(childrenContainer.querySelectorAll('.pb-child-block'));
                blockObj.children = children.map(child => ({
                    type: child.dataset.blockType,
                    data: JSON.parse(child.dataset.blockData || '{}')
                }));
            }
            
            return blockObj;
        });

        // Send to API
        fetch('/addons/page-builder/page-builder-api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'save',
                pageName: currentPage,
                blocks: pageData
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success indicator instead of alert
                showSaveIndicator();
                
                // Update page dropdown if needed (add new page to list)
                updatePageDropdown();
            } else {
                alert('Error saving page: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving page');
        });
    }
    
    // Update page dropdown with current pages
    function updatePageDropdown() {
        const select = document.getElementById('pb-page-select');
        const currentValue = select.value;
        
        // Check if current page is in dropdown
        let pageExists = false;
        for (let option of select.options) {
            if (option.value === currentPage) {
                pageExists = true;
                break;
            }
        }
        
        // Add current page to dropdown if it doesn't exist
        if (!pageExists && currentPage) {
            const option = document.createElement('option');
            option.value = currentPage;
            option.textContent = currentPage;
            option.selected = true;
            select.appendChild(option);
        }
    }

    // Load Page
    function loadPage() {
        const select = document.getElementById('pb-page-select');
        const pageName = select.value;
        
        if (!pageName) return;

        fetch('/addons/page-builder/page-builder-api.php?action=load&page=' + encodeURIComponent(pageName))
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentPage = pageName;
                    document.getElementById('pb-current-page-name').textContent = pageName;
                    
                    // Clear canvas
                    const canvas = document.getElementById('pb-canvas');
                    canvas.innerHTML = '';
                    blockCounter = 0;
                    
                    // Add blocks
                    if (data.blocks && data.blocks.length > 0) {
                        data.blocks.forEach(block => {
                            addBlockToCanvas(block.type, block.data, block.children, true);
                        });
                    } else {
                        showPlaceholder();
                    }
                } else {
                    alert('Error loading page: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading page');
            });
    }

    // Delete Page
    function deletePage() {
        if (!currentPage) {
            alert('Please select a page first');
            return;
        }

        if (!confirm(`Are you sure you want to delete the page "${currentPage}"?`)) {
            return;
        }

        fetch('/addons/page-builder/page-builder-api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'delete',
                pageName: currentPage
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Page deleted successfully!');
                location.reload();
            } else {
                alert('Error deleting page: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting page');
        });
    }

    // Preview Page
    function previewPage() {
        if (!currentPage) {
            alert('Please create or select a page first');
            return;
        }
        
        const iframe = document.getElementById('pb-preview-frame');
        // Load the actual page in the iframe
        iframe.src = '/?page=' + encodeURIComponent(currentPage);
        
        document.getElementById('pb-preview-modal').classList.add('active');
    }
    
    // View Source Code
    function viewSourceCode() {
        const canvas = document.getElementById('pb-canvas');
        const blocks = Array.from(canvas.querySelectorAll('.pb-canvas-block'));
        
        const pageData = blocks.map(block => ({
            type: block.dataset.blockType,
            data: JSON.parse(block.dataset.blockData || '{}')
        }));

        // Generate preview HTML
        const sourceHTML = generatePreviewHTML(pageData);
        
        document.getElementById('pb-source-code').value = sourceHTML;
        document.getElementById('pb-source-modal').classList.add('active');
    }

    function generatePreviewHTML(blocks) {
        let html = `
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview</title>
    <link rel="stylesheet" href="/framework/framework-styles/reset.css">
    <link rel="stylesheet" href="/framework/framework-styles/layout.css">
    <link rel="stylesheet" href="/framework/framework-styles/blocks.css">
    <link rel="stylesheet" href="/styles/theme.css">
</head>
<body>
    <div class="container">
`;

        blocks.forEach(block => {
            const data = block.data;
            // Simplified rendering - in production, this would call actual PHP block functions
            html += `<div class="block block-${block.type}" style="margin: 1rem 0; padding: 1rem; background: #f8f9fa; border-radius: 4px;">`;
            html += `<strong>${block.type.toUpperCase()}</strong><br>`;
            html += `<pre style="font-size: 0.85rem; margin-top: 0.5rem;">${JSON.stringify(data, null, 2)}</pre>`;
            html += `</div>`;
        });

        html += `
    </div>
</body>
</html>
`;
        return html;
    }

    // Modal Controls
    function setupModals() {
        // Properties sidebar
        const closePropertiesBtn = document.getElementById('pb-close-properties');
        const saveBlockBtn = document.getElementById('pb-save-block');
        
        if (closePropertiesBtn) {
            closePropertiesBtn.addEventListener('click', closePropertiesSidebar);
            console.log('Close properties button connected');
        } else {
            console.error('pb-close-properties button not found!');
        }
        
        if (saveBlockBtn) {
            saveBlockBtn.addEventListener('click', function(e) {
                console.log('Save block button clicked!');
                saveBlock();
            });
            console.log('Save block button connected');
        } else {
            console.error('pb-save-block button not found!');
        }

        // Preview modal
        document.getElementById('pb-close-preview').addEventListener('click', closePreviewModal);
        
        // Preview size buttons
        document.querySelectorAll('.pb-preview-size-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.pb-preview-size-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const size = this.dataset.size;
                const iframe = document.getElementById('pb-preview-frame');
                iframe.className = 'pb-preview-frame ' + size;
            });
        });

        // New page modal
        document.getElementById('pb-close-new-page').addEventListener('click', closeNewPageModal);
        document.getElementById('pb-create-page').addEventListener('click', createNewPage);
        document.getElementById('pb-cancel-new-page').addEventListener('click', closeNewPageModal);
        
        // Source code modal
        document.getElementById('pb-close-source').addEventListener('click', closeSourceModal);
        document.getElementById('pb-copy-source').addEventListener('click', copySourceCode);

        // Close modals on background click
        document.querySelectorAll('.pb-modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });
        });
    }

    function closePropertiesSidebar() {
        const sidebar = document.getElementById('pb-properties-sidebar');
        sidebar.classList.remove('active');
        
        // Clear form and show empty state
        const form = document.getElementById('pb-editor-form');
        form.innerHTML = '<div class="pb-properties-empty"><i class="fas fa-mouse-pointer"></i><p>Select a block to edit its properties</p></div>';
        
        currentEditingBlock = null;
    }

    function closePreviewModal() {
        document.getElementById('pb-preview-modal').classList.remove('active');
    }

    function closeNewPageModal() {
        document.getElementById('pb-new-page-modal').classList.remove('active');
    }
    
    function closeSourceModal() {
        document.getElementById('pb-source-modal').classList.remove('active');
    }
    
    function copySourceCode() {
        const textarea = document.getElementById('pb-source-code');
        textarea.select();
        document.execCommand('copy');
        alert('Source code copied to clipboard!');
    }

    // Placeholder management
    function removePlaceholder() {
        const placeholder = document.querySelector('.pb-canvas-placeholder');
        if (placeholder) {
            placeholder.remove();
        }
    }

    function showPlaceholder() {
        const canvas = document.getElementById('pb-canvas');
        if (canvas.children.length === 0) {
            canvas.innerHTML = `
                <div class="pb-canvas-placeholder">
                    <i class="fas fa-mouse-pointer"></i>
                    <p>Drag blocks here to start building your page</p>
                </div>
            `;
        }
    }

    function checkIfCanvasEmpty() {
        const canvas = document.getElementById('pb-canvas');
        if (canvas.querySelectorAll('.pb-canvas-block').length === 0) {
            showPlaceholder();
        }
    }

    // Export functions to global scope
    window.pageBuilder = {
        editBlock,
        deleteBlock,
        saveBlock
    };

})();
