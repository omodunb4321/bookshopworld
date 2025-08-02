<?php
// BookStore Configuration
session_start();

// Database settings - YOUR ACTUAL INFINITYFREE CREDENTIALS
$db_host = 'sql200.infinityfree.com';              //  database host
$db_name = 'if0_39593043_bookstore';               //  database name 
$db_user = 'if0_39593043';                         //  database username
$db_pass = 'Frxnc1s2024';                          //  actual password

// Site settings
$site_name = 'BookShop World';
$site_url = 'https://bookshopworld.infinityfreeapp.com';

// Connect to database
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Simple helper functions
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function showMessage($message, $type = 'info') {
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
}

function getMessage() {
    if (isset($_SESSION['message'])) {
        $msg = $_SESSION['message'];
        $type = $_SESSION['message_type'] ?? 'info';
        unset($_SESSION['message'], $_SESSION['message_type']);
        return ['message' => $msg, 'type' => $type];
    }
    return null;
}
?>