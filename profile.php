
<?php
session_start();
include "config/db.php";

$user_id = $_SESSION['user_id'];

if (isset($_POST['update_profile'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Handle profile photo upload
    if (!empty($_FILES['profile_photo']['name'])) {
        $photo_name = time() . '_' . $_FILES['profile_photo']['name'];
        move_uploaded_file($_FILES['profile_photo']['tmp_name'], 'uploads/' . $photo_name);
        $profile_photo_sql = ", profile_photo='$photo_name'";
    } else {
        $profile_photo_sql = "";
    }

    // Handle resume upload
    if (!empty($_FILES['resume']['name'])) {
        $resume_name = time() . '_' . $_FILES['resume']['name'];
        move_uploaded_file($_FILES['resume']['tmp_name'], 'uploads/' . $resume_name);
        $resume_sql = ", resume='$resume_name'";
    } else {
        $resume_sql = "";
    }

    // Update database
    $update_sql = "UPDATE users SET full_name=?, email=?, address=? $profile_photo_sql $resume_sql WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssi", $full_name, $email, $address, $user_id);
    $stmt->execute();

    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

//fetch user details
$user_sql = "
    SELECT full_name, email, address, profile_photo, resume
    FROM users
    WHERE id = ?
";
$stmt = $conn->prepare($user_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

//fetch applied jobs
$job_sql = "
    SELECT 
        jobs.job_id AS job_id,
        jobs.title,
        jobs.location,
        applications.status,
        applications.applied_at,
        employers.logo,
        employers.name AS company_name
    FROM applications
    INNER JOIN jobs ON applications.job_id = jobs.job_id
    INNER JOIN employers ON jobs.employer_id = employers.id
    WHERE applications.user_id = ?
";
$stmt2 = $conn->prepare($job_sql);
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$applied_jobs = $stmt2->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body.overlay-active {
            overflow: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            margin-top: 20px;
            margin-bottom: 20px
        }

        .profile-header {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .profile-photo-container {
            position: relative;
        }

        .profile-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #667eea;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .default-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
            font-weight: bold;
            border: 5px solid #667eea;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .profile-info {
            flex: 1;
            min-width: 300px;
        }

        .profile-title {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .profile-title h2 {
            color: #333;
            font-size: 28px;
        }

        .edit-icon {
            cursor: pointer;
            font-size: 24px;
            color: #667eea;
            transition: transform 0.3s ease;
        }

        .edit-icon:hover {
            transform: scale(1.2);
            color: #764ba2;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            color: #555;
        }

        .info-item i {
            color: #667eea;
            font-size: 18px;
            width: 25px;
        }

        .info-item strong {
            color: #333;
            min-width: 80px;
        }

        .resume-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            margin-top: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .resume-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .jobs-section {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .jobs-section h2 {
            color: #333;
            margin-bottom: 25px;
            font-size: 24px;
        }

        .job-card {
            background: #f8f9ff;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            display: flex;
            gap: 20px;
            align-items: start;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 2px solid transparent;
        }

        .job-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
            border-color: #667eea;
        }

        .company-logo {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            object-fit: cover;
            background: white;
            padding: 5px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .job-details {
            flex: 1;
        }

        .job-details h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 20px;
        }

        .job-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 12px;
        }

        .job-meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #666;
            font-size: 14px;
        }

        .job-meta-item i {
            color: #667eea;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .view-detail-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            margin-top: 10px;
            transition: gap 0.3s ease;
        }

        .view-detail-btn:hover {
            gap: 10px;
        }

        .no-jobs {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .no-jobs i {
            font-size: 64px;
            margin-bottom: 15px;
            color: #ddd;
        }

        /* Overlay styles */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }

        .overlay-content {
            background: white;
            padding: 35px;
            width: 500px;
            max-width: 90vw;
            border-radius: 20px;
            position: relative;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-height: 90vh;
            overflow-y: auto;
        }

        .overlay-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .overlay-header h2 {
            color: #333;
            font-size: 24px;
        }

        .close-btn {
            cursor: pointer;
            font-size: 28px;
            color: #999;
            transition: color 0.3s ease, transform 0.3s ease;
            line-height: 1;
        }

        .close-btn:hover {
            color: #ff3742;
        }

        .overlay form label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            margin-top: 15px;
        }

        .overlay form input[type="text"],
        .overlay form input[type="email"],
        .overlay form input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .overlay form input[type="text"]:focus,
        .overlay form input[type="email"]:focus {
            outline: none;
            border-color: #667eea;
        }

        .overlay form input[type="file"] {
            padding: 10px;
            cursor: pointer;
        }

        .overlay form button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .overlay form button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .job-card {
                flex-direction: column;
            }

            .company-logo {
                margin: 0 auto;
            }
        }
    </style>
