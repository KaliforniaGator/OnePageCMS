<?php
/**
 * Head Template
 * Dynamically generates meta tags based on page metadata
 */

// Default metadata
$defaultTitle = SITE_TITLE;
$defaultDescription = SITE_DESCRIPTION;
$defaultUrl = SITE_URL;
$defaultImage = SITE_URL . '/assets/default-og-image.jpg'; // You can add a default image

// Get page metadata if set
$pageTitle = isset($page_meta['title']) ? $page_meta['title'] : '';
$pageDescription = isset($page_meta['description']) ? $page_meta['description'] : $defaultDescription;
$pageUrl = isset($page_meta['url']) ? $page_meta['url'] : $defaultUrl;
$pageImage = isset($page_meta['image']) ? $page_meta['image'] : $defaultImage;
$pageType = isset($page_meta['type']) ? $page_meta['type'] : 'website';
$pageAuthor = isset($page_meta['author']) ? $page_meta['author'] : '';
$pageKeywords = isset($page_meta['keywords']) ? $page_meta['keywords'] : '';

// Build full title
$fullTitle = $pageTitle ? "$defaultTitle | $pageTitle" : $defaultTitle;
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($fullTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <?php if ($pageKeywords): ?>
    <meta name="keywords" content="<?php echo htmlspecialchars($pageKeywords); ?>">
    <?php endif; ?>
    <?php if ($pageAuthor): ?>
    <meta name="author" content="<?php echo htmlspecialchars($pageAuthor); ?>">
    <?php endif; ?>
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="<?php echo htmlspecialchars($pageType); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($pageUrl); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($fullTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($pageImage); ?>">
    <meta property="og:site_name" content="<?php echo htmlspecialchars($defaultTitle); ?>">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo htmlspecialchars($pageUrl); ?>">
    <meta property="twitter:title" content="<?php echo htmlspecialchars($fullTitle); ?>">
    <meta property="twitter:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta property="twitter:image" content="<?php echo htmlspecialchars($pageImage); ?>">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo htmlspecialchars($pageUrl); ?>">
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">
    
    <!-- Framework Styles -->
    <link rel="stylesheet" href="/framework-styles/reset.css">
    <link rel="stylesheet" href="/framework-styles/theme.css">
    <link rel="stylesheet" href="/framework-styles/layout.css">
    <link rel="stylesheet" href="/framework-styles/blocks.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- User Styles -->
    <link rel="stylesheet" href="/user-styles/main.css">
    
    <?php
    // Allow pages to add custom head content
    if (isset($page_meta['custom_head'])) {
        echo $page_meta['custom_head'];
    }
    ?>
</head>
