<?php
/**
 * All Products Page with book cover images
 * Displays all books with search and category filtering
 */
$page_title = 'All Books - BookShop World';
require_once 'header.php';

// Search and category filter
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = isset($_GET['category']) ? (int)$_GET['category'] : 0;

// Build query
$where_conditions = [];
$params = [];

if ($category > 0) {
    $where_conditions[] = "p.category_id = ?";
    $params[] = $category;
}

if (!empty($search)) {
    $where_conditions[] = "(p.title LIKE ? OR p.author LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";

// Get products
$sql = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id $where_clause ORDER BY p.title";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Get categories for filter
$stmt = $pdo->prepare("SELECT * FROM categories ORDER BY name");
$stmt->execute();
$categories = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2>All Books</h2>
    <p>We have <?php echo count($products); ?> books available.</p>
    
    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="search" 
                           value="<?php echo htmlspecialchars($search); ?>" 
                           placeholder="Search by title or author...">
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="category">
                        <option value="0">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo $category == $cat['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Product grid with images -->
    <?php if (!empty($products)): ?>
    <div class="row">
        <?php foreach ($products as $product): ?>
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="book-card h-100">
                <!-- Book cover image -->
                <?php if (file_exists("assets/images/book{$product['id']}.jpg")): ?>
                    <img src="assets/images/book<?php echo $product['id']; ?>.jpg" 
                         alt="<?php echo htmlspecialchars($product['title']); ?>" 
                         class="img-fluid mb-3 img-hover" 
                         style="height: 200px; width: 100%; object-fit: cover; border-radius: 8px;">
                <?php else: ?>
                    <div class="bg-light p-3 text-center mb-3" style="height: 200px; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                        <div>
                            <i class="fas fa-book fa-3x text-muted mb-2"></i>
                            <br><small class="text-muted"><?php echo htmlspecialchars($product['title']); ?></small>
                        </div>
                    </div>
                <?php endif; ?>
                
                <h5><?php echo htmlspecialchars($product['title']); ?></h5>
                <p><strong>by <?php echo htmlspecialchars($product['author']); ?></strong></p>
                <p><small class="text-muted"><?php echo htmlspecialchars($product['category_name']); ?></small></p>
                <p><?php echo htmlspecialchars(substr($product['description'], 0, 100)); ?>...</p>
                
                <p><strong>Formats:</strong>
                    <?php if ($product['paperback']): ?><span class="badge bg-secondary">Paperback</span> <?php endif; ?>
                    <?php if ($product['hardcover']): ?><span class="badge bg-secondary">Hardcover</span> <?php endif; ?>
                    <?php if ($product['ebook']): ?><span class="badge bg-secondary">E-Book</span> <?php endif; ?>
                </p>
                
                <div class="mt-auto">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="text-primary">$<?php echo number_format($product['price'], 2); ?></strong>
                        <div>
                            <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-primary btn-sm">View</a>
                            <?php if (isLoggedIn()): ?>
                            <button class="btn btn-primary btn-sm add-to-cart-btn" data-product-id="<?php echo $product['id']; ?>">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Book tour video -->
    <div class="row mt-5">
        <div class="col-12 text-center">
            <h4>Take a Tour of Our Collection</h4>
            <video controls class="img-fluid" style="max-width: 600px; max-height: 400px;">
                <source src="assets/videos/book-tour.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
    
    <?php else: ?>
    <div class="alert alert-info text-center">
        <img src="assets/images/404-image.jpg" alt="No books found" class="img-fluid mb-3" style="max-height: 200px;">
        <h4>No books found</h4>
        <p>Try different search terms or browse all categories.</p>
        <a href="products.php" class="btn btn-primary">View All Books</a>
    </div>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>