<?php
session_start();
include __DIR__ . '/../../config/db.php';

$employer_id = isset($_SESSION['EMPLOYER_ID']) ? (int)$_SESSION['EMPLOYER_ID'] : 0;

if ($employer_id == 0) {
    echo '<tr><td colspan="7" style="color:red; text-align:center">You must be logged in to view your jobs</td></tr>';
    exit;
}

$title = isset($_GET['title']) ? mysqli_real_escape_string($conn, $_GET['title']) : '';
$status = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';

$sql = "SELECT j.job_id, j.title, j.location, j.posted_time, j.status,
               COUNT(a.id) AS application_count
        FROM jobs j
        LEFT JOIN applications a ON j.job_id = a.job_id
        WHERE j.employer_id = $employer_id";

if ($title != '') {
    $title_safe = mysqli_real_escape_string($conn, $title);
    $sql .= " AND j.title LIKE '%$title_safe%'";
}

if ($status != '') {
    $status_safe = mysqli_real_escape_string($conn, $status);
    $sql .= " AND j.status='$status_safe'";
}

$sql .= " GROUP BY j.job_id";

$sql .= " ORDER BY j.posted_time DESC";


$result = mysqli_query($conn, $sql);

$output = '';
if (mysqli_num_rows($result) > 0) {
    $index = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $statusClass = ($row["status"] == "active") ? "active" : "inactive";
        $toggleStatus = ($row["status"] == "active") ? "inactive" : "active";
        $toggleIcon = ($row["status"] == "active")
            ? '<i class="ri-toggle-fill" style="color: green;" title="Active"></i>'
            : '<i class="ri-toggle-line" style="color: gray;" title="Inactive"></i>';

        $output .= '
            <tr data-job-id="' . $row["job_id"] . '">
                <td>' . $index . '</td>
                <td>' . $row["title"] . '</td>
                <td>' . $row["location"] . '</td>
                <td>' . $row["posted_time"] . '</td>
                <td><span class="status ' . $statusClass . '">' . ucfirst($row["status"]) . '</span></td>
                <td>'.$row["application_count"].'</td>
                <td class="actions">
                    <a href="./actions/job-action.php?action=toggle&id=' . $row["job_id"] . '&status=' . $toggleStatus . '">' . $toggleIcon . '</a>
                    <a href="#" onclick="openEdit(' . $row["job_id"] . ')">
                        <i class="ri-edit-2-fill" title="Edit"></i>
                    </a>

                    <a href="./actions/job-action.php?action=delete&id=' . $row["job_id"] . '" onclick="return confirm(\'Are you sure you want to delete this job?\');">
                        <i class="ri-delete-bin-line" title="Delete"></i>
                    </a>
                </td>
            </tr>
        ';

        $index++;
    }
} else {
    $output = '<tr><td colspan="7" style="color:red; text-align: center">No jobs found</td></tr>';
}

echo $output;
mysqli_close($conn);
