<?php
include __DIR__ . '/../../config/db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$errors = [];
$success = "";

if (!isset($_SESSION['EMPLOYER_ID'])) {
    die("<p style='color:red; text-align:center'>You must be logged in to post a job.</p>");
}

$employer_id = $_SESSION['EMPLOYER_ID'];

$title = "";
$location = "";
$description = "";
$minExperience = "";
$maxExperience = "";
$degree = "";
$expiryDate = "";
$category = "";
$jobType = "";
$jobLevel = "";
$minSalary = "";
$maxSalary = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Collect form data safely
    $title = trim($_POST['title'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $minExperience = trim($_POST['experience_min'] ?? '');
    $maxExperience = trim($_POST['experience_max'] ?? '');
    $degree = trim($_POST['degree'] ?? '');
    $expiryDate = trim($_POST['expiry_date'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $jobType = trim($_POST['job_type'] ?? '');
    $jobLevel = trim($_POST['job_level'] ?? '');
    $minSalary = trim($_POST['salary_min'] ?? '');
    $maxSalary = trim($_POST['salary_max'] ?? '');

    if ($title === "") {
        $errors[] = "Job title is required.";
    }

    if ($location === "") {
        $errors[] = "Location is required.";
    }

    if ($category === "") {
        $errors[] = "Job category is required.";
    }

    if ($jobType === "") {
        $errors[] = "Job type is required.";
    }

    if ($jobLevel === "") {
        $errors[] = "Job level is required.";
    }

    if ($expiryDate === "") {
        $errors[] = "Expiry date is required.";
    }

    if (strip_tags($description) === "") {
        $errors[] = "Job description cannot be empty.";
    }

    // Validate numeric fields
    if ($minExperience !== "" && !is_numeric($minExperience)) {
        $errors[] = "Minimum experience must be a number.";
    }

    if ($maxExperience !== "" && !is_numeric($maxExperience)) {
        $errors[] = "Maximum experience must be a number.";
    }

    if ($minExperience !== "" && $maxExperience !== "" && $minExperience > $maxExperience) {
        $errors[] = "Minimum experience cannot be greater than maximum experience.";
    }

    if ($minSalary !== "" && !is_numeric($minSalary)) {
        $errors[] = "Minimum salary must be numeric.";
    }

    if ($maxSalary !== "" && !is_numeric($maxSalary)) {
        $errors[] = "Maximum salary must be numeric.";
    }

    if ($minSalary !== "" && $maxSalary !== "" && $minSalary > $maxSalary) {
        $errors[] = "Minimum salary cannot be greater than maximum salary.";
    }

    if ($expiryDate !== "" && strtotime($expiryDate) < strtotime(date("Y-m-d"))) {
        $errors[] = "Expiry date must be a future date.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO jobs 
            (title, description, location, salary_min, salary_max, experience_min, experience_max, expiry_date, degree, job_type, job_level, category, employer_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === false) {
            $errors[] = "Database prepare error: " . $conn->error;
        } else {
            $stmt->bind_param(
                "sssddddsssssi",
                $title,
                $description,
                $location,
                $minSalary,
                $maxSalary,
                $minExperience,
                $maxExperience,
                $expiryDate,
                $degree,
                $jobType,
                $jobLevel,
                $category,
                $employer_id
            );

            if ($stmt->execute()) {
                $success = "New Job Posted Successfully";

                // Reset form values
                $title = "";
                $location = "";
                $description = "";
                $minExperience = "";
                $maxExperience = "";
                $degree = "";
                $expiryDate = "";
                $category = "";
                $jobType = "";
                $jobLevel = "";
                $minSalary = "";
                $maxSalary = "";
            } else {
                $errors[] = "Database error: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal - Employee Dashboard</title>
    <!-- Remix Icon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/emp-dashboard.css">

    <!-- Quill CSS & JS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>



    <style>
        /* Styles for .form-container only (integrated from your previous CSS) */
        .form-container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .title-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .title h2 {
            margin: 0 0 0.5rem 0;
            font-size: 2rem;
            font-weight: 600;
            line-height: 1.2;
        }

        .title p {
            margin: 0;
            opacity: 0.9;
            font-size: 1rem;
        }

        .preview {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background-color: #dfdfdfff;
            border-radius: 25px;
            cursor: pointer;
            transition: background 0.3s ease;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .preview i {
            font-size: 1.2rem;
        }

        .form-container form {
            padding-top: 0.8rem;
            /* ↓ reduced from 2rem */
        }


        form {
            padding: 2rem;
        }

        label {
            display: block;
            margin-bottom: 0.3rem;
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            background: #fff;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.25);
        }

        input[type="text"]::placeholder {
            color: #999;
        }

        .form-container form .btn {
            display: block;
            text-align: center;
            color: white;
            width: 200px;
            padding: 1rem;
            font-size: 1.1rem;
            font-weight: 600;
            background-color: #667eea;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin: auto;
        }

        .form-container form .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        /* Quill Editor Styles */
        #toolbar {
            margin-bottom: 1rem;
            border: none;
            background: transparent;
        }

        #editor {
            min-height: 200px;
            margin-bottom: 1.5rem;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            transition: border-color 0.3s ease;
        }

        #editor:focus-within {
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.25);
        }

        .ql-container {
            font-size: 1rem;
            line-height: 1.6;
        }

        .ql-toolbar {
            border-top: none;
            border-left: none;
            border-right: none;
            border-radius: 8px 8px 0 0;
            background: #f8f9fa;
            padding: 0.75rem;
        }

        .ql-toolbar .ql-formats {
            margin-right: 0.5rem;
        }

        .ql-toolbar button {
            border: none;
            background: transparent;
            color: #666;
            transition: color 0.3s ease;
        }

        .ql-toolbar button:hover {
            color: #667eea;
        }

        .ql-toolbar button.ql-active {
            color: #667eea;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .form-container {
                margin: 1rem;
                padding: 0;
                border-radius: 0;
                box-shadow: none;
            }

            .title-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
                padding: 1.5rem;
            }

            .preview {
                align-self: flex-end;
            }

            form {
                padding: 1.5rem;
            }

            .title h2 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            form {
                padding: 1rem;
            }

            input[type="text"],
            input[type="date"],
            select {
                padding: 0.625rem 0.875rem;
                margin-bottom: 1.25rem;
            }

            #editor {
                min-height: 150px;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-container {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</head>

<body>
    <?php
    include __DIR__ . '/../../config/db.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }


    if (!isset($_SESSION['EMPLOYER_ID'])) {
        echo "<p style='color:red; text-align:center'>You must be logged in to post a job.</p>";
        exit;
    }

    $employer_id = $_SESSION['EMPLOYER_ID'];

    ?>

    <div class="form-container">

        <div class="title-card">
            <div class="title">
                <h2>Post a Job</h2>
                <p>Here you can post a new job by filling the details</p>
            </div>
            <div class="preview">
                <i class="ri-eye-line"></i>
                preview
            </div>
        </div>
        <?php if (!empty($errors)) : ?>
            <div style="color:red; text-align:center; margin-bottom:1rem;">
                <?php foreach ($errors as $error) : ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)) : ?>
            <div style="color:green; text-align:center; margin-bottom:1rem;">
                <p><?php echo htmlspecialchars($success); ?></p>
            </div>
        <?php endif; ?>

        <form action="" id="jobForm" method="POST">
            <label for="title">Job Title</label>
            <input type="text" id="title" name="title" placeholder="Enter job title" value="<?php echo htmlspecialchars($title ?? ''); ?>">

            <label for="location">Location</label>
            <input type="text" name="location" id="location" placeholder="Enter job location" value="<?php echo htmlspecialchars($location ?? ''); ?>">

            <!-- Description Section -->
            <label for="description">Job Description</label>
            <div id="toolbar">
                <span class="ql-formats">
                    <button class="ql-bold" title="Bold"></button>
                    <button class="ql-italic" title="Italic"></button>
                    <button class="ql-underline" title="Underline"></button>
                </span>
                <span class="ql-formats">
                    <select class="ql-size" title="Font Size">
                        <option value="small">Small</option>
                        <option value="" <?php if (empty($description)) echo 'selected'; ?>>Normal</option>
                        <option value="large">Large</option>
                        <option value="huge">Huge</option>
                    </select>
                </span>
                <span class="ql-formats">
                    <button class="ql-list" value="ordered" title="Ordered List"></button>
                    <button class="ql-list" value="bullet" title="Bullet List"></button>
                </span>
            </div>
            <div id="editor"><?php echo $description ?? ''; ?></div>
            <input type="hidden" name="description" id="description">

            <label for="min-experience">Minimum Experience</label>
            <input type="text" id="min-experience" name="experience_min" placeholder="Enter minimum experience (years)" value="<?php echo htmlspecialchars($minExperience ?? ''); ?>">

            <label for="max-experience">Maximum Experience</label>
            <input type="text" id="max-experience" name="experience_max" placeholder="Enter maximum experience (years)" value="<?php echo htmlspecialchars($maxExperience ?? ''); ?>">

            <label for="degree">Degree</label>
            <input type="text" name="degree" id="degree" placeholder="Enter required degree" value="<?php echo htmlspecialchars($degree ?? ''); ?>">

            <label for="expiry-date">Expiry Date</label>
            <input type="date" name="expiry_date" id="expiry-date" value="<?php echo htmlspecialchars($expiryDate ?? ''); ?>" >

            <label for="category">Job Category</label>
            <select id="category" name="category" >
                <option value="">-- Select Category --</option>
                <option value="it_software" <?php if (($category ?? '') === 'it_software') echo 'selected'; ?>>IT & Software</option>
                <option value="web_dev" <?php if (($category ?? '') === 'web_dev') echo 'selected'; ?>>Web Development</option>
                <option value="design" <?php if (($category ?? '') === 'design') echo 'selected'; ?>>Design & Creative</option>
                <option value="marketing" <?php if (($category ?? '') === 'marketing') echo 'selected'; ?>>Marketing & Sales</option>
                <option value="finance" <?php if (($category ?? '') === 'finance') echo 'selected'; ?>>Finance & Accounting</option>
                <option value="hr" <?php if (($category ?? '') === 'hr') echo 'selected'; ?>>Human Resources</option>
                <option value="education" <?php if (($category ?? '') === 'education') echo 'selected'; ?>>Education & Training</option>
                <option value="healthcare" <?php if (($category ?? '') === 'healthcare') echo 'selected'; ?>>Healthcare</option>
                <option value="engineering" <?php if (($category ?? '') === 'engineering') echo 'selected'; ?>>Engineering</option>
                <option value="customer_service" <?php if (($category ?? '') === 'customer_service') echo 'selected'; ?>>Customer Service</option>
                <option value="management" <?php if (($category ?? '') === 'management') echo 'selected'; ?>>Management</option>
                <option value="writing" <?php if (($category ?? '') === 'writing') echo 'selected'; ?>>Writing & Translation</option>
                <option value="data_entry" <?php if (($category ?? '') === 'data_entry') echo 'selected'; ?>>Data Entry</option>
                <option value="legal" <?php if (($category ?? '') === 'legal') echo 'selected'; ?>>Legal</option>
                <option value="others" <?php if (($category ?? '') === 'others') echo 'selected'; ?>>Others</option>
            </select>

            <label for="job-type">Job Type</label>
            <select name="job_type" id="job_type" >
                <option value="">-- Select job type --</option>
                <option value="Full time" <?php if (($jobType ?? '') === 'Full time') echo 'selected'; ?>>Full time</option>
                <option value="Part time" <?php if (($jobType ?? '') === 'Part time') echo 'selected'; ?>>Part time</option>
                <option value="Internship" <?php if (($jobType ?? '') === 'Internship') echo 'selected'; ?>>Internship</option>
                <option value="Remote" <?php if (($jobType ?? '') === 'Remote') echo 'selected'; ?>>Remote</option>
                <option value="Contract" <?php if (($jobType ?? '') === 'Contract') echo 'selected'; ?>>Contract</option>
            </select>

            <label for="job-level">Job Level</label>
            <select name="job_level" id="job_level" >
                <option value="">-- Select job level --</option>
                <option value="Entry" <?php if (($jobLevel ?? '') === 'Entry') echo 'selected'; ?>>Entry level</option>
                <option value="Junior" <?php if (($jobLevel ?? '') === 'Junior') echo 'selected'; ?>>Junior level</option>
                <option value="Mid" <?php if (($jobLevel ?? '') === 'Mid') echo 'selected'; ?>>Mid level</option>
                <option value="Senior" <?php if (($jobLevel ?? '') === 'Senior') echo 'selected'; ?>>Senior level</option>
            </select>

            <label for="min-salary">Minimum Salary</label>
            <input type="text" name="salary_min" id="min-salary" placeholder="Enter minimum salary" value="<?php echo htmlspecialchars($minSalary ?? ''); ?>">

            <label for="max-salary">Maximum Salary</label>
            <input type="text" name="salary_max" id="max-salary" placeholder="Enter maximum salary" value="<?php echo htmlspecialchars($maxSalary ?? ''); ?>">

            <button type="submit" class="btn btn-primary btn-lg">Post Job</button>
        </form>


    </div>
    <script>
        const form = document.getElementById('jobForm');
        const quill = new Quill('#editor', {
            modules: {
                toolbar: '#toolbar'
            },
            placeholder: "Enter job description here...",
            theme: "snow"
        });

        // Load existing description content if available
        <?php if (!empty($description)) : ?>
            quill.root.innerHTML = <?php echo json_encode($description); ?>;
        <?php endif; ?>

        form.addEventListener('submit', function(e) {
            document.getElementById('description').value = quill.root.innerHTML;
        });
    </script>
</body>

</html>