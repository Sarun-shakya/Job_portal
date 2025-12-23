<?php
session_start();
include './config/db.php';

header("Content-Type: text/plain");

if (!isset($_SESSION["user_id"])) {
    echo "not_logged_in";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    echo "Invalid request";
    exit;
}

$job_id = intval($_POST['job_id']);
$user_id = intval($_SESSION['user_id']);

if (!$job_id) {
    echo "Invalid job ID";
    exit;
}

// Check if already applied 
$check_sql = "SELECT * FROM applications WHERE job_id=$job_id AND user_id=$user_id";
$check = mysqli_query($conn, $check_sql);

if (!$check) {
    echo "Database error: " . mysqli_error($conn);
    exit;
}

if (mysqli_num_rows($check) > 0) {
    echo "Already applied";
    exit;
}

// Insert application
$insert_sql = "INSERT INTO applications (job_id, user_id) VALUES ($job_id, $user_id)";
$insert = mysqli_query($conn, $insert_sql);

if ($insert) {
    echo "Applied successfully";
} else {
    echo "Error submitting application: " . mysqli_error($conn);
}
?>
