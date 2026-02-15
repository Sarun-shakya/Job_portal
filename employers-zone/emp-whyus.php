<!-- Employers Why Us Page -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Why Us - Job Portal</title>
    <link rel="stylesheet" href="../css/style.css">

    <style>
        /* Global */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'poppins', sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #212529;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 20px 20px;
            padding-bottom: 50px;
        }

        h1,
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 4rem;
        }

        h2 {
            font-size: 1.5rem;
            color: #0d6efd;
        }

        /* Cards */
        .why-cards {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            flex: 1 1 250px;
            max-width: 280px;
            padding: 30px 20px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            font-size: 3rem;
            color: #0d6efd;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .card-text {
            font-size: 1rem;
            color: #495057;
            line-height: 1.6rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .why-cards {
                gap: 20px;
            }

            .card {
                max-width: 100%;
            }
        }

        @media (max-width: 576px) {
            h1 {
                font-size: 2rem;
            }

            h2 {
                font-size: 1.3rem;
            }
        }
    </style>

    <!-- Optional: Remix Icons CDN for card icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
</head>

<body>
    <!-- Nav bar -->
    <?php include 'emp-navbar.php'; ?>

    <div class="container">
        <h1>Why Choose Us?</h1>

        <div class="why-cards">
            <!-- Card 1 -->
            <div class="card">
                <div class="card-icon"><i class="ri-team-line"></i></div>
                <div class="card-title">Top Talent</div>
                <div class="card-text">Access a wide range of skilled professionals ready to grow your business.</div>
            </div>

            <!-- Card 2 -->
            <div class="card">
                <div class="card-icon"><i class="ri-timer-line"></i></div>
                <div class="card-title">Save Time</div>
                <div class="card-text">Streamline the hiring process and post jobs in just a few clicks.</div>
            </div>

            <!-- Card 3 -->
            <div class="card">
                <div class="card-icon"><i class="ri-shield-check-line"></i></div>
                <div class="card-title">Trusted Platform</div>
                <div class="card-text">We ensure a safe and secure environment for both employers and candidates.</div>
            </div>

            <!-- Card 4 -->
            <div class="card">
                <div class="card-icon"><i class="ri-bar-chart-line"></i></div>
                <div class="card-title">Analytics</div>
                <div class="card-text">Get insights on job posts and applications to make informed hiring decisions.</div>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php' ?>
</body>

</html>