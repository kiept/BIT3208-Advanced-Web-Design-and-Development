<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$basePrefix = str_contains($_SERVER['SCRIPT_NAME'] ?? '', '/weeks/') ? '../' : '';
$selectColumns = getProductSelectColumns($pdo);
$products = $pdo->query("SELECT $selectColumns FROM products ORDER BY id LIMIT 4")->fetchAll(PDO::FETCH_ASSOC);

$imageMap = [
    1 => 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea?auto=format&fit=crop&w=900&q=80',
    2 => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=900&q=80',
    3 => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=900&q=80',
    4 => 'https://images.unsplash.com/photo-1527814050087-3793815479db?auto=format&fit=crop&w=900&q=80',
];
?>
<?php $pageTitle = 'Smart GameZone'; include __DIR__ . '/includes/header.php'; ?>

<main class="container">
    <section class="hero">
        <h1>Smart GameZone</h1>
        <p>Discover premium gaming gear built for serious players. Explore featured products, add favorites to your cart, and enjoy a smooth shopping experience from the first page.</p>
        <a class="button" href="catalog.php">Shop now</a>
        
    </section>

    <section class="card">
        <h2>Featured products</h2>
        <div class="grid">
            <?php foreach ($products as $product): ?>
                <article class="card product-card">
                    <?php $imagePath = $product['image_url'] ?? ($imageMap[(int) $product['id']] ?? ''); ?>
                    <?php if ($imagePath !== ''): ?>
                        <img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p><?= htmlspecialchars($product['description']) ?></p>
                    <p><strong>KSh <?= htmlspecialchars($product['price']) ?></strong></p>
                    <p><a class="button" href="<?= $basePrefix ?>product.php?id=<?= (int) $product['id'] ?>">View product</a></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="card">
        <h2>Project journey</h2>
        <p>The store is structured to reflect a complete web development project, with clear progression from layout and functionality to database-driven features and a polished shopping experience.</p>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
