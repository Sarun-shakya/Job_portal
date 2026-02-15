<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'header.php'; 
$message = '';
$message_type = '';
$index = 1;

// Handle job deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $job_id = $_POST['job_id'] ?? 0;
    
    if ($action === 'delete' && $job_id) {
        $sql = $conn->prepare("DELETE FROM jobs WHERE job_id = ?");
        if ($sql->execute([$job_id])) {
            $message = 'Job deleted successfully';
            $message_type = 'success';
        }
    } elseif ($action === 'toggle_status' && $job_id) {
        $sql = $conn->prepare("UPDATE jobs SET status = IF(status = 'active', 'inactive', 'active') WHERE job_id = ?");
        if ($sql->execute([$job_id])) {
            $message = 'Job status updated successfully';
            $message_type = 'success';
        }
    }
}

// Fetch all jobs with employer information
$sql = $conn->query("SELECT j.*, e.name as employer_name, e.email as employer_email,
                     (SELECT COUNT(*) FROM applications WHERE job_id = j.job_id) as application_count
                     FROM jobs j 
                     LEFT JOIN employers e ON j.employer_id = e.id 
                     ORDER BY j.posted_time DESC");
$jobs = [];
while ($row = $sql->fetch_assoc()) {
    $jobs[] = $row;
}
?>

<div class="page-content">
    <div class="page-header">
        <h1>Job Management</h1>
        <p style="padding-bottom: 5px ">Manage all job postings on the platform</p>
    </div>
    
    <?php if ($message): ?>
        <div class="alert alert-<?= $message_type ?>"><?= $message ?></div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-header">
            <h2>All Jobs </h2>
        </div>
        <div class="card-body">
            <!-- Filter Controls -->
            <div class="filter-container">
                <div class="filter-group">
                    <label for="searchInput">Search Jobs</label>
                    <input type="text" id="searchInput" placeholder="Search by Job title">
                </div>
                <div class="filter-group">
                    <label for="statusFilter">Filter by Status</label>
                    <select id="statusFilter">
                        <option value="all">All Employers</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="data-table" id="jobsTable">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Job Title</th>
                            <th>Employer</th>
                            <th>Location</th>
                            <th>Job Type</th>
                            <th>Level</th>
                            <th>Applications</th>
                            <th>Status</th>
                            <th>Posted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobs as $job): ?>
                        <tr data-status="<?= $job['status'] ?>">
                            <td><?= $index ?></td>
                            <td><?= $job['title'] ?></td>
                            <td><?= $job['employer_name'] ?></td>
                            <td><?= $job['location'] ?></td>
                            <td><?= $job['job_type'] ?></td>
                            <td><?= $job['job_level'] ?></td>
                            <td><?= $job['application_count'] ?></td>
                            <td>
                                <?php if ($job['status'] === 'active'): ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('M d, Y', strtotime($job['posted_time'])) ?></td>
                            <td class="actions">
                                <form method="POST" style="display:inline;" onsubmit="return confirmToggle()">
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="job_id" value="<?= $job['job_id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-info">
                                        <?= $job['status'] === 'active' ? 'Deactivate' : 'Activate' ?>
                                    </button>
                                </form>
                                
                                <a href="job_details.php?id=<?= $job['job_id'] ?>" class="btn btn-sm btn-primary">View</a>
                                
                                <form method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="job_id" value="<?= $job['job_id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php $index++ ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
const searchInput = document.getElementById('searchInput');
const statusFilter = document.getElementById('statusFilter');
const tableRows = document.querySelectorAll('#jobsTable tbody tr');

// Function to filter table
function filterTable() {
    const searchTerm = searchInput.value.toLowerCase();
    const statusValue = statusFilter.value;
    
    tableRows.forEach(row => {
        const name = row.cells[1].textContent.toLowerCase();
        const status = row.getAttribute('data-status');

        const matchesSearch = name.includes(searchTerm);

        const matchesStatus = statusValue === 'all' || status === statusValue;

        if (matchesSearch && matchesStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Add event listeners
searchInput.addEventListener('keyup', filterTable);
statusFilter.addEventListener('change', filterTable);
</script>
<?php include 'footer.php'?>