<?php
require_once __DIR__ . '/../config/database.php'; require_once __DIR__ . '/../includes/auth.php';
$id=(int)($_GET['id'] ?? 0); $stmt=$pdo->prepare("SELECT * FROM students WHERE id=?"); $stmt->execute([$id]); $student=$stmt->fetch();
if (!$student) { flash('error','Student not found.'); redirect('/student-management-system/students/view.php'); }
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    verify_csrf();
    $data=[trim($_POST['name']??''),trim($_POST['enrollment_no']??''),trim($_POST['branch']??''),(int)($_POST['semester']??0),trim($_POST['email']??''),trim($_POST['phone']??''),$_POST['gender']??'Prefer not to say',trim($_POST['address']??''),$id];
    if ($data[0]===''||$data[1]===''||$data[2]===''||$data[3]<1||$data[3]>12||($data[4]!==''&&!filter_var($data[4],FILTER_VALIDATE_EMAIL))) $error='Check required fields, semester and email.';
    else { try {$u=$pdo->prepare("UPDATE students SET name=?,enrollment_no=?,branch=?,semester=?,email=?,phone=?,gender=?,address=? WHERE id=?");$u->execute($data);flash('success','Student updated successfully.');redirect('/student-management-system/students/view.php');}catch(PDOException $ex){$error='Could not update. Enrollment number may already exist.';} }
    $student=array_merge($student,['name'=>$data[0],'enrollment_no'=>$data[1],'branch'=>$data[2],'semester'=>$data[3],'email'=>$data[4],'phone'=>$data[5],'gender'=>$data[6],'address'=>$data[7]]);
}
$pageTitle='Edit student';$active='students';require __DIR__.'/../includes/header.php';require __DIR__.'/../includes/sidebar.php';
?>
<div class="page-heading"><div><p class="eyebrow">STUDENT DIRECTORY</p><h1>Edit student</h1><p class="muted">Update the student information.</p></div><a class="btn secondary" href="view.php">← Back</a></div>
<div class="panel form-panel"><?php if($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
<form method="post" class="form-grid"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<div class="field"><label>Student name *</label><input name="name" required value="<?= e($student['name']) ?>"></div><div class="field"><label>Enrollment number *</label><input name="enrollment_no" required value="<?= e($student['enrollment_no']) ?>"></div>
<div class="field"><label>Branch *</label><input name="branch" required value="<?= e($student['branch']) ?>"></div><div class="field"><label>Semester *</label><select name="semester"><?php for($i=1;$i<=12;$i++): ?><option value="<?= $i ?>" <?= $student['semester']==$i?'selected':'' ?>><?= $i ?></option><?php endfor; ?></select></div>
<div class="field"><label>Email</label><input type="email" name="email" value="<?= e($student['email']) ?>"></div><div class="field"><label>Phone</label><input name="phone" value="<?= e($student['phone']) ?>"></div>
<div class="field"><label>Gender</label><select name="gender"><?php foreach(['Male','Female','Other','Prefer not to say'] as $g): ?><option <?= $student['gender']===$g?'selected':'' ?>><?= e($g) ?></option><?php endforeach; ?></select></div>
<div class="field span-2"><label>Address</label><textarea name="address" rows="3"><?= e($student['address']) ?></textarea></div><div class="form-actions span-2"><button class="btn primary">Update student</button><a class="btn secondary" href="view.php">Cancel</a></div></form></div>
<?php require __DIR__.'/../includes/footer.php'; ?>
