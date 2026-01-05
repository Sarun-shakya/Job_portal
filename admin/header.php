<!-- Header.php -->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../config/db.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Get current page
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ucfirst(str_replace('.php', '', $current_page)) ?> - Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">

</head>

<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <p>Job<span>Portal</span></p>
            </div>

            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item <?= $current_page === 'dashboard.php' ? 'active' : '' ?>">
                    <span class="icon"><i class="ri-dashboard-line"></i></span> Dashboard
                </a>
                <a href="users.php" class="nav-item <?= $current_page === 'users.php' ? 'active' : '' ?>">
                    <span class="icon"><i class="ri-group-line"></i></span> Users
                </a>
                <a href="employers.php" class="nav-item <?= $current_page === 'employers.php' ? 'active' : '' ?>">
                    <span class="icon"><i class="ri-hotel-line"></i></span> Employers
                </a>
                <a href="jobs.php" class="nav-item <?= $current_page === 'jobs.php' ? 'active' : '' ?>">
                    <span class="icon"><i class="ri-briefcase-line"></i></span> Jobs
                </a>
                <a href="applications.php" class="nav-item <?= $current_page === 'applications.php' ? 'active' : '' ?>">
                    <span class="icon"><i class="ri-file-list-line"></i> </span> Applications
                </a>
                <a href="settings.php" class="nav-item <?= $current_page === 'settings.php' ? 'active' : '' ?>">
                    <span class="icon"><i class="ri-settings-3-line"></i></span> Settings
                </a>
                <a href="logout.php" class="nav-item"
                    onclick="return confirm('Are you sure you want to log out?');">
                    <span class="icon"><i class="ri-logout-box-line"></i></span> Logout
                </a>

            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
                </div>
                <div class="header-right">
                    <span class="admin-name">Welcome, <?= $_SESSION['admin_username'] ?> </span>
                </div>
            </header>

            <main class="content-area">