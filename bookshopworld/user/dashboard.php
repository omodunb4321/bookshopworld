<?php
// User Dashboard
$page_title = 'My Account - BookShop World';
require_once '../config.php';

if (!isLoggedIn()) {
    showMessage('Please login first', 'warning');
    redirect('../login.php');
}

// Get user info
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Get simple stats
$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM cart_items WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$cart_count = $stmt->fetch()['count'];

$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM orders WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$order_count = $stmt->fetch()['count'];

require_once '../header.php';
?>

<div class="container mt-4">
    <h2>Welcome, <?php echo htmlspecialchars($user['first_name']); ?>!</h2>
    <p>This is your account dashboard.</p>
    
    <!-- Simple stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h3><?php echo $cart_count; ?></h3>
                    <p>Items in Cart</p>
                    <a href="../cart.php" class="btn btn-primary btn-sm">View Cart</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h3><?php echo $order_count; ?></h3>
                    <p>Total Orders</p>
                    <a href="orders.php" class="btn btn-success btn-sm">View Orders</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h3>👤</h3>
                    <p>Your Profile</p>
                    <a href="profile.php" class="btn btn-info btn-sm">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick actions -->
    <div class="card">
        <div class="card-header">
            <h5>What would you like to do?</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <a href="../products.php" class="btn btn-outline-primary w-100">
                        Browse Books
                    </a>
                </div>
                <div class="col-md-6 mb-3">
                    <a href="../cart.php" class="btn btn-outline-success w-100">
                        View My Cart
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Account info -->
    <div class="card mt-4">
        <div class="card-header">
            <h5>Account Information</h5>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Member since:</strong> <?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>
            
            <?php if ($user['is_admin']): ?>
            <div class="alert alert-info">
                <strong>Admin Account</strong> - You have administrator privileges.
                <a href="../admin/" class="btn btn-primary btn-sm ms-2">Go to Admin Panel</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../footer.php'; ?>