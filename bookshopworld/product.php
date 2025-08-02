<?php
/**
 * Product Detail Page with book cover images
 * Shows individual book details with enhanced media
 */
require_once 'config.php';

// Get product ID
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$product_id) {
    showMessage('Product not found', 'danger');
    redirect('products.php');
}

// Get product details
$stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    showMessage('Product not found', 'danger');
    redirect('products.php');
}

$page_title = $product['title'] . ' - BookShop World';
$page_description = substr($product['description'], 0, 160) . '...';

require_once 'header.php';
?>

<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="products.php">Books</a></li>
            <li class="breadcrumb-item"><a href="category.php?id=<?php echo $product['category_id']; ?>"><?php echo htmlspecialchars($product['category_name']); ?></a></li>
            <li class="breadcrumb-item active"><?php echo htmlspecialchars($product['title']); ?></li>
        </ol>
    </nav>
    
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <?php if (file_exists("assets/images/book{$product['id']}.jpg")): ?>
                        <img src="assets/images/book<?php echo $product['id']; ?>.jpg" 
                             alt="<?php echo htmlspecialchars($product['title']); ?>" 
                             class="img-fluid mb-3 img-hover" 
                             style="max-height: 400px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    <?php else: ?>
                        <div class="product-image-placeholder bg-light rounded p-4 mb-3" style="height: 400px; display: flex; align-items: center; justify-content: center;">
                            <div class="text-muted">
                                <i class="fas fa-book fa-5x mb-3"></i>
                                <h5><?php echo htmlspecialchars($product['title']); ?></h5>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($product['is_featured']): ?>
                    <span class="badge bg-warning text-dark mb-2">
                        <i class="fas fa-star"></i> Featured
                    </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Product Details -->
        <div class="col-md-8">
            <h1 class="h2 mb-2"><?php echo htmlspecialchars($product['title']); ?></h1>
            <p class="h5 text-muted mb-3">by <?php echo htmlspecialchars($product['author']); ?></p>
            
            <div class="row mb-3">
                <div class="col-sm-6">
                    <p><strong>Category:</strong> 
                        <a href="category.php?id=<?php echo $product['category_id']; ?>" class="text-decoration-none">
                            <?php echo htmlspecialchars($product['category_name']); ?>
                        </a>
                    </p>
                </div>
                <div class="col-sm-6">
                    <p><strong>Price:</strong> 
                        <span class="h4 text-primary">$<?php echo number_format($product['price'], 2); ?></span>
                    </p>
                </div>
            </div>
            
            <!-- Description -->
            <div class="mb-4">
                <h5>Description</h5>
                <p class="text-muted"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            </div>
            
            <!-- Available Formats -->
            <div class="mb-4">
                <h6>Available Formats:</h6>
                <div class="btn-group" role="group" id="formatGroup">
                    <?php if ($product['paperback']): ?>
                    <input type="radio" class="btn-check" name="format" id="paperback" value="paperback" checked>
                    <label class="btn btn-outline-primary" for="paperback">
                        <i class="fas fa-book"></i> Paperback
                    </label>
                    <?php endif; ?>
                    
                    <?php if ($product['hardcover']): ?>
                    <input type="radio" class="btn-check" name="format" id="hardcover" value="hardcover">
                    <label class="btn btn-outline-primary" for="hardcover">
                        <i class="fas fa-book"></i> Hardcover
                    </label>
                    <?php endif; ?>
                    
                    <?php if ($product['ebook']): ?>
                    <input type="radio" class="btn-check" name="format" id="ebook" value="ebook">
                    <label class="btn btn-outline-primary" for="ebook">
                        <i class="fas fa-tablet-alt"></i> E-Book
                    </label>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Quantity and Add to Cart -->
            <?php if (isLoggedIn()): ?>
            <div class="row mb-4">
                <div class="col-sm-6">
                    <label for="quantity" class="form-label">Quantity:</label>
                    <select class="form-select" id="quantity">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-sm-6 d-flex align-items-end">
                    <button class="btn btn-primary btn-lg w-100" onclick="addToCartDetailed(<?php echo $product['id']; ?>)">
                        <i class="fas fa-cart-plus me-2"></i>Add to Cart
                    </button>
                </div>
            </div>
            <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> 
                <a href="login.php">Login</a> or <a href="register.php">register</a> to purchase this book.
            </div>
            <?php endif; ?>
            
            <!-- Action Buttons -->
            <div class="row">
                <div class="col-12">
                    <a href="products.php" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Back to Books
                    </a>
                    <a href="category.php?id=<?php echo $product['category_id']; ?>" class="btn btn-outline-primary">
                        More <?php echo htmlspecialchars($product['category_name']); ?> Books
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products with Images -->
    <div class="row mt-5">
        <div class="col-12">
            <h4>More Books You Might Like</h4>
        </div>
        
        <?php
        // Get related products from same category
        $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? AND id != ? ORDER BY RAND() LIMIT 4");
        $stmt->execute([$product['category_id'], $product_id]);
        $related_products = $stmt->fetchAll();
        
        foreach ($related_products as $related): ?>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card product-card h-100">
                <div class="card-body">
                    <!-- Related book image -->
                    <?php if (file_exists("assets/images/book{$related['id']}.jpg")): ?>
                        <img src="assets/images/book<?php echo $related['id']; ?>.jpg" 
                             alt="<?php echo htmlspecialchars($related['title']); ?>" 
                             class="img-fluid mb-2 img-hover" 
                             style="height: 120px; width: 100%; object-fit: cover; border-radius: 6px;">
                    <?php else: ?>
                        <div class="bg-light p-2 text-center mb-2" style="height: 120px; display: flex; align-items: center; justify-content: center; border-radius: 6px;">
                            <i class="fas fa-book fa-2x text-muted"></i>
                        </div>
                    <?php endif; ?>
                    
                    <h6 class="card-title">
                        <a href="product.php?id=<?php echo $related['id']; ?>" class="text-decoration-none">
                            <?php echo htmlspecialchars($related['title']); ?>
                        </a>
                    </h6>
                    <p class="card-text text-muted small">by <?php echo htmlspecialchars($related['author']); ?></p>
                    <p class="card-text"><?php echo htmlspecialchars(substr($related['description'], 0, 80)); ?>...</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-primary fw-bold">$<?php echo number_format($related['price'], 2); ?></span>
                        <a href="product.php?id=<?php echo $related['id']; ?>" class="btn btn-outline-primary btn-sm">
                            View
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
// Enhanced add to cart function with format and quantity
function addToCartDetailed(productId) {
    const format = document.querySelector('input[name="format"]:checked')?.value || 'paperback';
    const quantity = document.getElementById('quantity').value;
    
    // Play notification sound
    const audio = new Audio('assets/audio/notification.mp3');
    audio.play().catch(e => console.log('Could not play sound'));
    
    fetch('ajax/add-to-cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            product_id: productId,
            quantity: parseInt(quantity),
            format: format
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`Added ${quantity} ${format} book(s) to cart!`);
            // Update cart count if available
            if (data.cart_count) {
                const cartBadges = document.querySelectorAll('.cart-count');
                cartBadges.forEach(badge => badge.textContent = data.cart_count);
            }
        } else {
            alert('Error adding to cart: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding to cart');
    });
}
</script>

<?php require_once 'footer.php'; ?>