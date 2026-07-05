<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$pageTitle = 'Catalog';
$search = trim($_GET['search'] ?? '');
$sql = 'SELECT id, name, price, description, image_url FROM products WHERE 1';
$params = [];
if ($search !== '') {
    $sql .= ' AND (name LIKE :search OR description LIKE :search)';
    $params[':search'] = '%' . $search . '%';
}
$sql .= ' ORDER BY id';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        <form method="get" class="form-grid search-form">
            <label>
                Search products
                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search by name or description">
            </label>
            <button type="submit">Search</button>
        </form>
        <?php if (empty($products)): ?>
            <p>No products match your search. Try another keyword.</p>
        <?php else: ?>
            <div class="grid">
                <?php foreach ($products as $product): ?>
                    <?php $imagePath = $product['image_url'] ?: ($imageMap[(int) $product['id']] ?? ''); ?>
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
