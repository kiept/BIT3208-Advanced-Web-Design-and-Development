<?php
session_start();
require_once __DIR__ . '/includes/db.php';

 $pageTitle = 'Order Confirmation';
 $message = $_SESSION['order_message'] ?? 'Your order has been placed.';
 $orderNumber = $_SESSION['order_number'] ?? null;
 unset($_SESSION['order_message'], $_SESSION['order_number']);

include __DIR__ . '/includes/header.php';
?>

<main class="container">
    <section class="card">
        <h1>Order confirmed</h1>
        <p><?= htmlspecialchars($orderNumber ? 'Order #' . $orderNumber . ' confirmed. ' . $message : $message) ?></p>
        <p><a href="catalog.php">Continue shopping</a></p>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
