<!-- Employer Register Page -->

<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

include "../config/db.php";

// uploads folder exists
if (!is_dir("uploads")) {
  mkdir("uploads", 0777, true);
}

if (isset($_POST['register'])) {
  $errors = [];

  $full_name = trim($_POST["full_name"]);
  $company_name = trim($_POST["name"]);
  $email = trim($_POST["email"]);
  $address = trim($_POST["location"]);
  $password = $_POST["password"];

  if (empty($full_name) || !preg_match("/^[A-Za-zÀ-ÖØ-özø-ÿ' -]{2,50}$/u", $full_name)) {
    $errors[] = "Please enter a valid full name (letters, spaces only).";
  }

  if (empty($company_name) || !preg_match("/^[A-Za-zÀ-ÖØ-özø-ÿ' -]{2,50}$/u", $company_name)) {
    $errors[] = "Please enter a valid company name (letters, spaces only).";
  }

  if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
  } else {
    $stmt = $conn->prepare("SELECT id FROM employers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
      $errors[] = "Email is already registered.";
    }
    $stmt->close();
  }

  if (empty($address)) {
    $errors[] = "Address is required.";
  }

  if (empty($password) || strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters.";
  }

  $allowedLogoTypes = ["image/jpeg", "image/png"];

  $logo = null;
  if (!empty($_FILES["logo"]["name"])) {
    if (!in_array($_FILES["logo"]["type"], $allowedLogoTypes)) {
      $errors[] = "Logo must be PNG or JPEG.";
    } elseif ($_FILES["logo"]["size"] > 2 * 1024 * 1024) { // 2MB limit
      $errors[] = "Logo must be less than 2MB.";
    } else {
      $logo = time() . "_" . basename($_FILES["logo"]["name"]);
      move_uploaded_file($_FILES["logo"]["tmp_name"], "uploads/" . $logo);
    }
  }

  //insert into database
  if (empty($errors)) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO employers(full_name, name, email, location, password, logo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $full_name, $company_name,  $email, $address, $hashedPassword, $logo);

    if ($stmt->execute()) {
      $stmt->close();
      $conn->close();
      header("Location: emp-login.php");
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
  <title>Job Portal - Employer Register</title>

  <!-- Remix Icon -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .register-container {
      min-height: 90vh;
      display: flex;
      align-items: stretch;
      justify-content: center;
      padding: 20px 0;
      gap: 0;
      margin: 20px auto;
      max-width: 800px;
      width: 100%;
    }


    .recruiter-image {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      padding: 40px;
      /* max-width: 50%; */
      border-radius: 15px 0 0 15px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .recruiter-image img {
      max-width: 100%;
      max-height: 100%;
      height: auto;
      width: auto;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      transform: scale(1.05);
      object-fit: cover;
    }

    .register-group {
      flex: 1;
      background: white;
      padding: 50px 40px;
      border-radius: 0 15px 15px 0;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      /* max-width: 55%; */
      width: 100%;
      /* display: flex; */
      /* flex-direction: column; */
      /* justify-content: center; */
      height: 100%;
      box-sizing: border-box;
    }

    .register-heading h2 {
      font-weight: 700;
      color: #1a237e;
      font-size: 2rem;
      margin-bottom: 10px;
      text-align: center;
    }

    .register-heading p {
      color: #555;
      font-size: 1rem;
      text-align: center;
      margin-bottom: 25px;
    }

    .register-form form {
      display: block;
    }

    .form-row {
      flex-wrap: wrap;
      gap: 15px;
    }

    .form-row .form-group {
      flex: 1;
    }


    .register-form {
      width: 100%;
    }

    .register-form label {
      font-weight: 600;
      color: #555;
      margin-bottom: 6px;
      display: block;
      font-size: 0.95rem;
    }

    .register-form input[type="text"],
    .register-form input[type="email"],
    .register-form input[type="password"],
    .register-form input[type="file"] {
      width: 100%;
      box-sizing: border-box;
      border: 2px solid #e9ecef;
      border-radius: 10px;
      padding: 12px 15px;
      margin-bottom: 15px;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
      font-size: 0.95rem;
    }

    .register-form input[type="text"]:focus,
    .register-form input[type="email"]:focus,
    .register-form input[type="password"]:focus,
    .register-form input[type="file"]:focus {
      border-color: #667eea;
      box-shadow: 0 0 6px rgba(102, 126, 234, 0.25);
      outline: none;
    }

    .register-form input[type="file"] {
      padding: 10px 15px;
      cursor: pointer;
      background-color: #f8f9fa;
    }

    .register-form input[type="file"]::file-selector-button {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      cursor: pointer;
      margin-right: 10px;
      font-weight: 500;
      transition: transform 0.2s ease;
    }

    .register-form input[type="file"]::file-selector-button:hover {
      transform: scale(1.02);
    }

    .terms-checkbox {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      margin: 20px 0;
    }

    .terms-checkbox input[type="checkbox"] {
      width: 18px;
      height: 18px;
      margin-top: 2px;
      accent-color: #667eea;
      cursor: pointer;
    }

    .terms-checkbox label {
      font-weight: 500;
      color: #666;
      font-size: 0.9rem;
      cursor: pointer;
      margin-bottom: 0;
    }

    .terms-checkbox label a {
      color: #667eea;
      text-decoration: none;
      font-weight: 600;
    }

    .terms-checkbox label a:hover {
      text-decoration: underline;
      color: #764ba2;
    }

    .register-form button {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      border-radius: 10px;
      padding: 14px 30px;
      color: white;
      font-size: 1.15rem;
      font-weight: 700;
      width: 100%;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .register-form button:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .register-form>p {
      text-align: center;
      color: #666;
      margin-top: 20px;
      font-size: 0.95rem;
    }

    .register-form>p a {
      color: #667eea;
      text-decoration: none;
      font-weight: bold;
    }

    .register-form>p a:hover {
      text-decoration: underline;
      color: #764ba2;
    }

    /* Two column layout for some fields */
    .form-row {
      display: flex;
      gap: 15px;
    }

    .form-row .form-group {
      flex: 1;
    }
  </style>
</head>

<body>
  <?php include 'emp-navbar.php' ?>

  <div class="register-container">
    <!-- Left Image -->
    <!-- <div class="recruiter-image">
      <img src="../assets/recruiter2.jpg" alt="Recruiter Image">
    </div> -->

    <!-- Right Form -->
    <div class="register-group">
      <div class="register-heading">
        <h2>Create Your Employer Account</h2>
        <p>Get instant access to top talent and start hiring today.</p>
      </div>

      <div class="register-form">
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group">
              <label for="full-name">Full Name</label>
              <input type="text" id="full-name" name="full_name" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
              <label for="company-name">Company Name</label>
              <input type="text" id="company-name" name="name" placeholder="Enter company name" required>
            </div>
          </div>

          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter your email address" required>

          <label for="location">Address</label>
          <input type="text" id="location" name="location" placeholder="Enter your company address">

          <label for="pwd">Password</label>
          <input type="password" id="pwd" name="password" placeholder="Enter your password" required>

          <label for="profile-pic">Profile Picture (Optional)</label>
          <input type="file" id="profile-pic" name="logo" accept="image/png, image/jpeg">

          <div class="terms-checkbox">
            <input type="checkbox" id="terms" name="terms" required>
            <label for="terms">
              I agree with the <a href="#">Terms and Conditions</a> of JobPortal
            </label>
          </div>

          <button type="submit" name="register">Register</button>
        </form>

        <p>Already have an account? <a href="./emp-login.php">Login here</a></p>
      </div>
    </div>
  </div>

  <script>
    const menuBtn = document.getElementById('menu-btn');
    const navLinks = document.querySelector('.nav-links');

    if (menuBtn) {
      menuBtn.addEventListener('click', () => {
        navLinks.classList.toggle('open');
        if (navLinks.classList.contains('open')) {
          menuBtn.innerHTML = '<i class="ri-close-line"></i>';
        } else {
          menuBtn.innerHTML = '<i class="ri-menu-line"></i>';
        }
      });

      // Keyboard accessibility for menu toggle
      menuBtn.addEventListener('keydown', (e) => {
        if (e.key === 'Entexr' || e.key === ' ') {
          e.preventDefault();
          menuBtn.click();
        }
      });
    }
  </script>
</body>

</html>