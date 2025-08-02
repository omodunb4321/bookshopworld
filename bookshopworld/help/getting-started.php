<?php
/**
 * Getting Started Guide
 */
$page_title = 'Getting Started - Help';
require_once '../header.php';
?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="index.php">Help</a></li>
            <li class="breadcrumb-item active">Getting Started</li>
        </ol>
    </nav>
    
    <h1>Getting Started</h1>
    <p>Learn how to use BookShop World</p>
    
    <div class="card mb-3">
        <div class="card-body">
            <h4>1. Browse Books</h4>
            <p>Find books by:</p>
            <ul>
                <li>Click "All Books" to see everything</li>
                <li>Use the search box for specific books</li>
                <li>Browse categories like Fiction or Mystery</li>
            </ul>
            <a href="../products.php" class="btn btn-primary">Browse Books</a>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-body">
            <h4>2. Create Account</h4>
            <p>You need an account to buy books:</p>
            <ol>
                <li>Click "Sign Up"</li>
                <li>Fill in your information</li>
                <li>Click "Create Account"</li>
            </ol>
            <?php if (!isLoggedIn()): ?>
                <a href="../register.php" class="btn btn-success">Create Account</a>
            <?php else: ?>
                <p class="text-success">✓ You're already logged in!</p>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-body">
            <h4>3. Add Books to Cart</h4>
            <ol>
                <li>Click on a book title</li>
                <li>Choose format (paperback, hardcover, ebook)</li>
                <li>Click "Add to Cart"</li>
            </ol>
            <p><strong>Note:</strong> You must be logged in to add books.</p>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-body">
            <h4>4. Checkout</h4>
            <ol>
                <li>Click "Cart" to review your books</li>
                <li>Click "Proceed to Checkout"</li>
                <li>Enter shipping address</li>
                <li>Click "Place Order"</li>
            </ol>
        </div>
    </div>
    
    <div class="text-center">
        <a href="shopping-guide.php" class="btn btn-outline-primary me-2">Shopping Guide</a>
        <a href="../contact.php" class="btn btn-outline-secondary">Contact Us</a>
    </div>
</div>

<?php require_once '../footer.php'; ?>