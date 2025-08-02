<?php
// Shopping Cart
$page_title = 'Shopping Cart - BookShop World';
require_once 'config.php';

if (!isLoggedIn()) {
    showMessage('Please login to view your cart', 'warning');
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];

// Handle quantity updates
if ($_POST && isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $cart_id => $quantity) {
        $quantity = (int)$quantity;
        if ($quantity > 0) {
            $stmt = $pdo->prepare("UPDATE cart_items SET quantity = ? WHERE id = ? AND user_id = ?");
            $stmt->execute([$quantity, $cart_id, $user_id]);
        } else {
            $stmt = $pdo->prepare("DELETE FROM cart_items WHERE id = ? AND user_id = ?");
            $stmt->execute([$cart_id, $user_id]);
        }
    }
    showMessage('Cart updated!', 'success');
    redirect('cart.php');
}

// Handle remove item
if (isset($_GET['remove'])) {
    $cart_id = (int)$_GET['remove'];
    $stmt = $pdo->prepare("DELETE FROM cart_items WHERE id = ? AND user_id = ?");
    if ($stmt->execute([$cart_id, $user_id])) {
        showMessage('Item removed from cart', 'info');
    }
    redirect('cart.php');
}

// Get cart items
$stmt = $pdo->prepare("
    SELECT ci.*, p.title, p.author, p.price 
    FROM cart_items ci 
    JOIN products p ON ci.product_id = p.id 
    WHERE ci.user_id = ? 
    ORDER BY ci.added_at DESC
");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll();

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}

require_once 'header.php';
?>

<div class="container mt-4">
    <h2>Shopping Cart</h2>
    
    <?php if (!empty($cart_items)): ?>
    <form method="POST">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>Format</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td>
                                <strong><?php echo htmlspecialchars($item['title']); ?></strong><br>
                                <small>by <?php echo htmlspecialchars($item['author']); ?></small>
                            </td>
                            <td><?php echo ucfirst($item['format']); ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <input type="number" class="form-control" style="width: 80px;" 
                                       name="quantities[<?php echo $item['id']; ?>]" 
                                       value="<?php echo $item['quantity']; ?>" min="0" max="10">
                            </td>
                            <td><strong>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></strong></td>
                            <td>
                                <a href="cart.php?remove=<?php echo $item['id']; ?>" 
                                   class="btn btn-outline-danger btn-sm"
                                   onclick="return confirm('Remove this item?')">Remove</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <button type="submit" name="update_cart" class="btn btn-outline-primary">Update Cart</button>
                    <div>
                        <strong>Total: $<?php echo number_format($total, 2); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    <div class="mt-3">
        <a href="checkout.php" class="btn btn-success btn-lg">Proceed to Checkout</a>
        <a href="products.php" class="btn btn-outline-secondary ms-2">Continue Shopping</a>
    </div>
    
    <?php else: ?>
    <div class="card">
        <div class="card-body text-center">
            <h4>Your cart is empty</h4>
            <p>You haven't added any books yet.</p>
            <a href="products.php" class="btn btn-primary">Start Shopping</a>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>