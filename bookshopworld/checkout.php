<?php
// Checkout Page
$page_title = 'Checkout - BookShop World';
require_once 'config.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];

// Get cart items
$stmt = $pdo->prepare("
    SELECT ci.*, p.title, p.author, p.price 
    FROM cart_items ci 
    JOIN products p ON ci.product_id = p.id 
    WHERE ci.user_id = ?
");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll();

if (empty($cart_items)) {
    showMessage('Your cart is empty', 'warning');
    redirect('cart.php');
}

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Handle order submission
if ($_POST && isset($_POST['place_order'])) {
    $address = trim($_POST['address']);
    
    if (empty($address)) {
        showMessage('Please enter your shipping address', 'danger');
    } else {
        // Create order
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, shipping_address) VALUES (?, ?, ?)");
        
        if ($stmt->execute([$user_id, $total, $address])) {
            $order_id = $pdo->lastInsertId();
            
            // Clear cart
            $stmt = $pdo->prepare("DELETE FROM cart_items WHERE user_id = ?");
            $stmt->execute([$user_id]);
            
            showMessage('Order placed successfully! Order #' . $order_id, 'success');
            redirect('user/dashboard.php');
        } else {
            showMessage('Error placing order. Please try again.', 'danger');
        }
    }
}

require_once 'header.php';
?>

<div class="container mt-4">
    <h2>Checkout</h2>
    
    <!-- Order Summary -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Order Summary</h5>
        </div>
        <div class="card-body">
            <?php foreach ($cart_items as $item): ?>
            <div class="d-flex justify-content-between">
                <span><?php echo htmlspecialchars($item['title']); ?> (<?php echo $item['quantity']; ?>x)</span>
                <span>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
            </div>
            <?php endforeach; ?>
            <hr>
            <div class="d-flex justify-content-between">
                <strong>Total: $<?php echo number_format($total, 2); ?></strong>
            </div>
        </div>
    </div>
    
    <!-- Checkout Form -->
    <div class="card">
        <div class="card-header">
            <h5>Shipping Information</h5>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label>Shipping Address</label>
                    <textarea class="form-control" name="address" rows="3" required 
                              placeholder="Enter your full shipping address..."></textarea>
                </div>
                
                <div class="alert alert-info">
                    <strong>Note:</strong> This is a demo checkout. No real payment will be processed.
                </div>
                
                <button type="submit" name="place_order" class="btn btn-success btn-lg">
                    Place Order ($<?php echo number_format($total, 2); ?>)
                </button>
                <a href="cart.php" class="btn btn-outline-secondary ms-2">Back to Cart</a>
            </form>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>