<?php
include 'db.php';
include 'includes/auth.php';
$error=''; $success='';
if ($_SERVER['REQUEST_METHOD']=='POST'){
  $fullname = trim($_POST['fullname'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $role = $_POST['role'] ?? 'student';
  if ($fullname==''||$email==''||$password=='') $error='All fields required.';
  else{
    $stmt=$conn->prepare('SELECT user_id FROM users WHERE email=? LIMIT 1'); $stmt->bind_param('s',$email); $stmt->execute(); $r=$stmt->get_result(); if($r->fetch_assoc()){ $error='Email taken.'; $stmt->close(); }
    else{
      $hash = password_hash($password,PASSWORD_DEFAULT);
      $ins=$conn->prepare('INSERT INTO users (fullname,email,password,role) VALUES (?,?,?,?)');
      $ins->bind_param('ssss',$fullname,$email,$hash,$role);
      if($ins->execute()) $success='Registration complete. You can login.'; else $error='DB error: '.$ins->error;
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
  <?php if ($error): ?><div class="alert error"><?php echo $error; ?></div><?php endif; ?>
  <?php if ($success): ?><div class="alert success"><?php echo $success; ?></div><?php endif; ?>
  <form method="post" onsubmit="return validateRegister();" class="form-box">
    <label>Full Name<br><input name="fullname" required></label>
    <label>Email<br><input name="email" type="email" required></label>
    <label>Password<br><input id="password" name="password" type="password" required></label>
    <label>Role<br><select name="role"><option value="student">Student</option><option value="lecturer">Lecturer</option><option value="admin">Administrator</option></select></label>
    <button type="submit">Register</button>
  </form>
  <p>Already registered? <a href="login.php">Login</a></p>
</main>
<script src="js/validation.js"></script>
</body></html>
