</main>

<!-- Footer -->
<footer class="bg-light mt-5 py-4 border-top">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h6>BookShop World</h6>
                <p>Your friendly online bookstore.</p>
            </div>
            <div class="col-md-6">
                <h6>Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="products.php">All Books</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="help/">Help Center</a></li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="text-center">
            <p>&copy; <?php echo date('Y'); ?> BookShop World. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- add to cart function -->
<script>
function addToCart(productId) {
    if (!<?php echo isLoggedIn() ? 'true' : 'false'; ?>) {
        alert('Please login first!');
        window.location.href = 'login.php';
        return;
    }
    
    fetch('ajax/add-to-cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({product_id: productId, quantity: 1})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Book added to cart!');
        } else {
            alert('Error adding book to cart');
        }
    });
}
</script>

</body>
</html>