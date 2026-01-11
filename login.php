<?php
session_start();
include './config/db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters";
    }

    if (empty($errors)) {

        // Fetch user from DB
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        if (!$stmt) {
            $errors['db'] = "Database error: " . $conn->error;
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                // Check account status
                if ($user['status'] !== 'active') {
                    $errors['status'] = "Your account is not active. Please contact admin.";
                }
                // Verify password
                elseif (!password_verify($password, $user['password'])) {
                    $errors['password'] = "Invalid password!";
                } else {
                    // ---------- Login Success ----------
                    session_regenerate_id(true); // prevent session fixation

                    $_SESSION['user_id']   = $user['id'];
                    $_SESSION['username']  = $user['full_name'];
                    $_SESSION['profile_pic'] = $user['profile_photo'];
                    $_SESSION['success_msg'] = "✅ Logged in successfully";

                    header("Location: index.php");
                    exit();
                }
            } else {
                $errors['email'] = "User not found!";
            }
            $stmt->close();
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (with Popper for dropdowns, tooltips, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- links -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/style.css">
    <style>
        /* Your existing styles go here if any */
    </style>
</head>

<body>
    <?php include './includes/header.php' ?>
    <div class="login-box">
        <h2>Welcome Back</h2>
        <p>Login to your job portal account</p>
        <div class="login-credentials">

            <form action="" method="POST">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address">
                <label for="pwd">Password</label>
                <input type="password" id="pwd" name="password" placeholder="Enter your password">
                <div class="login-options">
                    <label class="remember-me">
                        <input type="checkbox" id="remember-me" name="remember">
                        Remember Me
                    </label>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>
                <button type="submit" name="login">Login</button> <!-- Added name="login" to fix the issue -->
            </form>
            <p>Don't have an account? <a href="./register.php">Sign Up</a></p>
        </div>
        <?php if (!empty($errors)): ?>
            <div style="color:red; margin-bottom:3px;">
                <?php foreach ($errors as $error): ?>
                    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</body>

</html>