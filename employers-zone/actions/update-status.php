<?php
session_start();
include __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['EMPLOYER_ID'])) {
    echo "Unauthorized. Please log in.";
    exit;
}

$employer_id = intval($_SESSION['EMPLOYER_ID']);

$app_id = isset($_POST['app_id']) ? intval($_POST['app_id']) : 0;
$status = isset($_POST['status']) ? trim($_POST['status']) : '';

if ($app_id <= 0 || empty($status)) {
    echo "Invalid input.";
    exit;
}

$validStatuses = ['applied','reviewed','shortlisted','rejected','selected'];
if (!in_array(strtolower($status), $validStatuses)) {
    echo "Invalid status value.";
    exit;
}

$sql = "UPDATE applications a
        JOIN jobs j ON a.job_id = j.job_id
        SET a.status = ?
        WHERE a.id = ? AND j.employer_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'sii', $status, $app_id, $employer_id);
$result = mysqli_stmt_execute($stmt);

if ($result && mysqli_stmt_affected_rows($stmt) > 0) {
    echo "Status updated successfully to '$status'.";
} else {
    echo "Failed to update status. Maybe you do not have permission.";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
