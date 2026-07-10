<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!validate_csrf($_POST['csrf'] ?? '')) {
    $errors[] = 'Invalid form submission.';
  }
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!$username || !$email || !$password) {
        $errors[] = 'All fields are required.';
    }
    if (empty($errors)) {
        $pdo = getPDO();
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :u OR email = :e');
        $stmt->execute([':u'=>$username, ':e'=>$email]);
        if ($stmt->fetch()) {
            $errors[] = 'Username or email already taken.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $pdo->prepare('INSERT INTO users (username,email,password) VALUES (:u,:e,:p)');
            $ins->execute([':u'=>$username, ':e'=>$email, ':p'=>$hash]);
            header('Location: login.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Register</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main class="form-box">
    <h1>Register</h1>
    <?php if ($errors): ?>
      <div class="errors"><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
    <?php endif; ?>
    <form method="post" action="">
      <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(csrf_token()); ?>">
      <label>Username<br><input name="username" required></label>
      <label>Email<br><input type="email" name="email" required></label>
      <label>Password<br><input type="password" name="password" required></label>
      <button type="submit">Register</button>
    </form>
    <p><a href="login.php">Already have an account? Login</a></p>
  </main>
</body>
</html>
