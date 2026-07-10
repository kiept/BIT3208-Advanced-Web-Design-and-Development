<?php
$dir = __DIR__ . '/database';
if (!is_dir($dir)) mkdir($dir, 0755, true);
$dbFile = $dir . '/app.sqlite';
$init = !file_exists($dbFile);
try {
    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($init) {
        $pdo->exec("CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            email TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");
        $pdo->exec("CREATE TABLE orders (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT,
            product TEXT,
            address TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");
        echo "Database initialized at: $dbFile\n";
    } else {
        echo "Database already exists: $dbFile\n";
    }
} catch (Exception $e) {
    echo 'DB error: ' . $e->getMessage();
}
