<?php
// DB config for Book Management (adjust credentials for XAMPP/MySQL)
define('DB_HOST','127.0.0.1');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','week6_books');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die('DB Connection failed: '.$conn->connect_error);
}
$conn->set_charset('utf8');

function sanitize($v){ global $conn; return $conn->real_escape_string(trim($v)); }

?>
