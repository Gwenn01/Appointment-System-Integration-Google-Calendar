<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments | Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        body {
            padding: 20px;
            background-color: #f8f9fa;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .status-pending {
            background-color: #ffc107;
            color: black;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .status-approved {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .status-rejected {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2 class="mb-4"><i class="bi bi-calendar-check"></i> Manage Appointments</h2>

        <!-- Search and Filter Bar -->
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control" id="searchAppointment" placeholder="🔍 Search appointments...">
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterStatus">
                    <option value="">Filter by Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Approved">Approved</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </div>
            <div class="col-md-3 text-end">
                <button class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New Appointment</button>
            </div>
        </div>

        <!-- Appointments Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Client Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Service</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="appointmentsTable">
                    <tr>
                        <td>001</td>
                        <td>John Doe</td>
                        <td>2025-02-22</td>
                        <td>10:00 AM</td>
                        <td>Dental Checkup</td>
                        <td><span class="status-pending">Pending</span></td>
                        <td>
                            <button class="btn btn-success btn-sm"><i class="bi bi-check-lg"></i> Approve</button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-x-lg"></i> Reject</button>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#appointmentDetails"><i class="bi bi-eye"></i> View</button>
                        </td>
                    </tr>
                    <tr>
                        <td>002</td>
                        <td>Jane Smith</td>
                        <td>2025-02-23</td>
                        <td>2:00 PM</td>
                        <td>General Consultation</td>
                        <td><span class="status-approved">Approved</span></td>
                        <td>
                            <button class="btn btn-secondary btn-sm"><i class="bi bi-arrow-repeat"></i> Reschedule</button>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#appointmentDetails"><i class="bi bi-eye"></i> View</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Appointment Details Modal -->
    <div class="modal fade" id="appointmentDetails" tabindex="-1" aria-labelledby="appointmentDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentDetailsLabel"><i class="bi bi-info-circle"></i> Appointment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Client Name:</strong> John Doe</p>
                    <p><strong>Date:</strong> 2025-02-22</p>
                    <p><strong>Time:</strong> 10:00 AM</p>
                    <p><strong>Service:</strong> Dental Checkup</p>
                    <p><strong>Status:</strong> <span class="status-pending">Pending</span></p>
                    <hr>
                    <h6>Notes:</h6>
                    <p>No additional notes.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success"><i class="bi bi-check-lg"></i> Approve</button>
                    <button class="btn btn-danger"><i class="bi bi-x-lg"></i> Reject</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
