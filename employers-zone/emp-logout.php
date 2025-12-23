<?php
session_start();

// Unset all employer session variables
unset($_SESSION['EMPLOYER_ID']);
unset($_SESSION['EMPLOYER_NAME']);
unset($_SESSION['EMPLOYER_LOGGED_IN']);
unset($_SESSION['EMPLOYER_LOGO']);
unset($_SESSION['success_msg']);
unset($_SESSION['error_msg']);

// Optional: delete "remember me" cookie if you set it
if (isset($_COOKIE['EMPLOYER_ID'])) {
    setcookie('EMPLOYER_ID', '', time() - 3600, "/");
}

// Destroy the session completely
session_destroy();

session_start(); // start new session to set message
$_SESSION['success_msg'] = "✅ Logged out successfully";

// Redirect to employer login page
header("Location: emp-login.php");
exit;
?>
