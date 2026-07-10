<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!$username || !$password) $errors[] = 'Provide username and password.';
    if (empty($errors)) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :u LIMIT 1');
        $stmt->execute([':u'=>$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!validate_csrf($_POST['csrf'] ?? '')) {
          $errors[] = 'Invalid form submission.';
        } elseif ($user && password_verify($password, $user['password'])) {
          login_user(['id'=>$user['id'],'username'=>$user['username']]);
          header('Location: index.php');
          exit;
        } else {
            $errors[] = 'Invalid credentials.';
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main class="form-box">
    <h1>Login</h1>
    <?php if ($errors): ?>
      <div class="errors"><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
    <?php endif; ?>
    <form method="post" action="">
      <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(csrf_token()); ?>">
      <label>Username<br><input name="username" required></label>
      <label>Password<br><input type="password" name="password" required></label>
      <button type="submit">Login</button>
    </form>
    <p><a href="register.php">Create an account</a></p>
  </main>
</body>
</html>
