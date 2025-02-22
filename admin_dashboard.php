<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Appointment System</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <style>
        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
            transition: all 0.3s;
        }
        .sidebar a {
            color: white;
            padding: 12px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .sidebar .logout {
            color: #dc3545;
        }
        .main-content {
            margin-left: 250px;
            width: 100%;
            padding: 20px;
            transition: all 0.3s;
        }
        .dashboard-cards .card {
            text-align: center;
        }
        /* Responsive Sidebar */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 200px;
            }
        }
        @media (max-width: 576px) {
            .sidebar {
                width: 100px;
            }
            .sidebar h2 {
                display: none;
            }
            .sidebar a {
                text-align: center;
                font-size: 14px;
                padding: 10px 5px;
            }
            .main-content {
                margin-left: 100px;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2 class="text-center">Admin Panel</h2>
        <ul class="list-unstyled">
            <li><a href="#"><i class="bi bi-grid"></i> Dashboard</a></li>
            <li><a href="#"><i class="bi bi-calendar-check"></i> Manage Appointments</a></li>
            <li><a href="#"><i class="bi bi-people"></i> Manage Users</a></li>
            <li><a href="#"><i class="bi bi-exclamation-circle"></i> Pending Approvals</a></li>
            <li><a href="logout.php" class="logout"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header class="mb-4">
            <h1>Welcome, Admin!</h1>
        </header>

        <section class="dashboard-cards row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h3><i class="bi bi-calendar-check text-primary"></i> Total Appointments</h3>
                    <p id="totalAppointments" class="fs-3">0</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h3><i class="bi bi-people text-success"></i> Total Users</h3>
                    <p id="totalUsers" class="fs-3">0</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h3><i class="bi bi-hourglass-split text-warning"></i> Pending Approvals</h3>
                    <p id="pendingApprovals" class="fs-3">0</p>
                </div>
            </div>
        </section>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
