<?php
/**
 * Blog Index Page
 * Example of a page in a subdirectory
 */

// Set page metadata
set_page_meta([
    'title' => 'Blog',
    'description' => 'Read our blog about OnePage CMS - a lightweight, flexible content management framework designed for developers.',
    'url' => SITE_URL . '/?page=blog',
    'type' => 'website'
]);

// Sample blog posts (no database required)
$posts = [
    [
        'title' => 'Getting Started with OnePage CMS',
        'content' => 'Welcome to our blog! This is a sample post to demonstrate the blog functionality. OnePage CMS is a lightweight framework that makes it easy to build simple websites without the complexity of traditional CMSs.',
        'author' => 'Admin',
        'created_at' => '2024-10-01 10:00:00'
    ],
    [
        'title' => 'Building Your First Page',
        'content' => 'Learn how to create custom pages in the pages directory. Simply create a new PHP file in the pages folder, and it will automatically be accessible through the page parameter in the URL.',
        'author' => 'Admin',
        'created_at' => '2024-10-05 14:30:00'
    ],
    [
        'title' => 'Working with Subdirectories',
        'content' => 'You can organize your pages into subdirectories for better structure. This blog page is a perfect example - it lives in pages/blog/index.php and is accessible via ?page=blog.',
        'author' => 'Admin',
        'created_at' => '2024-10-10 09:15:00'
    ]
];
?>
<article class="page-content">
    <h1>Blog</h1>
    
    <p>Welcome to our blog! Here you'll find articles, tutorials, and updates about WindSurf CMS.</p>
    
    <?php if (!empty($posts)): ?>
        <div class="blog-posts" style="margin-top: 2rem;">
            <?php foreach ($posts as $post): ?>
                <article class="blog-post" style="margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #eee;">
                    <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                    <div class="post-meta" style="color: #666; font-size: 0.9rem; margin-bottom: 1rem;">
                        By <?php echo htmlspecialchars($post['author']); ?> | 
                        <?php echo date('F j, Y', strtotime($post['created_at'])); ?>
                    </div>
                    <div class="post-content">
                        <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No blog posts found.</p>
    <?php endif; ?>
    
    <p style="margin-top: 2rem;"><a href="/" class="btn">Back to Home</a></p>
</article>
