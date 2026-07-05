<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$basePrefix = $basePrefix ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Smart GameZone') ?></title>
    <link rel="stylesheet" href="<?= strpos($_SERVER['PHP_SELF'], '/weeks/') !== false ? '../assets/style.css' : 'assets/style.css' ?>">
</head>
<body>
<header>
    <nav>
        <strong><a class="brand" href="<?= $basePrefix ?>index.php">Smart GameZone</a></strong>
        <div class="nav-links">
            <a href="<?= $basePrefix ?>index.php">Home</a>
            <a href="<?= $basePrefix ?>catalog.php">Catalog</a>
            <a href="<?= $basePrefix ?>cart.php">Cart</a>
            <a href="<?= $basePrefix ?>weeks/index.php">Weekly log</a>
            <?php if (!empty($_SESSION['user_id'])): ?>
                <a href="<?= $basePrefix ?>order_history.php">Order history</a>
                <a href="<?= $basePrefix ?>logout.php">Logout</a>
            <?php else: ?>
                <a href="<?= $basePrefix ?>login.php">Login</a>
                <a href="<?= $basePrefix ?>register.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
