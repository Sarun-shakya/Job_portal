<!-- index page  -->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include './includes/flash.php';
include './config/db.php'
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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/flash.css">
    <style>
    </style>
</head>

<style>

</style>

<body>
    

    <!-- header  -->
    <?php include './includes/header.php' ?>

    <!-- hero section -->
    <div class="container" id="home">
        <img src="assets/google.png" alt="Google">
        <img src="assets/x.png" alt="x">
        <img src="assets/facebook.png" alt="facebook">
        <img src="assets/linkedin.png" alt="linkedin">
        <img src="assets/microsoft.png" alt="microsoft">
        <img src="assets/figma.png" alt="figma">
        <h2>
            <img src="assets/bag.png" alt="bag">
            No. 1 Job Portal Website
        </h2>
        <h1>Search, Apply & <br> Get Your <span class="gradient-text">Dream Job</span></h1>
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores tenetur sunt quidem? Aliquam architecto nulla, esse quas quibusdam culpa ullam, quidem placeat doloremque alias at, quis repellat nisi animi! Necessitatibus.
        </p>

        <div class="container-btns">
            <button class="btn btn-primary btn-lg"><a href="jobs.php">Browse Jobs</a></button>
            <a href="#steps-info">
                <span><i class="ri-play-fill"></i></span>How it works?
            </a>
        </div>
    </div>

    <!-- featured companies -->
    <div class="featured">
        <h1>Featured Companies</h1>
        <div class="companies-list">
            <div class="company">
                <img src="./assets/daraz.png" alt="daraz">
                Daraz
            </div>
            <div class="company">
                <img src="./assets/esewa.png" alt="esewa">
                E-Sewa
            </div>
            <div class="company">
                <img src="./assets/khalti.png" alt="Khalti">
                Khalti
            </div>
            <div class="company">
                <img src="./assets/hamropatro.png" alt="hamro patro">
                Hamro Patro
            </div>
            <div class="company">
                <img src="./assets/leapfrog.png" alt="Leap Frog">
                Leap Frog
            </div>
        </div>
    </div>

    <!-- Recent Jobs  -->
    <div class="recent-jobs">
        <div class="recent-jobs-header">
            <h2>Recent Jobs</h2>
            <button class="btn btn-outline-info"><a href="./jobs.php">View All</a> <i class="ri-arrow-right-line"></i></button>
        </div>
        <div class="jobs-list">
            <?php 
                // $sql = "SELECT * FROM jobs ORDER BY posted_time DESC LIMIT 6";
                $sql = "SELECT j.*, e.name AS company_name, e.logo AS company_logo
                FROM jobs j
                INNER JOIN employers e
                ON j.employer_id = e.id
                ORDER BY posted_time DESC LIMIT 6";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) <= 6){
                    while($row = mysqli_fetch_assoc($result)){
                        date_default_timezone_set('Asia/Kathmandu');
                        $posted_time = $row["posted_time"];
                        $current = new DateTime();
                        $posted = new DateTime($posted_time);
                        $diff = $current->diff($posted);

                        if($diff->y > 0){
                            $post_time = $diff->y.' year ago';
                        }
                        elseif($diff->m > 0){
                            $post_time = $diff->m.' month ago';
                        }
                        elseif($diff->d > 0){
                            $post_time = $diff->d.' day ago';
                        }
                        elseif($diff->h > 0){
                            $post_time = $diff->h.' hour ago';
                        }
                        elseif($diff->i > 0){
                            $post_time = $diff->i.' minute ago';
                        }
                        else{
                            $post_time = "Just now";
                        }
                        echo
                        '<div class="job-card">
                            <div class="card-row1">
                                <div class="post-time">'.$post_time.'</div>
                                <i class="ri-bookmark-line"></i>
                            </div>
                            <div class="card-row2">
                                <img src="./employers-zone/uploads/'.$row["company_logo"].'" alt="Comapany logo">
                                <div class="job-title">
                                    <h2>'.$row["title"].'</h2>
                                    <p>'.$row["company_name"].'</p>
                                </div>  
                            </div>
                            <div class="card-row3">
                                <i class="ri-map-pin-line"></i>
                                '.$row["location"].'
                            </div>
                            <div class="card-row4">
                                <i class="ri-briefcase-line"></i>
                                '.$row["salary_min"].' - '.$row["salary_max"].'
                            </div>
                            <div class="card-row5">
                                <div class="job-type">
                                    <i class="ri-time-line"></i>
                                    '.$row["job_type"].' 
                                </div>
                                <div class="job-category">'.$row["job_level"].' Level</div>
                                <button><a href="job-description.php?job_id='.$row["job_id"].'">Job Details</a></button>
                            </div>
                        </div>';
            }
                }
            ?>
        </div>
    </div>

    <section class="steps about" id="steps-info">
        <div class="section-container steps-container">
            <h2 class="section-header">
                Get Hired in 4 <span>Quick Easy Steps</span>
            </h2>
            <p class="section-description">
                Follow these simple steps to land your dream job faster. We guide you from creating your profile to landing the perfect role.
            </p>
            <div class="steps-grid">
                <div class="steps-card">
                    <span><i class="ri-user-fill icon-1"></i></span>
                    <h4>Create an Account</h4>
                    <p>Sign up and create your professional profile with your skills, experience, and resume to get started on your job search journey.</p>
                </div>
                <div class="steps-card">
                    <span><i class="ri-briefcase-fill icon-2"></i></span>
                    <h4>Build Your Profile</h4>
                    <p>Add your qualifications, work experience, and portfolio to make your profile stand out to top recruiters.</p>
                </div>
                <div class="steps-card">
                    <span><i class="ri-search-eye-fill icon-3"></i></span>
                    <h4>Apply for Jobs</h4>
                    <p>Browse curated job listings that match your skills and interests, and submit applications with just a few clicks.</p>
                </div>
                <div class="steps-card">
                    <span><i class="ri-trophy-fill icon-4"></i></span>
                    <h4>Get Hired</h4>
                    <p>Connect with employers, attend interviews, and land your dream job quickly with our guided hiring process.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="explore ">
        <div class="section-container explore-container">
            <h2 class="section-header">
                <span>Explore a world </span>full of exciting carrer possibilities
            </h2>
            <p class="section-description">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. At accusamus est assumenda, totam in explicabo, facilis quos voluptas, quae iure nihil neque commodi molestiae. Repudiandae enim porro ex modi ipsum.
            </p>
            <div class="explore-grid">
                <div class="explore-card">
                    <span><i class="ri-pencil-ruler-2-line logo-1"></i></span>
                    <h4>Design</h4>
                    <p>200+ jobs openings</p>
                </div>
                <div class="explore-card">
                    <span><i class="ri-price-tag-2-line logo-2"></i></span>
                    <h4>Sales</h4>
                    <p>290+ jobs openings</p>
                </div>
                <div class="explore-card">
                    <span><i class="ri-advertisement-line logo-3"></i></span>
                    <h4>Markeing</h4>
                    <p>100+ jobs openings</p>
                </div>
                <div class="explore-card">
                    <span><i class="ri-macbook-line logo-4"></i></span>
                    <h4>IT and Software</h4>
                    <p>330+ jobs openings</p>
                </div>
                <div class="explore-card">
                    <span><i class="ri-hammer-line logo-5"></i></span>
                    <h4>Engineering</h4>
                    <p>300+ jobs openings</p>
                </div>
                <div class="explore-card">
                    <span><i class="ri-bank-line logo-6"></i></span>
                    <h4>Banking</h4>
                    <p>50+ jobs openings</p>
                </div>
                <div class="explore-card">
                    <span><i class="ri-hotel-line logo-7"></i></span>
                    <h4>Hotel and Tourism</h4>
                    <p>60+ jobs openings</p>
                </div>
                <div class="explore-card">
                    <span><i class="ri-book-fill logo-7"></i></span>
                    <h4>Education</h4>
                    <p>80+ jobs openings</p>
                </div>
            </div>
        </div>

    </section>

    <section class="info">
        <div class="info-container">
            <div class="image-container">
                <img src="assets/team.jpg" alt="Info">
            </div>
            <div class="description-container">
                <h2>Find Your Dream Job,<span> Build Your Future </span></h2>
                <p>Unlock new opportunities and take the next step in your career. Whether you’re a fresher exploring your first job or a professional seeking growth, we connect you with companies that value your skills, passion, and ambition. Join thousands of job seekers who found their perfect match through us.</p>
                <button>
                    <a href="#">Serach Job</a>
                </button>
                <a href="#">Learn more</a>
            </div>
        </div>
    </section>

    <?php include './includes/footer.php' ?>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const flashMessage = document.getElementById('flashMessage');
            if (flashMessage) {
                // small timeout ensures transition works smoothly
                setTimeout(() => {
                    flashMessage.classList.add('show');
                }, 25); // 50ms delay to let browser render initial hidden state

                // Hide after 3s
                setTimeout(() => {
                    flashMessage.classList.remove('show');
                    flashMessage.classList.add('hide');

                    // Remove from DOM after animation
                    setTimeout(() => {
                        if (flashMessage.parentNode) {
                            flashMessage.parentNode.removeChild(flashMessage);
                        }
                    }, 500); // match CSS transition duration
                }, 3000);
            }
        });
    </script>
</body>

</html>