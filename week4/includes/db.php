<?php
function getPDO()
{
    $dbFile = __DIR__ . '/../database/app.sqlite';
    if (!file_exists($dbFile)) {
        // Attempt to initialize if missing
        if (is_readable(__DIR__ . '/../init_db.php')) {
            include __DIR__ . '/../init_db.php';
        }
    }
    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
