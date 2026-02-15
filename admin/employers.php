<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'header.php';

$message = '';
$message_type = '';
$index = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $employer_id = $_POST['employer_id'] ?? 0;
    
    if ($action === 'block' && $employer_id) {
        // Block employer - set status to 'blocked'
        $sql = $conn->prepare("UPDATE employers SET status = 'blocked' WHERE id = ?");
        if ($sql->execute([$employer_id])) {
            $message = 'Employer blocked successfully';
            $message_type = 'success';
        }
    } elseif ($action === 'unblock' && $employer_id) {
        // Unblock employer - set status to 'active'
        $sql = $conn->prepare("UPDATE employers SET status = 'active' WHERE id = ?");
        if ($sql->execute([$employer_id])) {
            $message = 'Employer unblocked successfully';
            $message_type = 'success';
        }
    } elseif ($action === 'delete' && $employer_id) {
        // Delete employer - permanently removes employer and cascades to jobs
        // CASCADE delete will remove all jobs and applications automatically
        $sql = $conn->prepare("DELETE FROM employers WHERE id = ?");
        if ($sql->execute([$employer_id])) {
            $message = 'Employer deleted successfully';
            $message_type = 'success';
        }
    }
}

// Fetch all employers with job count
$sql = $conn->query("SELECT e.*, COUNT(j.job_id) as job_count 
                     FROM employers e 
                     LEFT JOIN jobs j ON e.id = j.employer_id 
                     GROUP BY e.id 
                     ORDER BY e.created_at DESC");
$employers = [];
while($row = $sql->fetch_assoc()){
    $employers[] = $row;
}
?>

<div class="page-content">
    <div class="page-header">
        <h1>Employer Management</h1>
        <p style="padding-bottom: 5px ">Manage all registered employers and companies</p>
    </div>
    
    <?php if ($message): ?>
        <div class="alert alert-<?= $message_type ?>"><?= $message ?></div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-header">
            <h2>All Employers </h2>
        </div>
        <div class="card-body">
            <!-- Filter Controls -->
            <div class="filter-container">
                <div class="filter-group">
                    <label for="searchInput">Search Employers</label>
                    <input type="text" id="searchInput" placeholder="Search by Company name">
                </div>
                <div class="filter-group">
                    <label for="statusFilter">Filter by Status</label>
                    <select id="statusFilter">
                        <option value="all">All Employers</option>
                        <option value="active">Active</option>
                        <option value="blocked">Blocked</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table" id="employersTable">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Company Name</th>
                            <th>Contact Person</th>
                            <th>Email</th>
                            <th>Location</th>
                            <th>Jobs Posted</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employers as $employer): ?>
                        <tr data-status="<?= $employer['status'] ?>">
                            <td><?= $index ?></td>
                            <td><?= $employer['name'] ?></td>
                            <td><?= $employer['full_name'] ?></td>
                            <td><?= $employer['email'] ?></td>
                            <td><?= $employer['location'] ?></td>
                            <td><?= $employer['job_count'] ?></td>
                            <td>
                                <?php if ($employer['status'] === 'active'): ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Blocked</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('M d, Y', strtotime($employer['created_at'])) ?></td>
                            <td class="actions">
                                <?php if ($employer['status'] === 'active'): ?>
                                    <form method="POST" style="display:inline;" onsubmit="return confirmBlock()">
                                        <input type="hidden" name="action" value="block">
                                        <input type="hidden" name="employer_id" value="<?= $employer['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-warning">Block</button>
                                    </form>
                                <?php else: ?>
                                    <form method="POST" style="display:inline;" onsubmit="return confirmUnblock()">
                                        <input type="hidden" name="action" value="unblock">
                                        <input type="hidden" name="employer_id" value="<?= $employer['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-success">Unblock</button>
                                    </form>
                                <?php endif; ?>
                                
                                <form method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="employer_id" value="<?= $employer['id'] ?>">
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
const tableRows = document.querySelectorAll('#employersTable tbody tr');

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
<?php include 'footer.php'; ?>