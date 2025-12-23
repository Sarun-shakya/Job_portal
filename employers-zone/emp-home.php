<!-- Employers Home Page -->

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (with Popper for dropdowns, tooltips, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- links -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css">
    <title>Job Portal</title>

    <!-- css -->
    <style>
        .emp-hero {
            background-color: white;
            min-height: 70vh;
            display: flex;
            align-items: center;
            text-align: left;
        }

        .emp-hero-heading {
            text-align: left;
        }

        .emp-hero-heading h1 {
            margin-bottom: 1rem;
            font-size: 4rem;
            font-weight: 700;
            color: black;
            line-height: 5.5rem;
            text-align: left;
        }

        .emp-hero-heading h1 span {
            color: blue;
        }

        .emp-hero-heading p {
            margin-bottom: 2rem;
            max-width: 600px;
            color: black;
            line-height: 2rem;
            font-size: 1.2rem;
            text-align: left;
        }

        .emp-hero-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .emp-hero-link button a {
            color: white;
            text-decoration: none;
        }

        .emp-hero-link button a {
            color: white;
            text-decoration: none;
        }

        .emp-hero-link button {
            text-align: center;
            background: linear-gradient(135deg, #0056b3, #003d80);
        }

        .emp-hero-img img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .emp-hero {
                padding: 60px 0;
                text-align: center;
            }

            .emp-hero-heading h1 {
                font-size: 2.5rem;
                line-height: 3.5rem;
            }
        }
        .btn{
            background-color: #0d6efd!important;
        }
    </style>
</head>

<body>
    <!-- Nav bar -->
    <?php include 'emp-navbar.php'; ?>

    <!-- Hero Section -->
    <div class="emp-hero">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left side: Text and Button -->
                <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                    <div class="emp-hero-heading">
                        <h1>Find the Right Talent, <span>Effortlessly</span></h1>
                        <p>Connect with top professionals and streamline your hiring process with ease. Your ideal candidate is just a few clicks away.</p>
                    </div>
                    <div class="emp-hero-link">
                        <button class="btn btn-primary btn-lg" style="background-color: #0d6efd"><a href="emp-login.php">Post a Job</a></button>
                    </div>
                </div>
                <!-- Right side: Image -->
                <div class="col-lg-6 col-md-6">
                    <div class="emp-hero-img">
                        <img src="../assets/job-post.jpg" alt="Post job">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>