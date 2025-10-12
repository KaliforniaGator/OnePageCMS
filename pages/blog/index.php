<?php
/**
 * Blog Index Page
 * Example of a page in a subdirectory
 */

// Get database instance
$db = db();

// Create blog posts table if it doesn't exist
if (!$db->tableExists(DB_PREFIX . 'blog_posts')) {
    $db->addTable(DB_PREFIX . 'blog_posts', [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'title' => 'VARCHAR(255) NOT NULL',
        'content' => 'TEXT',
        'author' => 'VARCHAR(100)',
        'status' => 'VARCHAR(20) DEFAULT "published"',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ]);
    
    // Insert sample posts
    $db->insert(DB_PREFIX . 'blog_posts', [
        'title' => 'Getting Started with WindSurf CMS',
        'content' => 'Welcome to our blog! This is a sample post to demonstrate the blog functionality.',
        'author' => 'Admin',
        'status' => 'published'
    ]);
    
    $db->insert(DB_PREFIX . 'blog_posts', [
        'title' => 'Building Your First Page',
        'content' => 'Learn how to create custom pages in the pages directory.',
        'author' => 'Admin',
        'status' => 'published'
    ]);
}

// Get all published blog posts
$posts = $db->getResults(
    "SELECT * FROM " . DB_PREFIX . "blog_posts WHERE status = 'published' ORDER BY created_at DESC"
);
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
