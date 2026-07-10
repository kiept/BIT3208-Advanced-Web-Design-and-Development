<?php
require_once __DIR__ . '/includes/functions.php';
$message='';
if ($_SERVER['REQUEST_METHOD']==='POST'){
  if (!validate_csrf($_POST['csrf'] ?? '')){
    $message = 'Invalid form submission.';
  } else {
    $name=trim($_POST['name'] ?? '');
    $email=trim($_POST['email'] ?? '');
    $msg=trim($_POST['message'] ?? '');
    if ($name && $email && $msg) {
      $message = 'Thanks ' . htmlspecialchars($name) . ', we received your message.';
    } else {
      $message = 'Please complete all fields.';
    }
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Contact</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main class="form-box">
    <h1>Contact</h1>
    <?php if ($message): ?><div class="message"><?php echo $message; ?></div><?php endif; ?>
    <form method="post" action="">
      <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(csrf_token()); ?>">
      <label>Name<br><input name="name" required></label>
      <label>Email<br><input type="email" name="email" required></label>
      <label>Message<br><textarea name="message" required></textarea></label>
      <button type="submit">Send</button>
    </form>
  </main>
</body>
</html>
