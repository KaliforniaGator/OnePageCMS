<?php
/**
 * Documentation Index Page
 * Lists all available documentation files
 */

// Set page metadata
set_page_meta([
    'title' => 'Documentation',
    'description' => 'Browse all available documentation for OnePage CMS blocks and features.',
    'url' => SITE_URL . '/?page=documentation',
    'type' => 'website'
]);

// Get all markdown files from documentation directory
$docsDir = $_SERVER['DOCUMENT_ROOT'] . '/documentation';
$files = [];

if (is_dir($docsDir)) {
    $items = scandir($docsDir);
    foreach ($items as $item) {
        if (pathinfo($item, PATHINFO_EXTENSION) === 'md') {
            $files[] = $item;
        }
    }
    sort($files);
}

// Function to format filename to readable title
function formatTitle($filename) {
    // Remove .md extension
    $title = str_replace('.md', '', $filename);
    // Remove README- prefix
    $title = str_replace('README-', '', $title);
    // Replace hyphens with spaces
    $title = str_replace('-', ' ', $title);
    // Capitalize words
    $title = ucwords(strtolower($title));
    return $title;
}
?>
<article class="page-content">
    <h1>Documentation</h1>
    
    <p>Welcome to the OnePage CMS documentation. Browse through the guides below to learn about all available blocks and features.</p>
    
    <?php if (empty($files)): ?>
        <p class="error">No documentation files found.</p>
    <?php else: ?>
        <div class="documentation-list">
            <ul class="doc-list">
                <?php foreach ($files as $file): ?>
                    <li class="doc-item">
                        <a href="/?page=docs&file=<?php echo urlencode($file); ?>" class="doc-link">
                            <i class="fas fa-file-alt"></i>
                            <span><?php echo htmlspecialchars(formatTitle($file)); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <p><a href="/" class="btn">Back to Home</a></p>
</article>

<style>
.documentation-list {
    margin: 2rem 0;
}

.doc-list {
    list-style: none;
    padding: 0;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1rem;
}

.doc-item {
    margin: 0;
}

.doc-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    background: var(--color-surface, #f5f5f5);
    border: 1px solid var(--color-border, #e0e0e0);
    border-radius: 8px;
    text-decoration: none;
    color: var(--color-text, #333);
    transition: all 0.2s ease;
}

.doc-link:hover {
    background: var(--color-primary, #007bff);
    color: white;
    border-color: var(--color-primary, #007bff);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.doc-link i {
    font-size: 1.25rem;
    opacity: 0.8;
}

.doc-link span {
    font-weight: 500;
}
</style>
