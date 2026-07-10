<?php
require_once __DIR__ . '/includes/db.php';
$pdo = getPDO();
$action = $_GET['action'] ?? '';
if ($action === 'delete' && !empty($_GET['id'])) {
    $stmt = $pdo->prepare('DELETE FROM products WHERE id = :id');
    $stmt->execute([':id'=>$_GET['id']]);
    header('Location: products.php'); exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $sku = trim($_POST['sku'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    if (!empty($_POST['id'])) {
        $stmt = $pdo->prepare('UPDATE products SET name=:n,sku=:s,price=:p WHERE id=:id');
        $stmt->execute([':n'=>$name,':s'=>$sku,':p'=>$price,':id'=>$_POST['id']]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO products (name,sku,price) VALUES (:n,:s,:p)');
        $stmt->execute([':n'=>$name,':s'=>$sku,':p'=>$price]);
    }
    header('Location: products.php'); exit;
}
$items = $pdo->query('SELECT * FROM products ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Products CRUD</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main class="container">
    <h1>Products</h1>
    <section>
      <h2>Add / Edit Product</h2>
      <form method="post">
        <input type="hidden" name="id" id="pid">
        <label>Name<br><input name="name" id="pname" required></label>
        <label>SKU<br><input name="sku" id="psku"></label>
        <label>Price<br><input name="price" id="pprice" type="number" step="0.01"></label>
        <button type="submit">Save</button>
      </form>
    </section>

    <section>
      <h2>All Products</h2>
      <table border="1" cellpadding="6" cellspacing="0">
        <thead><tr><th>ID</th><th>Name</th><th>SKU</th><th>Price</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach($items as $s): ?>
          <tr>
            <td><?php echo $s['id']; ?></td>
            <td><?php echo htmlspecialchars($s['name']); ?></td>
            <td><?php echo htmlspecialchars($s['sku']); ?></td>
            <td><?php echo number_format($s['price'],2); ?></td>
            <td>
              <a href="#" onclick="edit(<?php echo $s['id']; ?>,'<?php echo addslashes($s['name']); ?>','<?php echo addslashes($s['sku']); ?>',<?php echo $s['price']; ?>)">Edit</a>
              | <a href="?action=delete&id=<?php echo $s['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </main>
  <script>
    function edit(id,name,sku,price){
      document.getElementById('pid').value=id;
      document.getElementById('pname').value=name;
      document.getElementById('psku').value=sku;
      document.getElementById('pprice').value=price;
      window.scrollTo(0,0);
    }
  </script>
</body>
</html>
