<?php
    if (!isset($_SESSION['adminid'])) {
        header("Location: ../admin_login.php");
        exit();
    }
    require(__DIR__ . '/../Database/database.php');

    // Fetch pending appointments
    $appointments = mysqli_query($conn, "
        SELECT a.id, u.name, a.status, t.slot_date
        FROM appointments a
        JOIN users u ON a.user_id = u.id
        JOIN time_slots t ON a.time_slot_id = t.id
        WHERE a.status = 'pending'
    ");
    $pending_users = mysqli_query($conn, "
    SELECT id, name, email, created_at FROM users WHERE is_verified = 0
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Approvals | Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .dashboard-container {
            margin-top: 20px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .badge-appointment {
            background-color: #0d6efd;
        }
        .badge-registration {
            background-color: #ffc107;
            color: black;
        }
    </style>
</head>
<body>
    <div class="container dashboard-container">
        <header class="text-center mb-4">
            <h1 class="fw-bold">Pending Approvals</h1>
        </header>

        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control" id="searchApproval" placeholder="🔍 Search requests...">
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterApprovalType">
                    <option value="">Filter by Type</option>
                    <option value="Appointment">Appointment</option>
                    <option value="Registration">User Registration</option>
                </select>
            </div>
            <div class="col-md-3 text-end">
                <button class="btn btn-primary"><i class="bi bi-arrow-clockwise"></i> Refresh</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Request Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="approvalsTable">
                    <?php while ($row = mysqli_fetch_assoc($appointments)): ?>
                    <tr>
                        <td><?php echo str_pad($row['id'], 3, '0', STR_PAD_LEFT); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><span class="badge badge-appointment">Appointment</span></td>
                        <td><?php echo htmlspecialchars($row['slot_date']); ?></td>
                        <td><span class="badge bg-warning">Pending</span></td>
                        <td>
                            <form method="POST" action="Backend/approve_request.php" style="display:inline;">
                                <input type="hidden" name="type" value="appointment">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button class="btn btn-success btn-sm"><i class="bi bi-check-lg"></i> Approve</button>
                            </form>
                            <form method="POST" action="Backend/reject_request.php" style="display:inline;">
                                <input type="hidden" name="type" value="appointment">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button class="btn btn-danger btn-sm"><i class="bi bi-x-lg"></i> Reject</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>

                    <?php while ($row = mysqli_fetch_assoc($pending_users)): ?>
                    <tr>
                        <td><?php echo str_pad($row['id'], 3, '0', STR_PAD_LEFT); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><span class="badge badge-registration">User Registration</span></td>
                        <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($row['created_at']))); ?></td>
                        <td><span class="badge bg-warning">Pending</span></td>
                        <td>
                            <form method="POST" action="Backend/approve_request.php" style="display:inline;">
                                <input type="hidden" name="type" value="registration">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button class="btn btn-success btn-sm"><i class="bi bi-check-lg"></i> Approve</button>
                            </form>
                            <form method="POST" action="Backend/reject_request.php" style="display:inline;">
                                <input type="hidden" name="type" value="registration">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button class="btn btn-danger btn-sm"><i class="bi bi-x-lg"></i> Reject</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>

            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
