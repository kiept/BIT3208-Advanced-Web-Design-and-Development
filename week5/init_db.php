<?php
$dir = __DIR__ . '/database';
if (!is_dir($dir)) mkdir($dir, 0755, true);
$dbFile = $dir . '/app.sqlite';
$init = !file_exists($dbFile);
try {
    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($init) {
        $pdo->exec("CREATE TABLE students (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            reg_no TEXT,
            email TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        $pdo->exec("CREATE TABLE products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            sku TEXT,
            price REAL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        $pdo->exec("CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            email TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        // sample data
        $pdo->exec("INSERT INTO students (name,reg_no,email) VALUES
            ('Alice Mwangi','STU001','alice@example.com'),
            ('Brian Otieno','STU002','brian@example.com')");

        $pdo->exec("INSERT INTO products (name,sku,price) VALUES
            ('Widget A','WID-A',9.99),
            ('Widget B','WID-B',19.5)");

        $hash = password_hash('password', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (username,password,email) VALUES (:u,:p,:e)');
        $stmt->execute([':u'=>'admin',':p'=>$hash,':e'=>'admin@example.com']);

        echo "Week5 database initialized at: $dbFile\n";
    } else {
        echo "Database already exists: $dbFile\n";
    }
} catch (Exception $e) {
    echo 'DB error: ' . $e->getMessage();
}
