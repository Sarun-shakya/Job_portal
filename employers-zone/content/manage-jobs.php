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

    <!-- Quill Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

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
        .table-box td,
        .table-box th {
            min-height: 60px;
            vertical-align: middle;
        }

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
            color: #555;
            font-size: 0.95rem;
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

        .status.active {
            background: #d4edda;
            color: #155724;
        }

        .status.inactive {
            background: #f8d7da;
            color: #721c24;
        }

        /* Actions Column */
        .table-box .actions {
            display: flex;
            gap: 0.75rem;
            height: 81px;
            text-align: center;
            justify-content: center;
        }

        .table-box .actions a {
            text-decoration: none;
        }

        .table-box .actions i {
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 6px;
            transition: color 0.2s ease, transform 0.2s ease;
            color: #6c757d;
        }

        .table-box .actions i {
            transform: scale(1.1);
            color: #007bff;
        }


        .table-box .actions .ri-delete-bin-line {
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


        /* OVERLAY EDIT JOB */
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
            width: 700px;
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

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        #editJobForm {
            padding: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .half {
            flex: 1;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #000;
            font-size: 14px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: color 0.2s ease, transform 0.2s ease;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #0056b3, #004085);
            transform: translateY(-1px);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .overlay-content {
                width: 95vw;
                max-height: 95vh;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .overlay-header {
                padding: 15px 20px;
            }

            .overlay-header h2 {
                font-size: 20px;
            }

            #editJobForm {
                padding: 20px;
            }
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
                    <h2>Manage Jobs</h2>
                    <p>Here you can update and delete and review the posted jobs</p>
                </div>
                <div class="post-job">
                    <a href="emp-dashboard.php?page=post-job">
                        <i class="ri-add-line"></i>
                        Post a new job
                    </a>
                </div>
            </div>
        </div>

        <div class="search-box">
            <form action="">
                <input type="text" name="title" placeholder="Search with title">
                <select name="status" id="status">
                    <option value="" selected>-- select status --</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </form>
        </div>
        <div class="table-box">
            <table>
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Title</th>
                        <th>Location</th>
                        <th>Posted on</th>
                        <th>Status</th>
                        <th>Applicants</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="job-table-body">
                    <!--manage jobs -->
                </tbody>

            </table>
        </div>
    </div>

    <!-- EDIT JOB OVERLAY -->
    <div id="editOverlay" class="overlay">
        <div class="overlay-content">
            <div class="overlay-header">
                <h2>Edit Job</h2>
                <span class="close-btn" onclick="closeEdit()">&times;</span>
            </div>

            <form action="actions/update-job.php" method="POST" id="editJobForm">
                <input type="hidden" name="job_id" id="edit_job_id">

                <div class="form-group">
                    <label for="edit_title">Job Title</label>
                    <input type="text" name="title" id="edit_title" required>
                </div>

                <div class="form-group">
                    <label for="edit_description">Description</label>
                    <textarea name="description" id="edit_description" style="display:none;"></textarea>
                    <div id="quill_editor" style="height:150px; background:#fff;"></div>
                </div>


                <div class="form-group">
                    <label for="edit_location">Location</label>
                    <input type="text" name="location" id="edit_location" required>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="edit_salary_min">Salary Min</label>
                        <input type="number" name="salary_min" id="edit_salary_min">
                    </div>
                    <div class="form-group half">
                        <label for="edit_salary_max">Salary Max</label>
                        <input type="number" name="salary_max" id="edit_salary_max">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="edit_experience_min">Experience Min</label>
                        <input type="number" name="experience_min" id="edit_experience_min">
                    </div>
                    <div class="form-group half">
                        <label for="edit_experience_max">Experience Max</label>
                        <input type="number" name="experience_max" id="edit_experience_max">
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_expiry_date">Expiry Date</label>
                    <input type="date" name="expiry_date" id="edit_expiry_date">
                </div>

                <div class="form-group">
                    <label for="edit_degree">Degree</label>
                    <input type="text" name="degree" id="edit_degree">
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="edit_job_type">Job Type</label>
                        <select name="job_type" id="edit_job_type">
                            <option>Full time</option>
                            <option>Part time</option>
                            <option>Internship</option>
                            <option>Remote</option>
                            <option>Contract</option>
                        </select>
                    </div>
                    <div class="form-group half">
                        <label for="edit_job_level">Job Level</label>
                        <select name="job_level" id="edit_job_level">
                            <option>Entry</option>
                            <option>Junior</option>
                            <option>Mid</option>
                            <option>Senior</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_category">Category</label>
                    <input type="text" name="category" id="edit_category">
                </div>

                <button type="submit" class="submit-btn">Update Job</button>
            </form>
        </div>
    </div>

    <script>
        const titleInput = document.querySelector('input[name="title"]');
        const statusSelect = document.querySelector('select[name="status"]');
        const tableBody = document.getElementById('job-table-body');

        function fetchJobs() {
            const title = titleInput.value;
            const status = statusSelect.value;

            fetch(`./actions/job-search.php?title=${encodeURIComponent(title)}&status=${encodeURIComponent(status)}`)
                .then(response => response.text())
                .then(data => {
                    tableBody.innerHTML = data;
                });
        }
        titleInput.addEventListener('input', fetchJobs);
        statusSelect.addEventListener('change', fetchJobs);
        window.addEventListener('load', fetchJobs);

        var quill = new Quill('#quill_editor', {
            theme: 'snow'
        });

        document.getElementById("editJobForm").addEventListener("submit", function() {
            document.getElementById("edit_description").value = quill.root.innerHTML;
        });

        function openEdit(id) {
            fetch("actions/fetch-edit-job.php?id=" + id)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("editOverlay").style.display = "flex";

                    // Fill form fields
                    const fields = data.split("|-|");
                    document.getElementById("edit_job_id").value = fields[0];
                    document.getElementById("edit_title").value = fields[1];
                    quill.root.innerHTML = fields[2];
                    document.getElementById("edit_location").value = fields[3];
                    document.getElementById("edit_salary_min").value = fields[4];
                    document.getElementById("edit_salary_max").value = fields[5];
                    document.getElementById("edit_experience_min").value = fields[6];
                    document.getElementById("edit_experience_max").value = fields[7];
                    document.getElementById("edit_expiry_date").value = fields[8];
                    document.getElementById("edit_degree").value = fields[9];
                    document.getElementById("edit_job_type").value = fields[10];
                    document.getElementById("edit_job_level").value = fields[11];
                    document.getElementById("edit_category").value = fields[12];
                });
        }

        function closeEdit() {
            document.getElementById("editOverlay").style.display = "none";
        }
    </script>

</body>

</html>