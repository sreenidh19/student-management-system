<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/config/database.php';

$count = (int)$pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn();
if ($count > 0) {
    flash('error', 'An administrator account already exists. Please log in.');
    redirect('/student-management-system/login.php');
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
        $error = 'Enter your name, a valid email and a password with at least 8 characters.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO admins (name, email, password) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
            flash('success', 'Administrator account created. You can now log in.');
            redirect('/student-management-system/login.php');
        } catch (PDOException $ex) {
            $error = 'Could not create account. This email may already be registered.';
        }
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Create Admin</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body class="auth-page"><div class="auth-card"><div class="auth-logo">S</div><p class="eyebrow">FIRST-TIME SETUP</p><h1>Create administrator</h1><p class="muted">Create the first admin account for your project.</p>
<?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
<form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<label>Full name</label><input name="name" required maxlength="100" value="<?= e($_POST['name'] ?? '') ?>">
<label>Email address</label><input type="email" name="email" required maxlength="150" value="<?= e($_POST['email'] ?? '') ?>">
<label>Password</label><input type="password" name="password" required minlength="8">
<button class="btn primary full" type="submit">Create account</button></form><p class="auth-note"><a href="login.php">Back to login</a></p></div></body></html>
