<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Accounts | Admin Dashboard</title>

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
        .badge-admin {
            background-color: #dc3545;
        }
        .badge-customer {
            background-color: #0d6efd;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2 class="mb-4"><i class="bi bi-people"></i> Manage Accounts</h2>

        <!-- Search and Filter Bar -->
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

        <!-- Accounts Table -->
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
                    <tr>
                        <td>001</td>
                        <td>John Doe</td>
                        <td>johndoe@example.com</td>
                        <td><span class="badge badge-admin">Admin</span></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editAccountModal"><i class="bi bi-pencil"></i> Edit</button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>002</td>
                        <td>Jane Smith</td>
                        <td>janesmith@example.com</td>
                        <td><span class="badge badge-customer">Customer</span></td>
                        <td>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editAccountModal"><i class="bi bi-pencil"></i> Edit</button>
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Account Modal -->
    <div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAccountModalLabel"><i class="bi bi-person-plus"></i> Add New Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select">
                                <option value="Admin">Admin</option>
                                <option value="Customer">Customer</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Add Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Account Modal -->
    <div class="modal fade" id="editAccountModal" tabindex="-1" aria-labelledby="editAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAccountModalLabel"><i class="bi bi-pencil-square"></i> Edit Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" value="John Doe">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="johndoe@example.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select">
                                <option value="Admin" selected>Admin</option>
                                <option value="Customer">Customer</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
