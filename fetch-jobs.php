<?php
session_start();
include './config/db.php';

/* ---------- HANDLE BOOKMARK AJAX ---------- */
if(isset($_POST['bookmark_job_id'])) {
    if(!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $job_id = $_POST['bookmark_job_id'];

    // Check if bookmark exists
    $check_sql = "SELECT id FROM bookmarks WHERE user_id=? AND job_id=?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $user_id, $job_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        // Remove bookmark
        $del_sql = "DELETE FROM bookmarks WHERE user_id=? AND job_id=?";
        $stmt_del = $conn->prepare($del_sql);
        $stmt_del->bind_param("ii", $user_id, $job_id);
        $stmt_del->execute();
        echo 'removed';
    } else {
        // Add bookmark
        $ins_sql = "INSERT INTO bookmarks (user_id, job_id) VALUES (?, ?)";
        $stmt_ins = $conn->prepare($ins_sql);
        $stmt_ins->bind_param("ii", $user_id, $job_id);
        $stmt_ins->execute();
        echo 'added';
    }
    exit;
}

/* ---------- COLLECT FILTER VALUES ---------- */
$search = $_POST['search'] ?? '';
$location = $_POST['location'] ?? '';
$category = $_POST['category'] ?? [];
$experience = $_POST['experience'] ?? [];
$job_type = $_POST['job_type'] ?? [];
$date_posted = $_POST['date_posted'] ?? [];

/* ---------- BASE QUERY ---------- */
$sql = "SELECT j.*, e.name AS company_name, e.logo AS company_logo
        FROM jobs j
        INNER JOIN employers e ON j.employer_id = e.id
        WHERE j.status='active'
        ";
        // AND (j.expiry_date IS NULL OR j.expiry_date >= CURDATE())

/* ---------- APPLY FILTERS ---------- */
if (!empty($search)) {
    $s = mysqli_real_escape_string($conn, $search);
    $sql .= " AND j.title LIKE '%$s%'";
}

if (!empty($location)) {
    $l = mysqli_real_escape_string($conn, $location);
    $sql .= " AND j.location LIKE '%$l%'";
}

if (!empty($category)) {
    $catList = "'" . implode("','", $category) . "'";
    $sql .= " AND j.category IN ($catList)";
}

if (!empty($experience)) {
    $expList = "'" . implode("','", $experience) . "'";
    $sql .= " AND j.job_level IN ($expList)";
}

if (!empty($job_type)) {
    $jobTypeList = "'" . implode("','", $job_type) . "'";
    $sql .= " AND j.job_type IN ($jobTypeList)";
}

if (!empty($date_posted)) {
    $dateConditions = [];
    if (in_array("Last Hour", $date_posted)) $dateConditions[] = "posted_time >= NOW() - INTERVAL 1 HOUR";
    if (in_array("Last 24 Hours", $date_posted)) $dateConditions[] = "posted_time >= NOW() - INTERVAL 1 DAY";
    if (in_array("Last 7 days", $date_posted)) $dateConditions[] = "posted_time >= NOW() - INTERVAL 7 DAY";
    if (in_array("Last 30 days", $date_posted)) $dateConditions[] = "posted_time >= NOW() - INTERVAL 30 DAY";

    if (!empty($dateConditions)) {
        $sql .= " AND (" . implode(" OR ", $dateConditions) . ")";
    }
}

$sql .= " ORDER BY posted_time DESC";

/* ---------- EXECUTE QUERY ---------- */
if(empty($sql)){
    die("SQL query is empty!");
}

$result = mysqli_query($conn, $sql);

/* ---------- FETCH USER BOOKMARKS ---------- */
$user_bookmarks = [];
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $bm_sql = "SELECT job_id FROM bookmarks WHERE user_id=?";
    $stmt = $conn->prepare($bm_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $bm_result = $stmt->get_result();
    while($row = $bm_result->fetch_assoc()){
        $user_bookmarks[] = $row['job_id'];
    }
}

/* ---------- BUILD JOB CARDS HTML ---------- */
$output = '';

if(mysqli_num_rows($result) > 0){
    date_default_timezone_set('Asia/Kathmandu');
    while($row = mysqli_fetch_assoc($result)){
        // Calculate posted time
        $posted = new DateTime($row["posted_time"]);
        $current = new DateTime();
        $diff = $current->diff($posted);

        if($diff->y > 0) $post_time = $diff->y . ' year ago';
        elseif($diff->m > 0) $post_time = $diff->m . ' month ago';
        elseif($diff->d > 0) $post_time = $diff->d . ' day ago';
        elseif($diff->h > 0) $post_time = $diff->h . ' hour ago';
        elseif($diff->i > 0) $post_time = $diff->i . ' minute ago';
        else $post_time = "Just now";

        // Bookmark icon
        $bookmark_icon = 'ri-bookmark-line';
        if(in_array($row['job_id'], $user_bookmarks)){
            $bookmark_icon = 'ri-bookmark-fill';
        }

        // Job card HTML
        $output .= '
        <div class="job-card">
            <div class="card-row1">
                <div class="post-time">' . $post_time . '</div>
                <i class="' . $bookmark_icon . ' bookmark-icon" data-job-id="' . $row["job_id"] . '" style="cursor:pointer;"></i>
            </div>
            <div class="card-row2">
                <img src="./employers-zone/uploads/' . $row["company_logo"] . '" alt="Company Logo">
                <div class="job-title">
                    <h2>' . $row["title"] . '</h2>
                    <p>' . $row["company_name"] . '</p>
                </div>
            </div>
            <div class="card-row3">
                <i class="ri-map-pin-line"></i> ' . $row["location"] . '
            </div>
            <div class="card-row4">
                <i class="ri-briefcase-line"></i> ' . $row["salary_min"] . ' - ' . $row["salary_max"] . '
            </div>
            <div class="card-row5">
                <div class="job-type"><i class="ri-time-line"></i> ' . $row["job_type"] . '</div>
                <div class="job-category">' . $row["job_level"] . ' Level</div>
                <button><a href="job-description.php?job_id=' . $row["job_id"] . '">Job Details</a></button>
            </div>
        </div>';
    }
} else {
    $output = "<h3 style='text-align:center;'>No jobs found.</h3>";
}

echo $output;
?>
