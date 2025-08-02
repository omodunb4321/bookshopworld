<?php
/**
 * Shopping Guide
 */
$page_title = 'Shopping Guide - Help';
require_once '../header.php';
?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="index.php">Help</a></li>
            <li class="breadcrumb-item active">Shopping Guide</li>
        </ol>
    </nav>
    
    <h1>Shopping Guide</h1>
    <p>How to buy books step by step</p>
    
    <div class="card mb-3">
        <div class="card-body">
            <h4>Step 1: Find Books</h4>
            <ul>
                <li><strong>Search:</strong> Use search box for title or author</li>
                <li><strong>Categories:</strong> Browse Fiction, Mystery, etc.</li>
                <li><strong>All Books:</strong> See complete catalog</li>
            </ul>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-body">
            <h4>Step 2: Add to Cart</h4>
            <ol>
                <li>Click book title to see details</li>
                <li>Choose format: Paperback 📖, Hardcover 📘, or E-book 📱</li>
                <li>Select quantity</li>
                <li>Click "Add to Cart"</li>
            </ol>
            <p><strong>Important:</strong> Must be logged in to add books.</p>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-body">
            <h4>Step 3: Review Cart</h4>
            <p>Click "Cart" to:</p>
            <ul>
                <li>See your books</li>
                <li>Change quantities</li>
                <li>Remove books</li>
                <li>See total price</li>
            </ul>
            <?php if (isLoggedIn()): ?>
                <a href="../cart.php" class="btn btn-warning">View My Cart</a>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-body">
            <h4>Step 4: Checkout</h4>
            <ol>
                <li>Click "Proceed to Checkout"</li>
                <li>Enter shipping address</li>
                <li>Review order</li>
                <li>Click "Place Order"</li>
            </ol>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <h4>Need Help?</h4>
            <p>Having problems? Check our <a href="troubleshooting.php">troubleshooting guide</a> or <a href="../contact.php">contact support</a>.</p>
        </div>
    </div>
</div>

<?php require_once '../footer.php'; ?>