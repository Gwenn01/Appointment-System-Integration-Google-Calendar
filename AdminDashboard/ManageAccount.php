<?php
    if (!isset($_SESSION['adminid'])) {
        header("Location: ../admin_login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Accounts | Admin Dashboard</title>
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
        .badge-admin {
            background-color: #dc3545;
        }
        .badge-customer {
            background-color: #0d6efd;
        }
    </style>
</head>
<body>
<?php
require(__DIR__ . '/../Database/database.php');

// Fetch all admins
$admins = [];
$adminQuery = mysqli_query($conn, "SELECT id, name, email FROM admins");
while ($row = mysqli_fetch_assoc($adminQuery)) {
    $row['role'] = 'Admin';
    $admins[] = $row;
}

// Fetch all users
$customers = [];
$userQuery = mysqli_query($conn, "SELECT id, name, email FROM users");
while ($row = mysqli_fetch_assoc($userQuery)) {
    $row['role'] = 'Customer';
    $customers[] = $row;
}

// Combine
$accounts = array_merge($admins, $customers);
?>

    <div class="container dashboard-container">
        <header class="text-center mb-4">
            <h1 class="fw-bold">Manage Accounts</h1>
        </header>

        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control" id="searchAccount" placeholder="🔍 Search users...">
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterRole">
                    <option value="">Filter by Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Customer">Customer</option>
                </select>
            </div>
            <div class="col-md-3 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccountModal"><i class="bi bi-person-plus"></i> Add New Account</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="accountsTable">
                    <?php foreach ($accounts as $account): ?>
                        <tr>
                            <td><?php echo str_pad($account['id'], 3, '0', STR_PAD_LEFT); ?></td>
                            <td><?php echo htmlspecialchars($account['name']); ?></td>
                            <td><?php echo htmlspecialchars($account['email']); ?></td>
                            <td>
                                <span class="badge <?php echo $account['role'] === 'Admin' ? 'badge-admin' : 'badge-customer'; ?>">
                                    <?php echo $account['role']; ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($account['role'] === 'Admin'): ?>
                                    <a href="edit_admin.php?id=<?php echo $account['id']; ?>" class="btn btn-info btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                                    <a href="delete_admin.php?id=<?php echo $account['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i> Delete</a>
                                <?php else: ?>
                                    <a href="edit_user.php?id=<?php echo $account['id']; ?>" class="btn btn-info btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                                    <a href="delete_user.php?id=<?php echo $account['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i> Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
