<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'smartstay');

// Create database connection
$conn = new mysqli('localhost', 'root', '', 'smartstay');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to redirect if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /smartstay/login.php');
        exit();
    }
}
?>