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
    <title>Job Portal System</title>

    <!-- links -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/style.css">

    <style>

    </style>
</head>

<body>
    <?php include './includes/header.php';
    include './config/db.php' ?>
    <div class="jobs-search">
        <h3>Find Your Dream Job</h3>
        <p>Find amazing opportunities and kickstart your dream career today! Filter by category, location, experience, or job type and discover jobs that match your skills and ambitions. </p>

        <form action="">
            <input type="text" id="search" placeholder="Job Title or Comapany">
            <input type="text" id="location" placeholder="Location">
            <button class="btn btn-primary">Search</button>
        </form>
    </div>

    <div class="display-jobs">
        <div class="filter-jobs">
            <h4>Category</h4>
            <label><input data-type="category" type="checkbox" value="Computer Science"> Computer Science</label>
            <label><input data-type="category" type="checkbox" value="Educaion"> Education</label>
            <label><input data-type="category" type="checkbox" value="Hotels and Tourism"> Hotels and Tourism</label>
            <label><input data-type="category" type="checkbox" value="Financial Services"> Financial Services</label>
            <label><input data-type="category" type="checkbox" value="Engineering"> Engineering</label>
            <!-- 'Entry','Junior', 'Mid', 'Senior' -->

            <h4>Experience Level</h4>
            <label><input data-type="experience" type="checkbox" value="Fresher"> Fresher</label>
            <label><input data-type="experience" type="checkbox" value="Entry"> Entry-Level</label>
            <label><input data-type="experience" type="checkbox" value="Mid"> Mid-Level</label>
            <label><input data-type="experience" type="checkbox" value="Senior"> Senior</label>
            <label><input data-type="experience" type="checkbox" value="Manager"> Manager</label>

            <h4>Job Type</h4>
            <label><input data-type="job_type" type="checkbox" value="Full Time"> Full Time</label>
            <label><input data-type="job_type" type="checkbox" value="Part Time"> Part Time</label>
            <label><input data-type="job_type" type="checkbox" value="Freelance"> Freelance</label>
            <label><input data-type="job_type" type="checkbox" value="Internship"> Internship</label>
            <label><input data-type="job_type" type="checkbox" value="Temporary"> Temporary</label>

            <h4>Date Posted</h4>
            <label><input data-type="date" type="checkbox" value="all"> All</label>
            <label><input data-type="date" type="checkbox" value="Last Hour"> Last Hour</label>
            <label><input data-type="date" type="checkbox" value="Last 24 Hours"> Last 24 Hours</label>
            <label><input data-type="date" type="checkbox" value="Last 7 days"> Last 7 days</label>
            <label><input data-type="date" type="checkbox" value="Last 30 days"> Last 30 days</label>

        </div>
        <div class="all-jobs-list">
            <!-- all jobs fetched here -->
        </div>
    </div>
    <?php include './includes/footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener("click", function(e) {
            const icon = e.target.closest(".bookmark-icon");
            if (!icon) return;

            icon.classList.toggle("ri-bookmark-line");
            icon.classList.toggle("ri-bookmark-fill");
        });

        function loadJobs(locationSearch = false) {
            let search = $("#search").val();
            let location = locationSearch ? $("#location").val() : '';

            let category = [];
            $("input[type=checkbox][data-type='category']:checked").each(function() {
                category.push($(this).val());
            });

            let experience = [];
            $("input[type=checkbox][data-type='experience']:checked").each(function() {
                experience.push($(this).val());
            });

            let job_type = [];
            $("input[type=checkbox][data-type='job_type']:checked").each(function() {
                job_type.push($(this).val());
            });

            let date_posted = [];
            $("input[type=checkbox][data-type='date']:checked").each(function() {
                date_posted.push($(this).val());
            });

            $.ajax({
                url: "fetch-jobs.php",
                type: "POST",
                data: {
                    search: search,
                    location: location,
                    category: category,
                    experience: experience,
                    job_type: job_type,
                    date_posted: date_posted
                },
                success: function(data) {
                    $(".all-jobs-list").html(data);
                }
            });
        }

        $(document).ready(function() {
            loadJobs();

            // Live search and filters
            $("#search").keyup(loadJobs);
            $("input[type=checkbox]").change(loadJobs);
            $("form").submit(function(e) {
                e.preventDefault();
                loadJobs(true);
            });
        });

        //bookmajrk job
        $(document).ready(function() {
            // Bookmark toggle
            $(document).on('click', '.bookmark-icon', function() {
                var icon = $(this);
                var job_id = icon.data('job-id');

                $.post('fetch-jobs.php', {
                    bookmark_job_id: job_id
                }, function(response) {
                    if (response == 'added') {
                        icon.removeClass('ri-bookmark-line').addClass('ri-bookmark-fill');
                    } else if (response == 'removed') {
                        icon.removeClass('ri-bookmark-fill').addClass('ri-bookmark-line');
                    } else if (response == 'redirect') {
                        // Redirect not logged in user to login page
                        window.location.href = 'login.php';
                    }
                });
            });
        });
    </script>



</body>

</html>