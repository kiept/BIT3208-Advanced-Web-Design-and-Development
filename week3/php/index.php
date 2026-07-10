<?php
// Simple PHP welcome and form page for Week 3
session_start();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Week3 PHP Intro</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <main class="container">
    <h1>PHP Intro — Welcome</h1>
    <?php if (!empty($_SESSION['user'])): ?>
      <p>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>.</p>
      <p><a href="process.php?action=logout">Logout</a></p>
    <?php else: ?>
      <p>This page demonstrates basic PHP form handling.</p>
      <form method="post" action="process.php">
        <label>Name<br><input name="name" required></label>
        <label>Message<br><input name="message"></label>
        <button type="submit">Send</button>
      </form>
    <?php endif; ?>
  </main>
</body>
</html>
