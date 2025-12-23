<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../config/db.php';

if(!isset($_SESSION['EMPLOYER_ID'])){
    header("Location: emp-login.php");
    exit;
}

$employer_id = $_SESSION['EMPLOYER_ID'];
$employer_name = $_SESSION['EMPLOYER_NAME'];

//total jobs
$total_jobs_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM jobs WHERE employer_id=$employer_id");
$total_jobs = mysqli_fetch_assoc($total_jobs_result)['total'];

// applications received
$total_applications_result = mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM applications a
    INNER JOIN jobs j ON a.job_id = j.job_id
    WHERE j.employer_id=$employer_id");
$total_applications = mysqli_fetch_assoc($total_applications_result)['total'];

//Active Candidates
$active_candidates_result = mysqli_query($conn, "
    SELECT COUNT(*) as total
    FROM applications a
    INNER JOIN jobs j ON a.job_id = j.job_id
    WHERE j.employer_id=$employer_id AND a.status in ('reviewed','shortlisted')");
$active_candidates = mysqli_fetch_assoc($active_candidates_result)['total'];

//hired candidates
$hired_candidates_result = mysqli_query($conn, "
    SELECT COUNT(*) as total
    FROM applications a
    INNER JOIN jobs j ON a.job_id = j.job_id
    WHERE j.employer_id=$employer_id AND a.status='selected'");
$hired_candidates = mysqli_fetch_assoc($hired_candidates_result)['total'];

//recent jobs
$recent_jobs_result = mysqli_query($conn, "SELECT * FROM jobs
                                            WHERE employer_id = $employer_id
                                            ORDER BY posted_time DESC
                                            LIMIT 3");

$recent_jobs = mysqli_fetch_all($recent_jobs_result, MYSQLI_ASSOC);

//recent applications
$recent_applications_result = mysqli_query($conn, "SELECT a.*, j.title, u.full_name FROM applications a
                                            INNER JOIN jobs j ON a.job_id = j.job_id
                                            INNER JOIN users u ON a.user_id = u.id
                                            WHERE j.employer_id = $employer_id
                                            ORDER BY a.applied_at DESC
                                            LIMIT 3");
$recent_applications = mysqli_fetch_all($recent_applications_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Remix Icon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/emp-dashboard.css">
    <style>


    </style>
</head>

<body>
    <?php 
    // get only first name
    $parts = explode(" ",$_SESSION['EMPLOYER_NAME']);
    $first_name = $parts[0];
    ?>
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1>Welcome Back, <?php echo $first_name?>!</h1>
        <p>Here's what's happening with your jobs today.</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <i class="ri-briefcase-line"></i>
            <h3><?php echo $total_jobs?></h3>
            <p>Total Jobs Posted</p>
        </div>
        <div class="stat-card">
            <i class="ri-file-list-3-line"></i>
            <h3><?php echo $total_applications?></h3>
            <p>Applications Received</p>
        </div>
        <div class="stat-card">
            <i class="ri-user-line"></i>
            <h3><?php echo $active_candidates?></h3>
            <p>Active Candidates</p>
        </div>
        <div class="stat-card">
            <i class="ri-chat-check-line"></i>
            <h3><?php echo $hired_candidates?></h3>
            <p>Hired Candidates</p>
        </div>
    </div>

    <!-- Recent Jobs Section -->
    <div class="recent-jobs-container">
        <div class="recent-jobs">
            <div class="recent-jobs-header">
                <h2>Recent Job Posts</h2>
                <button class="see-more-btn"><a href="emp-dashboard.php?page=manage-jobs">See More</a></button>
            </div>
            <?php foreach($recent_jobs as $job): ?>
            <div class="job-item">
                <div class="job-info">
                    <h4><?php echo htmlspecialchars($job['title']); ?></h4>
                    <p>Posted <?php echo date("d M, Y", strtotime($job['posted_time'])); ?></p>
                </div>
                <span class="job-status <?php echo ($job['status']=='active')?'status-active':'status-inactive'; ?>">
                    <?php echo ucfirst($job['status']); ?>
                </span>
            </div>
        <?php endforeach; ?>
        </div>

        <div class="recent-jobs">
            <div class="recent-jobs-header">
                <h2>Recent Applications</h2>
                <button class="see-more-btn"><a href="emp-dashboard.php?page=manage-applications">See More</a></button>
            </div>
            <?php foreach($recent_applications as $app): ?>
            <div class="job-item">
                <div class="job-info">
                    <h4><?php echo htmlspecialchars($app['title']); ?></h4>
                    <p>Applied by <?php echo htmlspecialchars($app['full_name']); ?></p>
                </div>
                <span class="applied-time"><i class="ri-time-line"></i> <?php echo date("d M, Y", strtotime($app['applied_at'])); ?></span>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
    </div>
</body>

</html>