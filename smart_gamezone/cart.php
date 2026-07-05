<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$pageTitle = 'Cart';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cartItems = [];
if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare('SELECT id, name, price FROM products WHERE id IN (' . $placeholders . ')');
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
                    <li>
                        <strong><?= htmlspecialchars($item['name']) ?></strong>
                        <p>Quantity: <?= (int) $quantity ?> | Price: KSh <?= htmlspecialchars($item['price']) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p><strong>Total: KSh <?= number_format($total, 2) ?></strong></p>
            <p><a class="button" href="checkout.php">Proceed to checkout</a></p>
        <?php endif; ?>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
