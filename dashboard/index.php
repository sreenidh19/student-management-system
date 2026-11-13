<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
$total = (int)$pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
$today = date('Y-m-d');
$stmt = $pdo->prepare("SELECT COUNT(*) FROM attendance WHERE attendance_date = ? AND status = 'Present'");
$stmt->execute([$today]); $present = (int)$stmt->fetchColumn();
$stmt = $pdo->prepare("SELECT COUNT(*) FROM attendance WHERE attendance_date = ? AND status = 'Absent'");
$stmt->execute([$today]); $absent = (int)$stmt->fetchColumn();
$recent = $pdo->query("SELECT id, name, enrollment_no, branch, created_at FROM students ORDER BY created_at DESC LIMIT 5")->fetchAll();
$pageTitle = 'Dashboard'; $active = 'dashboard';
require __DIR__ . '/../includes/header.php'; require __DIR__ . '/../includes/sidebar.php';
?>
<div class="welcome-row"><div><p class="eyebrow">OVERVIEW</p><h1>Good day, <?= e($_SESSION['admin_name']) ?> 👋</h1><p class="muted">Here is what is happening in your student database today.</p></div><a class="btn primary" href="/student-management-system/students/add.php">＋ Add student</a></div>
<div class="stats-grid">
<div class="stat-card"><div class="stat-icon blue">♙</div><div class="stat-label">Total students</div><div class="stat-number"><?= $total ?></div><div class="stat-foot">Registered records</div></div>
<div class="stat-card"><div class="stat-icon green">✓</div><div class="stat-label">Present today</div><div class="stat-number"><?= $present ?></div><div class="stat-foot"><?= e(date('d M Y')) ?></div></div>
<div class="stat-card"><div class="stat-icon orange">◷</div><div class="stat-label">Absent today</div><div class="stat-number"><?= $absent ?></div><div class="stat-foot"><?= e(date('d M Y')) ?></div></div>
<div class="stat-card"><div class="stat-icon purple">▤</div><div class="stat-label">Attendance marked</div><div class="stat-number"><?= $present + $absent ?></div><div class="stat-foot">Records for today</div></div>
</div>
<div class="panel"><div class="panel-heading"><div><h2>Recently added students</h2><p class="muted">Latest student registrations</p></div><a class="text-link" href="/student-management-system/students/view.php">View all →</a></div>
<?php if (!$recent): ?><div class="empty-state">No students yet. Add your first student to get started.</div><?php else: ?>
<div class="table-wrap"><table><thead><tr><th>Student</th><th>Enrollment no.</th><th>Branch</th><th>Added</th></tr></thead><tbody>
<?php foreach ($recent as $s): ?><tr><td><strong><?= e($s['name']) ?></strong></td><td><?= e($s['enrollment_no']) ?></td><td><?= e($s['branch']) ?></td><td><?= e(date('d M Y', strtotime($s['created_at']))) ?></td></tr><?php endforeach; ?>
</tbody></table></div><?php endif; ?></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
