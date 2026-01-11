<?php
session_start();
include '../config/db.php';

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
    } elseif (strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters";
    }

    if (empty($errors)) {

        $stmt = $conn->prepare("SELECT * FROM employers WHERE email = ?");
        if (!$stmt) {
            $errors['db'] = "Database error: " . $conn->error;
        } else {

            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $employer = $result->fetch_assoc();

                if ($employer['status'] !== 'active') {
                    $errors['status'] = "Your account is not active. Please contact admin.";
                } elseif (!password_verify($password, $employer['password'])) {
                    $errors['password'] = "Invalid password!";
                } else {
                    // Login success
                    session_regenerate_id(true);

                    $_SESSION['EMPLOYER_ID'] = $employer['id'];
                    $_SESSION['EMPLOYER_NAME'] = $employer['full_name'];
                    $_SESSION['EMPLOYER_LOGGED_IN'] = true;
                    $_SESSION['EMPLOYER_LOGO'] = $employer['logo'] ?? null;
                    $_SESSION['success_msg'] = "✅ Logged in successfully";

                    header("Location: emp-dashboard.php");
                    exit;
                }
            } else {
                $errors['email'] = "Employer not found!";
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
    <title>Employer Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/emp-login-register.css" rel="stylesheet">
    <style>
        .login-form form {
            display: block;
        }
    </style>
</head>

<body>
    <?php include 'emp-navbar.php'; ?>

    <div class="login-container">
        <div class="recruiter-image">
            <img src="../assets/recruiter.jpg" alt="Recruiter Image">
        </div>
        <div class="login-group">
            <div class="login-heading">
                <h2>Employer Access Portal</h2>
                <p>Login to find your next great hire</p>
            </div>
            <div class="login-form">
                <?php if (!empty($errors)) : ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $err): ?>
                            <div><?= htmlspecialchars($err) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email address" >

                    <label for="pwd">Password</label>
                    <input type="password" id="pwd" name="password" placeholder="Enter your password" >

                    <div class="login-options">
                        <a href="#" class="forgot-password">Forgot Password?</a>
                    </div>

                    <div>
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>

                    <button type="submit">Login</button>
                </form>
                <p>Don't have an account? <a href="emp-register.php">Sign Up</a></p>
            </div>
        </div>
    </div>
</body>

</html>