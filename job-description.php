<!-- Job Description Page  -->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
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
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .similar-jobs {
            max-width: 1300px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 30px 40px;
        }

        .similar-jobs .all-jobs-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            /* 3 equal columns */
            gap: 20px;
            padding: 15px;
            align-items: start;
        }
    </style>
</head>

<body>
    <?php include './includes/header.php';
    include './config/db.php' ?>

    <?php
    if (isset($_GET["job_id"])) {

        $id = intval($_GET["job_id"]);
        $sql = "SELECT j.*, e.name AS company_name, e.logo AS company_logo
                FROM jobs j
                INNER JOIN employers e
                ON j.employer_id = e.id
                WHERE job_id = $id";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // calcualte days left to apply
            date_default_timezone_set('Asia/Kathmandu');

            $expiry_date = $row["expiry_date"];
            $today = new DateTime();
            $expiry = new DateTime($expiry_date);

            if ($expiry >= $today) {
                $diff = $today->diff($expiry);
                $days_left = $diff->days;
                $result = "<p>" . $expiry->format("d M Y") . " (" . $days_left . " days left)</p>";
            } else {
                $result = "<p>" . $expiry->format("d M Y") . " (Expired)</p>";
            }

            $alreadyApplied = false;
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
                $q = "SELECT * FROM applications WHERE user_id = $userId AND job_id = $id";
                $r = mysqli_query($conn, $q);
                if (mysqli_num_rows($r) > 0) {
                    $alreadyApplied = true;
                }
            }

            $bookmark_class = "ri-bookmark-line";

            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $bm_sql = "SELECT id FROM bookmarks WHERE user_id=? AND job_id=? LIMIT 1";
                $stmt_bm = $conn->prepare($bm_sql);
                $stmt_bm->bind_param("ii", $user_id, $id);
                $stmt_bm->execute();
                $bm_result = $stmt_bm->get_result();

                if ($bm_result->num_rows > 0) {
                    $bookmark_class = "ri-bookmark-fill";
                }
            }

            echo '<div class="description">
            <div class="description-header">
                <div class="back-button">
                    <a href="./jobs.php"><i class="ri-arrow-left-line"></i> Back</a>
                </div>
                
                <div class="description-card">
                    <div class="description-row1">
                        <img src="./employers-zone/uploads/' . $row["company_logo"] . '" alt="Comapany logo">
                        <div class="description-title">
                            <h2>' . $row["title"] . '</h2>
                            <p>' . $row["company_name"] . '</p>
                        </div>
                        <div class="bookmark">
                            <i class="' . $bookmark_class . '"></i>
                        </div>
                    </div>
                    <div class="description-row2">
                        <div class="jd-type">
                            <i class="ri-time-line"></i>
                            ' . $row["job_type"] . '
                        </div>
                        <div class="jd-salary">
                            <i class="ri-wallet-line"></i>
                            ' . $row["salary_min"] . ' - ' . $row["salary_max"] . '
                        </div>
                        <div class="jd-location">
                            <i class="ri-map-pin-line"></i>
                            ' . $row["location"] . '
                        </div>
                        <div class="jd-level">
                            <i class="ri-award-line"></i>
                            ' . $row["job_level"] . ' level
                        </div>
                        ' . ($alreadyApplied ? '<button class="btn btn-secondary" disabled>Applied</button>'
                : '<button id="applyBtn" data-jobid="' . $row["job_id"] . '" class="btn btn-primary">Apply Job</button>'
            ) . '

                    </div>
                </div>


            </div>
            <div class="main-description">
                <div class="job-details">
                    ' . $row["description"] . '
                </div>

                <div class="job-overview">
                    <h5>Job Overview</h5>
                    <div class="jd-title">
                        <div class="title-label">
                            <i class="ri-user-fill"></i> <b>Job Title</b>
                        </div>
                        <p>' . $row["title"] . '</p>
                        <div class="title-label">
                            <i class="ri-time-line"></i> <b>Job Type</b>
                        </div>
                        <p>' . $row["job_type"] . '</p>
                        <div class="title-label">
                            <i class="ri-award-line"></i> <b>Job Level</b>
                        </div>
                        <p>' . $row["job_level"] . ' level</p>
                        <div class="title-label">
                            <i class="ri-wallet-line"></i> <b>Offered Salary</b>
                        </div>
                        <p>' . $row["salary_min"] . ' - ' . $row["salary_max"] . '</p>
                        <div class="title-label">
                            <i class="ri-briefcase-line"></i> <b>Category</b>
                        </div>
                        <p>Education</p>
                        <div class="title-label">
                            <i class="ri-graduation-cap-line"></i> <b>Degree</b>
                        </div>
                        <p>' . $row["degree"] . '</p>
                        <div class="title-label">
                            <i class="ri-line-chart-line"></i> <b>Experience</b>
                        </div>
                        <p>' . $row["experience_min"] . ' - ' . $row["experience_max"] . ' Years</p>
                        <div class="title-label">
                            <i class="ri-time-line"></i> <b>Location</b>
                        </div>
                        <p>' . $row["location"] . '</p>
                        <div class="title-label">
                            <i class="ri-calendar-line"></i> <b>Expiry Date</b>
                        </div>
                        ' . $result . ' 
                    </div>

                </div>
            </div>
        </div>';
        } else {
            echo "<p class='text-center text-danger'>Job not found!</p>";
        }
    } else {
        echo "Error displaying";
    }


    // similar jobs
    ?>
    <div class="similar-jobs">
        <h4>Similar Jobs</h4>
        <div class="all-jobs-list">
            <?php
            // Similar jobs based on title, excluding current job
            $current_job_id = intval($_GET["job_id"]);


            $sql_similar = "SELECT j.*, e.name AS company_name, e.logo AS company_logo
                FROM jobs j
                INNER JOIN employers e
                ON j.employer_id = e.id
                WHERE j.job_id != $current_job_id 
                AND j.status='active' 
                ORDER BY j.posted_time DESC 
                LIMIT 3";

            $result_similar = mysqli_query($conn, $sql_similar);

            if (mysqli_num_rows($result_similar) > 0) {
                while ($sim = mysqli_fetch_assoc($result_similar)) {
                    date_default_timezone_set('Asia/Kathmandu');
                    $posted_time = $sim["posted_time"];
                    $current_time = new DateTime();
                    $posted = new DateTime($posted_time);
                    $diff = $current_time->diff($posted);

                    if ($diff->y > 0) $post_time = $diff->y . ' year ago';
                    elseif ($diff->m > 0) $post_time = $diff->m . ' month ago';
                    elseif ($diff->d > 0) $post_time = $diff->d . ' day ago';
                    elseif ($diff->h > 0) $post_time = $diff->h . ' hour ago';
                    elseif ($diff->i > 0) $post_time = $diff->i . ' minute ago';
                    else $post_time = "Just now";

                    echo '<div class="job-card">
                            <div class="card-row1">
                                <div class="post-time">' . $post_time . '</div>
                                <i class="ri-bookmark-line"></i>
                                </div>
                            <div class="card-row2">
                            <img src="./employers-zone/uploads/' . $sim["company_logo"] . '" alt="Comapany logo">
                            <div class="job-title">
                            <h2>' . $sim["title"] . '</h2>
                            <p>' . $sim["company_name"] . '</p>
                            </div>  
                            </div>
                            <div class="card-row3">
                            <i class="ri-map-pin-line"></i>' . $sim["location"] . '
                                    </div>
                                    <div class="card-row4">
                                    <i class="ri-briefcase-line"></i>' . $sim["salary_min"] . ' - ' . $sim["salary_max"] . '
                                    </div>
                                    <div class="card-row5">
                                    <div class="job-type"><i class="ri-time-line"></i>' . $sim["job_type"] . '</div>
                                    <div class="job-category">' . $sim["job_level"] . ' Level</div>
                                    <button><a href="job-description.php?job_id=' . $sim["job_id"] . '">Job Details</a></button>
                                    </div>
                                    </div>';
                }
            } else {
                echo '<p class="text-center text-secondary">No similar jobs found.</p>';
            }
            ?>
        </div>
    </div>

    <?php include './includes/footer.php' ?>
    <script>
        const applyBtn = document.getElementById('applyBtn');
        const applyMessage = document.getElementById('applyMessage');

        if (applyBtn) {
            applyBtn.addEventListener('click', function() {

                const jobId = this.dataset.jobid;
                applyBtn.disabled = true;
                applyBtn.textContent = "Applying...";

                fetch('apply-job.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'job_id=' + jobId
                    })
                    .then(res => res.text())
                    .then(data => {
                        data = data.trim().toLowerCase();
                        console.log("Server response:", data);

                        if (applyMessage) applyMessage.textContent = data;

                        if (data === "not_logged_in") {
                            window.location.href = "login.php"; // redirect if not logged in
                            return;
                        }

                        if (data.includes("successfully") || data.includes("already applied")) {
                            applyBtn.textContent = "Applied";
                            applyBtn.disabled = true;
                            applyBtn.classList.remove("btn-primary");
                            applyBtn.classList.add("btn-secondary");
                        } else {
                            applyBtn.textContent = "Apply Job";
                            applyBtn.disabled = false;
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        if (applyMessage) applyMessage.textContent = "Network error, try again.";
                        applyBtn.textContent = "Apply Job";
                        applyBtn.disabled = false;
                    });
            });
        }
    </script>

</body>

</html>