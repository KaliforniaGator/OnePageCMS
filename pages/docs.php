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

/* Markdown content styling */
.block-markdown {
    line-height: 1.7;
}

.block-markdown h1 {
    font-size: 2.5rem;
    margin-top: 0;
    margin-bottom: 1.5rem;
    color: var(--color-heading, #222);
    border-bottom: 2px solid var(--color-border, #e0e0e0);
    padding-bottom: 0.5rem;
}

.block-markdown h2 {
    font-size: 2rem;
    margin-top: 2.5rem;
    margin-bottom: 1rem;
    color: var(--color-heading, #222);
}

.block-markdown h3 {
    font-size: 1.5rem;
    margin-top: 2rem;
    margin-bottom: 0.75rem;
    color: var(--color-heading, #333);
}

.block-markdown h4 {
    font-size: 1.25rem;
    margin-top: 1.5rem;
    margin-bottom: 0.5rem;
    color: var(--color-heading, #333);
}

.block-markdown h5,
.block-markdown h6 {
    font-size: 1.1rem;
    margin-top: 1.25rem;
    margin-bottom: 0.5rem;
    color: var(--color-heading, #444);
}

.block-markdown p {
    margin-bottom: 1rem;
}

.block-markdown ul,
.block-markdown ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}

.block-markdown li {
    margin-bottom: 0.5rem;
}

.block-markdown code {
    background: var(--color-code-bg, #f5f5f5);
    padding: 0.2rem 0.4rem;
    border-radius: 3px;
    font-family: 'Courier New', Courier, monospace;
    font-size: 0.9em;
    color: var(--color-code, #d63384);
}

.block-markdown pre {
    background: var(--color-code-bg, #f5f5f5);
    padding: 1rem;
    border-radius: 6px;
    overflow-x: auto;
    margin-bottom: 1rem;
    border: 1px solid var(--color-border, #e0e0e0);
}

.block-markdown pre code {
    background: none;
    padding: 0;
    color: var(--color-text, #333);
    font-size: 0.9rem;
}

.block-markdown blockquote {
    border-left: 4px solid var(--color-primary, #007bff);
    padding-left: 1rem;
    margin: 1.5rem 0;
    color: var(--color-text-muted, #666);
    font-style: italic;
}

.block-markdown a {
    color: var(--color-primary, #007bff);
    text-decoration: none;
}

.block-markdown a:hover {
    text-decoration: underline;
}

.block-markdown img {
    max-width: 100%;
    height: auto;
    border-radius: 6px;
    margin: 1rem 0;
}

.block-markdown hr {
    border: none;
    border-top: 1px solid var(--color-border, #e0e0e0);
    margin: 2rem 0;
}

.block-markdown table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 1rem;
}

.block-markdown table th,
.block-markdown table td {
    padding: 0.75rem;
    border: 1px solid var(--color-border, #e0e0e0);
    text-align: left;
}

.block-markdown table th {
    background: var(--color-surface, #f5f5f5);
    font-weight: 600;
}

.block-markdown .error {
    color: var(--color-error, #dc3545);
    background: var(--color-error-bg, #f8d7da);
    padding: 1rem;
    border-radius: 6px;
    border: 1px solid var(--color-error, #dc3545);
}
</style>
