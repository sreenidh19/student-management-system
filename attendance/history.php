<?php
require_once __DIR__ . '/../config/database.php'; require_once __DIR__ . '/../includes/auth.php';
$date=$_GET['date']??''; $sql="SELECT a.attendance_date,a.status,s.name,s.enrollment_no FROM attendance a JOIN students s ON s.id=a.student_id";$params=[];
if($date!==''){$sql.=" WHERE a.attendance_date=?";$params[]=$date;}
$sql.=" ORDER BY a.attendance_date DESC,s.name";$stmt=$pdo->prepare($sql);$stmt->execute($params);$rows=$stmt->fetchAll();
$pageTitle='Attendance history';$active='history';require __DIR__.'/../includes/header.php';require __DIR__.'/../includes/sidebar.php';
?>
<div class="page-heading"><div><p class="eyebrow">ATTENDANCE</p><h1>Attendance history</h1><p class="muted">Review saved attendance records by date.</p></div><a class="btn primary" href="mark.php">＋ Mark attendance</a></div>
<div class="panel"><form method="get" class="filter-bar"><label class="inline-label">Filter by date</label><input type="date" name="date" value="<?= e($date) ?>"><button class="btn primary">Filter</button><a class="btn secondary" href="history.php">Clear</a></form>
<div class="table-wrap"><table><thead><tr><th>Date</th><th>Student</th><th>Enrollment number</th><th>Status</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><?= e(date('d M Y',strtotime($r['attendance_date']))) ?></td><td><strong><?= e($r['name']) ?></strong></td><td><?= e($r['enrollment_no']) ?></td><td><span class="pill <?= $r['status']==='Present'?'pill-green':'pill-red' ?>"><?= e($r['status']) ?></span></td></tr><?php endforeach; ?>
<?php if(!$rows): ?><tr><td colspan="4" class="empty-cell">No attendance records found.</td></tr><?php endif; ?>
</tbody></table></div><div class="table-foot"><?= count($rows) ?> attendance record(s)</div></div>
<?php require __DIR__.'/../includes/footer.php'; ?>
