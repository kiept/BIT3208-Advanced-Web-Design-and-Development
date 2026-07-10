<?php
include 'db.php';
include 'includes/auth.php';
start_secure_session();
$error='';
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    if ($email=='' || $pass=='') $error='Email and password required.';
    else{
        $stmt = $conn->prepare('SELECT user_id,username,password FROM users WHERE email=? LIMIT 1');
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $res = $stmt->get_result();
        $u = $res->fetch_assoc();
        $stmt->close();
        if ($u && password_verify($pass,$u['password'])){
            login_user($u['user_id']);
            header('Location: index.php'); exit;
        } else $error='Invalid credentials.';
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<main class="container">
  <h1>Login</h1>
  <?php if ($error): ?><div class="alert error"><?php echo $error;?></div><?php endif; ?>
  <form method="post" class="form-box">
    <label>Email<br><input type="email" name="email" required></label>
    <label>Password<br><input type="password" name="password" required></label>
    <button type="submit">Login</button>
  </form>
  <p>Don't have an account? <a href="register.php">Register</a></p>
</main>
</body></html>
