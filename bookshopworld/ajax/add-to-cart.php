<?php
// AJAX Add to Cart Handler
require_once '../config.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

// Get JSON input
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$product_id = (int)($data['product_id'] ?? 0);
$quantity = (int)($data['quantity'] ?? 1);
$format = $data['format'] ?? 'paperback';
$user_id = $_SESSION['user_id'];

// Validate input
if (!$product_id || $quantity < 1) {
    echo json_encode(['success' => false, 'message' => 'Invalid product or quantity']);
    exit;
}

// Check if product exists
$stmt = $pdo->prepare("SELECT id FROM products WHERE id = ?");
$stmt->execute([$product_id]);
if (!$stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'Product not found']);
    exit;
}

try {
    // Check if item already exists in cart
    $stmt = $pdo->prepare("SELECT id, quantity FROM cart_items WHERE user_id = ? AND product_id = ? AND format = ?");
    $stmt->execute([$user_id, $product_id, $format]);
    $existing = $stmt->fetch();
    
    if ($existing) {
        // Update existing cart item
        $new_quantity = $existing['quantity'] + $quantity;
        $stmt = $pdo->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
        $stmt->execute([$new_quantity, $existing['id']]);
    } else {
        // Add new cart item
        $stmt = $pdo->prepare("INSERT INTO cart_items (user_id, product_id, quantity, format) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $product_id, $quantity, $format]);
    }
    
    // Get updated cart count
    $stmt = $pdo->prepare("SELECT SUM(quantity) as total FROM cart_items WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $cart_total = $stmt->fetch()['total'] ?? 0;
    
    echo json_encode([
        'success' => true, 
        'message' => 'Item added to cart successfully',
        'cart_count' => $cart_total
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error adding to cart']);
}
?>