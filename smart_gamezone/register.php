<?php
require_once __DIR__ . '/includes/db.php';

$pageTitle = 'Register';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $email === '' || $password === '') {
        $message = 'Please fill in all fields.';
    } else {
        $check = $pdo->prepare('SELECT id FROM users WHERE username = :username OR email = :email');
        $check->execute([':username' => $username, ':email' => $email]);
        if ($check->fetch()) {
            $message = 'That username or email already exists.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash, role) VALUES (:username, :email, :password_hash, :role)');
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password_hash' => password_hash($password, PASSWORD_DEFAULT),
                ':role' => 'customer',
            ]);
            $message = 'Account created successfully. You can now log in.';
        }
    }
}

include __DIR__ . '/includes/header.php';
?>

<main class="container">
    <section class="card">
        <h1>Create an account</h1>
        <p>Register to save your orders and access the Smart GameZone experience.</p>
        <?php if ($message !== ''): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="post" class="form-grid">
            <label>
                Username
                <input type="text" name="username" required>
            </label>
            <label>
                Email
                <input type="email" name="email" required>
            </label>
            <label>
                Password
                <input type="password" name="password" required>
            </label>
            <button type="submit">Register</button>
        </form>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
