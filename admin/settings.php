<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../config/db.php'; // make sure this sets $conn
include 'header.php';

$message = '';
$message_type = '';

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Get current admin password
    $sql = $conn->prepare("SELECT password FROM admins WHERE id = ?");
    $sql->bind_param("i", $_SESSION['admin_id']);
    $sql->execute();
    $result = $sql->get_result();
    $admin = $result->fetch_assoc();
    $sql->close();

    if (!$admin) {
        $message = 'Admin not found';
        $message_type = 'error';
    } elseif (!password_verify($current_password, $admin['password'])) {
        $message = 'Current password is incorrect';
        $message_type = 'error';
    } elseif (strlen($new_password) < 6) {
        $message = 'New password must be at least 6 characters';
        $message_type = 'error';
    } elseif ($new_password !== $confirm_password) {
        $message = 'New passwords do not match';
        $message_type = 'error';
    } else {
        // Update password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = $conn->prepare("UPDATE admins SET password = ? WHERE id = ?");
        $sql->bind_param("si", $hashed_password, $_SESSION['admin_id']);
        if ($sql->execute()) {
            $message = 'Password changed successfully';
            $message_type = 'success';
        } else {
            $message = 'Failed to update password';
            $message_type = 'error';
        }
        $sql->close();
    }
}

// Get admin info
$sql = $conn->prepare("SELECT username FROM admins WHERE id = ?");
$sql->bind_param("i", $_SESSION['admin_id']);
$sql->execute();
$result = $sql->get_result();
$admin_info = $result->fetch_assoc();
$sql->close();

?>

<div class="page-content">
    <div class="page-header">
        <h1>Admin Settings</h1>
        <p style="padding-bottom: 5px ">Manage your admin account settings</p>
    </div>
    
    <?php if ($message): ?>
        <div class="alert alert-<?= $message_type ?>"><?= $message ?></div>
    <?php endif; ?>
    
    <div class="settings-grid">
        <!-- Account Information -->
        <div class="card">
            <div class="card-header">
                <h2>Account Information</h2>
            </div>
            <div class="card-body">
                <div class="info-group">
                    <label>Username:</label>
                    <p><?=  $_SESSION['admin_username']; ?></p>
                </div>
                <div class="info-group">
                    <label>Email:</label>
                    <p><?=  $_SESSION['admin_email']; ?></p>
                </div>
            </div>
        </div>
        
        <!-- Change Password -->
        <div class="card">
            <div class="card-header">
                <h2>Change Password</h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required minlength="6">
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required minlength="6">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>
        
    </div>
</div>
<?php include 'footer.php'?>