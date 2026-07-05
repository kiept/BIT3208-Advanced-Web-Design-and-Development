<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$pageTitle = 'Checkout';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if ($name !== '' && $email !== '' && $address !== '') {
        $_SESSION['order_message'] = 'Order placed successfully. Thank you for shopping at Smart GameZone.';
        unset($_SESSION['cart']);
        header('Location: confirmation.php');
        exit;
    }
}

include __DIR__ . '/includes/header.php';
?>

<main class="container">
    <section class="card">
        <h1>Checkout</h1>
        <p>Please enter your delivery details to complete the order.</p>
        <form method="post" class="form-grid">
            <label>
                Full name
                <input type="text" name="name" required>
            </label>
            <label>
                Email
                <input type="email" name="email" required>
            </label>
            <label>
                Delivery address
                <textarea name="address" rows="4" required></textarea>
            </label>
            <button type="submit">Place order</button>
        </form>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
