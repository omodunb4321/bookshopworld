<?php
/**
 * About Page with team images and media
 */
$page_title = 'About Us - BookShop World';
require_once 'config.php';
require_once 'header.php';

// Get book count
$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM products");
$stmt->execute();
$total_books = $stmt->fetch()['total'];
?>

<div class="container mt-4">
    <!-- Header with team image -->
    <div class="text-center mb-4">
        <img src="assets/images/about-team.jpg" alt="BookShop World Team" 
             class="img-fluid rounded mb-3" style="max-height: 300px; width: 100%; object-fit: cover;">
        <h1><i class="fas fa-book-open text-primary me-2"></i>About BookShop World</h1>
        <p class="lead">Your online destination for books</p>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-6">
            <h3>Who We Are</h3>
            <p>BookShop World is an online bookstore that makes it easy to find and buy books. We have a wide selection of books in many different categories.</p>
            
            <p>Our goal is simple: help you find great books at good prices with an easy shopping experience.</p>
            
            <!-- Reading images -->
            <div class="row mt-3">
                <div class="col-6">
                    <img src="assets/images/reading1.jpg" alt="Reading" 
                         class="img-fluid rounded" style="height: 120px; width: 100%; object-fit: cover;">
                </div>
                <div class="col-6">
                    <img src="assets/images/reading2.jpg" alt="Bookshelf" 
                         class="img-fluid rounded" style="height: 120px; width: 100%; object-fit: cover;">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h3>What We Offer</h3>
            <ul>
                <li><?php echo $total_books; ?>+ books available</li>
                <li>Multiple book formats</li>
                <li>Easy search and browsing</li>
                <li>Simple checkout process</li>
                <li>Customer support</li>
            </ul>
            
            <!-- Logo -->
            <div class="text-center mt-3">
                <img src="assets/images/logo.png" alt="BookShop World Logo" 
                     class="img-fluid" style="max-height: 150px;">
            </div>
        </div>
    </div>
    
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <i class="fas fa-books fa-3x text-primary mb-2"></i>
            <h4>📚 Wide Selection</h4>
            <p>Fiction, mystery, romance, and more</p>
        </div>
        <div class="col-md-4">
            <i class="fas fa-shopping-cart fa-3x text-success mb-2"></i>
            <h4>🛒 Easy Shopping</h4>
            <p>Simple cart and checkout process</p>
        </div>
        <div class="col-md-4">
            <i class="fas fa-headset fa-3x text-info mb-2"></i>
            <h4>💬 Great Support</h4>
            <p>Help when you need it</p>
        </div>
    </div>
    
    <div class="text-center">
        <a href="products.php" class="btn btn-primary me-2">
            <i class="fas fa-book me-1"></i>Browse Books
        </a>
        <a href="contact.php" class="btn btn-outline-primary">
            <i class="fas fa-envelope me-1"></i>Contact Us
        </a>
    </div>
</div>

<?php require_once 'footer.php'; ?>