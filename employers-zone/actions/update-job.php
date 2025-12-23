<?php
include "../../config/db.php";

$id = (int)$_POST["job_id"];
echo $id;

$title       = mysqli_real_escape_string($conn, $_POST["title"]);
$description = mysqli_real_escape_string($conn, $_POST["description"]);
$location    = mysqli_real_escape_string($conn, $_POST["location"]);
$salary_min  = mysqli_real_escape_string($conn, $_POST["salary_min"]);
$salary_max  = mysqli_real_escape_string($conn, $_POST["salary_max"]);
$exp_min     = mysqli_real_escape_string($conn, $_POST["experience_min"]);
$exp_max     = mysqli_real_escape_string($conn, $_POST["experience_max"]);
$expiry      = mysqli_real_escape_string($conn, $_POST["expiry_date"]);
$degree      = mysqli_real_escape_string($conn, $_POST["degree"]);
$job_type    = mysqli_real_escape_string($conn, $_POST["job_type"]);
$job_level   = mysqli_real_escape_string($conn, $_POST["job_level"]);
$category    = mysqli_real_escape_string($conn, $_POST["category"]);

$sql = "UPDATE jobs SET 
            title='$title',
            description='$description',
            location='$location',
            salary_min='$salary_min',
            salary_max='$salary_max',
            experience_min='$exp_min',
            experience_max='$exp_max',
            expiry_date='$expiry',
            degree='$degree',
            job_type='$job_type',
            job_level='$job_level',
            category='$category'
        WHERE job_id=$id";

if(mysqli_query($conn, $sql)){
    if(mysqli_affected_rows($conn) > 0){
        header("Location: ../emp-dashboard.php?page=manage-jobs");
    } else {
        echo "No rows updated. Check if job_id exists and values are different.";
    }
} else {
    echo "SQL ERROR: ".mysqli_error($conn);
}

?>
