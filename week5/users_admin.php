<?php
require_once __DIR__ . '/includes/db.php';
$pdo = getPDO();
$users = $pdo->query('SELECT id,username,email,created_at FROM users ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Users - DB Integration</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main class="container">
    <h1>Users (for login DB integration)</h1>
    <table border="1" cellpadding="6" cellspacing="0">
      <thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Created</th></tr></thead>
      <tbody>
      <?php foreach($users as $u): ?>
      <tr>
        <td><?php echo $u['id']; ?></td>
        <td><?php echo htmlspecialchars($u['username']); ?></td>
        <td><?php echo htmlspecialchars($u['email']); ?></td>
        <td><?php echo $u['created_at']; ?></td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <p>Use this table to verify login integration screenshots.</p>
  </main>
</body>
</html>
