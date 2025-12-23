<?php
session_start();
include __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['EMPLOYER_ID'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$employer_id = $_SESSION['EMPLOYER_ID'];

$title = isset($_GET['title']) ? mysqli_real_escape_string($conn, $_GET['title']) : '';
$status = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';

$sql = "SELECT a.id AS application_id, u.full_name AS applicant_name, u.resume, j.title AS job_title, j.location, a.status
        FROM applications a
        JOIN users u ON a.user_id = u.id
        JOIN jobs j ON a.job_id = j.job_id
        WHERE j.employer_id = $employer_id";

if ($title != '') {
    $sql .= " AND j.title LIKE '%$title%'";
}

if ($status != '') {
    $sql .= " AND a.status='$status'";
}

$sql .= " ORDER BY a.applied_at DESC";

$result = mysqli_query($conn, $sql);

$output = '';

if ($result && mysqli_num_rows($result) > 0) {
    $sn = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $resumeLink = $row['resume'] 
    ? "<a href='./download-resume.php?file={$row['resume']}'><i class='ri-download-2-line'></i> Resume</a>" 
    : 'N/A';

        $statusClass = strtolower($row['status']);
        $output .= "
        <tr>
            <td>{$sn}</td>
            <td>{$row['applicant_name']}</td>
            <td>{$row['job_title']}</td>
            <td>{$row['location']}</td>
            <td>{$resumeLink}</td>
            <td><span class='status {$statusClass}'>" . ucfirst($row['status']) . "</span></td>
            <td class='detail'>
                <span class='view-btn' onclick='viewProfile({$row['application_id']})'>
                    <i class='ri-eye-line'></i> View
                </span>
            </td>

        </tr>
        ";
        $sn++;
    }
} else {
    $output = "<tr><td colspan='7' style='text-align:center;color:red;'>No applications found.</td></tr>";
}

echo $output;
mysqli_close($conn);
