<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if employer is logged in
if (!isset($_SESSION['EMPLOYER_ID'])) {
    echo "<p style='color:red; text-align:center'>You must be logged in to post a job.</p>";
    exit;
}

include __DIR__ . '/../../config/db.php';

$employer_id = $_SESSION['EMPLOYER_ID'];
$success_message = '';
$error_message = '';

// Fetch employer data
$stmt = $conn->prepare("SELECT * FROM employers WHERE id = ?");
$stmt->bind_param("i", $employer_id);
$stmt->execute();
$result = $stmt->get_result();
$employer = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $company_name = trim($_POST['company_name']);
    $email = trim($_POST['email']);
    $location = trim($_POST['location']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validation
    $errors = [];

    if (empty($full_name)) {
        $errors[] = "Full name is required";
    }

    if (empty($company_name)) {
        $errors[] = "Company name is required";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }

    if (empty($location)) {
        $errors[] = "Location is required";
    }

    // Check if email is already taken by another employer
    $logo_path = $employer['logo'];

    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        $tmp_name = $_FILES['logo']['tmp_name'];
        $file_type = mime_content_type($tmp_name);
        $file_size = $_FILES['logo']['size'];

        if (!in_array($file_type, $allowed_types)) {
            $errors[] = "Only JPG, JPEG, PNG & GIF files are allowed";
        } elseif ($file_size > 2 * 1024 * 1024) { // 2MB
            $errors[] = "Logo file size must be less than 2MB";
        } else {
            $upload_dir = 'uploads/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
            $new_filename = $logo = time() . "_" . basename($_FILES["logo"]["name"]);;
            $upload_path = $upload_dir . $new_filename;

            if (move_uploaded_file($tmp_name, $upload_path)) {
                // Delete old logo safely
                if (!empty($employer['logo']) && file_exists($employer['logo'])) {
                    unlink($employer['logo']);
                }
                $logo_path = $new_filename;
            } else {
                $errors[] = "Failed to upload logo";
            }
        }
    }


    // If no errors, update the database
    if (empty($errors)) {
        if (!empty($new_password)) {
            // Update with new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_stmt = $conn->prepare("UPDATE employers SET full_name = ?, name = ?, email = ?, location = ?, password = ?, logo = ? WHERE id = ?");
            $update_stmt->bind_param("ssssssi", $full_name, $company_name, $email, $location, $hashed_password, $logo_path, $employer_id);
        } else {
            // Update without password
            $update_stmt = $conn->prepare("UPDATE employers SET full_name = ?, name = ?, email = ?, location = ?, logo = ? WHERE id = ?");
            $update_stmt->bind_param("sssssi", $full_name, $company_name, $email, $location, $logo_path, $employer_id);
        }

        if ($update_stmt->execute()) {
            $success_message = "Profile updated successfully!";
            // Refresh employer data
            $stmt = $conn->prepare("SELECT * FROM employers WHERE id = ?");
            $stmt->bind_param("i", $employer_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $employer = $result->fetch_assoc();
            $stmt->close();
        } else {
            $error_message = "Failed to update profile. Please try again.";
        }
        $update_stmt->close();
    } else {
        $error_message = implode("<br>", $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Profile - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #0d6efd;
            --primary-dark: #0b5ed7;
            --success: #10b981;
            --danger: #ef4444;
            --text-dark: #0f172a;
            --text-gray: #64748b;
            --bg-light: #f8fafc;
            --bg-white: #ffffff;
            --border: #e2e8f0;
            --shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
        }

        .container1 {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 24px;
        }

        /* Profile Header Banner */
        .profile-header-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            margin-bottom: 32px;
            box-shadow: var(--shadow);
        }

        .profile-logo-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--bg-white);
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 4px solid rgba(255, 255, 255, 0.3);
        }

        .profile-logo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-logo-preview i {
            font-size: 48px;
            color: var(--text-gray);
        }

        .profile-header-banner h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .profile-header-banner p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
        }

        /* Alert Messages */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
        }

        .alert i {
            font-size: 20px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        /* Profile Card */
        .profile-card {
            background: var(--bg-white);
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow);
        }

        .card-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title i {
            color: var(--primary);
        }

        .card-subtitle {
            color: var(--text-gray);
            font-size: 14px;
            margin-bottom: 32px;
        }

        /* Form Styles */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            margin-bottom: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-label i {
            font-size: 16px;
            color: var(--primary);
        }

        .form-input {
            padding: 14px 16px;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 15px;
            font-family: inherit;
            color: var(--text-dark);
            transition: all 0.3s ease;
            background: var(--bg-white);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }

        .form-input:disabled {
            background: var(--bg-light);
            cursor: not-allowed;
        }

        /* File Upload Input */
        .file-input-wrapper {
            position: relative;
        }

        .file-input-wrapper input[type="file"] {
            padding: 12px 16px;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            color: var(--text-dark);
            transition: all 0.3s ease;
            background: var(--bg-white);
            width: 100%;
            cursor: pointer;
        }

        .file-input-wrapper input[type="file"]:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }

        .file-input-wrapper input[type="file"]::file-selector-button {
            padding: 8px 16px;
            border: none;
            background: var(--primary);
            color: #ffffff;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            margin-right: 12px;
            transition: all 0.3s ease;
        }

        .file-input-wrapper input[type="file"]::file-selector-button:hover {
            background: var(--primary-dark);
        }

        .file-hint {
            font-size: 12px;
            color: var(--text-gray);
            margin-top: 6px;
        }

        /* Password Section */
        .password-section {
            margin-top: 40px;
            padding-top: 32px;
            border-top: 2px solid var(--border);
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--primary);
        }

        /* Buttons */
        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 32px;
        }

        .btn {
            padding: 14px 32px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-family: inherit;
        }

        .btn-primary {
            background: var(--primary);
            color: #ffffff;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
        }

        .btn-secondary {
            background: var(--bg-light);
            color: var(--text-gray);
            border: 2px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--border);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container1 {
                padding: 0 16px;
                margin: 20px auto;
            }

            .profile-header-banner,
            .profile-card {
                padding: 24px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .profile-header-banner h1 {
                font-size: 24px;
            }

            .card-title {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container1">
        <!-- Alert Messages -->
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <i class="ri-checkbox-circle-line"></i>
                <span><?php echo $success_message; ?></span>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger">
                <i class="ri-error-warning-line"></i>
                <span><?php echo $error_message; ?></span>
            </div>
        <?php endif; ?>

        <!-- Profile Form -->
        <div class="profile-card">
            <h2 class="card-title">
                Profile Settings
            </h2>
            <p class="card-subtitle">Update your company information and account settings</p>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <!-- Full Name -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="ri-user-line"></i>
                            Full Name
                        </label>
                        <input
                            type="text"
                            name="full_name"
                            class="form-input"
                            value="<?php echo htmlspecialchars($employer['full_name']); ?>"
                            required>
                    </div>

                    <!-- Company Name -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="ri-building-line"></i>
                            Company Name
                        </label>
                        <input
                            type="text"
                            name="company_name"
                            class="form-input"
                            value="<?php echo htmlspecialchars($employer['name']); ?>"
                            required>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="ri-mail-line"></i>
                            Email Address
                        </label>
                        <input
                            type="email"
                            name="email"
                            class="form-input"
                            value="<?php echo htmlspecialchars($employer['email']); ?>"
                            required>
                    </div>

                    <!-- Location -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="ri-map-pin-line"></i>
                            Location
                        </label>
                        <input
                            type="text"
                            name="location"
                            class="form-input"
                            value="<?php echo htmlspecialchars($employer['location']); ?>"
                            placeholder="City, Country"
                            required>
                    </div>

                    <!-- Logo Upload -->
                    <div class="form-group full-width">
                        <label class="form-label">
                            <i class="ri-image-line"></i>
                            Company Logo
                        </label>
                        <div class="file-input-wrapper">
                            <input
                                type="file"
                                name="logo"
                                id="logo"
                                accept="image/jpeg,image/png,image/gif,image/jpg">
                            <p class="file-hint">JPG, PNG or GIF (Max 2MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div class="password-section">
                    <h3 class="section-title">
                        <i class="ri-lock-password-line"></i>
                        Change Password
                    </h3>
                    <p class="card-subtitle" style="margin-bottom: 20px;">Leave blank if you don't want to change your password</p>

                    <div class="form-grid">
                        <!-- New Password -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="ri-lock-line"></i>
                                New Password
                            </label>
                            <input
                                type="password"
                                name="new_password"
                                class="form-input"
                                placeholder="Enter new password"
                                minlength="6">
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="ri-lock-line"></i>
                                Confirm Password
                            </label>
                            <input
                                type="password"
                                name="confirm_password"
                                class="form-input"
                                placeholder="Confirm new password">
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>