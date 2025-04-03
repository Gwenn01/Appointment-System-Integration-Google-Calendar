<?php
if (!isset($_SESSION['adminid'])) {
    header("Location: ../admin_login.php");
    exit();
}

require(__DIR__ . '/../Database/database.php');

// Handle Add Service
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_service'])) {
    $name = trim($_POST['service_name']);
    $description = trim($_POST['description']);

    if (!empty($name) && !empty($description)) {
        $stmt = $conn->prepare("INSERT INTO services (service_name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $description);
        $stmt->execute();
        $stmt->close();
        header("Location: admin_dashboard.php?page=services"); // redirect to prevent form resubmission
        exit();
    }
}

// Fetch existing services
$services = [];
$result = mysqli_query($conn, "SELECT * FROM services ORDER BY id ASC");
while ($row = mysqli_fetch_assoc($result)) {
    $services[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Services | Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="text-center mb-4">Manage Services</h2>

    <!-- Add Service Form -->
    <form method="POST" class="card p-4 shadow-sm mb-4">
        <h5>Add New Service</h5>
        <div class="mb-3">
            <label for="service_name" class="form-label">Service Name</label>
            <input type="text" name="service_name" id="service_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Service Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" name="add_service" class="btn btn-primary w-100">Add Service</button>
    </form>

    <!-- Services Table -->
    <table class="table table-bordered bg-white shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Service Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($services) > 0): ?>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?= $service['id'] ?></td>
                        <td><?= htmlspecialchars($service['service_name']) ?></td>
                        <td><?= htmlspecialchars($service['description']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3" class="text-center text-muted">No services found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
