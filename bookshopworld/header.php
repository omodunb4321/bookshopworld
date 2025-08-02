<?php 
/**
 * Header with working logo and media
 */
require_once 'config.php'; 

// Simple theme handling
if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'earthy';
}

if (isset($_GET['theme']) && in_array($_GET['theme'], ['earthy', 'dark', 'summer'])) {
    $_SESSION['theme'] = $_GET['theme'];
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$current_theme = $_SESSION['theme'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'BookShop World'; ?></title>
    <meta name="description" content="<?php echo $page_description ?? 'BookShop World - Your online bookstore'; ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Simple inline CSS with themes -->
    <style>
        /* Theme colors */
        <?php if ($current_theme == 'earthy'): ?>
        :root {
            --primary: #2E8B57;
            --secondary: #228B22;
            --bg: #f8f9fa;
            --text: #333;
        }
        <?php elseif ($current_theme == 'dark'): ?>
        :root {
            --primary: #6c63ff;
            --secondary: #4834d4;
            --bg: #1a1a1a;
            --text: #fff;
        }
        body { background-color: var(--bg); color: var(--text); }
        .navbar-light { background-color: #2f2f2f !important; }
        .navbar-light .nav-link { color: #fff !important; }
        .card { background-color: #3a3a3a; color: var(--text); }
        <?php else: // summer ?>
        :root {
            --primary: #ff6b6b;
            --secondary: #4ecdc4;
            --bg: #fff9c4;
            --text: #2c3e50;
        }
        body { background-color: var(--bg); color: var(--text); }
        <?php endif; ?>
        
        .navbar-brand { color: var(--primary) !important; font-weight: bold; }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background-color: var(--secondary); border-color: var(--secondary); }
        .text-primary { color: var(--primary) !important; }
        .book-card { 
            border: 1px solid #ddd; 
            padding: 15px; 
            border-radius: 8px; 
            margin-bottom: 20px;
            transition: all 0.3s;
        }
        .book-card:hover { 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
            border-color: var(--primary);
            transform: translateY(-2px);
        }
        .jumbotron.bg-primary { 
            background: linear-gradient(135deg, var(--primary), var(--secondary)) !important; 
        }
        .navbar-brand img {
            height: 30px;
            width: auto;
        }
    </style>
</head>
<body>

<!-- Navigation with Logo -->
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="assets/images/logo.png" alt="BookShop World" class="me-2">
            <span><i class="fas fa-book-open me-2"></i>BookShop World</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="products.php">All Books</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="help/">Help</a></li>
            </ul>
            
            <!-- Search -->
            <form class="d-flex me-3" method="GET" action="search.php">
                <input class="form-control me-2" type="search" name="q" placeholder="Search books...">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
            
            <!-- Simple Theme Switcher -->
            <div class="dropdown me-3">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Theme
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="?theme=earthy">🌿 Earthy</a></li>
                    <li><a class="dropdown-item" href="?theme=dark">🌙 Dark</a></li>
                    <li><a class="dropdown-item" href="?theme=summer">☀️ Summer</a></li>
                </ul>
            </div>
            
            <!-- User menu -->
            <ul class="navbar-nav">
                <?php if (isLoggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Cart</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            Hi, <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="user/dashboard.php">My Account</a></li>
                            <?php if (isAdmin()): ?>
                            <li><a class="dropdown-item" href="admin/">Admin Panel</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Messages -->
<?php $msg = getMessage(); if ($msg): ?>
<div class="container mt-3">
    <div class="alert alert-<?php echo $msg['type']; ?> alert-dismissible fade show">
        <?php echo htmlspecialchars($msg['message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>

<main>