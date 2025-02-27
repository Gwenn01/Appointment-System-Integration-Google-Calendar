<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments | Appointment System</title>
    <link rel="stylesheet" href="style/dashboard.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

</head>
<body>

    <div class="appointments-container">
        <h2 class="mb-4 text-center"><i class="bi bi-calendar-check"></i> My Appointments</h2>

        <!-- Search & Filter -->
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control" id="searchAppointment" placeholder="🔍 Search appointments...">
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterStatus">
                    <option value="">Filter by Status</option>
                    <option value="Confirmed">Confirmed</option>
                    <option value="Pending">Pending</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>
            <div class="col-md-3 text-end">
                <button class="btn btn-primary"><i class="bi bi-arrow-clockwise"></i> Refresh</button>
            </div>
        </div>

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
                        <td><span class="badge badge-confirmed">Confirmed</span></td>
                        <td>
                            <button class="cancel-btn"><i class="bi bi-x-circle"></i> Cancel</button>
                        </td>
                    </tr>
                    <tr>
                        <td>002</td>
                        <td>General Consultation</td>
                        <td>2025-03-15</td>
                        <td>2:00 PM</td>
                        <td><span class="badge badge-pending">Pending</span></td>
                        <td>
                            <button class="cancel-btn"><i class="bi bi-x-circle"></i> Cancel</button>
                        </td>
                    </tr>
                    <tr>
                        <td>003</td>
                        <td>Skin Treatment</td>
                        <td>2025-02-25</td>
                        <td>4:00 PM</td>
                        <td><span class="badge badge-cancelled">Cancelled</span></td>
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
