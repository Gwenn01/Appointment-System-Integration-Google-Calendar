<?php
if (!isset($_SESSION['adminid'])) {
    header("Location: ../admin_login.php");
    exit();
}

require(__DIR__ . '/../Database/database.php');

// Handle user deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $userId = intval($_POST['user_id']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_dashboard.php?page=users");
    exit();
}

// Handle user update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $userId = intval($_POST['user_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if (!empty($name) && !empty($email)) {
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $email, $userId);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: admin_dashboard.php?page=users");
    exit();
}

// Fetch admins
$admins = [];
$adminQuery = mysqli_query($conn, "SELECT id, name, email FROM admins");
while ($row = mysqli_fetch_assoc($adminQuery)) {
    $row['role'] = 'Admin';
    $admins[] = $row;
}

// Fetch users
$customers = [];
$userQuery = mysqli_query($conn, "SELECT id, name, email FROM users");
while ($row = mysqli_fetch_assoc($userQuery)) {
    $row['role'] = 'Customer';
    $customers[] = $row;
}

// Combine
$accounts = array_merge($admins, $customers);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Accounts | Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                        <td><?= str_pad($account['id'], 3, '0', STR_PAD_LEFT); ?></td>
                        <td><?= htmlspecialchars($account['name']); ?></td>
                        <td><?= htmlspecialchars($account['email']); ?></td>
                        <td>
                            <span class="badge <?= $account['role'] === 'Admin' ? 'badge-admin' : 'badge-customer'; ?>">
                                <?= $account['role']; ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($account['role'] === 'Admin'): ?>
                                <a href="edit_admin.php?id=<?= $account['id']; ?>" class="btn btn-info btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                                <a href="delete_admin.php?id=<?= $account['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i> Delete</a>
                            <?php else: ?>
                                <!-- Edit Button triggers Modal -->
                                <button 
                                    class="btn btn-info btn-sm editBtn"
                                    data-id="<?= $account['id']; ?>"
                                    data-name="<?= htmlspecialchars($account['name']); ?>"
                                    data-email="<?= htmlspecialchars($account['email']); ?>"
                                    data-bs-toggle="modal" data-bs-target="#editUserModal">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>

                                <!-- Delete Form -->
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                    <input type="hidden" name="user_id" value="<?= $account['id']; ?>">
                                    <button type="submit" name="delete_user" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="user_id" id="editUserId">
          <div class="mb-3">
              <label for="editUserName" class="form-label">Name</label>
              <input type="text" class="form-control" name="name" id="editUserName" required>
          </div>
          <div class="mb-3">
              <label for="editUserEmail" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" id="editUserEmail" required>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="edit_user" class="btn btn-primary">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Load data into Edit Modal
    document.addEventListener('DOMContentLoaded', () => {
        const editButtons = document.querySelectorAll('.editBtn');
        const userIdInput = document.getElementById('editUserId');
        const userNameInput = document.getElementById('editUserName');
        const userEmailInput = document.getElementById('editUserEmail');

        editButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                userIdInput.value = btn.dataset.id;
                userNameInput.value = btn.dataset.name;
                userEmailInput.value = btn.dataset.email;
            });
        });
    });
</script>
</body>
</html>
