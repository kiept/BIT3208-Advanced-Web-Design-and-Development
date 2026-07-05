<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$basePrefix = str_contains($_SERVER['SCRIPT_NAME'] ?? '', '/weeks/') ? '../' : '';
$productId = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT id, name, price, description FROM products WHERE id = :id');
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
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    $message = 'Item added to cart.';
}

include __DIR__ . '/includes/header.php';
?>

<main class="container">
    <section class="card detail-card">
        <h1><?= htmlspecialchars($product['name']) ?></h1>
        <?php $imagePath = [
            1 => 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea?auto=format&fit=crop&w=900&q=80',
            2 => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=900&q=80',
            3 => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=900&q=80',
            4 => 'https://images.unsplash.com/photo-1527814050087-3793815479db?auto=format&fit=crop&w=900&q=80',
        ][(int) $product['id']] ?? ''; ?>
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
            <button type="submit">Add to cart</button>
        </form>
        <p><a href="<?= $basePrefix ?>catalog.php">← Back to catalog</a></p>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
