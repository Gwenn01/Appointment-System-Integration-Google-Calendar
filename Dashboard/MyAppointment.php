<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments | Appointment System</title>
    <link rel="stylesheet" href="style/appointments.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .appointments-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .badge-confirmed { background-color: #28a745; color: white; padding: 5px 10px; border-radius: 5px; }
        .badge-pending { background-color: #ffc107; color: black; padding: 5px 10px; border-radius: 5px; }
        .badge-cancelled { background-color: #dc3545; color: white; padding: 5px 10px; border-radius: 5px; }

        .cancel-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .cancel-btn:hover { background-color: #c82333; }
    </style>
</head>
<body>

    <div class="appointments-container">
        <h2 class="mb-4 text-center"><i class="bi bi-calendar-check"></i> My Appointments</h2>

        <!-- Appointments Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>001</td>
                        <td>Dental Checkup</td>
                        <td>2025-03-10</td>
                        <td>10:00 AM</td>
                        <td><span class="badge-confirmed">Confirmed</span></td>
                        <td><button class="cancel-btn"><i class="bi bi-x-circle"></i> Cancel</button></td>
                    </tr>
                    <tr>
                        <td>002</td>
                        <td>General Consultation</td>
                        <td>2025-03-15</td>
                        <td>2:00 PM</td>
                        <td><span class="badge-pending">Pending</span></td>
                        <td><button class="cancel-btn"><i class="bi bi-x-circle"></i> Cancel</button></td>
                    </tr>
                    <tr>
                        <td>003</td>
                        <td>Skin Treatment</td>
                        <td>2025-02-25</td>
                        <td>4:00 PM</td>
                        <td><span class="badge-cancelled">Cancelled</span></td>
                        <td> - </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
