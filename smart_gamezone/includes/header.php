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
        <strong></strong>
        <div>
            <a href="<?= isset($basePrefix) ? $basePrefix : '' ?>index.php">Home</a>
            <a href="<?= isset($basePrefix) ? $basePrefix : '' ?>catalog.php">Catalog</a>
            <a href="<?= isset($basePrefix) ? $basePrefix : '' ?>cart.php">Cart</a>
            <a href="<?= isset($basePrefix) ? $basePrefix : '' ?>login.php">Login</a>
            <a href="<?= isset($basePrefix) ? $basePrefix : '' ?>register.php">Register</a>
        </div>
    </nav>
</header>
