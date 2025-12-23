<?php
include __DIR__ . '/../../config/db.php';;

$action = $_GET['action'];
$id = $_GET['id'];

if ($action === "delete") {
    $sql = "DELETE FROM jobs WHERE job_id='$id'";
    mysqli_query($conn, $sql);
    header("Location: ../emp-dashboard.php?page=manage-jobs");
    exit();
}

if ($action === "toggle") {
    $status = $_GET['status'];
    $sql = "UPDATE jobs SET status='$status' WHERE job_id='$id'";
    mysqli_query($conn, $sql);
    header("Location: ../emp-dashboard.php?page=manage-jobs");
    exit();
}

if($action === "edit"){
    header("Location: emp-dashboard.php?page=dashboard");
    exit;
}

