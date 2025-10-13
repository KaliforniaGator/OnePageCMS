<?php
/**
 * Contact Page
 */

// Set page metadata
set_page_meta([
    'title' => 'Contact Us',
    'description' => 'Contact OnePage CMS - a lightweight, flexible content management framework designed for developers.',
    'url' => SITE_URL . '/?page=contact',
    'type' => 'website'
]);

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $subject = htmlspecialchars($_POST['subject'] ?? '');
    $messageText = htmlspecialchars($_POST['message'] ?? '');
    
    if (!empty($name) && !empty($email) && !empty($messageText)) {
        // Here you would typically save to database or send an email
        // For demo purposes, we'll just show a success message
        $message = block_alert([
            'message' => 'Thank you for your message! We will get back to you soon.',
            'type' => 'success',
            'style' => 'inline'
        ]);
    } else {
        $message = block_alert([
            'message' => 'Please fill in all required fields.',
            'type' => 'error',
            'style' => 'inline'
        ]);
    }
}
?>
<article class="page-content">
    <h1>Contact Us</h1>
    
    <p>Have a question or want to get in touch? Fill out the form below and we'll get back to you as soon as possible.</p>
    
    <?php echo $message; ?>
    
    <?php echo block_form([
        'action' => '/?page=contact',
        'method' => 'POST',
        'fields' => [
            [
                'type' => 'text',
                'name' => 'name',
                'label' => 'Name',
                'required' => true,
                'placeholder' => 'Your name'
            ],
            [
                'type' => 'email',
                'name' => 'email',
                'label' => 'Email',
                'required' => true,
                'placeholder' => 'your.email@example.com'
            ],
            [
                'type' => 'text',
                'name' => 'subject',
                'label' => 'Subject',
                'placeholder' => 'What is this about?'
            ],
            [
                'type' => 'textarea',
                'name' => 'message',
                'label' => 'Message',
                'required' => true,
                'placeholder' => 'Your message here...'
            ],
            [
                'type' => 'hidden',
                'name' => 'contact_submit',
                'value' => '1'
            ]
        ],
        'submit_text' => 'Send Message'
    ]); ?>
</article>
