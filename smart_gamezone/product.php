<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$basePrefix = str_contains($_SERVER['SCRIPT_NAME'] ?? '', '/weeks/') ? '../' : '';
$productId = (int) ($_GET['id'] ?? 0);
$selectColumns = getProductSelectColumns($pdo);
$stmt = $pdo->prepare("SELECT $selectColumns FROM products WHERE id = :id");
$stmt->execute([':id' => $productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: catalog.php');
    exit;
}

$pageTitle = $product['name'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $id = (int) $_POST['product_id'];
    $quantity = max(1, (int) ($_POST['quantity'] ?? 1));
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $quantity;
    $message = 'Added ' . $quantity . ' item(s) to cart.';
}

include __DIR__ . '/includes/header.php';
?>

<main class="container">
    <section class="card detail-card">
        <h1><?= htmlspecialchars($product['name']) ?></h1>
        <?php $imagePath = $product['image_url'] ?: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=900&q=80'; ?>
        <?php if ($imagePath !== ''): ?>
            <img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image detail-image">
        <?php endif; ?>
        <p><?= htmlspecialchars($product['description']) ?></p>
        <p class="price">KSh <?= htmlspecialchars($product['price']) ?></p>
        <?php if (!empty($message ?? '')): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="post" class="form-grid">
            <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
            <label>
                Quantity
                <input type="number" name="quantity" value="1" min="1">
            </label>
            <button type="submit">Add to cart</button>
        </form>
        <p><a href="<?= $basePrefix ?>catalog.php">← Back to catalog</a></p>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
