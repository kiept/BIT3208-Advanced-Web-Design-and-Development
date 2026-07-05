<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$pageTitle = 'Checkout';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

 $message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if ($name === '' || $email === '' || $address === '') {
        $message = 'Please complete all checkout fields.';
    } else {
        $ids = array_keys($_SESSION['cart']);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $pdo->prepare('SELECT id, price FROM products WHERE id IN (' . $placeholders . ')');
        $stmt->execute($ids);
        $orderProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($orderProducts)) {
            header('Location: cart.php');
            exit;
        }

        $total = 0;
        foreach ($orderProducts as $productItem) {
            $quantity = $_SESSION['cart'][(int) $productItem['id']] ?? 1;
            $total += (float) $productItem['price'] * $quantity;
        }

        $stmt = $pdo->prepare('INSERT INTO orders (user_id, customer_name, customer_email, shipping_address, total) VALUES (:user_id, :name, :email, :address, :total)');
        $stmt->execute([
            ':user_id' => $_SESSION['user_id'] ?? null,
            ':name' => $name,
            ':email' => $email,
            ':address' => $address,
            ':total' => $total,
        ]);

        $orderId = $pdo->lastInsertId();
        $insertItem = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (:order_id, :product_id, :quantity, :unit_price)');
        foreach ($orderProducts as $productItem) {
            $quantity = $_SESSION['cart'][(int) $productItem['id']] ?? 1;
            $insertItem->execute([
                ':order_id' => $orderId,
                ':product_id' => $productItem['id'],
                ':quantity' => $quantity,
                ':unit_price' => $productItem['price'],
            ]);
        }

        $_SESSION['order_message'] = 'Order placed successfully. Thank you for shopping at Smart GameZone.';
        $_SESSION['order_number'] = $orderId;
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
