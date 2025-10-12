<?php
/**
 * Contact Page
 */

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
        $message = '<div class="success-message">Thank you for your message! We will get back to you soon.</div>';
    } else {
        $message = '<div class="error-message">Please fill in all required fields.</div>';
    }
}
?>
<article class="page-content">
    <h1>Contact Us</h1>
    
    <p>Have a question or want to get in touch? Fill out the form below and we'll get back to you as soon as possible.</p>
    
    <?php echo $message; ?>
    
    <form method="POST" action="/?page=contact" id="contactForm" style="margin-top: 2rem;">
        <div style="margin-bottom: 1rem;">
            <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Name *</label>
            <input type="text" id="name" name="name" required 
                   style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Email *</label>
            <input type="email" id="email" name="email" required 
                   style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label for="subject" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Subject</label>
            <input type="text" id="subject" name="subject" 
                   style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label for="message" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Message *</label>
            <textarea id="message" name="message" rows="6" required 
                      style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; resize: vertical;"></textarea>
        </div>
        
        <button type="submit" name="contact_submit" class="btn">Send Message</button>
    </form>
    
    <style>
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            border: 1px solid #c3e6cb;
        }
        
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            border: 1px solid #f5c6cb;
        }
    </style>
</article>
