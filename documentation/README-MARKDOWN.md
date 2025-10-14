# Markdown Block

The Markdown block allows you to display formatted markdown content from `.md` files in your pages.

## Basic Usage

```php
<?php
echo block_markdown('path/to/file.md');
?>
```

## Parameters

### Required Parameters

- **$src** (string): Path to the markdown file relative to the project root
  - Example: `'documentation/README.md'`
  - The path should not include a leading slash

### Optional Parameters

- **$options** (array): Additional options
  - `class` (string): Additional CSS classes to add to the markdown container

## Examples

### Simple Markdown Display

```php
<?php
echo block_markdown('documentation/README-BUTTONS.md');
?>
```

### With Custom Class

```php
<?php
echo block_markdown('documentation/README-CARDS.md', [
    'class' => 'custom-docs'
]);
?>
```

### In a Container

```php
<?php
echo block_container([
    block_markdown('content/article.md')
], [
    'width' => 'narrow'
]);
?>
```

## Supported Markdown Features

The markdown parser supports the following features:

### Headings

```markdown
# Heading 1
## Heading 2
### Heading 3
#### Heading 4
##### Heading 5
###### Heading 6
```

### Text Formatting

```markdown
**Bold text**
*Italic text*
***Bold and italic***
`Inline code`
```

### Links and Images

```markdown
[Link text](https://example.com)
[Anchor link](#section-name)
![Alt text](path/to/image.jpg)
```

**Note:** Anchor links work automatically! All headings get an auto-generated ID based on their text.

### Lists

**Unordered Lists:**
```markdown
- Item 1
- Item 2
- Item 3
```

**Ordered Lists:**
```markdown
1. First item
2. Second item
3. Third item
```

### Code Blocks

````markdown
```php
<?php
echo "Hello, World!";
?>
```
````

### Blockquotes

```markdown
> This is a blockquote
> It can span multiple lines
```

### Horizontal Rules

```markdown
---
***
___
```

## Styling

The markdown block comes with default styling that can be customized using CSS variables:

```css
.block-markdown {
    /* Customize markdown content */
}

.block-markdown h1 {
    /* Customize headings */
}

.block-markdown code {
    /* Customize inline code */
}

.block-markdown pre {
    /* Customize code blocks */
}
```

## Security

The markdown block includes security features:

- **File validation**: Only `.md` files are allowed
- **Path traversal protection**: Prevents access to files outside the project directory
- **HTML escaping**: Code blocks are properly escaped to prevent XSS attacks

## Error Handling

If a markdown file is not found, the block will display an error message:

```html
<div class="block-markdown">
    <p class="error">Markdown file not found: path/to/file.md</p>
</div>
```

## Use Cases

### Documentation Pages

Display documentation files in a user-friendly format:

```php
<?php
$file = $_GET['doc'] ?? 'README.md';
echo block_markdown('documentation/' . $file);
?>
```

### Blog Posts

Store blog posts as markdown files:

```php
<?php
echo block_markdown('blog/posts/my-first-post.md');
?>
```

### Static Content

Use markdown for easy-to-edit static content:

```php
<?php
echo block_markdown('content/about.md');
?>
```

## Anchor Links

All headings automatically get an ID attribute for anchor linking. The ID is generated from the heading text:

**Heading:**
```markdown
## Getting Started
```

**Generated HTML:**
```html
<h2 id="getting-started">Getting Started</h2>
```

**Link to it:**
```markdown
[Jump to Getting Started](#getting-started)
```

**ID Generation Rules:**
- Text is converted to lowercase
- Spaces and special characters become hyphens
- Multiple hyphens are collapsed to one
- Leading/trailing hyphens are removed

**Examples:**
- `# Hello World` → `id="hello-world"`
- `## API Reference` → `id="api-reference"`
- `### Step 1: Setup` → `id="step-1-setup"`

## Tips

1. **File Organization**: Keep markdown files organized in dedicated directories like `documentation/` or `content/`
2. **Relative Paths**: Use relative paths from the project root without leading slashes
3. **Anchor Links**: Use `#heading-text` format for same-page navigation
4. **Syntax Highlighting**: For better code highlighting, consider integrating a syntax highlighting library like Prism.js or Highlight.js
5. **Performance**: Markdown parsing happens on each request. For high-traffic sites, consider caching the parsed HTML

## Related Blocks

- **TextView Block**: For simple formatted text without markdown
- **Container Block**: To wrap markdown content in styled containers
