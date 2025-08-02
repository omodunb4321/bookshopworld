<?php
// Login Page
$page_title = 'Login - BookShop World';
require_once 'header.php';

// Handle login
if ($_POST) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        showMessage('Please fill in both fields', 'danger');
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];
            
            showMessage('Welcome back!', 'success');
            redirect('user/dashboard.php');
        } else {
            showMessage('Wrong username or password', 'danger');
        }
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Login to Your Account</h3>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label>Username or Email</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    
                    <hr>
                    <div class="text-center">
                        <p>Don't have an account? <a href="register.php">Sign up here</a></p>
                    </div>
                    
                    <!-- Test accounts -->
                    <div class="alert alert-info">
                        <strong>Test Accounts:</strong><br>
                        Admin: <code>admin</code> / <code>admin123</code><br>
                        User: <code>testuser</code> / <code>test123</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>