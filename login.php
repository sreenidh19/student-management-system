<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/config/database.php';
if (!empty($_SESSION['admin_id'])) redirect('/student-management-system/dashboard/index.php');
$error = '';
$adminCount = (int)$pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT id, name, email, password FROM admins WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($password, $admin['password'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        redirect('/student-management-system/dashboard/index.php');
    }
    $error = 'Incorrect email or password.';
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Admin Login</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body class="auth-page"><div class="auth-card"><div class="auth-logo">S</div><p class="eyebrow">WELCOME BACK</p><h1>Admin login</h1><p class="muted">Sign in to manage student records and attendance.</p>
<?php show_flash(); ?><?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
<form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<label>Email address</label><input type="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>">
<label>Password</label><input type="password" name="password" required>
<button class="btn primary full" type="submit">Sign in</button></form>
<?php if ($adminCount === 0): ?><p class="auth-note">First time here? <a href="register.php">Create the first admin account</a>.</p><?php endif; ?>
</div></body></html>
