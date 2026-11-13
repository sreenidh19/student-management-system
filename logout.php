<?php
require_once __DIR__ . '/includes/functions.php';
$_SESSION = [];
session_destroy();
header('Location: /student-management-system/login.php');
exit;
