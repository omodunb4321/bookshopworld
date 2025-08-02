<?php
/**
 * Contact Page with background image
 */
$page_title = 'Contact Us - BookShop World';
require_once 'config.php';
require_once 'header.php';

// Handle contact form
if ($_POST && isset($_POST['send_message'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);
    
    if (!empty($name) && !empty($email) && !empty($message)) {
        showMessage('Thank you for your message! We will get back to you soon.', 'success');
        redirect('contact.php');
    } else {
        showMessage('Please fill in all fields.', 'danger');
    }
}
?>

<div class="container mt-4">
    <!-- Header with background -->
    <div class="text-center mb-4 p-5 rounded" 
         style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('assets/images/contact-bg.jpg'); 
                background-size: cover; background-position: center; color: white;">
        <h1><i class="fas fa-envelope me-2"></i>Contact Us</h1>
        <p class="lead">Get in touch with our support team</p>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4>Send us a message</h4>
                    <form method="POST">
                        <div class="mb-3">
                            <label>Your Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label>Message</label>
                            <textarea class="form-control" name="message" rows="4" 
                                      placeholder="How can we help you?" required></textarea>
                        </div>
                        
                        <button type="submit" name="send_message" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Team image -->
            <div class="mb-3">
                <img src="assets/images/about-team.jpg" alt="Our Team" class="img-fluid rounded">
            </div>
            
            <h4>Contact Info</h4>
            
            <div class="mb-3">
                <strong>📧 Email</strong><br>
                support@bookshopworld.com
            </div>
            
            <div class="mb-3">
                <strong>📞 Phone</strong><br>
                +1 (555) BOOKS-1
            </div>
            
            <div class="mb-3">
                <strong>🕐 Hours</strong><br>
                Monday - Friday<br>
                9 AM - 6 PM
            </div>
            
            <div class="mb-3">
                <strong>❓ Need Help?</strong><br>
                <a href="help/" class="btn btn-outline-primary btn-sm">Help Center</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>