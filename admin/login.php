<?php 
session_start();
require '../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {

        $sql = "SELECT * FROM admins WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_username'] = $row['username'];

                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid username or password";
            }

        } else {
            $error = "Invalid username or password";
        }

    } else {
        $error = "Please fill in all fields";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Everest Tech Nepal</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

    <div class="login-container">
        <h1>Job Portal System</h1>
        <p>Admin Panel Login</p>

        <?php if ($error): ?>
                <div class="alert alert-error" style="color:red"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="username">Username</label>
            <input type="text" id="username" placeholder="Username" name="username" required>
            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Password" name="password" required>
            <div class="remember">
                <input type="checkbox" id="remember">
                <label for="remember">Remember me</label>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>

</body>

</html>