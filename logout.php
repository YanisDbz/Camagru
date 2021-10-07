<?php
session_start();
require_once 'config/database.php';

$user_id = $_SESSION['id'];
$queryLogoutTime = "UPDATE users set log_date = NOW() where id = '$user_id'";
$conn->exec($queryLogoutTime);


unset($_SESSION['id']);
unset($_SESSION['username']);
unset($_SESSION['email']);
unset($_SESSION['verified']);
session_destroy();
header('location: index.php');
exit();
?>