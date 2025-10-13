# List Blocks

Create ordered lists, unordered lists, and checklists with various styles.

## Unordered List

```php
// Basic unordered list
echo block_list([
    'First item',
    'Second item',
    'Third item'
]);

// List with custom style
echo block_list([
    'Item 1',
    'Item 2',
    'Item 3'
], 'ul', '', 'disc');
```

## Ordered List

```php
// Basic ordered list
echo block_list([
    'Step one',
    'Step two',
    'Step three'
], 'ol');

// Numbered list with alpha style
echo block_list([
    'First point',
    'Second point',
    'Third point'
], 'ol', '', 'alpha');
```

## Nested Lists

```php
echo block_list([
    'Parent item 1',
    'Parent item 2' => [
        'children' => [
            'Child item 1',
            'Child item 2',
            'Child item 3'
        ]
    ],
    'Parent item 3'
]);
```

## List Styles

```php
// No bullets
echo block_list(['Item 1', 'Item 2'], 'ul', '', 'none');

// Disc bullets (default)
echo block_list(['Item 1', 'Item 2'], 'ul', '', 'disc');

// Circle bullets
echo block_list(['Item 1', 'Item 2'], 'ul', '', 'circle');

// Square bullets
echo block_list(['Item 1', 'Item 2'], 'ul', '', 'square');

// Decimal numbers
echo block_list(['Item 1', 'Item 2'], 'ol', '', 'decimal');

// Alphabetical
echo block_list(['Item 1', 'Item 2'], 'ol', '', 'alpha');
```

## Static Checklist

```php
// Simple checklist
echo block_checklist([
    ['text' => 'Completed task', 'checked' => true],
    ['text' => 'Another completed task', 'checked' => true],
    ['text' => 'Pending task', 'checked' => false],
    ['text' => 'Another pending task', 'checked' => false]
]);

// Checklist with simple array
echo block_checklist([
    'Task 1',
    'Task 2',
    'Task 3'
]);
```

## Interactive Checklist

```php
// Interactive checklist with checkboxes
echo block_checklist_interactive([
    ['text' => 'Task 1', 'checked' => false],
    ['text' => 'Task 2', 'checked' => true],
    ['text' => 'Task 3', 'checked' => false]
], 'todo');

// With custom IDs and values
echo block_checklist_interactive([
    ['text' => 'Option A', 'id' => 'opt_a', 'value' => 'a', 'checked' => true],
    ['text' => 'Option B', 'id' => 'opt_b', 'value' => 'b', 'checked' => false],
    ['text' => 'Option C', 'id' => 'opt_c', 'value' => 'c', 'checked' => false]
], 'options');
```

## Parameters

### block_list()
- **items** (array): Array of list items (strings or arrays with 'content' and 'children')
- **type** (string, default: 'ul'): List type
  - `ul` - Unordered list
  - `ol` - Ordered list
- **class** (string, optional): Additional CSS classes
- **style** (string, default: 'default'): List style
  - `default` - Default browser style
  - `none` - No bullets/numbers
  - `disc` - Disc bullets
  - `circle` - Circle bullets
  - `square` - Square bullets
  - `decimal` - Decimal numbers
  - `alpha` - Alphabetical

### block_checklist()
- **items** (array): Array of items (strings or arrays with 'text' and 'checked')
- **class** (string, optional): Additional CSS classes

### block_checklist_interactive()
- **items** (array): Array of items with 'text', optional 'checked', 'id', and 'value'
- **name** (string, default: 'checklist'): Form name for the checklist
- **class** (string, optional): Additional CSS classes

## Examples

### Feature List
```php
echo block_list([
    'Lightning-fast performance',
    'Responsive design',
    'SEO optimized',
    'Easy to customize',
    'No dependencies'
], 'ul', '', 'disc');
```

### Step-by-Step Instructions
```php
echo block_list([
    'Download the files',
    'Upload to your server',
    'Configure config.php',
    'Visit your site',
    'Start building!'
], 'ol');
```

### Nested Navigation
```php
echo block_list([
    'Home',
    'Products' => [
        'children' => [
            'Category 1',
            'Category 2',
            'Category 3'
        ]
    ],
    'About',
    'Contact'
]);
```

### Project Checklist
```php
echo block_checklist([
    ['text' => 'Design mockups', 'checked' => true],
    ['text' => 'Frontend development', 'checked' => true],
    ['text' => 'Backend API', 'checked' => false],
    ['text' => 'Testing', 'checked' => false],
    ['text' => 'Deployment', 'checked' => false]
]);
```

### Todo List Form
```php
echo '<form action="/save-tasks" method="POST">';
echo block_checklist_interactive([
    ['text' => 'Review pull requests', 'checked' => false],
    ['text' => 'Update documentation', 'checked' => false],
    ['text' => 'Fix bug #123', 'checked' => true],
    ['text' => 'Deploy to production', 'checked' => false]
], 'tasks');
echo block_button('Save', '', 'primary');
echo '</form>';
```

### Requirements List
```php
echo '<h3>System Requirements</h3>';
echo block_checklist([
    ['text' => 'PHP 7.4 or higher', 'checked' => true],
    ['text' => 'Apache or Nginx', 'checked' => true],
    ['text' => 'MySQL (optional)', 'checked' => false]
]);
```

### Multi-level List
```php
echo block_list([
    'Chapter 1: Introduction' => [
        'children' => [
            'Section 1.1: Overview',
            'Section 1.2: Getting Started' => [
                'children' => [
                    'Installation',
                    'Configuration',
                    'First Steps'
                ]
            ]
        ]
    ],
    'Chapter 2: Advanced Topics',
    'Chapter 3: Examples'
], 'ol');
```

## Notes

- Static checklists are for display only (visual checkmarks)
- Interactive checklists create actual form checkboxes
- Nested lists automatically inherit the parent list type
- Custom classes can be added for additional styling
- Interactive checklists submit as arrays (e.g., `tasks[]`)
