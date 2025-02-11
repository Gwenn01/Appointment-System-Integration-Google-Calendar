<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard | Appointment System</title>
    <link rel="stylesheet" href="style/dashboard.css"> <!-- Link external CSS -->
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
            <li><a href="#">🏠 Home</a></li>
            <li><a href="#">📅 My Appointments</a></li>
            <li><a href="#">👤 Profile</a></li>
            <li><a href="logout.php" class="logout">🚪 Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>Welcome, [Customer Name]!</h1>
            <button id="newAppointmentBtn">+ New Appointment</button>
        </header>

        <section class="appointments">
            <h2>Upcoming Appointments</h2>
            <div class="appointment-list">
                <p>No upcoming appointments.</p> <!-- Default message -->
            </div>
        </section>
    </div>

</body>
</html>