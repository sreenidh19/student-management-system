<?php
require_once __DIR__ . '/includes/functions.php';
if (!empty($_SESSION['admin_id'])) {
    redirect('/student-management-system/dashboard/index.php');
}
redirect('/student-management-system/login.php');
