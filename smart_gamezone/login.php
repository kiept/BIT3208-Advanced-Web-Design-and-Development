<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$pageTitle = 'Login';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = $pdo->prepare('SELECT id, username, password_hash, role FROM users WHERE username = :username');
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: index.php');
        exit;
    }

    $message = 'Invalid username or password.';
}

include __DIR__ . '/includes/header.php';
?>

<main class="container">
    <section class="card">
        <h1>Login</h1>
        <?php if ($message !== ''): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="post" class="form-grid">
            <label>
                Username
                <input type="text" name="username" required>
            </label>
            <label>
                Password
                <input type="password" name="password" required>
            </label>
            <button type="submit">Login</button>
        </form>
        <p><a href="register.php">Create a new account</a></p>
    </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
