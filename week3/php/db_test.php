<?php
// Simple MySQL connection test (adjust credentials as needed)
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db = 'studentdb';

$conn = mysqli_connect($host, $user, $pass, $db);
if ($conn) {
    echo "Connected Successfully to MySQL ($host) and database '$db'";
    mysqli_close($conn);
} else {
    echo "Connection Failed: " . mysqli_connect_error();
}
