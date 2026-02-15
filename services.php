<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <!-- links -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <style>
        /* Services Page CSS */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #0d6efd;
            --primary-dark: #0b5ed7;
            --primary-light: #3d8bfd;
            --secondary: #6c757d;
            --success: #198754;
            --text-dark: #0f172a;
            --text-gray: #64748b;
            --text-light: #94a3b8;
            --bg-light: #f8f9fa;
            --bg-white: #ffffff;
            --border: #e5e7eb;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.12);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            background: var(--bg-white);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Hero Section */
        .hero {
            position: relative;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 100px 0 120px;
            overflow: hidden;
            text-align: center;
        }

        .hero-shapes {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .hero-shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }

        .hero-shape:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -50px;
            animation-delay: 0s;
        }

        .hero-shape:nth-child(2) {
            width: 200px;
            height: 200px;
            bottom: -50px;
            right: 10%;
            animation-delay: 5s;
        }

        .hero-shape:nth-child(3) {
            width: 150px;
            height: 150px;
            top: 50%;
            right: -30px;
            animation-delay: 10s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -30px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 24px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .hero-badge i {
            color: #ffd700;
        }

        .hero-title {
            font-size: 56px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 20px;
            line-height: 1.2;
            letter-spacing: -1px;
        }

        .hero-subtitle {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.8;
            max-width: 700px;
            margin: 0 auto;
        }

        /* Services Section */
        .services-section {
            padding: 80px 0;
            background: var(--bg-white);
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #e0e7ff;
            color: var(--primary);
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .section-title {
            font-size: 42px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 16px;
            line-height: 1.2;
        }

        .highlight {
            color: var(--primary);
            position: relative;
        }

        .section-subtitle {
            font-size: 17px;
            color: var(--text-gray);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* Services Grid */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 32px;
            margin-top: 48px;
        }

        .service-card {
            background: var(--bg-white);
            border: 2px solid var(--border);
            border-radius: 20px;
            padding: 40px 32px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .service-card:hover::before {
            transform: scaleX(1);
        }

        .service-icon {
            width: 70px;
            height: 70px;
            background-color: #0d6efd;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            transition: var(--transition);
        }

        .service-card:hover .service-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .service-icon i {
            font-size: 32px;
            color: #ffffff;
        }

        .service-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .service-description {
            font-size: 15px;
            color: var(--text-gray);
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .service-features {
            list-style: none;
        }

        .service-feature {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: var(--text-gray);
            margin-bottom: 12px;
        }

        .service-feature i {
            color: var(--success);
            font-size: 16px;
        }

        /* Why Choose Section */
        .why-choose {
            padding: 80px 0;
            background: linear-gradient(180deg, var(--bg-white) 0%, var(--bg-light) 100%);
        }

        .why-choose-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-top: 48px;
        }

        .why-card {
            background: var(--bg-white);
            border-radius: 20px;
            padding: 40px 32px;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            position: relative;
            border: 1px solid transparent;
        }

        .why-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .why-number {
            position: absolute;
            top: 24px;
            right: 24px;
            font-size: 48px;
            font-weight: 700;
            color: rgba(13, 110, 253, 0.1);
            line-height: 1;
        }

        .why-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .why-icon i {
            font-size: 28px;
            color: var(--primary);
        }

        .why-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .why-description {
            font-size: 15px;
            color: var(--text-gray);
            line-height: 1.7;
        }

        /* CTA Section */
        .cta-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
            margin-bottom: 40px;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.3;
        }

        .cta-container {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .cta-content {
            max-width: 700px;
            margin: 0 auto;
        }

        .cta-title {
            font-size: 42px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 16px;
            line-height: 1.2;
        }

        .cta-subtitle {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 32px;
            line-height: 1.7;
        }

        .cta-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 32px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            border: 2px solid transparent;
        }

        .cta-button.primary {
            background: #ffffff;
            color: var(--primary);
        }

        .cta-button.primary:hover {
            background: var(--bg-light);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .cta-button.secondary {
            background: transparent;
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.4);
        }

        .cta-button.secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #ffffff;
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hero-title {
                font-size: 48px;
            }

            .section-title {
                font-size: 36px;
            }

            .cta-title {
                font-size: 36px;
            }

            .services-grid,
            .why-choose-grid {
                gap: 24px;
            }
        }

        @media (max-width: 768px) {
            .hero {
                padding: 80px 0 100px;
            }

            .hero-title {
                font-size: 40px;
            }

            .hero-subtitle {
                font-size: 16px;
            }

            .section-title {
                font-size: 32px;
            }

            .cta-title {
                font-size: 32px;
            }

            .services-section,
            .why-choose,
            .cta-section {
                padding: 60px 0;
            }

            .services-grid,
            .why-choose-grid {
                grid-template-columns: 1fr;
            }

            .service-card,
            .why-card {
                padding: 32px 24px;
            }

            .section-header {
                margin-bottom: 40px;
            }
        }

        @media (max-width: 640px) {
            .container {
                padding: 0 16px;
            }

            .hero {
                padding: 60px 0 80px;
            }

            .hero-title {
                font-size: 32px;
            }

            .hero-badge {
                font-size: 13px;
                padding: 8px 16px;
            }

            .section-title {
                font-size: 28px;
            }

            .section-subtitle {
                font-size: 15px;
            }

            .cta-title {
                font-size: 28px;
            }

            .cta-subtitle {
                font-size: 16px;
            }

            .cta-buttons {
                flex-direction: column;
                gap: 12px;
            }

            .cta-button {
                width: 100%;
                justify-content: center;
            }

            .service-title,
            .why-title {
                font-size: 20px;
            }

            .hero-shape:nth-child(1) {
                width: 200px;
                height: 200px;
            }

            .hero-shape:nth-child(2) {
                width: 150px;
                height: 150px;
            }

            .hero-shape:nth-child(3) {
                width: 100px;
                height: 100px;
            }
        }
    </style>
</head>

<body>
    <?php include './includes/header.php' ?>
    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-shapes">
                <div class="hero-shape"></div>
                <div class="hero-shape"></div>
                <div class="hero-shape"></div>
            </div>
            <div class="container">
                <div class="hero-content">
                    <div class="hero-badge">
                        <i class="ri-search-line"></i>
                        Trusted by 10,000+ Companies Worldwide
                    </div>
                    <h1 class="hero-title">Our Services</h1>
                    <p class="hero-subtitle">
                        Connecting talented professionals with leading employers.
                        Discover comprehensive solutions designed to accelerate your career
                        or find the perfect candidate for your team.
                    </p>
                </div>
            </div>
        </section>

        <!-- Services for Job Seekers -->
        <section class="services-section" id="job-seekers">
            <div class="container">
                <div class="section-header">
                    <span class="section-badge">
                        <i class="ri-user-3-line"></i>
                        For Job Seekers
                    </span>
                    <h2 class="section-title">Find Your <span class="highlight">Dream Job</span></h2>
                    <p class="section-subtitle">
                        Powerful tools and resources to help you land your next opportunity faster
                    </p>
                </div>

                <div class="services-grid">
                    <!-- Service Card 1 -->
                    <article class="service-card">
                        <div class="service-icon">
                            <i class="ri-search-line"></i>
                        </div>
                        <h3 class="service-title">Job Search & Filtering</h3>
                        <p class="service-description">
                            Find the perfect job with our advanced search and filtering options.
                            Filter by location, salary, experience level, and more.
                        </p>
                        <ul class="service-features">
                            <li class="service-feature">
                                <i class="ri-check-line"></i>
                                Advanced keyword search
                            </li>
                            <li class="service-feature">
                                <i class="ri-check-line"></i>
                                Location-based filtering
                            </li>
                            <li class="service-feature">
                                <i class="ri-check-line"></i>
                                Salary range options
                            </li>
                        </ul>
                    </article>

                    <!-- Service Card 2 -->
                    <article class="service-card">
                        <div class="service-icon">
                            <i class="ri-upload-cloud-line"></i>
                        </div>
                        <h3 class="service-title">Resume Upload</h3>
                        <p class="service-description">
                            Upload your resume and let employers find you. Our smart system
                            parses your skills and matches you with relevant opportunities.
                        </p>
                        <ul class="service-features">
                            <li class="service-feature">
                                <i class="ri-check-line"></i>
                                Multiple format support
                            </li>
                            <li class="service-feature">
                                <i class="ri-check-line"></i>
                                AI-powered parsing
                            </li>
                            <li class="service-feature">
                                <i class="ri-check-line"></i>
                                Privacy controls
                            </li>
                        </ul>
                    </article>

                    <!-- Service Card 3 -->
                    <article class="service-card">
                        <div class="service-icon">
                            <i class="ri-notification-line"></i>
                        </div>
                        <h3 class="service-title">Job Application Tracking</h3>
                        <p class="service-description">
                            Track your job applications in real time.
                            Know when your application is viewed or shortlisted
                            and keep all your job applications organized in one place.
                        </p>
                        <ul class="service-features">
                            <li class="service-feature">
                                <i class="ri-check-line"></i>
                                Real-time status
                            </li>
                            <li class="service-feature">
                                <i class="ri-check-line"></i>
                                Email notifications
                            </li>
                            <li class="service-feature">
                                <i class="ri-check-line"></i>
                                History & insights
                            </li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        <!-- Why Choose Us Section -->
        <section class="why-choose" id="why-us">
            <div class="container">
                <div class="section-header">
                    <span class="section-badge">
                        <i class="ri-trophy-line"></i>
                        Why Choose Us
                    </span>
                    <h2 class="section-title">Why <span class="highlight">JobPortal</span>?</h2>
                    <p class="section-subtitle">
                        We're committed to providing the best experience for job seekers and employers alike
                    </p>
                </div>

                <div class="why-choose-grid">
                    <!-- Why Card 1 -->
                    <article class="why-card">
                        <span class="why-number">01</span>
                        <div class="why-icon">
                            <i class="ri-building-4-line"></i>
                        </div>
                        <h3 class="why-title">Trusted by Companies</h3>
                        <p class="why-description">
                            Over 10,000 leading companies trust our platform to find their next great hire.
                            Join the ranks of Fortune 500 companies and innovative startups.
                        </p>
                    </article>

                    <!-- Why Card 2 -->
                    <article class="why-card">
                        <span class="why-number">02</span>
                        <div class="why-icon">
                            <i class="ri-computer-line"></i>
                        </div>
                        <h3 class="why-title">Easy-to-Use Interface</h3>
                        <p class="why-description">
                            Our intuitive platform makes job searching and hiring effortless.
                            Simple navigation, powerful features, and a clean design you'll love.
                        </p>
                    </article>

                    <!-- Why Card 3 -->
                    <article class="why-card">
                        <span class="why-number">03</span>
                        <div class="why-icon">
                            <i class="ri-shield-line"></i>
                        </div>
                        <h3 class="why-title">Secure & Reliable</h3>
                        <p class="why-description">
                            Your data is protected with enterprise-grade security. We ensure 99.9% uptime
                            and comply with global privacy standards to keep your information safe.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section" id="cta">
            <div class="container">
                <div class="cta-container">
                    <div class="cta-content">
                        <h2 class="cta-title">Ready to Get Started?</h2>
                        <p class="cta-subtitle">
                            Join thousands of job seekers and employers who are already
                            finding success with JobConnect.
                        </p>
                        <div class="cta-buttons">
                            <a href="jobs.php" class="cta-button primary">
                                <i class="ri-search-line"></i>
                                Find a Job
                            </a>
                            <a href="employers-zone/emp-home.php" class="cta-button secondary">
                                <i class="ri-add-line"></i>
                                Post a Job
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include './includes/footer.php' ?>
</body>

</html>