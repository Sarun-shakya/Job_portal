<?php
include "../../config/db.php";

$errors = [];
$success = "";

// Get Job ID
$jobId = (int)($_POST["job_id"] ?? 0);

if ($jobId <= 0) {
    die("<p style='color:red;text-align:center'>Invalid Job ID.</p>");
}

// Fetch existing job to check if it exists
$stmt = $conn->prepare("SELECT * FROM jobs WHERE job_id = ?");
$stmt->bind_param("i", $jobId);
$stmt->execute();
$job = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$job) {
    die("<p style='color:red;text-align:center'>Job not found.</p>");
}

// Only process POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get POST values
    $title          = trim($_POST['title'] ?? "");
    $location       = trim($_POST['location'] ?? "");
    $description    = trim($_POST['description'] ?? "");
    $degree         = trim($_POST['degree'] ?? "");
    $expiryDate     = trim($_POST['expiry_date'] ?? "");
    $category       = trim($_POST['category'] ?? "");
    $jobType        = trim($_POST['job_type'] ?? "");
    $jobLevel       = trim($_POST['job_level'] ?? "");

    $minSalary      = trim($_POST['salary_min'] ?? "");
    $maxSalary      = trim($_POST['salary_max'] ?? "");
    $minExperience  = trim($_POST['experience_min'] ?? "");
    $maxExperience  = trim($_POST['experience_max'] ?? "");

    // ----------------- VALIDATION -----------------
    if ($title === "") {
        $errors[] = "Job title is required.";
    }

    if ($location === "") {
        $errors[] = "Location is required.";
    }

    if (strip_tags($description) === "") {
        $errors[] = "Job description cannot be empty.";
    }

    if ($expiryDate === "") {
        $errors[] = "Expiry date is required.";
    } elseif (strtotime($expiryDate) < strtotime(date("Y-m-d"))) {
        $errors[] = "Expiry date must be in the future.";
    }

    if ($minExperience !== "" && !is_numeric($minExperience)) {
        $errors[] = "Minimum experience must be numeric.";
    }

    if ($maxExperience !== "" && !is_numeric($maxExperience)) {
        $errors[] = "Maximum experience must be numeric.";
    }

    if ($minExperience !== "" && $maxExperience !== "" && $minExperience > $maxExperience) {
        $errors[] = "Minimum experience cannot exceed maximum experience.";
    }

    if ($minSalary !== "" && !is_numeric($minSalary)) {
        $errors[] = "Minimum salary must be numeric.";
    }

    if ($maxSalary !== "" && !is_numeric($maxSalary)) {
        $errors[] = "Maximum salary must be numeric.";
    }

    if ($minSalary !== "" && $maxSalary !== "" && $minSalary > $maxSalary) {
        $errors[] = "Minimum salary cannot exceed maximum salary.";
    }

    // ----------------- UPDATE JOB -----------------
    if (empty($errors)) {
        // Prepare null values
        $minSalaryVal     = ($minSalary === "") ? null : $minSalary;
        $maxSalaryVal     = ($maxSalary === "") ? null : $maxSalary;
        $minExpVal        = ($minExperience === "") ? null : $minExperience;
        $maxExpVal        = ($maxExperience === "") ? null : $maxExperience;

        $stmt = $conn->prepare(
            "UPDATE jobs SET
                title = ?,
                description = ?,
                location = ?,
                salary_min = ?,
                salary_max = ?,
                experience_min = ?,
                experience_max = ?,
                expiry_date = ?,
                degree = ?,
                job_type = ?,
                job_level = ?,
                category = ?
             WHERE job_id = ?"
        );

        $stmt->bind_param(
            "sssddddsssssi",
            $title,
            $description,
            $location,
            $minSalaryVal,
            $maxSalaryVal,
            $minExpVal,
            $maxExpVal,
            $expiryDate,
            $degree,
            $jobType,
            $jobLevel,
            $category,
            $jobId
        );

        if ($stmt->execute()) {
            $success = "Job updated successfully.";
            header("Location: ../emp-dashboard.php?page=manage-jobs");
            // Refresh job data
            $stmt->close();
            $stmt = $conn->prepare("SELECT * FROM jobs WHERE job_id = ?");
            $stmt->bind_param("i", $jobId);
            $stmt->execute();
            $job = $stmt->get_result()->fetch_assoc();
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }

        $stmt->close();
    }
}

if (!empty($errors)) {
    foreach($errors as $error){
        echo "<p style='color:red;'>$error</p>";
    }
} elseif ($success) {
    echo "<p style='color:green;'>$success</p>";
} else {
    echo "<p style='color:red;'>Unknown error occurred.</p>";
}
exit;

?>
