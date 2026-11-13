<?php
require_once __DIR__ . '/../config/database.php'; require_once __DIR__ . '/../includes/auth.php';
$date=$_GET['date']??date('Y-m-d'); if(!preg_match('/^\d{4}-\d{2}-\d{2}$/',$date)) $date=date('Y-m-d');
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    verify_csrf(); $date=$_POST['attendance_date']??date('Y-m-d'); $marks=$_POST['status']??[];
    try{
        $pdo->beginTransaction();
        $check=$pdo->prepare("INSERT INTO attendance (student_id,attendance_date,status) VALUES (?,?,?) ON DUPLICATE KEY UPDATE status=VALUES(status)");
        foreach($marks as $sid=>$status){if(in_array($status,['Present','Absent'],true)) $check->execute([(int)$sid,$date,$status]);}
        $pdo->commit(); flash('success','Attendance saved for '.date('d M Y',strtotime($date)).'.'); redirect('/student-management-system/attendance/mark.php?date='.urlencode($date));
    }catch(PDOException $ex){$pdo->rollBack();$error='Could not save attendance. Please check the database and try again.';}
}
$stmt=$pdo->prepare("SELECT s.id,s.name,s.enrollment_no,a.status FROM students s LEFT JOIN attendance a ON a.student_id=s.id AND a.attendance_date=? ORDER BY s.name");$stmt->execute([$date]);$students=$stmt->fetchAll();
$pageTitle='Mark attendance';$active='attendance';require __DIR__.'/../includes/header.php';require __DIR__.'/../includes/sidebar.php';
?>
<div class="page-heading"><div><p class="eyebrow">ATTENDANCE</p><h1>Mark attendance</h1><p class="muted">Choose a date and mark each student's status.</p></div></div>
<div class="panel"><?php if($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
<form method="get" class="filter-bar"><label class="inline-label">Attendance date</label><input type="date" name="date" value="<?= e($date) ?>"><button class="btn secondary">Load students</button></form>
<?php if(!$students): ?><div class="empty-state">No students are registered. Add students before marking attendance.</div><?php else: ?>
<form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="attendance_date" value="<?= e($date) ?>">
<div class="table-wrap"><table><thead><tr><th>Student</th><th>Enrollment number</th><th>Attendance status</th></tr></thead><tbody>
<?php foreach($students as $s): ?><tr><td><strong><?= e($s['name']) ?></strong></td><td><?= e($s['enrollment_no']) ?></td><td><select name="status[<?= (int)$s['id'] ?>]" class="status-select"><option value="Present" <?= $s['status']==='Present'?'selected':'' ?>>Present</option><option value="Absent" <?= $s['status']==='Absent'?'selected':'' ?>>Absent</option></select></td></tr><?php endforeach; ?>
</tbody></table></div><div class="form-actions"><button class="btn primary">Save attendance</button><a class="btn secondary" href="history.php">View history</a></div></form><?php endif; ?></div>
<?php require __DIR__.'/../includes/footer.php'; ?>
