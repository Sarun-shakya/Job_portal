<?php
session_start();
include '../config/db.php';

$error = "";

// Process login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        $error = "Please fill all fields!";
    } else {
        // Fetch employer
        $stmt = $conn->prepare("SELECT * FROM employers WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $employer = $result->fetch_assoc();

                if (password_verify($password, $employer['password'])) {
                    // Set session variables
                    // Set employer session variables
                    $_SESSION['EMPLOYER_ID'] = $employer['id'];
                    $_SESSION['EMPLOYER_NAME'] = $employer['full_name'];
                    $_SESSION['EMPLOYER_LOGGED_IN'] = true;
                    $_SESSION['EMPLOYER_LOGO'] = $employer['logo'] ?? null;
                    // Optional flash message
                    $_SESSION['success_msg'] = "✅ Logged in successfully";


                    // Optional: remember me cookie
                    if (isset($_POST['remember'])) {
                        setcookie('EMPLOYER_ID', $employer['id'], time() + 30 * 24 * 60 * 60, "/");
                    }


                    header("Location: emp-dashboard.php");
                    exit;
                } else {
                    $error = "Invalid password!";
                }
            } else {
                $error = "Employer not found!";
            }

            $stmt->close();
        } else {
            $error = "Database error: " . $conn->error;
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
                <?php if ($error) : ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form action="" method="POST">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email address" required>

                    <label for="pwd">Password</label>
                    <input type="password" id="pwd" name="password" placeholder="Enter your password" required>

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