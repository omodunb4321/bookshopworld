<?php

//Simple Theme System for BookShop World
// Basic theme switching functionality
 

session_start();

// Available themes
$themes = [
    'earthy' => 'Earthy Natural',
    'dark' => 'Dark Mode', 
    'summer' => 'Summer Bright'
];

// Set default theme
if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'earthy';
}

// Handle theme change
if (isset($_POST['theme']) && array_key_exists($_POST['theme'], $themes)) {
    $_SESSION['theme'] = $_POST['theme'];
    
    // Return JSON response for AJAX
    if (isset($_POST['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'theme' => $_POST['theme']]);
        exit;
    }
    
    // Redirect for regular form submission
    header('Location: ' . ($_POST['redirect'] ?? 'index.php'));
    exit;
}

// Get current theme
function getCurrentTheme() {
    return $_SESSION['theme'] ?? 'earthy';
}

// Get theme name
function getThemeName($theme_key = null) {
    global $themes;
    $theme_key = $theme_key ?? getCurrentTheme();
    return $themes[$theme_key] ?? 'Unknown Theme';
}

// Get all themes
function getAllThemes() {
    global $themes;
    return $themes;
}
?>