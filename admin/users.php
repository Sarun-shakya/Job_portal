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
    $user_id = $_POST['user_id'] ?? 0;
    
    if ($action === 'block' && $user_id) {
        // Block user - set status to 'blocked'
        $sql = $conn->prepare("UPDATE users SET status = 'blocked' WHERE id = ?");
        if ($sql->execute([$user_id])) {
            $message = 'User blocked successfully';
            $message_type = 'success';
        }
    } elseif ($action === 'unblock' && $user_id) {
        // Unblock user - set status to 'active'
        $sql = $conn->prepare("UPDATE users SET status = 'active' WHERE id = ?");
        if ($sql->execute([$user_id])) {
            $message = 'User unblocked successfully';
            $message_type = 'success';
        }
    } elseif ($action === 'delete' && $user_id) {
        // Delete user - permanently removes user and all related data
        // CASCADE delete will remove applications and bookmarks automatically
        $sql = $conn->prepare("DELETE FROM users WHERE id = ?");
        if ($sql->execute([$user_id])) {
            $message = 'User deleted successfully';
            $message_type = 'success';
        }
    }
}
$sql = $conn->query("SELECT id, full_name, email, address, status, created_at FROM users ORDER BY created_at DESC");

$users = [];
while ($row = $sql->fetch_assoc()) {
    $users[] = $row;
}

?>

<div class="page-content">
    <div class="page-header">
        <h1>User Management</h1>
        <p style="padding-bottom: 5px ">Manage all registered users on the platform</p>
    </div>
    
    <?php if ($message): ?>
        <div class="alert alert-<?= $message_type ?>"><?= $message ?></div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-header">
            <h2>All Users</h2>
        </div>
        <div class="card-body">
            <!-- Filter Controls -->
            <div class="filter-container">
                <div class="filter-group">
                    <label for="searchInput">Search Users</label>
                    <input type="text" id="searchInput" placeholder="Search by name...">
                </div>
                <div class="filter-group">
                    <label for="statusFilter">Filter by Status</label>
                    <select id="statusFilter">
                        <option value="all">All Users</option>
                        <option value="active">Active</option>
                        <option value="blocked">Blocked</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table" id="usersTable">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr data-status="<?= $user['status'] ?>">
                            <td><?= $index ?></td>
                            <td><?= $user['full_name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['address'] ?></td>
                            <td>
                                <?php if ($user['status'] === 'active'): ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Blocked</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                            <td class="actions">
                                <?php if ($user['status'] === 'active'): ?>
                                    <form method="POST" style="display:inline;" onsubmit="return confirmBlock()">
                                        <input type="hidden" name="action" value="block">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-warning">Block</button>
                                    </form>
                                <?php else: ?>
                                    <form method="POST" style="display:inline;" onsubmit="return confirmUnblock()">
                                        <input type="hidden" name="action" value="unblock">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-success">Unblock</button>
                                    </form>
                                <?php endif; ?>
                                
                                <form method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
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
const tableRows = document.querySelectorAll('#usersTable tbody tr');

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