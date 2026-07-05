<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$pageTitle = 'Catalog';
$products = $pdo->query('SELECT id, name, price, description FROM products ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);

$imageMap = [
    1 => 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea?auto=format&fit=crop&w=900&q=80',
    2 => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=900&q=80',
    3 => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=900&q=80',
    4 => 'https://images.unsplash.com/photo-1527814050087-3793815479db?auto=format&fit=crop&w=900&q=80',
];

include __DIR__ . '/includes/header.php';
?>

<main class="container">
    <section class="card">
        <h1>Gaming products</h1>
        <p>Browse the latest gaming hardware and accessories for your setup.</p>
        <div class="grid">
            <?php foreach ($products as $product): ?>
                <?php $imagePath = $imageMap[(int) $product['id']] ?? ''; ?>
                <article class="card product-card">
                    <?php if ($imagePath !== ''): ?>
                        <img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p><?= htmlspecialchars($product['description']) ?></p>
                    <p><strong>KSh <?= htmlspecialchars($product['price']) ?></strong></p>
                    <p><a class="button" href="product.php?id=<?= (int) $product['id'] ?>">View product</a></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
