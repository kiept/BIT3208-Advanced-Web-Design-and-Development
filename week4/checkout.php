<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!validate_csrf($_POST['csrf'] ?? '')) {
    $message = 'Invalid form submission.';
  } else {
    $name = trim($_POST['name'] ?? '');
    $product = trim($_POST['product'] ?? '');
    $address = trim($_POST['address'] ?? '');
    if ($name && $product && $address) {
      $pdo = getPDO();
      $ins = $pdo->prepare('INSERT INTO orders (name,product,address) VALUES (:n,:p,:a)');
      $ins->execute([':n'=>$name,':p'=>$product,':a'=>$address]);
      $message = 'Order received. Thank you, ' . htmlspecialchars($name) . '!';
    } else {
      $message = 'Please fill all fields.';
    }
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Checkout</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main class="form-box">
    <h1>Checkout</h1>
    <?php if ($message): ?>
      <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="post" action="">
      <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(csrf_token()); ?>">
      <label>Name<br><input name="name" required></label>
      <label>Product<br><input name="product" required></label>
      <label>Address<br><textarea name="address" required></textarea></label>
      <button type="submit">Place Order</button>
    </form>
  </main>
</body>
</html>
