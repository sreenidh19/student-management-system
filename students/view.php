<?php
require_once __DIR__ . '/../config/database.php'; require_once __DIR__ . '/../includes/auth.php';
$q = trim($_GET['q'] ?? ''); $branch = trim($_GET['branch'] ?? ''); $semester = trim($_GET['semester'] ?? '');
$sql = "SELECT * FROM students WHERE 1=1"; $params = [];
if ($q !== '') { $sql .= " AND (name LIKE ? OR enrollment_no LIKE ?)"; $params[]="%$q%"; $params[]="%$q%"; }
if ($branch !== '') { $sql .= " AND branch = ?"; $params[]=$branch; }
if ($semester !== '') { $sql .= " AND semester = ?"; $params[]=(int)$semester; }
$sql .= " ORDER BY created_at DESC";
$stmt=$pdo->prepare($sql); $stmt->execute($params); $students=$stmt->fetchAll();
$branches=$pdo->query("SELECT DISTINCT branch FROM students ORDER BY branch")->fetchAll(PDO::FETCH_COLUMN);
$pageTitle='Students'; $active='students'; require __DIR__ . '/../includes/header.php'; require __DIR__ . '/../includes/sidebar.php';
?>
<div class="page-heading"><div><p class="eyebrow">STUDENT DIRECTORY</p><h1>Students</h1><p class="muted">Manage all registered student records.</p></div><a class="btn primary" href="add.php">＋ Add student</a></div>
<div class="panel"><form class="filter-bar" method="get"><input name="q" placeholder="Search name or enrollment..." value="<?= e($q) ?>"><select name="branch"><option value="">All branches</option><?php foreach($branches as $b): ?><option value="<?= e($b) ?>" <?= $branch===$b?'selected':'' ?>><?= e($b) ?></option><?php endforeach; ?></select><select name="semester"><option value="">All semesters</option><?php for($i=1;$i<=12;$i++): ?><option value="<?= $i ?>" <?= $semester==(string)$i?'selected':'' ?>>Semester <?= $i ?></option><?php endfor; ?></select><button class="btn primary" type="submit">Search</button><a class="btn secondary" href="view.php">Reset</a></form>
<div class="table-wrap"><table><thead><tr><th>Student</th><th>Enrollment no.</th><th>Branch</th><th>Semester</th><th>Email</th><th>Actions</th></tr></thead><tbody>
<?php foreach($students as $s): ?><tr><td><strong><?= e($s['name']) ?></strong></td><td><?= e($s['enrollment_no']) ?></td><td><?= e($s['branch']) ?></td><td><?= e($s['semester']) ?></td><td><?= e($s['email'] ?: '—') ?></td><td class="actions"><a class="small-action" href="edit.php?id=<?= (int)$s['id'] ?>">Edit</a><a class="small-action danger-text" href="delete.php?id=<?= (int)$s['id'] ?>" onclick="return confirm('Delete this student and their attendance records?')">Delete</a></td></tr><?php endforeach; ?>
<?php if (!$students): ?><tr><td colspan="6" class="empty-cell">No matching students found.</td></tr><?php endif; ?>
</tbody></table></div><div class="table-foot"><?= count($students) ?> student record(s)</div></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
