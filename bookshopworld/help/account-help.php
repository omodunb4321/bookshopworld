<?php
/**
 * Account Help Guide
 */
$page_title = 'Account Help - Help';
require_once '../header.php';
?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="index.php">Help</a></li>
            <li class="breadcrumb-item active">Account Help</li>
        </ol>
    </nav>
    
    <h1>Account Help</h1>
    <p>Manage your account and profile</p>
    
    <div class="card mb-3">
        <div class="card-body">
            <h4>Creating Account</h4>
            <ol>
                <li>Click "Sign Up"</li>
                <li>Enter your name, username, email, password</li>
                <li>Click "Create Account"</li>
            </ol>
            <?php if (!isLoggedIn()): ?>
                <a href="../register.php" class="btn btn-success">Create Account</a>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-body">
            <h4>Logging In</h4>
            <ol>
                <li>Click "Login"</li>
                <li>Enter username or email</li>
                <li>Enter password</li>
                <li>Click "Login"</li>
            </ol>
            <div class="alert alert-info">
                <strong>Test account:</strong> Username: <code>testuser</code> Password: <code>test123</code>
            </div>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-body">
            <h4>Update Profile</h4>
            <ol>
                <li>Click your username in top menu</li>
                <li>Select "Edit Profile"</li>
                <li>Update name or email</li>
                <li>Click "Update Profile"</li>
            </ol>
            <?php if (isLoggedIn()): ?>
                <a href="../user/profile.php" class="btn btn-primary">Edit Profile</a>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-body">
            <h4>Your Dashboard</h4>
            <p>From your dashboard you can:</p>
            <ul>
                <li>View account info</li>
                <li>Check cart items</li>
                <li>See order history</li>
            </ul>
            <?php if (isLoggedIn()): ?>
                <a href="../user/dashboard.php" class="btn btn-primary">Go to Dashboard</a>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <h4>Logging Out</h4>
            <ol>
                <li>Click your username</li>
                <li>Select "Logout"</li>
            </ol>
            <p>Your cart will be saved when you log back in.</p>
        </div>
    </div>
</div>

<?php require_once '../footer.php'; ?>