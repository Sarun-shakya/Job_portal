<!--  Employee Dashboard  -->
<?php

if (!isset($_GET['page'])) {
    header("Location: emp-dashboard.php?page=dashboard");
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$allowed_pages = ['dashboard', 'post-job', 'manage-jobs', 'manage-applications','profile', 'logout'];

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['EMPLOYER_LOGGED_IN']) || $_SESSION['EMPLOYER_LOGGED_IN'] !== true) {
    $_SESSION['error_msg'] = "Please login to access the dashboard.";
    header("Location: emp-login.php"); // your login page
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal - Employee Dashboard</title>
    <!-- Remix Icon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/emp-dashboard.css">

    <!-- Quill CSS & JS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../css/flash.css">
    <style>


    </style>
</head>

<body>
    <?php

    include "../includes/flash.php";
    ?>
    <!-- Nav Bar -->
    <nav>
        <div class="container">
            <div class="nav-logo">
                <a href="#" class="logo">Job<span>Portal</span></a>
            </div>
            <div class="nav-menu-btn" id="menu-btn">
                <i class="ri-menu-line"></i>
            </div>
            <div class="employee-detail">
                <span><?php echo $_SESSION['EMPLOYER_NAME']; ?></span>
                <img src="uploads/<?php echo $_SESSION['EMPLOYER_LOGO'] ?>" alt="Profile Pic">
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <ul>
            <li><a href="emp-dashboard.php?page=dashboard" class="menu-item " data-page="dashboard"><i class="ri-dashboard-line"></i>Dashboard</a></li> <!-- Fixed typo -->
            <li><a href="emp-dashboard.php?page=post-job" class="menu-item" data-page="post-job"><i class="ri-add-fill"></i>Post Job</a></li>
            <li><a href="emp-dashboard.php?page=manage-jobs" class="menu-item" data-page="manage-jobs"><i class="ri-briefcase-line"></i>Manage Jobs</a></li>
            <li><a href="emp-dashboard.php?page=manage-applications" class="menu-item" data-page="manage-applications"><i class="ri-file-list-3-line"></i>Manage Applications</a></li>
            <li><a href="emp-dashboard.php?page=profile" class="menu-item" data-page="profile"><i class="ri-user-line"></i>Profile</a></li>
            <li>
                <a href="emp-logout.php" class="menu-item" onclick="return confirm('Are you sure you want to log out?');">
                    <i class="ri-logout-box-line"></i> Log Out
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <main id="main">
        <div class="container" id="main-content">
            <?php
            if (in_array($page, $allowed_pages)) {
                include "content/{$page}.php";
            } else {
                echo "<h2>Page not found</h2>";
            }
            ?>
        </div>
    </main>

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const sidebar = document.getElementById('sidebar');
        const main = document.getElementById('main');

        const overlay = document.createElement('div');
        overlay.classList.add('sidebar-overlay');
        document.body.appendChild(overlay);

        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            main.classList.toggle('sidebar-open');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            main.classList.remove('sidebar-open');
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                main.classList.remove('sidebar-open');
            }
        });

        const urlParams = new URLSearchParams(window.location.search);
        const currentPage = urlParams.get('page') || 'dashboard'; // default to dashboard


        document.querySelectorAll('.sidebar a').forEach(link => {
            link.classList.remove('active');
        });

        const activeLink = document.querySelector(`.sidebar a[href*="page=${currentPage}"]`);
        if (activeLink) {
            activeLink.classList.add('active');
        }


        window.addEventListener('DOMContentLoaded', () => {
            const flashMessage = document.getElementById('flashMessage');
            if (flashMessage) {
                setTimeout(() => {
                    flashMessage.classList.add('show');
                }, 25);

                setTimeout(() => {
                    flashMessage.classList.remove('show');
                    flashMessage.classList.add('hide');


                    setTimeout(() => {
                        if (flashMessage.parentNode) {
                            flashMessage.parentNode.removeChild(flashMessage);
                        }
                    }, 500);
                }, 3000);
            }
        });
    </script>

</body>

</html>