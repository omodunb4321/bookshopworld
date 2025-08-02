<?php
/**
 * Troubleshooting Guide
 */
$page_title = 'Troubleshooting - Help';
require_once '../header.php';
?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="index.php">Help</a></li>
            <li class="breadcrumb-item active">Troubleshooting</li>
        </ol>
    </nav>
    
    <h1>Troubleshooting</h1>
    <p>Common problems and solutions</p>
    
    <div class="card mb-3">
        <div class="card-body">
            <h4>Login Problems</h4>
            
            <h6>Problem: Wrong username or password</h6>
            <p><strong>Solutions:</strong></p>
            <ul>
                <li>Check spelling</li>
                <li>Make sure Caps Lock is off</li>
                <li>Try using email instead of username</li>
                <li>Use test account: <code>testuser</code> / <code>test123</code></li>
            </ul>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-body">
            <h4>Cart Problems</h4>
            
            <h6>Problem: Can't add books to cart</h6>
            <p><strong>Solution:</strong> You must be logged in first.</p>
            
            <h6>Problem: Items disappear from cart</h6>
            <p><strong>Causes:</strong></p>
            <ul>
                <li>You logged out</li>
                <li>You set quantity to 0</li>
            </ul>
            
            <h6>Problem: Can't update quantities</h6>
            <p><strong>Solution:</strong> Change number and click "Update Cart"</p>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-body">
            <h4>Checkout Problems</h4>
            
            <h6>Problem: Cart is empty at checkout</h6>
            <p><strong>Solution:</strong> Add books to cart first</p>
            
            <h6>Problem: Must enter shipping address</h6>
            <p><strong>Solution:</strong> Enter any complete address</p>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-body">
            <h4>Search Problems</h4>
            
            <h6>Problem: No search results</h6>
            <p><strong>Try:</strong></p>
            <ul>
                <li>Check spelling</li>
                <li>Use fewer words</li>
                <li>Try author's last name only</li>
                <li>Search for genre like "mystery"</li>
            </ul>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-body">
            <h4>Common Questions</h4>
            
            <p><strong>Q: What are book formats?</strong><br>
            A: Paperback (soft cover), Hardcover (hard cover), E-book (digital)</p>
            
            <p><strong>Q: How do I change themes?</strong><br>
            A: Click "Theme" in navigation and pick one</p>
            
            <p><strong>Q: Can I use this on mobile?</strong><br>
            A: Yes, works on phones and tablets</p>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body text-center">
            <h4>Still Need Help?</h4>
            <a href="../contact.php" class="btn btn-primary">Contact Support</a>
        </div>
    </div>
</div>

<?php require_once '../footer.php'; ?>