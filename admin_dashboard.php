<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'home'; // Default to 'home'

$allowed_pages = [
    "home" => "AdminDashboard/Home.php",
    "appointments" => "AdminDashboard/ManageAppointment.php",
    "users" => "AdminDashboard/ManageAccount.php",
    "approvals" => "AdminDashboard/PendingAproval.php"
];

$page_file = isset($allowed_pages[$page]) ? $allowed_pages[$page] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Appointment System</title>
    <link rel="stylesheet" href="style/admin_dashboard.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul class="list-unstyled">
            <li><a href="admin_dashboard.php?page=home"><i class="bi bi-house-door"></i> Home</a></li>
            <li><a href="admin_dashboard.php?page=appointments"><i class="bi bi-calendar-check"></i> Manage Appointments</a></li>
            <li><a href="admin_dashboard.php?page=users"><i class="bi bi-people"></i> Manage Account</a></li>
            <li><a href="admin_dashboard.php?page=approvals"><i class="bi bi-exclamation-circle"></i> Pending Approvals</a></li>
            <li><a href="logout.php" class="logout"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div id="content">
            <?php
            if ($page_file && file_exists($page_file)) {
                include $page_file;
            } else {
                echo "<p class='text-danger'>Page not found.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
