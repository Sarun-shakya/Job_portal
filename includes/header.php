<!-- Header -->

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- meta -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- links -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/header.css">
  <title>Job Portal</title>

  <!-- css -->
  <style>
    /*  nav bar   */

    nav {
      position: sticky;
      top: 0;
      z-index: 1000;
      background-color: #fff;
      border-bottom: 1px solid #ddd;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      padding: 0.75rem 2rem;
      height: 67px;
    }

    .nav-header {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: nowrap;
      position: relative;
    }

    .nav-logo .logo {
      font-weight: 700;
      font-size: 1.7rem;
      color: #0d6efd;
      text-decoration: none;
      white-space: nowrap;
    }

    .nav-logo .logo span {
      color: #6d15b4;
    }

    .nav-links {
      flex: 1;
      display: flex;
      justify-content: center;
    }

    .nav-links ul {
      list-style: none;
      display: flex;
      gap: 2rem;
      margin: 0;
      padding: 0;
    }

    .nav-links ul li a {
      text-decoration: none;
      color: #333;
      font-weight: 500;
      font-size: 1rem;
      transition: color 0.3s ease;
    }

    .nav-links ul li a:hover,
    .nav-links ul li a:focus {
      color: #0d6efd;
      outline: none;
    }

    .login {
      display: flex;
      align-items: center;
    }

    .login ul {
      list-style: none;
      display: flex;
      gap: 1rem;
      margin: 0;
      padding: 0;
      align-items: center;
    }

    .login ul li {
      display: flex;
      align-items: center;
    }

    .login ul li button {
      font-size: 1rem;
      font-weight: 600;
      padding: 0.5rem 1.25rem;
      border-radius: 0.375rem;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
      white-space: nowrap;
    }

    .login ul li button a {
      text-decoration: none;
      color: white;
    }

    .login ul li button.btn-primary {
      background-color: #0d6efd;
      border: none;
    }

    .nav-menu-btn {
      display: none;
      font-size: 1.8rem;
      cursor: pointer;
      color: #333;
      background: none;
      border: none;
    }

    .nav-links ul li a,
    .login ul li button {
      line-height: 1.5;
    }

    .login ul li a {
      text-align: center;
      padding: 0.5rem 1rem;
      line-height: 1.5;
      color: #333;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .login ul li:last-child a {
      padding-left: 1rem;
      padding-right: 0;
      border-left: 1px solid #ccc;
      color: #333;
    }

    .login ul li:last-child a:hover {
      color: #0d6efd;
    }

    .login ul li a[href="./bookmarks.php"] {
      font-size: 1.3rem;
      color: #333;
      transition: color 0.3s ease;
    }

    .login ul li a[href="./bookmarks.php"]:hover {
      color: #0d6efd;
    }

    /* Responsive */
    @media (max-width: 991px) {
      .nav-menu-btn {
        display: block;
      }

      .nav-header {
        flex-wrap: nowrap;
        justify-content: space-between;
      }

      .nav-links {
        position: fixed;
        top: 60px;
        left: 0;
        right: 0;
        background: white;
        flex-direction: column;
        align-items: center;
        display: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        padding: 1rem 0;
      }

      .nav-links.open {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        padding: 1rem 0;
      }

      .nav-links ul {
        flex-direction: column;
        gap: 1rem;
        width: 100%;
        padding: 0 2rem;
      }

      .nav-links ul li a {
        color: #333;
        font-size: 1.2rem;
        padding: 0.75rem 0;
        text-align: center;
      }

      .login {
        display: none;
      }

      /* Styles for login when moved inside nav-links in mobile */
      .nav-links .login {
        display: flex !important;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        margin-top: 1rem;
        padding: 1rem 2rem 0;
        border-top: 1px solid #ddd;
        width: 100%;
      }

      .nav-links .login ul {
        flex-direction: column;
        gap: 1rem;
        width: 100%;
        align-items: center;
      }

      .nav-links .login ul li {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .nav-links .login ul li button {
        width: 100%;
        max-width: 200px;
        font-size: 1.1rem;
      }

      .nav-links .login ul li:last-child a {
        border-left: none;
        padding: 0.75rem 0;
        width: 100%;
        text-align: center;
        border-top: 1px solid #ddd;
        margin-top: 0.5rem;
      }

      /* Mobile adjustments for login status */
      .nav-links .profile-dropdown-menu {
        position: static;
        box-shadow: none;
        border: 1px solid #ddd;
        margin-top: 0.5rem;
      }

      /* Mobile: Smaller profile pic and adjust layout */
      .nav-links .profile-pic {
        width: 35px;
        height: 35px;
      }

      .nav-links .profile-username {
        font-size: 0.9rem;
      }
    }

    @media (max-width: 480px) {
      nav {
        padding: 0.75rem 1rem;
      }

      .nav-links ul li a {
        font-size: 1rem;
      }

      .login ul li button {
        padding: 0.4rem 1rem;
        font-size: 1rem;
      }

      .nav-links ul {
        padding: 0 1rem;
      }

      .nav-links .login {
        padding: 1rem 1rem 0;
      }

      .login ul li a {
        padding: 0.5rem 0.5rem;
        text-align: left;
      }

      .profile-pic {
        width: 30px;
        height: 30px;
      }

      .profile-username {
        font-size: 0.8rem;
      }
    }

    .nav-links ul li a {
      position: relative;
      padding-bottom: 4px;
    }

    .nav-links ul li a::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: 0;
      height: 3px;
      width: 0%;
      background-color: #0d6efd;
      transition: width 0.3s ease-in-out;
    }

    .nav-links ul li a.active {
      color: #0d6efd;
    }

    .nav-links ul li a.active::after {
      width: 100%;
    }

    .nav-links ul li a:hover::after {
      width: 100%;
    }



    /* Profile Dropdown Styles */
