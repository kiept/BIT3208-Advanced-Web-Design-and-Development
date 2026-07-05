<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$pageTitle = 'Cart';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $productId = (int) ($_POST['product_id'] ?? 0);

    if ($productId > 0 && isset($_SESSION['cart'][$productId])) {
        if ($action === 'remove') {
            unset($_SESSION['cart'][$productId]);
        } elseif ($action === 'update') {
            $quantity = max(1, (int) ($_POST['quantity'] ?? 1));
            $_SESSION['cart'][$productId] = $quantity;
        }
    }

    header('Location: cart.php');
    exit;
}

$cartItems = [];
if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare('SELECT id, name, price, image_url FROM products WHERE id IN (' . $placeholders . ')');
    $stmt->execute($ids);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$total = 0;
foreach ($cartItems as $item) {
    $id = (int) $item['id'];
    $quantity = $_SESSION['cart'][$id] ?? 1;
    $total += (float) $item['price'] * $quantity;
}

include __DIR__ . '/includes/header.php';
?>

<main class="container">
    <section class="card">
        <h1>Your cart</h1>
        <?php if (empty($cartItems)): ?>
            <p>Your cart is empty. Visit the catalog and add a product.</p>
        <?php else: ?>
            <ul class="idea-list">
                <?php foreach ($cartItems as $item): ?>
                    <?php $quantity = $_SESSION['cart'][(int) $item['id']] ?? 1; ?>
                    <?php $imagePath = $item['image_url'] ?? ''; ?>
                    <li>
                        <?php if ($imagePath): ?>
                            <img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="product-image">
                        <?php endif; ?>
                        <div>
                        <strong><?= htmlspecialchars($item['name']) ?></strong>
                        <p>Quantity: <?= (int) $quantity ?> | Price: KSh <?= htmlspecialchars($item['price']) ?></p>
                            <form method="post" class="form-grid">
                                <input type="hidden" name="product_id" value="<?= (int) $item['id'] ?>">
                                <label>
                                    Quantity
                                    <input type="number" name="quantity" value="<?= (int) $quantity ?>" min="1">
                                </label>
                                <div>
                                    <button type="submit" name="action" value="update">Update</button>
                                    <button type="submit" name="action" value="remove">Remove</button>
                                </div>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p><strong>Total: KSh <?= number_format($total, 2) ?></strong></p>
            <p><a class="button" href="checkout.php">Proceed to checkout</a></p>
        <?php endif; ?>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
