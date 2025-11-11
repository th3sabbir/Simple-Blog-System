<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'blog_system');

// Create connection
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Set charset to utf8mb4
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

// Helper function to sanitize input
// Note: When using prepared statements (which this project does), 
// we don't need real_escape_string as bind_param handles escaping
// htmlspecialchars should be applied at output, not input
function clean_input($data) {
    // Only trim leading and trailing whitespace
    // Preserve line breaks (\n, \r\n) and internal spacing
    return trim($data);
}

// Helper function for prepared statements
function execute_query($query, $types = "", $params = []) {
    global $conn;
    
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        return false;
    }
    
    if (!empty($types) && !empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $result = $stmt->execute();
    
    if (!$result) {
        $stmt->close();
        return false;
    }
    
    $stmt_result = $stmt->get_result();
    $stmt->close();
    
    return $stmt_result;
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Check if user is admin
function is_admin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}

// Get current user ID
function get_current_user_id() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

// Get current username
function get_current_username() {
    return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}

// Helper function to safely display content with line breaks preserved
// Use this when displaying post content, comments, or any user-generated text
function display_content($content) {
    return nl2br(htmlspecialchars($content));
}

// Helper function to safely display excerpt with line breaks preserved
function display_excerpt($content, $length = 150) {
    $excerpt = substr($content, 0, $length);
    if (strlen($content) > $length) {
        $excerpt .= '...';
    }
    return nl2br(htmlspecialchars($excerpt));
}
?>