.profile-dropdown {
  position: relative;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.profile-pic {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #ddd;
  transition: border-color 0.3s ease;
  cursor: pointer;
}

.profile-pic:hover {
  border-color: #0d6efd;
}

.profile-username {
  font-weight: 600;
  color: #333;
  font-size: 1rem;
  white-space: nowrap;
  margin-right: 0.5rem;
}

.profile-dropdown-btn {
  background: none;
  border: none;
  cursor: pointer;
  color: #333;
  font-size: 1.5rem;
  border-radius: 0.25rem;
  padding: 0.25rem;
  transition: background-color 0.3s ease, transform 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.profile-dropdown-btn:hover {
  background-color: #f8f9fa;
  transform: translateY(2px);
}

.profile-dropdown-btn:focus {
  outline: 2px solid #0d6efd;
  outline-offset: 2px;
}

.profile-dropdown-menu {
  display: none;
  position: absolute;
  top: calc(100% + 0.5rem);
  right: 0;
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 0.5rem;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
  min-width: 200px;
  z-index: 1000;
  overflow: hidden;
  animation: dropdownFadeIn 0.2s ease-out;
}

@keyframes dropdownFadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.profile-dropdown-menu a {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.875rem 1.25rem;
  text-decoration: none;
  color: #333;
  font-weight: 500;
  font-size: 0.95rem;
  transition: all 0.2s ease;
  border-bottom: 1px solid #f0f0f0;
}

.profile-dropdown-menu a:last-child {
  border-bottom: none;
}

.profile-dropdown-menu a:hover {
  background-color: #f8f9fa;
  color: #0d6efd;
  padding-left: 1.5rem;
}

.profile-dropdown-menu a i {
  font-size: 1.1rem;
  transition: transform 0.2s ease;
}

.profile-dropdown-menu a:hover i {
  transform: scale(1.1);
}

/* Mobile Responsive */
@media (max-width: 991px) {
  .nav-links .profile-dropdown-menu {
    position: static;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    margin-top: 0.5rem;
    width: 100%;
    max-width: 300px;
  }

  .nav-links .profile-pic {
    width: 35px;
    height: 35px;
  }

  .nav-links .profile-username {
    font-size: 0.9rem;
  }
}

@media (max-width: 480px) {
  .profile-pic {
    width: 32px;
    height: 32px;
  }

  .profile-username {
    font-size: 0.85rem;
  }

  .profile-dropdown-menu {
    min-width: 180px;
  }

  .profile-dropdown-menu a {
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
  }
}
  </style>
</head>

<body>
  <!-- nav bar -->
  <nav>
    <div class="nav-header">
      <div class="nav-logo">
        <a href="/Online%20Job%20Portal%20System/index.php" class="logo">Job<span>Portal</span></a>
      </div>
      <div class="nav-menu-btn" id="menu-btn">
        <i class="ri-menu-line"></i>
      </div>
      <div class="nav-links">
        <ul>
          <li><a href="/Online Job Portal System/index.php"
              class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
              Home
            </a>
          </li>

          <li>
            <a href="/Online Job Portal System/jobs.php"
              class="<?php
                      $currentPage = basename($_SERVER['PHP_SELF']);
                      echo ($currentPage == 'jobs.php' || $currentPage == 'job-description.php') ? 'active' : '';
                      ?>">
              Jobs
            </a>
          </li>


          <li><a href="/Online Job Portal System/about.php"
              class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">
              About
            </a>
          </li>

          <li><a href="/Online Job Portal System/services.php"
              class="<?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : ''; ?>">
              Services
            </a>
          </li>

          <li><a href="/Online Job Portal System/contact.php"
              class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">
              Contacts
            </a>
          </li>

        </ul>
      </div>
      <div class="login">
        <ul>
          <?php if (isset($_SESSION['user_id'])): ?>
            <li>
              <a href="./bookmarks.php" style="font-size:1.3rem;">
                <i class="ri-bookmark-line"></i>
              </a>
            </li>

            <li class="profile-dropdown">

              <img src="/Online Job Portal System/uploads/<?php echo htmlspecialchars($_SESSION['profile_pic']); ?>"
                alt="Profile Picture" class="profile-pic">

              <span class="profile-username"><?php echo $_SESSION['username']; ?></span>

              <button class="profile-dropdown-btn" id="profileBtn" aria-expanded="false" aria-haspopup="true">
                <i class="ri-arrow-drop-down-line"></i>
              </button>

              <div class="profile-dropdown-menu" id="profileMenu">
                <a href="./profile.php"><i class="ri-user-line"></i> Visit Profile</a>
                <a href="./logout.php"><i class="ri-logout-box-line"></i> Logout</a>
              </div>
            </li>

          <?php else: ?>

            <!-- If NOT logged in -->
            <li>
              <button class="btn btn-primary btn-lg">
                <a href="./login.php">Login</a>
              </button>
            </li>
            <li><a href="./employers-zone/emp-home.php">Employers Zone</a></li>

          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <script>
    const menuBtn = document.getElementById('menu-btn');
    const navLinks = document.querySelector('.nav-links');
    const login = document.querySelector('.login');
    const navHeader = document.querySelector('.nav-header');
    const ul = navLinks.querySelector('ul');

    menuBtn.addEventListener('click', () => {
      const isOpen = navLinks.classList.toggle('open');
      if (isOpen) {
        login.style.display = 'flex';
        ul.appendChild(login);
        menuBtn.innerHTML = '<i class="ri-menu-line"></i>';
      } else {
        navHeader.appendChild(login);
        login.style.display = '';
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

    // Updated script for profile dropdown toggle (targets the new button)
    const profileBtn = document.getElementById('profileBtn');
    const profileMenu = document.getElementById('profileMenu');

    if (profileBtn && profileMenu) {
      // Toggle dropdown on button click
      profileBtn.addEventListener('click', (e) => {
        e.stopPropagation(); // Prevent event bubbling
        const isExpanded = profileMenu.style.display === 'block';
        profileMenu.style.display = isExpanded ? 'none' : 'block';
        profileBtn.setAttribute('aria-expanded', !isExpanded); // Update accessibility
      });

      // Close dropdown when clicking outside
      document.addEventListener('click', () => {
        profileMenu.style.display = 'none';
        profileBtn.setAttribute('aria-expanded', 'false');
      });

      // Keyboard support: Close on Escape
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
          profileMenu.style.display = 'none';
          profileBtn.setAttribute('aria-expanded', 'false');
        }
      });

      // Keyboard accessibility for profile button
      profileBtn.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          profileBtn.click();
        }
      });
    }
  </script>

</body>

</html>