<?php
session_start();
include __DIR__ . '/../../config/db.php';

$id = (int)$_GET["id"];

$sql = "SELECT * FROM jobs WHERE job_id=$id";
$r = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($r);

// returning |-| separated values (NOT JSON)
echo $row["job_id"] . "|-|" .
     $row["title"] . "|-|" .
     $row['description'] . "|-|" .
     $row["location"] . "|-|" .
     $row["salary_min"] . "|-|" .
     $row["salary_max"] . "|-|" .
     $row["experience_min"] . "|-|" .
     $row["experience_max"] . "|-|" .
     $row["expiry_date"] . "|-|" .
     $row["degree"] . "|-|" .
     $row["job_type"] . "|-|" .
     $row["job_level"] . "|-|" .
     $row["category"];

?>