</head>
<body>
<?php include './includes/header.php'?>
<div class="container">
    <div class="profile-header">
        <div class="profile-photo-container">
            <?php if (!empty($user['profile_photo'])): ?>
                <img src="uploads/<?= $user['profile_photo']; ?>" class="profile-photo" alt="Profile Photo">
            <?php else: ?>
                <div class="default-avatar">
                    <?= strtoupper(substr($user['full_name'], 0, 1)); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="profile-info">
            <div class="profile-title">
                <h2>User Profile</h2>
                <i class="ri-edit-box-line edit-icon" onclick="showOverlay()"></i>
            </div>

            <div class="info-item">
                <i class="ri-user-line"></i>
                <strong>Name:</strong>
                <span><?= htmlspecialchars($user['full_name']); ?></span>
            </div>

            <div class="info-item">
                <i class="ri-mail-line"></i>
                <strong>Email:</strong>
                <span><?= htmlspecialchars($user['email']); ?></span>
            </div>

            <div class="info-item">
                <i class="ri-map-pin-line"></i>
                <strong>Address:</strong>
                <span><?= htmlspecialchars($user['address']); ?></span>
            </div>

            <?php if (!empty($user['resume'])): ?>
                <a href="uploads/<?= $user['resume']; ?>" target="_blank" class="resume-btn">
                    <i class="ri-file-text-line"></i>
                    View Resume
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="jobs-section">
        <h2><i class="ri-briefcase-line"></i> Applied Jobs</h2>

        <?php if ($applied_jobs->num_rows > 0): ?>
            <?php while ($job = $applied_jobs->fetch_assoc()): ?>
                <div class="job-card">
                    <?php if (!empty($job['logo'])): ?>
                        <img src="employers-zone/uploads/<?= $job['logo']; ?>" class="company-logo" alt="Company Logo">
                    <?php else: ?>
                        <div class="company-logo" style="display:flex; align-items:center; justify-content:center; background:#667eea; color:white; font-weight:bold;">
                            <?= strtoupper(substr($job['company_name'], 0, 1)); ?>
                        </div>
                    <?php endif; ?>

                    <div class="job-details">
                        <h3><?= htmlspecialchars($job['title']); ?></h3>
                        
                        <div class="job-meta">
                            <div class="job-meta-item">
                                <i class="ri-building-line"></i>
                                <?= htmlspecialchars($job['company_name']); ?>
                            </div>
                            <div class="job-meta-item">
                                <i class="ri-map-pin-line"></i>
                                <?= htmlspecialchars($job['location']); ?>
                            </div>
                            <div class="job-meta-item">
                                <i class="ri-calendar-line"></i>
                                Applied: <?= date("M d, Y", strtotime($job['applied_at'])); ?>
                            </div>
                        </div>

                        <span class="status-badge status-<?= strtolower($job['status']); ?>">
                            <?= ucfirst($job['status']); ?>
                        </span>

                        <a href="job-description.php?job_id=<?= $job['job_id']; ?>" class="view-detail-btn">
                            View Details
                            <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-jobs">
                <i class="ri-inbox-line"></i>
                <p>No applied jobs found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Overlay with form -->
<div class="overlay" id="editOverlay">
    <div class="overlay-content">
        <div class="overlay-header">
            <h2>Edit Profile</h2>
            <span class="close-btn" onclick="hideOverlay()">&times;</span>
        </div>

        <form method="POST" enctype="multipart/form-data">
            <label>Full Name</label>
            <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']); ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>

            <label>Address</label>
            <input type="text" name="address" value="<?= htmlspecialchars($user['address']); ?>">

            <label>Profile Photo</label>
            <input type="file" name="profile_photo" accept="image/*">

            <label>Resume</label>
            <input type="file" name="resume" accept=".pdf,.doc,.docx">

            <button type="submit" name="update_profile">Update Profile</button>
        </form>
    </div>
</div>
<?php include './includes/footer.php'?>

<script>
function showOverlay() {
    document.getElementById('editOverlay').style.display = 'flex';
}
function hideOverlay() {
    document.getElementById('editOverlay').style.display = 'none';
}
</script>

</body>
</html>