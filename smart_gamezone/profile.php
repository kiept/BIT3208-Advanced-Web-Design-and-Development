<?php
require 'config.php';
require_login();

$conn = db_connect();
$user_id = $_SESSION['user_id'];
$message = '';

// Get user details
$stmt = $conn->prepare('SELECT user_id, fullname, email FROM users WHERE user_id=?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    redirect('login.php');
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die('CSRF token validation failed');
    }

    $fullname = sanitize($_POST['fullname'] ?? '');
    $action = $_POST['action'] ?? '';

    if ($action === 'update_profile') {
        if (!$fullname) {
            $message = 'Full name is required';
        } else {
            $stmt = $conn->prepare('UPDATE users SET fullname=? WHERE user_id=?');
            $stmt->bind_param('si', $fullname, $user_id);
            if ($stmt->execute()) {
                $message = 'Profile updated successfully';
                $user['fullname'] = $fullname;
            } else {
                $message = 'Error updating profile';
            }
        }
    } elseif ($action === 'change_password') {
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        // Verify current password
        $stmt = $conn->prepare('SELECT password FROM users WHERE user_id=?');
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $pwd_row = $result->fetch_assoc();

        if (!password_verify($current_password, $pwd_row['password'])) {
            $message = 'Current password is incorrect';
        } elseif (strlen($new_password) < 8) {
            $message = 'New password must be at least 8 characters';
        } elseif ($new_password !== $confirm_password) {
            $message = 'Passwords do not match';
        } else {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare('UPDATE users SET password=? WHERE user_id=?');
            $stmt->bind_param('si', $hashed_password, $user_id);
            if ($stmt->execute()) {
                $message = 'Password changed successfully';
            } else {
                $message = 'Error changing password';
            }
        }
    }
}

$csrf_token = generate_csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Smart GameZone</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background: #f4f7ff; color: #1f2937; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { font-size: 28px; color: #2563eb; }
        .btn { padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; text-decoration: none; display: inline-block; }
        .btn-primary { background: #2563eb; color: white; }
        .btn-primary:hover { background: #1d4ed8; }
        .btn-secondary { background: #6b7280; color: white; }
        .btn-secondary:hover { background: #4b5563; }
        .message { padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; }
        .message.success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .message.error { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .section { background: white; border-radius: 8px; padding: 30px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .section h2 { font-size: 20px; margin-bottom: 20px; color: #1f2937; border-bottom: 2px solid #2563eb; padding-bottom: 10px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; }
        .form-group input:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
        .form-actions { display: flex; gap: 10px; }
        .info-item { margin-bottom: 15px; }
        .info-label { font-size: 12px; color: #6b7280; font-weight: 600; margin-bottom: 4px; }
        .info-value { font-size: 16px; color: #1f2937; font-weight: 600; }
        .quick-links { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px; }
        .quick-link { padding: 15px; background: #f9fafb; border-radius: 6px; text-align: center; text-decoration: none; color: #2563eb; font-weight: 600; border: 1px solid #e5e7eb; }
        .quick-link:hover { background: #f3f4f6; border-color: #2563eb; }

        @media (max-width: 780px) {
            .container { padding: 16px 14px 32px; }
            .header { flex-wrap: wrap; gap: 10px; }
            .section { padding: 20px; }
            .form-actions { flex-direction: column; }
            .quick-links { grid-template-columns: 1fr; }
        }
    </style>
    <?php require_once 'includes/global_styles.php'; ?>
</head>
<body>
    <?php require_once 'includes/navbar.php'; ?>
    <div class="container">
        <div class="header">
            <h1>My Profile</h1>
            <a href="dashboard.php" class="btn btn-secondary">Back</a>
        </div>

        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'Error') === false && strpos($message, 'incorrect') === false ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Account Overview -->
        <div class="section">
            <h2>Account Information</h2>
            <div class="info-item">
                <div class="info-label">Full Name</div>
                <div class="info-value"><?php echo sanitize($user['fullname']); ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Email Address</div>
                <div class="info-value"><?php echo sanitize($user['email']); ?></div>
            </div>
        </div>

        <!-- Edit Profile -->
        <div class="section">
            <h2>Update Profile</h2>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <input type="hidden" name="action" value="update_profile">
                
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="fullname" value="<?php echo sanitize($user['fullname']); ?>" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>

        <!-- Change Password -->
        <div class="section">
            <h2>Change Password</h2>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <input type="hidden" name="action" value="change_password">
                
                <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" name="current_password" required>
                </div>

                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" required>
                </div>

                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>

        <!-- Quick Links -->
        <div class="section">
            <h2>Quick Links</h2>
            <div class="quick-links">
                <a href="my_orders.php" class="quick-link">📦 My Orders</a>
                <a href="wishlist.php" class="quick-link">❤️ My Wishlist</a>
                <a href="index.php" class="quick-link">🛍️ Continue Shopping</a>
                <a href="logout.php" class="quick-link">🚪 Logout</a>
            </div>
        </div>
    </div>
</body>
</html>
