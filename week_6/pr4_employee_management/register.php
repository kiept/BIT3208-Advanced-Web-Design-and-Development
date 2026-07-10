<?php
include 'db.php';
include 'includes/auth.php';
$error=''; $success='';
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username==''||$email==''||$password=='') $error='All fields required.';
    else{
        $stmt=$conn->prepare('SELECT user_id FROM users WHERE email=? LIMIT 1'); $stmt->bind_param('s',$email); $stmt->execute(); $res=$stmt->get_result(); if($res->fetch_assoc()){ $error='Email already registered.'; $stmt->close(); }
        else{
            $hash = password_hash($password,PASSWORD_DEFAULT);
            $ins = $conn->prepare('INSERT INTO users (username,email,password) VALUES (?,?,?)');
            $ins->bind_param('sss',$username,$email,$hash);
            if ($ins->execute()){ $success='Registered. You can now login.'; } else $error='DB error: '.$ins->error;
            $ins->close();
        }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Register</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<main class="container">
  <h1>Register</h1>
  <?php if ($error): ?><div class="alert error"><?php echo $error;?></div><?php endif; ?>
  <?php if ($success): ?><div class="alert success"><?php echo $success;?></div><?php endif; ?>
  <form method="post" class="form-box" onsubmit="return validateRegister();">
    <label>Username<br><input name="username" required></label>
    <label>Email<br><input name="email" type="email" required></label>
    <label>Password<br><input id="password" name="password" type="password" required></label>
    <label>Confirm Password<br><input id="confirm_password" type="password" required></label>
    <button type="submit">Register</button>
  </form>
  <p>Already registered? <a href="login.php">Login</a></p>
</main>
<script src="js/validation.js"></script>
</body></html>
