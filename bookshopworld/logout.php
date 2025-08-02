<?php
// Simple Logout Script
require_once 'config.php';

// Destroy all session data
session_unset();
session_destroy();

// Show logout message and redirect
session_start();
showMessage('You have been logged out successfully', 'info');
redirect('index.php');
?>