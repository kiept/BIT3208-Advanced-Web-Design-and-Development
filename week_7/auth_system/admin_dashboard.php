<?php
include 'db.php'; include 'includes/auth.php';
require_login(); require_role($conn,['admin']);
$u = current_user($conn);
?>
<!doctype html>
<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Dashboard</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<main class="container">
  <h1>Admin Dashboard</h1>
  <div>Welcome, <?php echo htmlspecialchars($u['fullname']); ?> (<?php echo htmlspecialchars($u['email']); ?>)</div>
  <p><a href="logout.php">Logout</a></p>
</main>
</body></html>
