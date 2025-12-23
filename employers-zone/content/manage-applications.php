<!-- Manage Applications -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Remix Icon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/emp-dashboard.css">

    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- Bootstrap JS (with Popper for dropdowns, tooltips, etc.) -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <style>
        .table-container {
            max-width: 1300px;
            margin: 2rem auto;
            padding: 0 1rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .title-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem 2rem 1.5rem;
        }

        .title h2 {
            margin: 0 0 0.5rem 0;
            font-size: 2rem;
            font-weight: 600;
            line-height: 1.2;
        }

        .title p {
            margin: 0;
            opacity: 0.9;
            font-size: 1rem;
        }

        .post-job {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background-color: #667eea;
            border-radius: 25px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .post-job a {
            color: white;
            text-decoration: none;

        }

        .post-job:hover {
            background-color: #5a67d8;
            transform: translateY(-1px);
        }

        .post-job i {
            font-size: 1.2rem;
        }


        .search-box form {
            display: flex;
            gap: 1rem;
            margin-bottom: 0;

        }

        .search-box input,
        .search-box select {
            margin: 0;
            display: block;

        }

        .search-box input[type="text"] {
            flex: 8;
            padding: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .search-box select {
            flex: 2;
            padding: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 0.95rem;
            background: #fff;
            cursor: pointer;
        }


        /* Table Styles */
        .table-box {
            padding: 0rem 2rem;
            overflow-x: auto;
        }

        .table-box table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .table-box th,
        .table-box td {
            padding: 1rem 1.25rem;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }

        .table-box th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-box td {
            font-size: 0.95rem;
            color: #555;
        }

        .table-box td a {
            text-decoration: none;
            color: #555;
        }

        .table-box tr:hover {
            background: #f8f9fa;
            transition: background 0.2s ease;
        }

        /* Status Badge */
        .table-box .status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status.pending {
            background: #facc15;
            color: #4a5715ff;
        }

        .status.inactive {
            background: #f8d7da;
            color: #721c24;
        }

        /* Actions Column */
        .table-box .detail {
            display: flex;
            gap: 0.75rem;
        }

        .table-box .detail i {
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 6px;
            transition: color 0.2s ease, transform 0.2s ease;
            color: #6c757d;
        }

        .table-box .detail i {
            transform: scale(1.1);
            color: #007bff;
        }

        .table-box .detail .ri-delete-bin-line {
            color: #dc3545;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .title-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
                padding: 1.5rem;
            }

            .post-job {
                align-self: flex-end;
            }

            .search-box {
                padding: 1rem;
            }

            .search-box form {
                flex-direction: column;
                gap: 0.75rem;
                max-width: none;
            }

            .table-box {
                padding: 1rem;
            }

            .table-box th,
            .table-box td {
                padding: 0.75rem 0.5rem;
                font-size: 0.9rem;
            }

            /* Make table responsive on small screens */
            .table-box table {
                font-size: 0.85rem;
            }

            .table-box .actions {
                flex-direction: column;
                gap: 0.25rem;
            }

            .search-box form {
                flex-direction: column;
            }

            .search-box input[type="text"],
            .search-box select {
                flex: 1;
                /* full width */
            }
        }

        @media (max-width: 480px) {
            .title h2 {
                font-size: 1.5rem;
            }

            .search-box input[type="text"],
            .search-box select {
                padding: 0.625rem 0.875rem;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table-container {
            animation: fadeIn 0.6s ease-out;
        }

        .view-btn {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            gap: 4px;
        }

        .view-btn i {
            font-size: 18px;
        }

        /* OVERLAY USER PROFILE */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }

        .overlay-content {
            background: #ffffff;
            padding: 0;
            width: 610px;
            max-width: 90vw;
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 12px;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.3s ease-in-out;
        }

        .overlay-header {
            position: sticky;
            top: 0;
            background: #ffffff;
            padding: 15px 20px;
            border-bottom: 1px solid #e0e0e0;
            border-radius: 12px 12px 0 0;
            z-index: 10;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .overlay-header h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
            font-weight: 600;
        }

        .close-btn {
            cursor: pointer;
            font-size: 28px;
            color: #333;
            transition: color 0.2s;
        }

        .close-btn:hover {
            color: #ff3742;
        }

        .app-profile-container {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            width: 600px;
            margin: auto;
        }

        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .profile-header h2 {
            font-size: 22px;
            margin: 0;
        }

        .close-btn {
            font-size: 28px;
            cursor: pointer;
            padding: 5px;
        }

        .profile-top {
            text-align: center;
            margin: 20px 0;
        }

        .profile-photo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
        }

        .applicant-name {
            margin-top: 10px;
            font-size: 20px;
            font-weight: 600;
        }

        .applicant-email {
            color: #666;
        }

        .profile-card {
            background: #f8fafc;
            padding: 18px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .profile-card h4 {
            margin-bottom: 8px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }

        .status-badge {
            background: #e7ecf8;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 14px;
        }

        .resume-btn {
            width: 100%;
            border: 1px solid #003de3;
            color: white;
            padding: 10px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            font-size: 16px;
            text-decoration: none;
            margin: 10px 0;
            color: black;
        }

        .resume-btn:hover {
            color: #003de8;
        }

        .change-status-box {
            margin-top: 15px;
        }

        .status-select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            margin: 8px 0;
        }

        .update-btn {
            width: 100%;
            background: #0a4bff;
            color: white;
            padding: 10px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            font-size: 16px;
            text-decoration: none;
            margin: 10px 0;
            cursor: pointer;
            border: none;
        }
    </style>
</head>

<body>
    <?php
    include __DIR__ . '/../../config/db.php';
    ?>
    <div class="table-container">
        <div class="table-heading">
            <div class="title-card">
                <div class="title">
                    <h2>Manage Applications</h2>
                    <p>View and manage all candidates who have applied for your posted jobs.</p>

                </div>
                <div class="post-job">
                    <a href="emp-dashboard.php?page=manage-jobs">
                        <i class="ri-eye-line"></i>
                        View Job Posts
                    </a>
                </div>
            </div>
        </div>

        <div class="search-box">
            <form id="searchForm">
                <input type="text" name="title" id="searchTitle" placeholder="Search with title">
                <select name="status" id="searchStatus">
                    <option value="" selected>-- select status --</option>
                    <option value="applied">Applied</option>
                    <option value="reviewed">Reviewed</option>
                    <option value="shortlisted">Shortlisted</option>
                    <option value="rejected">Rejected</option>
                    <option value="selected">Selected</option>
                </select>
            </form>
        </div>

        <div class="table-box">
            <table>
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Applicant Name</th>
                        <th>Job Title</th>
                        <th>Location</th>
                        <th>Resume</th>
                        <th>Status</th>
                        <th>View Detail</th>
                    </tr>
                </thead>
                <tbody id="applicationsTable">
                    <!-- Filled dynamically by AJAX -->
                </tbody>
            </table>

        </div>
    </div>

    <!-- USER PROFILE OVERLAY -->
    <div id="editOverlay" class="overlay">
        <div class="overlay-content">
            <div class="overlay-header">
                <h2>Applicant Profile</h2>
                <span class="close-btn" onclick="closeOverlay()">&times;</span>
            </div>

            <div class="profile-container">
                <!-- PRofile will be displayed here -->
            </div>
        </div>
    </div>
</body>

<script>
    const searchTitle = document.getElementById('searchTitle');
    const searchStatus = document.getElementById('searchStatus');
    const applicationsTable = document.getElementById('applicationsTable');

    function fetchApplications() {
        const title = searchTitle.value;
        const status = searchStatus.value;

        fetch(`./actions/search-applications.php?title=${encodeURIComponent(title)}&status=${encodeURIComponent(status)}`)
            .then(response => response.text())
            .then(data => {
                applicationsTable.innerHTML = data;
            })
            .catch(err => console.error(err));
    }

    // Fetch on page load
    fetchApplications();

    searchTitle.addEventListener('input', fetchApplications);
    searchStatus.addEventListener('change', fetchApplications);


    //OVERLAY FOR USER PROFILE


    function viewProfile(appId) {
        fetch(`./actions/fetch-applications-detail.php?id=${appId}`)
        .then(res => res.text())
        .then(html => {
            document.querySelector('.profile-container').innerHTML = html;
            document.getElementById('editOverlay').style.display = 'flex';
        })
        .catch(err => console.error(err));
    }

    function closeOverlay() {
        document.getElementById("editOverlay").style.display = "none";
    }

    function updateStatus(appId) {
        const status = document.getElementById('changeStatus').value;

        const formData = new FormData();
        formData.append('app_id', appId);
        formData.append('status', status);

        fetch('./actions/update-status.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(msg => {
            alert(msg); 
            document.querySelector('.status-badge').textContent = status;
            fetchApplications(); // refresh table
        })
        .catch(err => console.error(err));
    }

</script>

</html>