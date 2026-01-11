
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "./config/db.php";

// uploads folder exists
if(!is_dir("uploads")){
    mkdir("uploads", 0777, true);
}

if (isset($_POST['register'])) { 
    $errors = [];

    $full_name = trim($_POST["full-name"]);
    $email = trim($_POST["email"]);
    $address = trim($_POST["address"]);
    $password = $_POST["password"];

    if(empty($full_name) || !preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ' -]{2,50}$/u", $full_name)){
        $errors[] = "Please enter a valid full name (letters, spaces only).";
    }

    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Please enter a valid email address.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0){
            $errors[] = "Email is already registered.";
        }
        $stmt->close();
    }

    if(empty($address)){
        $errors[] = "Address is required.";
    }

    if(empty($password) || strlen($password) < 8){
        $errors[] = "Password must be at least 8 characters.";
    }

    $allowedProfileTypes = ["image/jpeg", "image/png"];
    $allowedResumeTypes = ["application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"];

    $profile = null;
    if(!empty($_FILES["profile"]["name"])){
        if(!in_array($_FILES["profile"]["type"], $allowedProfileTypes)){
            $errors[] = "Profile picture must be PNG or JPEG.";
        } elseif($_FILES["profile"]["size"] > 2*1024*1024){ // 2MB limit
            $errors[] = "Profile picture must be less than 2MB.";
        } else {
            $profile = time() . "_" . basename($_FILES["profile"]["name"]);
            move_uploaded_file($_FILES["profile"]["tmp_name"], "uploads/".$profile);
        }
    }

    $resume = null;
    if(!empty($_FILES["resume"]["name"])){
        if(!in_array($_FILES["resume"]["type"], $allowedResumeTypes)){
            $errors[] = "Resume must be PDF or DOC/DOCX.";
        } elseif($_FILES["resume"]["size"] > 5*1024*1024){ // 5MB limit
            $errors[] = "Resume must be less than 5MB.";
        } else {
            $resume = time() . "_" . basename($_FILES["resume"]["name"]);
            move_uploaded_file($_FILES["resume"]["tmp_name"], "uploads/".$resume);
        }
    }

    //insert into database
    if(empty($errors)){
        $hassedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users(full_name, address, email, password, profile_photo, resume) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $full_name, $address, $email, $hassedPassword, $profile, $resume);

        if($stmt->execute()){
            $stmt->close();
            $conn->close();
            header("Location: login.php");
            exit();
        } else {
            $errors[] = "Error registering user: " . $stmt->error;
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


    </style>
</head>

<body>
    <?php include './includes/header.php' ?>
    <div class="login-box">
        <h2>Create Account</h2>
        <p>Create a new account in job portal</p>
        <div class="login-credentials">
            <form action="" method="POST"  enctype="multipart/form-data">
                <label for="full-name">Full Name</label>
                <input type="text" id="full-name" name="full-name" placeholder="Enter Full Name">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter email address">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" placeholder="Enter your address">
                <label for="pwd">Password</label>
                <input type="password" id="pwd" name="password" placeholder="Enter password">
                <label for="profile-pic">Profile Picture (Optional)</label>
                <input type="file" id="profile-pic" class="form-control" name="profile" accept="image/png, image/jpeg">
                <label for="profile-pic">Resume (Optional)</label>
                <input type="file" id="resume" class="form-control" name="resume" accept=".pdf, .doc, .docx">
                <input type="checkbox" id="TermsAndConditions" >
                <label for="TermsAndConditions">I agree with the terms and conditions of JobPortal</label>
                <button type="submit" name="register">Register</button>
            </form>
            <p>Already have an account? <a href="./login.php">Login</a></p>
        </div>
    <?php if(!empty($errors)){
        foreach($errors as $error){
            echo "<p style='color:red;'>$error</p>";
        }
    }
    ?>
    </div>
    
</body>

</html>