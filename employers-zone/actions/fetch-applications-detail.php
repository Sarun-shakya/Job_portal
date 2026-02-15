<?php
// actions/fetch-application-detail.php
session_start();
include __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['EMPLOYER_ID'])) {
    echo "Unauthorized.";
    exit;
}

$employer_id = intval($_SESSION['EMPLOYER_ID']);
$app_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($app_id <= 0) {
    echo "Invalid application ID.";
    exit;
}

$sql = "SELECT a.id AS application_id, a.status, a.applied_at,
               u.full_name, u.email, u.resume, u.profile_photo AS profile,
               j.title AS job_title, j.location
        FROM applications a
        JOIN users u ON a.user_id = u.id
        JOIN jobs j ON a.job_id = j.job_id
        WHERE a.id = ? AND j.employer_id = ?
        LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $app_id, $employer_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Application not found or access denied.";
    exit;
}

$row = mysqli_fetch_assoc($result);
function e($s)
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

$profileImg = $row['profile'];
$resumePath = $row['resume'] ? "../uploads/" . rawurlencode($row['resume']) : '#';
$status = e($row['status']);
$appliedAt = date('jS M Y', strtotime($row['applied_at'] ?? 'now'));
$jobTitle = e($row['job_title']);
$location = e($row['location']);
$name = e($row['full_name']);
$email = e($row['email']);
$appId = intval($row['application_id']);

?>

<div class="app-profile-container">
    <div class="profile-top">
        <img src="<?php echo "../uploads/$profileImg"; ?>" alt="Profile" class="profile-photo">
        <h3 class="applicant-name"><?php echo $name; ?></h3>
        <p class="applicant-email"><?php echo $email; ?></p>
    </div>

    <div class="profile-card">
        <h4>Applied Position</h4>
        <p class="job-title"> <?php echo $jobTitle; ?></p>
        <p class="job-location"><?php echo $location; ?></p>
    </div>

    <div class="profile-card">
        <h4>Application Details</h4>
        <div class="detail-row">
            <span>Status:</span>
            <span class="status-badge"><?php echo $status; ?></span>
        </div>
        <div class="detail-row">
            <span>Applied Date:</span>
            <span><?php echo $appliedAt; ?></span>
        </div>
    </div>

    <?php if ($resumePath != '#'): ?>
        <a href="<?php echo $resumePath; ?>" download class="resume-btn">
            <i class="ri-download-2-line"></i> Download Resume
        </a>
    <?php else: ?>
        <p>Resume: N/A</p>
    <?php endif; ?>

    <div class="change-status-box">
        <label>Change Application Status</label>
        <select id="changeStatus" class="status-select">
            <option value="applied" <?php if ($status == 'Applied') echo 'selected'; ?>>Applied</option>
            <option value="reviewed" <?php if ($status == 'Reviewed') echo 'selected'; ?>>Reviewed</option>
            <option value="shortlisted" <?php if ($status == 'Shortlisted') echo 'selected'; ?>>Shortlisted</option>
            <option value="rejected" <?php if ($status == 'Rejected') echo 'selected'; ?>>Rejected</option>
            <option value="selected" <?php if ($status == 'Selected') echo 'selected'; ?>>Selected</option>
        </select>

        <button class="update-btn" onclick="updateStatus(<?php echo $appId; ?>)">Update</button>
    </div>
</div>