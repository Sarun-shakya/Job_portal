<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../config/db.php';
include 'header.php';
// Get statistics
$stats = [];

// Total users
$result = $conn->query("SELECT COUNT(*) as count FROM users");
if ($result) {
    $row = $result->fetch_assoc();
    $stats['users'] = $row['count'];
} else {
    $stats['users'] = 0;
}

// Total employers
$result = $conn->query("SELECT COUNT(*) as count FROM employers");
if ($result) {
    $row = $result->fetch_assoc();
    $stats['employers'] = $row['count'];
} else {
    $stats['employers'] = 0;
}

// Total jobs
$result = $conn->query("SELECT COUNT(*) as count FROM jobs");
if ($result) {
    $row = $result->fetch_assoc();
    $stats['jobs'] = $row['count'];
} else {
    $stats['jobs'] = 0;
}

// Total applications
$result = $conn->query("SELECT COUNT(*) as count FROM applications");
if ($result) {
    $row = $result->fetch_assoc();
    $stats['applications'] = $row['count'];
} else {
    $stats['applications'] = 0;
}

// Recent users
$result = $conn->query("SELECT id, full_name, email, created_at FROM users ORDER BY created_at DESC LIMIT 5");
$recent_users = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $recent_users[] = $row;
    }
}

// Recent employers
$result = $conn->query("SELECT id, name, email, created_at FROM employers ORDER BY created_at DESC LIMIT 5");
$recent_employers = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $recent_employers[] = $row;
    }
}

// Recent jobs
$result = $conn->query("SELECT 
    j.job_id,
    j.title,
    j.location,
    e.name AS employer_name,
    j.posted_time,
    COUNT(a.id) AS total_applications
    FROM jobs j
    LEFT JOIN employers e ON j.employer_id = e.id
    LEFT JOIN applications a ON j.job_id = a.job_id
    GROUP BY j.job_id, j.title, j.location, e.name, j.posted_time
    ORDER BY j.posted_time DESC
    LIMIT 5;");

$recent_jobs = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $recent_jobs[] = $row;
    }
}

?>

<div class="dashboard">
    <h1>Dashboard</h1>
    <p style="margin-bottom: 5px;">Here's what's happening with your job Portal today.</p>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-primary">
            <div class="stat-icon"><i class="ri-group-line"></i></div>
            <div class="stat-info">
                <h3><?= $stats['users'] ?></h3>
                <p>Total Users</p>
            </div>
        </div>

        <div class="stat-card stat-success">
            <div class="stat-icon"><i class="ri-hotel-line"></i></div>
            <div class="stat-info">
                <h3><?= $stats['employers'] ?></h3>
                <p>Total Employers</p>
            </div>
        </div>

        <div class="stat-card stat-warning">
            <div class="stat-icon"><i class="ri-briefcase-line"></i></div>
            <div class="stat-info">
                <h3><?= $stats['jobs'] ?></h3>
                <p>Total Jobs</p>
            </div>
        </div>

        <div class="stat-card stat-info">
            <div class="stat-icon"><i class="ri-file-list-line"></i></div>
            <div class="stat-info">
                <h3><?= $stats['applications'] ?></h3>
                <p>Total Applications</p>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="activity-grid">
        <!-- Recent Users -->
        <div class="activity-card">
            <h2>Recent Users</h2>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_users as $user): ?>
                            <tr>
                                <td><?= $user['full_name'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Employers -->
        <div class="activity-card">
            <h2>Recent Employers</h2>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Company</th>
                            <th>Email</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_employers as $employer): ?>
                            <tr>
                                <td><?= $employer['name'] ?></td>
                                <td><?= $employer['email'] ?></td>
                                <td><?= date('M d, Y', strtotime($employer['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Jobs -->
        <div class="activity-card full-width">
            <h2>Recent Jobs Posted</h2>
            
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Employer</th>
                            <th>Location</th>
                            <th>Posted</th>
                            <th>Applications</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_jobs as $job): ?>
                            <tr>
                                <td><?= $job['title'] ?></td>
                                <td><?= $job['employer_name'] ?></td>
                                <td><?= $job['location'] ?></td>
                                <td><?= date('M d, Y', strtotime($job['posted_time'])) ?></td>
                                <td><?= $job['total_applications'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php' ?>