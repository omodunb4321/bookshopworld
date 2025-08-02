<?php
/**
 * Homepage with images in root folder (simple fix)
 */
$page_title = 'BookShop World - Online Bookstore';
require_once 'header.php';

// Get featured books
$stmt = $pdo->prepare("SELECT * FROM products WHERE is_featured = 1 LIMIT 6");
$stmt->execute();
$featured_books = $stmt->fetchAll();

// Get categories
$stmt = $pdo->prepare("SELECT * FROM categories");
$stmt->execute();
$categories = $stmt->fetchAll();
?>

<div class="container mt-4">
    <!-- Hero section -->
    <div class="jumbotron bg-primary text-white p-5 rounded mb-4">
        <h1>Welcome to BookShop World</h1>
        <p class="lead">Find great books at great prices!</p>
        <a href="products.php" class="btn btn-warning btn-lg">Shop Now</a>
    </div>
    
    <!-- Featured books -->
    <?php if (!empty($featured_books)): ?>
    <h3>Featured Books</h3>
    <div class="row">
        <?php foreach ($featured_books as $book): ?>
        <div class="col-md-4 mb-4">
            <div class="book-card">
                <!-- Try multiple image paths -->
                <div style="height: 250px; overflow: hidden; border-radius: 8px; margin-bottom: 15px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                    <!-- Try assets path first -->
                    <img src="assets/images/book<?php echo $book['id']; ?>.jpg" 
                         alt="<?php echo htmlspecialchars($book['title']); ?>" 
                         style="width: 100%; height: 100%; object-fit: cover; display: block;"
                         onerror="this.onerror=null; this.src='book<?php echo $book['id']; ?>.jpg';"
                         onload="this.style.display='block';">
                    
                    <!-- Fallback content -->
                    <div style="text-align: center; color: #666;">
                        <i class="fas fa-book fa-3x mb-2"></i><br>
                        <small><?php echo htmlspecialchars($book['title']); ?></small>
                    </div>
                </div>
                
                <h5><?php echo htmlspecialchars($book['title']); ?></h5>
                <p><strong>by <?php echo htmlspecialchars($book['author']); ?></strong></p>
                <p><?php echo htmlspecialchars(substr($book['description'], 0, 100)); ?>...</p>
                <p><strong>Price: $<?php echo number_format($book['price'], 2); ?></strong></p>
                
                <div class="d-flex gap-2">
                    <a href="product.php?id=<?php echo $book['id']; ?>" class="btn btn-outline-primary btn-sm">View Details</a>
                    <?php if (isLoggedIn()): ?>
                    <button class="btn btn-primary btn-sm" onclick="addToCart(<?php echo $book['id']; ?>)">
                        Add to Cart
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    
    <!-- Video section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h3>Welcome to Our Store</h3>
            <video controls class="img-fluid rounded" style="max-width: 600px; max-height: 400px;">
                <source src="assets/videos/welcome-video.mp4" type="video/mp4">
                <source src="welcome-video.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
    
    <!-- Categories -->
    <h3>Browse Categories</h3>
    <div class="row">
        <?php foreach ($categories as $category): ?>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6><?php echo htmlspecialchars($category['name']); ?></h6>
                    <a href="category.php?id=<?php echo $category['id']; ?>" class="btn btn-outline-primary btn-sm">
                        Browse Books
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Info section -->
    <div class="row mt-5">
        <div class="col-md-4 text-center">
            <h4>📚 Books</h4>
            <h6>Lots of Books</h6>
            <p>We have many books in different categories.</p>
        </div>
        <div class="col-md-4 text-center">
            <h4>🚚 Shipping</h4>
            <h6>Fast Shipping</h6>
            <p>We ship your books quickly and safely.</p>
        </div>
        <div class="col-md-4 text-center">
            <h4>💬 Service</h4>
            <h6>Great Service</h6>
            <p>Our team is here to help you find great books.</p>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>