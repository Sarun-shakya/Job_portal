<!-- Header -->

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- meta -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


  <!-- Bootstrap CSS -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

  <!-- Bootstrap JS (with Popper for dropdowns, tooltips, etc.) -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

  <!-- links -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/style.css">
  <title>Job Portal</title>

  <!-- css -->
  <style>

  </style>
</head>

<body>
  <!-- nav bar -->
  <nav>
    <div class="nav-header">
      <!-- logo -->
      <div class="nav-logo">
        <a href="emp-home.php" class="logo">Job<span>Portal</span></a>
      </div>
      <div class="nav-menu-btn" id="menu-btn">
        <i class="ri-menu-line"></i>
      </div>
      <div class="nav-links">
        <ul>
          <li><a href="emp-home.php">Home</a></li>
          <li><a href="#">Why us?</a></li>
          <li><a href="#">Pricing/Plans</a></li>
        </ul>
      </div>
      <div class="login">
        <ul>
          <li><button class="btn btn-primary btn-lg"><a href="emp-login.php">Login</a></button></li>
          <li><a href="/Online%20Job%20Portal%20System/index.php">Browse jobs</a></li>
        </ul>
      </div>

    </div>

  </nav>
  <script>
    const menuBtn = document.getElementById('menu-btn');
    const navLinks = document.querySelector('.nav-links');

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
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        menuBtn.click();
      }
    });
  </script>

</body>

</html>