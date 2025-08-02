<?php
// Admin Panel
require_once '../config.php';

if (!isLoggedIn() || !isAdmin()) {
    showMessage('You need to be an admin to access this page.', 'danger');
    redirect('../login.php');
}

$page_title = 'Admin Panel - BookShop World';

// Get some basic stats
$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM products");
$stmt->execute();
$product_count = $stmt->fetch()['count'];

$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM users WHERE is_admin = 0");
$stmt->execute();
$user_count = $stmt->fetch()['count'];

$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM orders");
$stmt->execute();
$order_count = $stmt->fetch()['count'];

require_once '../header.php';
?>

<div class="container mt-4">
    <h2>Admin Panel</h2>
    <p>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    
    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h3><?php echo $product_count; ?></h3>
                    <p>Total Books</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h3><?php echo $user_count; ?></h3>
                    <p>Total Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h3><?php echo $order_count; ?></h3>
                    <p>Total Orders</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Menu -->
    <div class="card">
        <div class="card-body">
            <h5>What would you like to do?</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <a href="products.php" class="btn btn-primary w-100">
                        Manage Books
                    </a>
                </div>
                <div class="col-md-6 mb-3">
                    <a href="users.php" class="btn btn-success w-100">
                        View Users
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="card mt-4">
        <div class="card-body">
            <h5>Recent Activity</h5>
            <?php
            $stmt = $pdo->prepare("SELECT * FROM orders ORDER BY order_date DESC LIMIT 3");
            $stmt->execute();
            $recent_orders = $stmt->fetchAll();
            
            if (empty($recent_orders)): ?>
                <p>No recent orders.</p>
            <?php else: ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($recent_orders as $order): ?>
                    <li class="list-group-item">
                        Order #<?php echo $order['id']; ?> - $<?php echo number_format($order['total_amount'], 2); ?>
                        <small class="text-muted">(<?php echo date('M j', strtotime($order['order_date'])); ?>)</small>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../footer.php'; ?>