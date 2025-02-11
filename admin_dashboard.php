<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Appointment System</title>
    <link rel="stylesheet" href="style/admin_dashboard.css"> <!-- Link external CSS -->
    <script defer src="script/admin-dashboard.js"></script> <!-- Link external JS -->
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="#">📊 Dashboard</a></li>
            <li><a href="#">📅 Manage Appointments</a></li>
            <li><a href="#">👥 Manage Users</a></li>
            <li><a href="#">⚙️ Settings</a></li>
            <li><a href="logout.php" class="logout">🚪 Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>Welcome, Admin!</h1>
        </header>

        <section class="dashboard-cards">
            <div class="card">
                <h3>Total Appointments</h3>
                <p id="totalAppointments">0</p>
            </div>
            <div class="card">
                <h3>Total Users</h3>
                <p id="totalUsers">0</p>
            </div>
            <div class="card">
                <h3>Pending Approvals</h3>
                <p id="pendingApprovals">0</p>
            </div>
        </section>
    </div>

</body>
</html>
