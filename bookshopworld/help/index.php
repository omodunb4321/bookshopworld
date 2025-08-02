<?php
/**
 * Help Center for BookShop World
 */
$page_title = 'Help Center - BookShop World';
require_once '../header.php';
?>

<div class="container mt-4">
    <h1>Help Center</h1>
    <p>Find answers to common questions</p>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h4>🚀 Getting Started</h4>
                    <p>New to BookShop World? Learn the basics.</p>
                    <a href="getting-started.php" class="btn btn-primary">Read Guide</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h4>🛒 Shopping Help</h4>
                    <p>How to buy books and checkout.</p>
                    <a href="shopping-guide.php" class="btn btn-success">Read Guide</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h4>👤 Account Help</h4>
                    <p>Manage your profile and settings.</p>
                    <a href="account-help.php" class="btn btn-info">Read Guide</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h4>🔧 Troubleshooting</h4>
                    <p>Fix common problems.</p>
                    <a href="troubleshooting.php" class="btn btn-warning">Read Guide</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-body">
            <h4>Quick Help</h4>
            <div class="row">
                <div class="col-md-6">
                    <h6>Common Questions:</h6>
                    <ul>
                        <li><a href="getting-started.php">How to create account?</a></li>
                        <li><a href="shopping-guide.php">How to buy books?</a></li>
                        <li><a href="troubleshooting.php">Login problems?</a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>Still need help?</h6>
                    <a href="../contact.php" class="btn btn-outline-primary">Contact Support</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../footer.php'; ?>