<?php
session_start();
if (!isset($_SESSION['username'])) {
    // User not logged in, redirect to login page
    header('Location: index.php');
    exit;
}
// get the pages components
$page = isset($_GET['page']) ? $_GET['page'] : 'home'; // Default to 'home'

$allowed_pages = [
    "home" => "Dashboard/Home.php",
    "appointments" => "Dashboard/MyAppointment.php",
    "profile" => "Dashboard/Profile.php"
];

$page_file = isset($allowed_pages[$page]) ? $allowed_pages[$page] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard | Appointment System</title>
    <link rel="stylesheet" href="style/dashboard.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2>Customer Panel</h2>
        <ul class="list-unstyled">
            <li><a href="dashboard.php?page=home"><i class="bi bi-house-door"></i> Home</a></li>
            <li><a href="dashboard.php?page=appointments"><i class="bi bi-calendar-check"></i> My Appointments</a></li>
            <li><a href="dashboard.php?page=profile"><i class="bi bi-person"></i> Profile</a></li>
            <li><a href="Authentication/logout.php" class="logout"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
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
