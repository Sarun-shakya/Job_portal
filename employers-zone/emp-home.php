<!-- Employers Home Page -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <link rel="stylesheet" href="../css/style.css">

    <style>
        /* Global Styles */
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

        /* Hero Section */
        .emp-hero {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 20px;
            background: linear-gradient(135deg, #ffffff, #e9ecef);
            min-height: 80vh;
            margin-bottom: 30px;
            box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.1);
        }

        .emp-hero-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 40px;
            max-width: 1200px;
            width: 100%;
            
        }

        .emp-hero-left {
            flex: 1;
        }

        .emp-hero-heading h1 {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 4rem;
            margin-bottom: 20px;
        }

        .emp-hero-heading h1 span {
            color: #0d6efd;
        }

        .emp-hero-heading p {
            font-size: 1.2rem;
            line-height: 1.8rem;
            color: #495057;
            margin-bottom: 30px;
            max-width: 500px;
        }

        .emp-hero-link button {
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #0056b3, #003d80);
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .emp-hero-link button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .emp-hero-right {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .emp-hero-img img {
            max-width: 100%;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .emp-hero-container {
                flex-direction: column;
                text-align: center;
            }

            .emp-hero-heading h1 {
                font-size: 2.5rem;
                line-height: 3rem;
            }

            .emp-hero-heading p {
                font-size: 1rem;
            }

            .emp-hero-link button {
                padding: 10px 25px;
                font-size: 1rem;
            }

            .emp-hero-img img {
                max-width: 400px;
            }
        }

        @media (max-width: 576px) {
            .emp-hero-heading h1 {
                font-size: 2rem;
                line-height: 2.5rem;
            }

            .emp-hero-img img {
                max-width: 300px;
            }
        }
    </style>
</head>

<body>
    <!-- Nav bar -->
    <?php include 'emp-navbar.php'; ?>

    <!-- Hero Section -->
    <section class="emp-hero">
        <div class="emp-hero-container">
            <div class="emp-hero-left">
                <div class="emp-hero-heading">
                    <h1>Find the Right Talent, <span>Effortlessly</span></h1>
                    <p>Connect with top professionals and streamline your hiring process. Your ideal candidate is just a few clicks away.</p>
                    <div class="emp-hero-link">
                        <button><a href="emp-login.php">Post a Job</a></button>
                    </div>
                </div>
            </div>
            <div class="emp-hero-right">
                <div class="emp-hero-img">
                    <img src="../assets/job-post.jpg" alt="Post job">
                </div>
            </div>
        </div>
    </section>
    <?php include '../includes/footer.php'?>
</body>

</html>
