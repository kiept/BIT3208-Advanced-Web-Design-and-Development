<?php
require_once __DIR__ . '/includes/functions.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Week 4 - Dynamic Welcome</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main class="container">
    <?php if (isLoggedIn()): ?>
      <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</h1>
      <p>This is a session-protected welcome page. <a href="logout.php">Logout</a></p>
      <p><a href="admin.php">Go to admin dashboard</a></p>
    <?php else: ?>
      <h1>Welcome to Week 4 Demo</h1>
      <p>This page demonstrates a dynamic welcome page using PHP sessions.</p>
      <p><a href="login.php">Login</a> or <a href="register.php">Register</a></p>
    <?php endif; ?>
  </main>
</body>
</html>
