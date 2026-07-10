<?php
// Database Configuration
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'week6_pr1_students');

// Create connection (try socket for 'localhost', fallback to TCP 127.0.0.1)
$conn = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// If connecting to 'localhost' fails due to socket issues, try TCP loopback
if ($conn->connect_error) {
    if (DB_HOST === 'localhost') {
        // Try TCP by using 127.0.0.1
        $conn = @new mysqli('127.0.0.1', DB_USER, DB_PASS, DB_NAME);
    }
}

// Final connection check
if ($conn->connect_error) {
    // Provide a helpful error message with common fixes
    $msg = "Connection failed: " . $conn->connect_error . "\n";
    $msg .= "Possible causes:\n";
    $msg .= " - MySQL server is not running. Start it (e.g. `brew services start mysql` or `mysql.server start`).\n";
    $msg .= " - Socket path mismatch when using 'localhost' — try changing DB_HOST to '127.0.0.1'.\n";
    $msg .= " - Wrong credentials or database name.\n";
    die(nl2br(htmlspecialchars($msg)));
}

// Set charset to UTF-8
$conn->set_charset("utf8");

// Function to sanitize input
function sanitizeInput($data) {
    global $conn;
    return $conn->real_escape_string(trim($data));
}
?>
