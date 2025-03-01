<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .dashboard-cards .card {
            border-radius: 12px;
            transition: transform 0.3s ease-in-out;
        }
        .dashboard-cards .card:hover {
            transform: translateY(-5px);
        }
        .card h3 {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .card p {
            font-size: 2rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <header class="text-center mb-4">
            <h1 class="fw-bold">Welcome, Admin!</h1>
        </header>

        <section class="dashboard-cards row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm p-4 bg-white text-center">
                    <h3><i class="bi bi-calendar-check text-primary"></i> Total Appointments</h3>
                    <p id="totalAppointments" class="text-primary">0</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-4 bg-white text-center">
                    <h3><i class="bi bi-people text-success"></i> Total Users</h3>
                    <p id="totalUsers" class="text-success">0</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-4 bg-white text-center">
                    <h3><i class="bi bi-hourglass-split text-warning"></i> Pending Approvals</h3>
                    <p id="pendingApprovals" class="text-warning">0</p>
                </div>
            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
