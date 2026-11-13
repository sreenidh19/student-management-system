<?php $base = '/student-management-system'; ?>
<aside class="sidebar" id="sidebar">
    <div class="brand"><span class="brand-mark">S</span><span>Student<span class="brand-light">Desk</span></span></div>
    <div class="nav-caption">MAIN MENU</div>
    <a class="nav-link <?= ($active ?? '') === 'dashboard' ? 'active' : '' ?>" href="<?= $base ?>/dashboard/index.php">▦ <span>Dashboard</span></a>
    <a class="nav-link <?= ($active ?? '') === 'students' ? 'active' : '' ?>" href="<?= $base ?>/students/view.php">♙ <span>Students</span></a>
    <a class="nav-link <?= ($active ?? '') === 'add' ? 'active' : '' ?>" href="<?= $base ?>/students/add.php">＋ <span>Add Student</span></a>
    <a class="nav-link <?= ($active ?? '') === 'attendance' ? 'active' : '' ?>" href="<?= $base ?>/attendance/mark.php">✓ <span>Mark Attendance</span></a>
    <a class="nav-link <?= ($active ?? '') === 'history' ? 'active' : '' ?>" href="<?= $base ?>/attendance/history.php">◷ <span>Attendance History</span></a>
    <div class="sidebar-bottom">
        <div class="admin-mini"><div class="avatar"><?= e(strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1))) ?></div><div><strong><?= e($_SESSION['admin_name'] ?? 'Administrator') ?></strong><small>Administrator</small></div></div>
        <a class="nav-link logout-link" href="<?= $base ?>/logout.php">↪ <span>Log out</span></a>
    </div>
</aside>
<main class="main-area">
    <header class="topbar">
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">☰</button>
        <div><div class="topbar-title"><?= e($pageTitle) ?></div><div class="topbar-subtitle">Student Management System</div></div>
        <div class="topbar-right"><span class="status-dot"></span> Admin workspace</div>
    </header>
    <section class="content">
        <?php show_flash(); ?>
