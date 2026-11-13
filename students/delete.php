<?php
require_once __DIR__ . '/../config/database.php'; require_once __DIR__ . '/../includes/auth.php';
$id=(int)($_GET['id']??0);
if($id>0){$stmt=$pdo->prepare("DELETE FROM students WHERE id=?");$stmt->execute([$id]);flash('success',$stmt->rowCount()?'Student deleted successfully.':'Student not found.');}
redirect('/student-management-system/students/view.php');
