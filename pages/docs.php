<?php
/**
 * Documentation Viewer Page
 * Displays individual markdown documentation files
 */

// Get the file parameter from URL
$file = isset($_GET['file']) ? $_GET['file'] : '';

// Validate file parameter
if (empty($file)) {
    header('Location: /?page=documentation');
    exit;
}

// Security: Only allow .md files and prevent directory traversal
if (pathinfo($file, PATHINFO_EXTENSION) !== 'md' || strpos($file, '..') !== false) {
    header('Location: /?page=documentation');
    exit;
}

// Check if file exists
$filePath = $_SERVER['DOCUMENT_ROOT'] . '/documentation/' . $file;
if (!file_exists($filePath)) {
    header('Location: /?page=documentation');
    exit;
}

// Format filename to readable title
function formatDocTitle($filename) {
    $title = str_replace('.md', '', $filename);
    $title = str_replace('README-', '', $title);
    $title = str_replace('-', ' ', $title);
    $title = ucwords(strtolower($title));
    return $title;
}

$pageTitle = formatDocTitle($file);

// Set page metadata
set_page_meta([
    'title' => $pageTitle . ' Documentation',
    'description' => 'Documentation for ' . $pageTitle . ' in OnePage CMS.',
    'url' => SITE_URL . '/?page=docs&file=' . urlencode($file),
    'type' => 'article'
]);
?>
<article class="page-content documentation-page">
    <div class="doc-header">
        <a href="/?page=documentation" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Documentation
        </a>
    </div>
    
    <?php
    // Display the markdown content using the markdown block
    echo block_markdown('documentation/' . $file);
    ?>
    
    <div class="doc-footer">
        <a href="/?page=documentation" class="btn">Back to Documentation</a>
    </div>
</article>

<style>
.documentation-page {
    max-width: 900px;
    margin: 0 auto;
}

.doc-header {
    margin-bottom: 2rem;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--color-primary, #007bff);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.back-link:hover {
    color: var(--color-primary-dark, #0056b3);
}

.back-link i {
    font-size: 0.9rem;
}

.doc-footer {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid var(--color-border, #e0e0e0);
}
</style>
