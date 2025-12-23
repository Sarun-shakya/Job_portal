<?php
include "config/db.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION["user_id"]);

// Handle AJAX request to remove bookmark
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['action']) && $_POST['action'] === 'remove') {
    $job_id = intval($_POST['job_id']);
    $stmt = $conn->prepare("DELETE FROM bookmarks WHERE user_id = ? AND job_id = ?");
    $stmt->bind_param("ii", $user_id, $job_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => $conn->error]);
    }
    exit;
}

// Fetch bookmarks
$sql = "SELECT b.job_id, j.title, e.name AS company_name, e.logo as company_logo, j.location, j.posted_time, b.created_at
        FROM bookmarks b
        INNER JOIN jobs j ON b.job_id = j.job_id
        INNER JOIN employers e ON j.employer_id = e.id
        WHERE b.user_id = ?
        ORDER BY b.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Bookmarked Jobs | Job Portal</title>
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
/* BASIC RESET */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: "Poppins", sans-serif;
    min-height: 100vh;
    color: #333;
}

.container {
    max-width: 1200px;
    margin: auto;
    padding: 20px;
}

.bookmarks-section {
    padding: 10px 0;
    min-height: calc(100vh - 200px);
}

/* Header Section */
.page-header {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 10px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.back-button a {
    text-decoration: none;
    font-size: 15px;
    color: #667eea;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
    padding: 10px 18px;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.back-button a:hover {
    background: rgba(102, 126, 234, 0.2);
    transform: translateX(-5px);
}

.back-button a i {
    font-size: 18px;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.header-title {
    flex: 1;
}

h2{
    font-size: 2.5rem;
    font-weight: 700;
    background-color: #0d6efd;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 5px;
}

.subtitle {
    color: #333;
    font-size: 14px;
    margin-top: 5px;
}

.bookmarks-controls {
    display: flex;
    gap: 10px;
}

.clear-all-btn {
    background-color: #EF4444;
    color: #fff;
    border: none;
    padding: 12px 24px;
    border-radius: 12px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.clear-all-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(245, 87, 108, 0.4);
}

.clear-all-btn i {
    font-size: 16px;
}

/* Bookmarks List */
.bookmarks-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.bookmark-card {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 25px;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    position: relative;
    overflow: hidden;
}

.bookmark-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    transform: scaleY(0);
    transition: transform 0.3s ease;
}


.bookmark-card:hover::before {
    transform: scaleY(1);
}

.logo-title {
    display: flex;
    align-items: center;
    gap: 18px;
    flex: 2;
    min-width: 300px;
}

.company-logo {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    object-fit: cover;
    border: 3px solid rgba(102, 126, 234, 0.2);
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}


.job-title-info h3 {
    font-size: 1.3rem;
    margin-bottom: 5px;
    color: #1a202c;
    font-weight: 600;
}

.company-name {
    color: #718096;
    font-size: 14px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 5px;
}

.company-name::before {
    content: '';
    width: 4px;
    height: 4px;
    background: #cbd5e0;
    border-radius: 50%;
}

.details {
    display: flex;
    flex-direction: column;
    gap: 8px;
    flex: 1;
    min-width: 200px;
}

.details p {
    font-size: 14px;
    color: #333;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}

.details i {
    color: #667eea;
    font-size: 16px;
}

.actions {
    display: flex;
    gap: 12px;
    align-items: center;
}

.details-btn {
    background-color: #6d15b4;
    color: #fff;
    text-decoration: none;
    padding: 10px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.details-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.remove-btn {
    background-color: #EF4444;
    color: #fff;
    padding: 10px 20px;
    border-radius: 10px;
    border: none;
    font-size: 14px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(245, 87, 108, 0.2);
    display: inline-flex;
    align-items: center;
    gap: 6px;
}


.empty-bookmarks {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    text-align: center;
    padding: 80px 40px;
    font-size: 1.3rem;
    color: #718096;
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    display: none;
}

.empty-bookmarks i {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 20px;
    display: block;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.bookmark-card {
    animation: fadeInUp 0.5s ease forwards;
}

.bookmark-card:nth-child(1) { animation-delay: 0.1s; }
.bookmark-card:nth-child(2) { animation-delay: 0.2s; }
.bookmark-card:nth-child(3) { animation-delay: 0.3s; }
.bookmark-card:nth-child(4) { animation-delay: 0.4s; }
.bookmark-card:nth-child(5) { animation-delay: 0.5s; }

/* Responsive Design */
@media (max-width: 968px) {
    .bookmark-card {
        flex-direction: column;
        gap: 20px;
        align-items: flex-start;
    }

    .logo-title {
        width: 100%;
    }

    .details {
        width: 100%;
    }

    .actions {
        width: 100%;
        justify-content: flex-start;
    }
}

@media (max-width: 768px) {
    h2 {
        font-size: 2rem;
    }

    .page-header {
        padding: 20px;
    }

    .header-content {
        flex-direction: column;
        align-items: flex-start;
    }

    .actions {
        flex-wrap: wrap;
    }

    .details-btn,
    .remove-btn {
        flex: 1;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .logo-title {
        min-width: 100%;
    }

    .company-logo {
        width: 50px;
        height: 50px;
    }

    .job-title-info h3 {
        font-size: 1.1rem;
    }

    .clear-all-btn {
        width: 100%;
        justify-content: center;
    }
}

.bookmark-card.removing {
    opacity: 0.5;
    pointer-events: none;
}

.bookmark-count {
    background-color: #0d6efd;
    color: white;
    padding: 5px 15px;
    border-radius: 10px;
    font-weight: 600;

}
</style>
</head>

<body>

<?php include './includes/header.php'; ?>

<section class="bookmarks-section">
<div class="container">

    <div class="page-header">
        <div class="back-button">
            <a href="./jobs.php"><i class="ri-arrow-left-line"></i> Back to Jobs</a>
        </div>

        <div class="header-content">
            <div class="header-title">
                <h2><i class="ri-bookmark-fill"></i> My Bookmarked Jobs</h2>
                <p class="subtitle">Keep track of jobs you're interested in</p>
            </div>
            <div class="bookmarks-controls">
                <span class="bookmark-count" id="bookmarkCount"><?= $result->num_rows ?> Jobs</span>
                <button id="clearAllBtn" class="clear-all-btn">
                    <i class="ri-delete-bin-6-line"></i> Clear All
                </button>
            </div>
        </div>
    </div>

    <div class="bookmarks-list" id="bookmarksGrid">

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="bookmark-card" data-job-id="<?= $row['job_id'] ?>">
                    <div class="logo-title">
                        <img src="employers-zone/uploads/<?= htmlspecialchars($row['company_logo']) ?>" class="company-logo" alt="<?= htmlspecialchars($row['company_name']) ?>">
                        <div class="job-title-info">
                            <h3><?= htmlspecialchars($row['title']) ?></h3>
                            <p class="company-name"><?= htmlspecialchars($row['company_name']) ?></p>
                        </div>
                    </div>

                    <div class="details">
                        <p><i class="ri-map-pin-line"></i> <?= htmlspecialchars($row['location']) ?></p>
                        <p><i class="ri-time-line"></i> Posted <?= date("d M Y", strtotime($row['posted_time'])) ?></p>
                    </div>

                    <div class="actions">
                        <a href="job-description.php?job_id=<?= $row['job_id'] ?>" class="details-btn">
                            <i class="ri-eye-line"></i> View Details
                        </a>
                        <button class="remove-btn" data-job-id="<?= $row['job_id'] ?>">
                            <i class="ri-close-line"></i> Remove
                        </button>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty-bookmarks" id="emptyBookmarks">
                <i class="ri-bookmark-line"></i>
                <p>No bookmarked jobs yet.</p>
                <p style="font-size: 1rem; margin-top: 10px; color: #a0aec0;">Start exploring and bookmark jobs you're interested in!</p>
            </div>
        <?php endif; ?>

    </div>

</div>
</section>

<?php include './includes/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bookmarksGrid = document.getElementById('bookmarksGrid');
    const emptyBookmarks = document.getElementById('emptyBookmarks');
    const clearAllBtn = document.getElementById('clearAllBtn');
    const bookmarkCount = document.getElementById('bookmarkCount');

    function updateBookmarkCount() {
        const cards = bookmarksGrid.querySelectorAll('.bookmark-card');
        const count = cards.length;
        bookmarkCount.textContent = count + (count === 1 ? ' Job' : ' Jobs');
    }

    function checkEmptyBookmarks() {
        const cards = bookmarksGrid.querySelectorAll('.bookmark-card');
        emptyBookmarks.style.display = cards.length === 0 ? 'block' : 'none';
        clearAllBtn.style.display = cards.length === 0 ? 'none' : 'flex';
        updateBookmarkCount();
    }

    // Remove single bookmark via AJAX
    bookmarksGrid.addEventListener('click', function(e) {
        if(e.target.closest('.remove-btn')) {
            const btn = e.target.closest('.remove-btn');
            const jobId = btn.dataset.jobId;
            const card = document.querySelector(`.bookmark-card[data-job-id="${jobId}"]`);

            if(confirm('Remove this bookmark?')) {
                card.classList.add('removing');
                
                fetch('', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: `action=remove&job_id=${jobId}`
                })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') {
                        card.style.animation = 'fadeInUp 0.3s ease reverse';
                        setTimeout(() => {
                            card.remove();
                            checkEmptyBookmarks();
                        }, 300);
                    } else {
                        card.classList.remove('removing');
                        alert('Error removing bookmark: ' + data.msg);
                    }
                })
                .catch(err => {
                    card.classList.remove('removing');
                    alert('Network error. Please try again.');
                });
            }
        }
    });

    // Clear all bookmarks
    clearAllBtn.addEventListener('click', function() {
        const cards = bookmarksGrid.querySelectorAll('.bookmark-card');
        if(cards.length === 0) return;
        
        if(confirm(`Clear all ${cards.length} bookmark(s)?`)) {
            cards.forEach((card, index) => {
                setTimeout(() => {
                    const removeBtn = card.querySelector('.remove-btn');
                    if(removeBtn) removeBtn.click();
                }, index * 100);
            });
        }
    });

    checkEmptyBookmarks();
});
</script>

</body>
</html>