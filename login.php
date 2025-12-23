<?php
session_start();
include './config/db.php';


if (isset($_POST['login']) || $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user from DB
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if (!$stmt) {
        $error = "Database error: " . $conn->error; // Show DB prep errors
    } else {
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            $error = "Query execution failed: " . $stmt->error; // Show execution errors
        } else {
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                // Verify password
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['full_name'];
                    $_SESSION['profile_pic'] = $user['profile_photo'];
                    session_start(); // start new session to set message
                    $_SESSION['success_msg'] = "✅ Logged in successfully";

                    // Optional: remember me using cookie
                    if (isset($_POST['remember'])) {
                        setcookie('user_id', $user['id'], time() + 30 * 24 * 60 * 60, "/"); // 30 days
                    }

                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Invalid password!";
                }
            } else {
                $error = "User not found!";
            }
        }
        $stmt->close();
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
                <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                <label for="pwd">Password</label>
                <input type="password" id="pwd" name="password" placeholder="Enter your password" required>
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
        <?php if (isset($error)): ?>
            <p style="color:red; margin-bottom:1rem;"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>
</body>

</html>