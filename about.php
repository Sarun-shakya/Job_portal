<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Job Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            overflow-x: hidden;
            background: #ffffff;
            scroll-behavior: smooth;
        }

        /* Hero Section with Image */
        .hero-section {
            background: #ffffff;
            padding: 80px 20px;
            position: relative;
            overflow: hidden;
        }

        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-content {
            padding-right: 20px;
        }

        .hero-badge {
            display: inline-block;
            background-color: #0d6efd;
            color: white;
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 25px;
            animation: fadeInUp 0.8s ease;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            color: #1a202c;
            margin-bottom: 20px;
            font-weight: 800;
            line-height: 1.2;
            animation: fadeInUp 0.8s ease 0.1s backwards;
        }

        .hero-content h1 .gradient-text {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-content p {
            font-size: 1.2rem;
            color: #718096;
            margin-bottom: 35px;
            line-height: 1.8;
            animation: fadeInUp 0.8s ease 0.2s backwards;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            animation: fadeInUp 0.8s ease 0.3s backwards;
        }

        .btn {
            padding: 15px 35px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            align-items: center;
            gap: 10px;
        }

        .btn-primary {
            background: #0d6efd;
            color: white;
        }


        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-3px);
        }

        .hero-image {
            position: relative;
            animation: fadeInRight 1s ease 0.4s backwards;
        }

        .hero-image img {
            width: 100%;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .floating-card {
            position: absolute;
            background: white;
            padding: 20px 25px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
            animation: float 3s ease-in-out infinite;
        }

        .floating-card-1 {
            top: 10%;
            left: -10%;
        }

        .floating-card-2 {
            bottom: 15%;
            right: -5%;
        }

        .floating-icon {
            width: 50px;
            height: 50px;
            background-color: #6d15b4;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .floating-text h4 {
            font-size: 1.1rem;
            color: #1a202c;
            margin-bottom: 3px;
        }

        .floating-text p {
            font-size: 0.85rem;
            color: #718096;
        }


        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            padding: 60px 20px;
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: white;
            display: block;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }

        /* Mission Section */
        .mission-section {
            padding: 50px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: #1a202c;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .section-title p {
            font-size: 1.1rem;
            color: #718096;
            max-width: 700px;
            margin: 0 auto;
        }

        .mission-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .mission-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .mission-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.15);
            border-color: #667eea;
        }

        .mission-icon {
            width: 80px;
            height: 80px;
            background-color: #0d6efd;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 2.5rem;
            color: white;
            transition: all 0.3s ease;
        }

        .mission-card:hover .mission-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .mission-card h3 {
            font-size: 1.5rem;
            color: #1a202c;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .mission-card p {
            color: #718096;
            line-height: 1.7;
            font-size: 1rem;
        }

        /* Features Section */
        .features-section {
            padding: 100px 20px;
            background: white;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
            margin-top: 50px;
        }

        .feature-item {
            display: flex;
            gap: 25px;
            align-items: flex-start;
        }

        .feature-icon {
            min-width: 60px;
            height: 60px;
            background-color: #6a11cb;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
        }

        .feature-content h4 {
            font-size: 1.3rem;
            color: #1a202c;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .feature-content p {
            color: #718096;
            line-height: 1.7;
        }

        
        /* CTA Section */
        .cta-section {
            padding: 50px 20px;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0.3;
        }

        .cta-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .cta-content h2 {
            font-size: 3rem;
            color: white;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .cta-content p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn-white {
            background: white;
            color: #667eea;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .btn-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
            backdrop-filter: blur(10px);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive */
        @media (max-width: 968px) {
            .hero-container {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .hero-content {
                padding-right: 0;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .hero-image {
                order: -1;
            }

            .floating-card-1 {
                left: 0;
                top: 5%;
            }

            .floating-card-2 {
                right: 0;
                bottom: 5%;
            }

            .stats-container {
                grid-template-columns: repeat(2, 1fr);
                gap: 30px;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .stat-number {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content p {
                font-size: 1rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .cta-content h2 {
                font-size: 2rem;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .floating-card {
                padding: 15px 20px;
            }

            .floating-icon {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }

            .floating-text h4 {
                font-size: 0.95rem;
            }

            .floating-text p {
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
        <?php include 'includes/header.php'?>
    <!-- Hero Section with Image -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <span class="hero-badge"> #1 Job Portal Platform</span>
                <h1>Connecting <span class="gradient-text">Talent</span> with <span class="gradient-text">Opportunity</span></h1>
                <p>We're on a mission to revolutionize the job search experience, making it easier for talented individuals to find their dream careers and for companies to discover exceptional talent.</p>
                <div class="hero-buttons">
                    <a href="register.php" class="btn btn-primary">
                        Get Started <i class="ri-arrow-right-line"></i>
                    </a>
                    <a href="#features" class="btn btn-secondary">
                        Learn More <i class="ri-information-line"></i>
                    </a>
                </div>
            </div>

            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=600&fit=crop" alt="Team collaboration">
                
                <!-- Floating Cards -->
                <div class="floating-card floating-card-1">
                    <div class="floating-icon">
                        <i class="ri-user-add-line"></i>
                    </div>
                    <div class="floating-text">
                        <h4>100K+</h4>
                        <p>Job Seekers</p>
                    </div>
                </div>

                <div class="floating-card floating-card-2">
                    <div class="floating-icon">
                        <i class="ri-briefcase-line"></i>
                    </div>
                    <div class="floating-text">
                        <h4>50K+</h4>
                        <p>Active Jobs</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-container">
            <div class="stat-item">
                <span class="stat-number">50K+</span>
                <span class="stat-label">Active Jobs</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">100K+</span>
                <span class="stat-label">Job Seekers</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">5K+</span>
                <span class="stat-label">Companies</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">95%</span>
                <span class="stat-label">Success Rate</span>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="mission-section">
        <div class="container">
            <div class="section-title">
                <h2>Our Mission & Vision</h2>
                <p>Building bridges between ambition and achievement, one opportunity at a time</p>
            </div>

            <div class="mission-grid">
                <div class="mission-card">
                    <div class="mission-icon">
                        <i class="ri-lightbulb-flash-line"></i>
                    </div>
                    <h3>Innovation First</h3>
                    <p>We leverage cutting-edge technology to create seamless job matching experiences that save time and deliver results.</p>
                </div>

                <div class="mission-card">
                    <div class="mission-icon">
                        <i class="ri-heart-3-line"></i>
                    </div>
                    <h3>People Focused</h3>
                    <p>Every feature we build is designed with real people in mind, ensuring accessibility and ease of use for everyone.</p>
                </div>

                <div class="mission-card">
                    <div class="mission-icon">
                        <i class="ri-trophy-line"></i>
                    </div>
                    <h3>Excellence Driven</h3>
                    <p>We're committed to maintaining the highest standards in recruitment, helping both job seekers and employers achieve their goals.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="section-title">
                <h2>What Makes Us Different</h2>
                <p>Innovative features designed to make your job search or hiring process effortless</p>
            </div>

            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="ri-search-eye-line"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Smart Job Matching</h4>
                        <p>Our AI-powered algorithm analyzes your skills, experience, and preferences to recommend the most relevant job opportunities.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="ri-shield-check-line"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Verified Companies</h4>
                        <p>Every employer on our platform is thoroughly verified, ensuring you're applying to legitimate and reputable organizations.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="ri-time-line"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Real-Time Updates</h4>
                        <p>Get instant notifications about new job postings, application status changes, and messages from employers.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="ri-user-star-line"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Career Resources</h4>
                        <p>Access resume templates, interview tips, and career guidance to help you land your dream job with confidence.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="ri-bar-chart-box-line"></i>
                    </div>
                    <div class="feature-content">
                        <h4>Analytics Dashboard</h4>
                        <p>Track your application progress, view profile insights, and understand market trends with our comprehensive analytics.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="ri-customer-service-2-line"></i>
                    </div>
                    <div class="feature-content">
                        <h4>24/7 Support</h4>
                        <p>Our dedicated support team is always available to help you navigate the platform and resolve any issues quickly.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content">
            <h2>Ready to Start Your Journey?</h2>
            <p>Join thousands of professionals who have found their dream careers through our platform. Whether you're seeking new opportunities or looking to hire top talent, we're here to help.</p>
            <div class="cta-buttons">
                <a href="register.php" class="btn btn-white">
                    Get Started <i class="ri-arrow-right-line"></i>
                </a>
                <a href="contact.php" class="btn btn-outline">
                    Contact Us <i class="ri-chat-3-line"></i>
                </a>
            </div>
        </div>
    </section>
<?php include 'includes/footer.php'?>
</body>
</html>