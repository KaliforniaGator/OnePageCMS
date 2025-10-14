<?php
/**
 * Blocks Showcase Page
 * Demonstrates all available block components
 */
?>
<article class="page-content">
    <h1>Blocks Showcase</h1>
    <p>This page demonstrates all available block components in OnePage CMS. Use these blocks to build beautiful, functional pages quickly.</p>
    
    <!-- Buttons -->
    <section style="margin: 3rem 0; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
        <h2>Buttons</h2>
        <p>Various button styles and sizes:</p>
        
        <h3>Button Types</h3>
        <?php
        echo block_button_group([
            ['text' => 'Primary', 'url' => '#', 'type' => 'primary'],
            ['text' => 'Secondary', 'url' => '#', 'type' => 'secondary'],
            ['text' => 'Success', 'url' => '#', 'type' => 'success'],
            ['text' => 'Danger', 'url' => '#', 'type' => 'danger'],
            ['text' => 'Outline', 'url' => '#', 'type' => 'outline']
        ]);
        ?>
        
        <h3 style="margin-top: 2rem;">Button Sizes</h3>
        <?php
        echo block_button_group([
            ['text' => 'Small', 'url' => '#', 'type' => 'primary', 'size' => 'small'],
            ['text' => 'Medium', 'url' => '#', 'type' => 'primary', 'size' => 'medium'],
            ['text' => 'Large', 'url' => '#', 'type' => 'primary', 'size' => 'large']
        ]);
        ?>
    </section>
    
    <!-- Lists -->
    <section style="margin: 3rem 0; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
        <h2>Lists</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div>
                <h3>Unordered List</h3>
                <?php
                echo block_list([
                    'First item',
                    'Second item',
                    'Third item with nested list' => [
                        'children' => ['Nested item 1', 'Nested item 2']
                    ]
                ]);
                ?>
            </div>
            
            <div>
                <h3>Ordered List</h3>
                <?php
                echo block_list([
                    'Step one',
                    'Step two',
                    'Step three'
                ], 'ol');
                ?>
            </div>
            
            <div>
                <h3>Static Checklist</h3>
                <?php
                echo block_checklist([
                    ['text' => 'Completed task', 'checked' => true],
                    ['text' => 'Another completed task', 'checked' => true],
                    ['text' => 'Pending task', 'checked' => false]
                ]);
                ?>
            </div>
        </div>
        
        <h3 style="margin-top: 2rem;">Interactive Checklist</h3>
        <?php
        echo block_checklist_interactive([
            ['text' => 'Task 1', 'checked' => false],
            ['text' => 'Task 2', 'checked' => true],
            ['text' => 'Task 3', 'checked' => false]
        ], 'tasks');
        ?>
    </section>
    
    <!-- Alerts -->
    <section style="margin: 3rem 0; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
        <h2>Alerts</h2>
        
        <h3>Alert Types</h3>
        <?php
        echo block_alert([
            'message' => 'This is an informational message.',
            'type' => 'info',
            'style' => 'inline'
        ]);
        echo block_alert([
            'message' => 'Success! Your action was completed.',
            'type' => 'success',
            'style' => 'inline'
        ]);
        echo block_alert([
            'message' => 'Warning: Please review this information.',
            'type' => 'warning',
            'style' => 'inline'
        ]);
        echo block_alert([
            'message' => 'Error: Something went wrong.',
            'type' => 'error',
            'style' => 'inline'
        ]);
        ?>
        
        <h3 style="margin-top: 2rem;">Alert with Title</h3>
        <?php
        echo block_alert([
            'title' => 'Important Notice',
            'message' => 'This alert has a title to draw more attention.',
            'type' => 'warning',
            'style' => 'inline'
        ]);
        ?>
        
        <h3 style="margin-top: 2rem;">Banner Alert</h3>
        <?php
        echo block_alert([
            'message' => 'This is a full-width banner alert.',
            'type' => 'info',
            'style' => 'banner'
        ]);
        ?>
        
        <h3 style="margin-top: 2rem;">Toast Notification (Click to trigger)</h3>
        <button class="btn btn-primary" onclick="showToastDemo()">Show Toast</button>
        
        <h3 style="margin-top: 2rem;">Popup Alert (Click to trigger)</h3>
        <button class="btn btn-secondary" onclick="showPopupDemo()">Show Popup</button>
    </section>
    
    <!-- Text Views -->
    <section style="margin: 3rem 0; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
        <h2>Text Views</h2>
        <p>Display different types of formatted text content:</p>
        
        <h3>Paragraph</h3>
        <?php
        echo block_textview('This is a regular paragraph with some text content.', 'paragraph');
        ?>
        
        <h3 style="margin-top: 2rem;">Heading</h3>
        <?php
        echo block_textview('Important Heading', 'heading', ['level' => 3]);
        ?>
        
        <h3 style="margin-top: 2rem;">Quote</h3>
        <?php
        echo block_textview('The only way to do great work is to love what you do.', 'quote', ['author' => 'Steve Jobs']);
        ?>
        
        <h3 style="margin-top: 2rem;">Code Block (JavaScript Example)</h3>
        <?php
        echo block_textview('function hello() {\n    console.log("Hello, World!");\n}', 'code', ['language' => 'javascript']);
        ?>
    </section>
    
    <!-- Cards & Grid -->
    <section style="margin: 3rem 0; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
        <h2>Cards & Grid</h2>
        <?php
        $cards = [
            block_card([
                'title' => 'Card Title 1',
                'content' => 'This is a sample card with some content. Cards are great for displaying grouped information.',
                'footer' => block_button('Learn More', '#', 'primary', 'small')
            ]),
            block_card([
                'title' => 'Card Title 2',
                'content' => 'Another card example with different content. You can customize cards with images, footers, and more.',
                'footer' => block_button('Read More', '#', 'secondary', 'small')
            ]),
            block_card([
                'title' => 'Card Title 3',
                'content' => 'Cards work great in grid layouts. They automatically adapt to different screen sizes.',
                'footer' => block_button('View Details', '#', 'success', 'small')
            ])
        ];
        
        echo block_grid($cards, 3, '1.5rem');
        ?>
    </section>
    
    <!-- Slider -->
    <section style="margin: 3rem 0; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
        <h2>Image Slider</h2>
        <?php
        echo block_slider([
            [
                'src' => 'https://placehold.co/800x400/3498db/ffffff?text=Slide+1',
                'alt' => 'Slide 1',
                'caption' => 'First slide caption'
            ],
            [
                'src' => 'https://placehold.co/800x400/2ecc71/ffffff?text=Slide+2',
                'alt' => 'Slide 2',
                'caption' => 'Second slide caption'
            ],
            [
                'src' => 'https://placehold.co/800x400/e74c3c/ffffff?text=Slide+3',
                'alt' => 'Slide 3',
                'caption' => 'Third slide caption'
            ]
        ], 'image', ['autoplay' => true, 'interval' => 3000]);
        ?>
    </section>
    
    <!-- Accordion -->
    <section style="margin: 3rem 0; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
        <h2>Accordion</h2>
        <?php
        echo block_accordion([
            [
                'title' => 'What is OnePage CMS?',
                'content' => 'OnePage CMS is a lightweight, flexible content management framework that makes it easy to build simple websites without the complexity of traditional CMSs.'
            ],
            [
                'title' => 'How do I use blocks?',
                'content' => 'Blocks are reusable PHP functions that generate HTML components. Simply call the block function with your desired parameters, and it will return the HTML markup.'
            ],
            [
                'title' => 'Can I customize blocks?',
                'content' => 'Yes! All blocks accept custom CSS classes and styling options. You can also modify the block PHP files directly to change their behavior.'
            ]
        ]);
        ?>
    </section>
    
    <!-- Tabs -->
    <section style="margin: 3rem 0; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
        <h2>Tabs</h2>
        <?php
        echo block_tabs([
            [
                'title' => 'Overview',
                'content' => '<p>This is the overview tab. Tabs are great for organizing related content in a compact space.</p>'
            ],
            [
                'title' => 'Features',
                'content' => '<ul><li>Easy to use</li><li>Fully customizable</li><li>Responsive design</li><li>No dependencies</li></ul>'
            ],
            [
                'title' => 'Documentation',
                'content' => '<p>Check out the block files in <code>framework-includes/blocks/</code> to see how each block is implemented.</p>'
            ]
        ]);
        ?>
    </section>
    
    <!-- Menu -->
    <section style="margin: 3rem 0; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
        <h2>Navigation Menu</h2>
        
        <h3>Simple Menu</h3>
        <?php
        echo block_menu([
            ['text' => 'Home', 'url' => '/', 'icon' => 'fas fa-home'],
            ['text' => 'About', 'url' => '/?page=about', 'icon' => 'fas fa-info-circle'],
            ['text' => 'Services', 'url' => '#', 'icon' => 'fas fa-briefcase', 'children' => [
                ['text' => 'Web Design', 'url' => '#'],
                ['text' => 'Development', 'url' => '#'],
                ['text' => 'Consulting', 'url' => '#']
            ]],
            ['text' => 'Blog', 'url' => '/?page=blog', 'icon' => 'fas fa-blog'],
            ['text' => 'Contact', 'url' => '/?page=contact', 'icon' => 'fas fa-envelope']
        ], 'horizontal', 'simple');
        ?>
        
        <h3 style="margin-top: 2rem;">Rounded Rectangle Menu</h3>
        <?php
        echo block_menu([
            ['text' => 'Home', 'url' => '/'],
            ['text' => 'About', 'url' => '/?page=about'],
            ['text' => 'Blog', 'url' => '/?page=blog'],
            ['text' => 'Contact', 'url' => '/?page=contact']
        ], 'horizontal', 'rounded-rect');
        ?>
        
        <h3 style="margin-top: 2rem;">Capsule Menu</h3>
        <?php
        echo block_menu([
            ['text' => 'Home', 'url' => '/'],
            ['text' => 'About', 'url' => '/?page=about'],
            ['text' => 'Blog', 'url' => '/?page=blog'],
            ['text' => 'Contact', 'url' => '/?page=contact']
        ], 'horizontal', 'capsule');
        ?>
        
        <h3 style="margin-top: 2rem;">Breadcrumb</h3>
        <?php
        echo block_breadcrumb([
            ['text' => 'Home', 'url' => '/'],
            ['text' => 'Pages', 'url' => '#'],
            ['text' => 'Blocks', 'url' => '']
        ]);
        ?>
    </section>
    
    <!-- Social Buttons -->
    <section style="margin: 3rem 0; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
        <h2>Social Buttons</h2>
        
        <h3>Icon Style</h3>
        <?php
        echo block_social_buttons([
            ['platform' => 'facebook', 'url' => 'https://facebook.com'],
            ['platform' => 'twitter', 'url' => 'https://twitter.com'],
            ['platform' => 'instagram', 'url' => 'https://instagram.com'],
            ['platform' => 'linkedin', 'url' => 'https://linkedin.com'],
            ['platform' => 'github', 'url' => 'https://github.com']
        ], 'icon', 'medium');
        ?>
        
        <h3 style="margin-top: 2rem;">Icon + Text Style</h3>
        <?php
        echo block_social_buttons([
            ['platform' => 'facebook', 'url' => 'https://facebook.com'],
            ['platform' => 'twitter', 'url' => 'https://twitter.com'],
            ['platform' => 'github', 'url' => 'https://github.com']
        ], 'both', 'medium');
        ?>
    </section>
    
    <!-- Form -->
    <section style="margin: 3rem 0; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
        <h2>Form</h2>
        <?php
        echo block_form([
            'action' => '#',
            'method' => 'POST',
            'submit_text' => 'Send Message',
            'fields' => [
                [
                    'type' => 'text',
                    'name' => 'name',
                    'label' => 'Your Name',
                    'placeholder' => 'John Doe',
                    'required' => true
                ],
                [
                    'type' => 'email',
                    'name' => 'email',
                    'label' => 'Email Address',
                    'placeholder' => 'john@example.com',
                    'required' => true
                ],
                [
                    'type' => 'select',
                    'name' => 'subject',
                    'label' => 'Subject',
                    'required' => true,
                    'options' => [
                        '' => 'Select a subject',
                        'general' => 'General Inquiry',
                        'support' => 'Technical Support',
                        'feedback' => 'Feedback'
                    ]
                ],
                [
                    'type' => 'textarea',
                    'name' => 'message',
                    'label' => 'Message',
                    'placeholder' => 'Your message here...',
                    'required' => true
                ],
                [
                    'type' => 'checkbox',
                    'name' => 'subscribe',
                    'label' => 'Subscribe to newsletter'
                ]
            ]
        ]);
        ?>
    </section>
    
    <!-- Hero & CTA -->
    <section style="margin: 3rem 0; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
        <h2>Hero & Call to Action</h2>
        
        <h3>Default Hero with Image Background</h3>
        <?php
        echo block_hero([
            'title' => 'Welcome to OnePage CMS',
            'subtitle' => 'Build beautiful websites with ease',
            'background' => 'https://placehold.co/1200x500/2c3e50/ffffff?text=Hero+Background',
            'type' => 'default',
            'overlay' => 0.4,
            'height' => '400px',
            'alignment' => 'center',
            'buttons' => [
                ['text' => 'Get Started', 'url' => '#', 'type' => 'primary'],
                ['text' => 'Learn More', 'url' => '#', 'type' => 'outline']
            ]
        ]);
        ?>
        
        <h3 style="margin-top: 2rem;">Gradient Hero</h3>
        <?php
        echo block_hero([
            'title' => 'Modern Gradient Design',
            'subtitle' => 'Eye-catching animated gradients',
            'type' => 'gradient',
            'gradient' => 'ocean',
            'height' => '400px',
            'alignment' => 'center',
            'buttons' => [
                ['text' => 'Explore', 'url' => '#', 'type' => 'primary']
            ]
        ]);
        ?>
        
        <h3 style="margin-top: 2rem;">Split Hero</h3>
        <?php
        echo block_hero([
            'title' => 'Split Layout Hero',
            'subtitle' => 'Perfect for showcasing products or services',
            'type' => 'split',
            'image' => 'https://placehold.co/600x500/3498db/ffffff?text=Product+Image',
            'height' => '500px',
            'buttons' => [
                ['text' => 'Learn More', 'url' => '#', 'type' => 'primary']
            ]
        ]);
        ?>
        
        <h3 style="margin-top: 2rem;">Minimal Hero</h3>
        <?php
        echo block_hero([
            'title' => 'Clean & Minimal',
            'subtitle' => 'Sometimes less is more',
            'type' => 'minimal',
            'height' => '300px',
            'alignment' => 'center',
            'buttons' => [
                ['text' => 'Get Started', 'url' => '#', 'type' => 'primary']
            ]
        ]);
        ?>
        
        <h3 style="margin-top: 2rem;">Call to Action</h3>
        <?php
        echo block_cta(
            'Ready to Get Started?',
            'Join thousands of users who are already building amazing websites with OnePage CMS.',
            ['text' => 'Start Building', 'url' => '#', 'type' => 'primary'],
            'gradient'
        );
        ?>
    </section>
    
    <!-- Media -->
    <section style="margin: 3rem 0; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
        <h2>Media</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div>
                <h3>Image with Caption</h3>
                <?php
                echo block_image(
                    'https://placehold.co/400x300/3498db/ffffff?text=Sample+Image',
                    'Sample image',
                    'This is a sample image with a caption',
                    '',
                    'medium'
                );
                ?>
            </div>
            
            <div>
                <h3>Font Awesome Icons</h3>
                <p style="font-size: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                    <?php
                    echo block_icon('fas fa-home', 'large', '', '#3498db');
                    echo block_icon('fas fa-envelope', 'large', '', '#e74c3c');
                    echo block_icon('fas fa-mobile-alt', 'large', '', '#2ecc71');
                    echo block_icon('fas fa-cog', 'large', '', '#f39c12');
                    echo block_icon('fas fa-heart', 'large', '', '#e91e63');
                    echo block_icon('fas fa-star', 'large', '', '#ffc107');
                    echo block_icon('fas fa-user', 'large', '', '#9c27b0');
                    echo block_icon('fas fa-shopping-cart', 'large', '', '#ff5722');
                    ?>
                </p>
            </div>
        </div>
    </section>
    
    <!-- Usage Instructions -->
    <section style="margin: 3rem 0; padding: 2rem; background: #e8f4f8; border-radius: 8px; border-left: 4px solid #3498db;">
        <h2>How to Use Blocks</h2>
        <p>To use any block in your pages, simply call the block function with the appropriate parameters:</p>
        
        <?php
        echo block_textview('<?php
// Example: Create a button
echo block_button("Click Me", "/page", "primary", "large");

// Example: Create a card
echo block_card([
    "title" => "My Card",
    "content" => "Card content here",
    "footer" => "Card footer"
]);

// Example: Create a form
echo block_form([
    "action" => "/submit",
    "fields" => [
        ["type" => "text", "name" => "name", "label" => "Name"]
    ]
]);
?>', 'code', ['language' => 'php']);
        ?>
        
        <p style="margin-top: 1rem;">All block functions are automatically loaded and available in any page. Check the files in <code>framework/framework-includes/blocks/</code> to see all available parameters for each block.</p>
    </section>
    
    <p style="margin-top: 2rem;"><a href="/" class="btn btn-primary">Back to Home</a></p>
</article>

<script>
function showToastDemo() {
    // Create toast alert dynamically
    var alertHtml = <?php echo json_encode(block_alert([
        'message' => 'This is a toast notification!',
        'type' => 'success',
        'style' => 'toast',
        'position' => 'top-right',
        'duration' => 5000
    ])); ?>;
    
    var tempDiv = document.createElement('div');
    tempDiv.innerHTML = alertHtml;
    document.body.appendChild(tempDiv.firstChild);
}

function showPopupDemo() {
    // Create popup alert dynamically
    var alertHtml = <?php echo json_encode(block_alert([
        'title' => 'Popup Alert',
        'message' => 'This is a popup alert that appears in the center.',
        'type' => 'warning',
        'style' => 'popup',
        'position' => 'top-center'
    ])); ?>;
    
    var tempDiv = document.createElement('div');
    tempDiv.innerHTML = alertHtml;
    document.body.appendChild(tempDiv.firstChild);
}
</script>
