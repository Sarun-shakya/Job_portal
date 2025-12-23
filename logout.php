<?php
session_start();

$_SESSION = [];

session_destroy();

if (isset($_COOKIE['user_id'])) {
    setcookie('user_id', '', time() - 3600, '/'); 
}
session_start(); 
$_SESSION['success_msg'] = "✅ Logged out successfully";
header("Location: index.php");
exit();
