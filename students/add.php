<?php
require_once __DIR__ . '/../config/database.php'; require_once __DIR__ . '/../includes/auth.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $data = [
        trim($_POST['name'] ?? ''), trim($_POST['enrollment_no'] ?? ''), trim($_POST['branch'] ?? ''),
        (int)($_POST['semester'] ?? 0), trim($_POST['email'] ?? ''), trim($_POST['phone'] ?? ''),
        $_POST['gender'] ?? '', trim($_POST['address'] ?? '')
    ];
    if ($data[0] === '' || $data[1] === '' || $data[2] === '' || $data[3] < 1 || $data[3] > 12 ||
        ($data[4] !== '' && !filter_var($data[4], FILTER_VALIDATE_EMAIL)) ||
        !in_array($data[6], ['Male','Female','Other','Prefer not to say'], true)) {
        $error = 'Please complete the required fields and check the email/semester values.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO students (name,enrollment_no,branch,semester,email,phone,gender,address) VALUES (?,?,?,?,?,?,?,?)");
            $stmt->execute($data); flash('success', 'Student added successfully.'); redirect('/student-management-system/students/view.php');
        } catch (PDOException $ex) { $error = 'Could not save student. Check that the enrollment number is unique.'; }
    }
}
$pageTitle='Add student'; $active='add'; require __DIR__ . '/../includes/header.php'; require __DIR__ . '/../includes/sidebar.php';
?>
<div class="page-heading"><div><p class="eyebrow">STUDENT DIRECTORY</p><h1>Add a student</h1><p class="muted">Enter the student information below.</p></div><a class="btn secondary" href="view.php">← Back to students</a></div>
<div class="panel form-panel"><?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
<form method="post" class="form-grid" id="studentForm"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<div class="field"><label>Student name *</label><input name="name" required maxlength="120" value="<?= e($_POST['name'] ?? '') ?>"></div>
<div class="field"><label>Enrollment number *</label><input name="enrollment_no" required maxlength="50" value="<?= e($_POST['enrollment_no'] ?? '') ?>"></div>
<div class="field"><label>Branch *</label><input name="branch" required maxlength="100" placeholder="e.g. CSE" value="<?= e($_POST['branch'] ?? '') ?>"></div>
<div class="field"><label>Semester *</label><select name="semester" required><option value="">Select semester</option><?php for($i=1;$i<=12;$i++): ?><option value="<?= $i ?>" <?= (($_POST['semester'] ?? '')==$i)?'selected':'' ?>><?= $i ?></option><?php endfor; ?></select></div>
<div class="field"><label>Email</label><input type="email" name="email" maxlength="150" value="<?= e($_POST['email'] ?? '') ?>"></div>
<div class="field"><label>Phone</label><input name="phone" maxlength="20" value="<?= e($_POST['phone'] ?? '') ?>"></div>
<div class="field"><label>Gender</label><select name="gender"><option value="Prefer not to say">Prefer not to say</option><option>Male</option><option>Female</option><option>Other</option></select></div>
<div class="field span-2"><label>Address</label><textarea name="address" rows="3"><?= e($_POST['address'] ?? '') ?></textarea></div>
<div class="form-actions span-2"><button class="btn primary" type="submit">Save student</button><a class="btn secondary" href="view.php">Cancel</a></div></form></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
