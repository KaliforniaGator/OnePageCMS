<header class="site-header">
    <div class="container">
        <?php echo block_logo([
            'image' => '/assets/favicon/apple-touch-icon.png',
            'text' => SITE_TITLE,
            'alt' => SITE_TITLE,
            'width' => '54px',
            'height' => '54px',
            'link' => '/',
            'class' => 'site-logo'
        ]); ?>
        <p class="site-description"><?php echo SITE_DESCRIPTION; ?></p>
        
        <nav class="main-nav">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/?page=about">About</a></li>
                <li><a href="/?page=blocks">Blocks</a></li>
                <li><a href="/?page=docs">Documentation</a></li>
                <li><a href="/?page=blog">Blog</a></li>
                <li><a href="/?page=contact">Contact</a></li>
            </ul>
        </nav>
    </div>
</header>
