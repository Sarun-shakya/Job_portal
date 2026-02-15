<!-- Employers Pricing Page -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing & Plans - Job Portal</title>
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

        /* Container */
        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 10px 20px;
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 3rem;
        }

        h2 {
            font-size: 1.8rem;
            color: #0d6efd;
        }

        /* Pricing Cards */
        .pricing-cards {
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
            max-width: 300px;
            padding: 30px 20px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .price {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .duration {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .features {
            list-style: none;
            margin-bottom: 25px;
            text-align: left;
            padding-left: 0;
        }

        .features li {
            margin: 10px 0;
            padding-left: 20px;
            position: relative;
        }

        .features li::before {
            content: "✔";
            position: absolute;
            left: 0;
            color: #0d6efd;
        }

        .card button {
            background: #0d6efd;
            color: #fff;
            border: none;
            padding: 12px 25px;
            font-size: 1rem;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .card button:hover {
            background: #0056b3;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .pricing-cards {
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
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Nav bar -->
    <?php include 'emp-navbar.php'; ?>

    <div class="container">
        <h1>Pricing & Plans</h1>
        <p style="text-align:center; margin-bottom:50px;">Choose the plan that best fits your hiring needs.</p>

        <div class="pricing-cards">
            <!-- Basic Plan -->
            <div class="card">
                <div class="card-title">Basic</div>
                <div class="price">$0</div>
                <div class="duration">per month</div>
                <ul class="features">
                    <li>Post 5 Jobs</li>
                    <li>Access to Basic Candidates</li>
                    <li>Change application status</li>
                </ul>
                <button><a href="emp-login.php">Choose Plan</a></button>
            </div>

            <!-- Standard Plan -->
            <div class="card">
                <div class="card-title">Standard</div>
                <div class="price">$99</div>
                <div class="duration">per month</div>
                <ul class="features">
                    <li>Post 20 Jobs</li>
                    <li>Access to All Candidates</li>
                    <li>Email & Chat Support</li>
                    <li>Featured Job Posts</li>
                </ul>
                <button><a href="emp-login.php">Choose Plan</a></button>
            </div>

            <!-- Premium Plan -->
            <div class="card">
                <div class="card-title">Premium</div>
                <div class="price">$199</div>
                <div class="duration">per month</div>
                <ul class="features">
                    <li>Unlimited Job Posts</li>
                    <li>Access to Premium Candidates</li>
                    <li>Priority Support</li>
                    <li>Featured & Top Listings</li>
                    <li>Analytics Dashboard</li>
                </ul>
                <button><a href="emp-login.php">Choose Plan</a></button>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php' ?>
</body>

</html>
