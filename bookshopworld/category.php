<?php
// Category Page
require_once 'config.php';

$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$category_id) {
    showMessage('Category not found', 'danger');
    redirect('products.php');
}

// Get category info
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$category_id]);
$category = $stmt->fetch();

if (!$category) {
    showMessage('Category not found', 'danger');
    redirect('products.php');
}

$page_title = $category['name'] . ' Books - BookShop World';
$page_description = 'Browse our collection of ' . $category['name'] . ' books';

// Get products in this category
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 12;
$offset = ($page - 1) * $limit;

// Get total count
$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM products WHERE category_id = ?");
$stmt->execute([$category_id]);
$total_products = $stmt->fetch()['total'];
$total_pages = ceil($total_products / $limit);

// Get products
$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? ORDER BY title LIMIT $limit OFFSET $offset");
$stmt->execute([$category_id]);
$products = $stmt->fetchAll();

require_once 'header.php';
?>

<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="products.php">Books</a></li>
            <li class="breadcrumb-item active"><?php echo htmlspecialchars($category['name']); ?></li>
        </ol>
    </nav>
    
    <!-- Category Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h2>
                <?php
                // Category icons
                $icons = [
                    'Fiction' => 'fas fa-magic',
                    'Mystery' => 'fas fa-search',
                    'Romance' => 'fas fa-heart',
                    'Science Fiction' => 'fas fa-rocket',
                    'History' => 'fas fa-landmark',
                    'Biography' => 'fas fa-user',
                    'Self-Help' => 'fas fa-lightbulb',
                    'Technology' => 'fas fa-laptop-code',
                    'Business' => 'fas fa-briefcase',
                    'Art' => 'fas fa-palette'
                ];
                $icon = $icons[$category['name']] ?? 'fas fa-book';
                ?>
                <i class="<?php echo $icon; ?> me-2"></i>
                <?php echo htmlspecialchars($category['name']); ?> Books
            </h2>
            <p class="text-muted">
                Showing <?php echo $total_products; ?> books in <?php echo htmlspecialchars($category['name']); ?>
            </p>
        </div>
    </div>
    
    <!-- Products Grid -->
    <?php if (!empty($products)): ?>
    <div class="row">
        <?php foreach ($products as $product): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card product-card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title fw-bold">
                        <a href="product.php?id=<?php echo $product['id']; ?>" 
                           class="text-decoration-none text-dark">
                            <?php echo htmlspecialchars($product['title']); ?>
                        </a>
                    </h6>
                    
                    <p class="card-text text-muted small">
                        by <?php echo htmlspecialchars($product['author']); ?>
                    </p>
                    
                    <p class="card-text flex-grow-1">
                        <?php echo htmlspecialchars(substr($product['description'], 0, 100)); ?>...
                    </p>
                    
                    <!-- Available Formats -->
                    <div class="mb-2">
                        <small class="text-muted">Available in:</small><br>
                        <?php if ($product['paperback']): ?>
                            <span class="badge bg-secondary me-1">Paperback</span>
                        <?php endif; ?>
                        <?php if ($product['hardcover']): ?>
                            <span class="badge bg-secondary me-1">Hardcover</span>
                        <?php endif; ?>
                        <?php if ($product['ebook']): ?>
                            <span class="badge bg-secondary me-1">E-Book</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h6 text-primary fw-bold mb-0">
                                $<?php echo number_format($product['price'], 2); ?>
                            </span>
                            
                            <div>
                                <a href="product.php?id=<?php echo $product['id']; ?>" 
                                   class="btn btn-outline-primary btn-sm me-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <?php if (isLoggedIn()): ?>
                                <button class="btn btn-primary btn-sm" 
                                        onclick="addToCart(<?php echo $product['id']; ?>)">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
    <div class="row mt-4">
        <div class="col-12">
            <nav aria-label="Category pagination">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?id=<?php echo $category_id; ?>&page=<?php echo $page-1; ?>">Previous</a>
                    </li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?id=<?php echo $category_id; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?id=<?php echo $category_id; ?>&page=<?php echo $page+1; ?>">Next</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
    <?php endif; ?>
    
    <?php else: ?>
    <!-- No Products -->
    <div class="row">
        <div class="col-12 text-center">
            <div class="alert alert-info">
                <i class="fas fa-info-circle fa-3x mb-3"></i>
                <h4>No books in this category yet</h4>
                <p>Check back later for new additions!</p>
                <a href="products.php" class="btn btn-primary">Browse All Books</a>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Other Categories -->
    <div class="row mt-5">
        <div class="col-12">
            <h4>Browse Other Categories</h4>
        </div>
        
        <?php
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id != ? ORDER BY name LIMIT 4");
        $stmt->execute([$category_id]);
        $other_categories = $stmt->fetchAll();
        
        foreach ($other_categories as $other_cat): ?>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <?php $icon = $icons[$other_cat['name']] ?? 'fas fa-book'; ?>
                    <i class="<?php echo $icon; ?> fa-3x text-primary mb-3"></i>
                    <h6 class="card-title"><?php echo htmlspecialchars($other_cat['name']); ?></h6>
                    <a href="category.php?id=<?php echo $other_cat['id']; ?>" class="btn btn-outline-primary">
                        Browse <?php echo htmlspecialchars($other_cat['name']); ?>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once 'footer.php'; ?>