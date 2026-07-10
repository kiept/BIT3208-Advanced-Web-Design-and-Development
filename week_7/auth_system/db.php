<?php
// Week 7 auth DB helper
define('DB_HOST','127.0.0.1');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','week7_auth');

$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if ($conn->connect_error) die('DB connect error: '.$conn->connect_error);
$conn->set_charset('utf8');

?>
