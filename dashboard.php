<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard | Appointment System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
            background-color: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
            transition: all 0.3s;
        }
        .sidebar h2 {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        .sidebar a {
            color: white;
            padding: 12px;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 16px;
        }
        .sidebar a i {
            margin-right: 10px;
            font-size: 18px;
        }
        .sidebar a:hover {
            background: #495057;
            border-radius: 5px;
        }
        .sidebar .logout {
            color: #dc3545;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            width: 100%;
            padding: 20px;
            transition: all 0.3s;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        #newAppointmentBtn {
            background: #0d6efd;
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.3s;
        }
        #newAppointmentBtn:hover {
            background: #0b5ed7;
        }
        .appointments {
            margin-top: 20px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .appointment-list p {
            text-align: center;
            font-size: 16px;
            color: #6c757d;
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
                justify-content: center;
                font-size: 14px;
                padding: 10px;
            }
            .sidebar a i {
                margin-right: 0;
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
        <h2>Customer Panel</h2>
        <ul class="list-unstyled">
            <li><a href="#"><i class="bi bi-house-door"></i> Home</a></li>
            <li><a href="#"><i class="bi bi-calendar-check"></i> My Appointments</a></li>
            <li><a href="#"><i class="bi bi-person"></i> Profile</a></li>
            <li><a href="logout.php" class="logout"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>Welcome, <span id="customerName">Customer</span>!</h1>
            <button id="newAppointmentBtn" data-bs-toggle="modal" data-bs-target="#newAppointmentModal">
                <i class="bi bi-plus-lg"></i> New Appointment
            </button>
        </header>

        <section class="appointments">
            <h2><i class="bi bi-calendar-event"></i> Upcoming Appointments</h2>
            <div class="appointment-list">
                <p>No upcoming appointments.</p> <!-- Default message -->
            </div>
        </section>
    </div>

    <!-- New Appointment Modal -->
    <div class="modal fade" id="newAppointmentModal" tabindex="-1" aria-labelledby="newAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newAppointmentModalLabel"><i class="bi bi-calendar-plus"></i> Book an Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Select Date</label>
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Time</label>
                            <input type="time" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Service Type</label>
                            <select class="form-select" required>
                                <option value="">Choose a service</option>
                                <option value="Dental Checkup">Dental Checkup</option>
                                <option value="General Consultation">General Consultation</option>
                                <option value="Skin Treatment">Skin Treatment</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Additional Notes</label>
                            <textarea class="form-control" rows="3" placeholder="Enter any special requests..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Confirm Appointment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
