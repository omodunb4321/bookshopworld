<?php
// Search Page
require_once 'config.php';

$search_query = isset($_GET['q']) ? trim($_GET['q']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 12;
$offset = ($page - 1) * $limit;

$page_title = !empty($search_query) ? "Search Results for '$search_query' - BookShop World" : 'Search Books - BookShop World';
$page_description = 'Search our complete collection of books by title, author, or keyword';

$products = [];
$total_products = 0;
$total_pages = 0;

if (!empty($search_query)) {
    // Get total count
    $count_sql = "SELECT COUNT(*) as total FROM products p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  WHERE p.title LIKE ? OR p.author LIKE ? OR p.description LIKE ? OR c.name LIKE ?";
    $search_term = "%$search_query%";
    $stmt = $pdo->prepare($count_sql);
    $stmt->execute([$search_term, $search_term, $search_term, $search_term]);
    $total_products = $stmt->fetch()['total'];
    $total_pages = ceil($total_products / $limit);
    
    // Get search results
    $sql = "SELECT p.*, c.name as category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.title LIKE ? OR p.author LIKE ? OR p.description LIKE ? OR c.name LIKE ?
            ORDER BY 
                CASE 
                    WHEN p.title LIKE ? THEN 1
                    WHEN p.author LIKE ? THEN 2
                    WHEN c.name LIKE ? THEN 3
                    ELSE 4
                END,
                p.title
            LIMIT $limit OFFSET $offset";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$search_term, $search_term, $search_term, $search_term, $search_term, $search_term, $search_term]);
    $products = $stmt->fetchAll();
}

require_once 'header.php';
?>

<div class="container mt-4">
    <!-- Search Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="fas fa-search"></i> Search Books</h2>
            <?php if (!empty($search_query)): ?>
                <p class="text-muted">
                    Showing <?php echo $total_products; ?> results for 
                    <strong>"<?php echo htmlspecialchars($search_query); ?>"</strong>
                </p>
            <?php else: ?>
                <p class="text-muted">Search our complete collection of books</p>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-8">
                            <input type="text" class="form-control form-control-lg" name="q" 
                                   value="<?php echo htmlspecialchars($search_query); ?>" 
                                   placeholder="Search by title, author, category, or keyword..." 
                                   required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-search me-2"></i>Search Books
                            </button>
                        </div>
                    </form>
                    
                    <?php if (!empty($search_query)): ?>
                    <div class="mt-3">
                        <a href="search.php" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Clear Search
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php if (!empty($search_query)): ?>
        <?php if (!empty($products)): ?>
        <!-- Search Results -->
        <div class="row">
            <?php foreach ($products as $product): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card product-card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold">
                            <a href="product.php?id=<?php echo $product['id']; ?>" 
                               class="text-decoration-none text-dark">
                                <?php 
                                // Highlight search term in title
                                $highlighted_title = str_ireplace($search_query, '<mark>' . $search_query . '</mark>', htmlspecialchars($product['title']));
                                echo $highlighted_title;
                                ?>
                            </a>
                        </h6>
                        
                        <p class="card-text text-muted small">
                            by <?php 
                            $highlighted_author = str_ireplace($search_query, '<mark>' . $search_query . '</mark>', htmlspecialchars($product['author']));
                            echo $highlighted_author;
                            ?>
                        </p>
                        
                        <p class="card-text text-muted small">
                            <i class="fas fa-tag"></i> 
                            <?php 
                            $highlighted_category = str_ireplace($search_query, '<mark>' . $search_query . '</mark>', htmlspecialchars($product['category_name']));
                            echo $highlighted_category;
                            ?>
                        </p>
                        
                        <p class="card-text flex-grow-1">
                            <?php 
                            $description_excerpt = substr($product['description'], 0, 100);
                            $highlighted_description = str_ireplace($search_query, '<mark>' . $search_query . '</mark>', htmlspecialchars($description_excerpt));
                            echo $highlighted_description;
                            ?>...
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
                <nav aria-label="Search results pagination">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?q=<?php echo urlencode($search_query); ?>&page=<?php echo $page-1; ?>">
                                Previous
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                            <a class="page-link" href="?q=<?php echo urlencode($search_query); ?>&page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                        <?php endfor; ?>
                        
                        <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?q=<?php echo urlencode($search_query); ?>&page=<?php echo $page+1; ?>">
                                Next
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
        <?php endif; ?>
        
        <?php else: ?>
        <!-- No Results -->
        <div class="row">
            <div class="col-12 text-center">
                <div class="alert alert-warning">
                    <i class="fas fa-search fa-3x mb-3"></i>
                    <h4>No books found</h4>
                    <p>We couldn't find any books matching <strong>"<?php echo htmlspecialchars($search_query); ?>"</strong></p>
                    <p>Try:</p>
                    <ul class="list-unstyled">
                        <li>• Check your spelling</li>
                        <li>• Use different keywords</li>
                        <li>• Search by author name</li>
                        <li>• Browse categories instead</li>
                    </ul>
                    <a href="products.php" class="btn btn-primary">Browse All Books</a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    
    <?php else: ?>
    <!-- Search Suggestions -->
    <div class="row">
        <div class="col-12">
            <h4>Popular Searches</h4>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-fire text-danger"></i> Popular Authors</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <?php
                        $stmt = $pdo->prepare("SELECT author, COUNT(*) as book_count FROM products GROUP BY author ORDER BY book_count DESC LIMIT 8");
                        $stmt->execute();
                        $popular_authors = $stmt->fetchAll();
                        
                        foreach ($popular_authors as $author): ?>
                        <a href="search.php?q=<?php echo urlencode($author['author']); ?>" 
                           class="btn btn-outline-primary btn-sm">
                            <?php echo htmlspecialchars($author['author']); ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-tags text-success"></i> Browse Categories</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <?php
                        $stmt = $pdo->prepare("SELECT * FROM categories ORDER BY name");
                        $stmt->execute();
                        $all_categories = $stmt->fetchAll();
                        
                        foreach ($all_categories as $cat): ?>
                        <a href="category.php?id=<?php echo $cat['id']; ?>" 
                           class="btn btn-outline-success btn-sm">
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>