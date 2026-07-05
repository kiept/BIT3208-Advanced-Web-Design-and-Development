<?php
session_start();
require_once __DIR__ . '/includes/db.php';

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$pageTitle = 'Order History';
$userId = (int) $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT id, customer_name, customer_email, total, created_at FROM orders WHERE user_id = :user_id ORDER BY created_at DESC');
$stmt->execute([':user_id' => $userId]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/includes/header.php';
?>

<main class="container">
    <section class="card">
        <h1>Order History</h1>
        <?php if (empty($orders)): ?>
            <p>You have not placed any orders yet.</p>
        <?php else: ?>
            <ul class="idea-list">
                <?php foreach ($orders as $order): ?>
                    <li>
                        <strong>Order #<?= htmlspecialchars($order['id']) ?></strong>
                        <p>Placed on <?= htmlspecialchars($order['created_at']) ?> | Total: KSh <?= htmlspecialchars($order['total']) ?></p>
                        <p>Shipping to: <?= htmlspecialchars($order['customer_name']) ?> (<?= htmlspecialchars($order['customer_email']) ?>)</p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php';
