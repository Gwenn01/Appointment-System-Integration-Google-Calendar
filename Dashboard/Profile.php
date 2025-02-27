<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Appointment System</title>
    <link rel="stylesheet" href="style/dashboard.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

    <div class="profile-container">
        <h2 class="mb-3"><i class="bi bi-person-circle"></i> My Profile</h2>

        <!-- Profile Picture -->
        <img src="https://via.placeholder.com/120" alt="Profile Picture" class="profile-picture">

        <!-- User Info -->
        <h4 id="fullName">John Doe</h4>
        <p class="text-muted"><i class="bi bi-envelope"></i> johndoe@example.com</p>
        <p class="text-muted"><i class="bi bi-telephone"></i> +123 456 7890</p>

        <!-- Edit Profile Button -->
        <button class="edit-profile-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <i class="bi bi-pencil"></i> Edit Profile
        </button>

        <hr>

        <!-- Change Password -->
        <h5 class="mt-3"><i class="bi bi-key"></i> Change Password</h5>
        <form>
            <div class="mb-2">
                <input type="password" class="form-control" placeholder="Current Password" required>
            </div>
            <div class="mb-2">
                <input type="password" class="form-control" placeholder="New Password" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" placeholder="Confirm New Password" required>
            </div>
            <button type="submit" class="btn btn-success w-100"><i class="bi bi-save"></i> Update Password</button>
        </form>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel"><i class="bi bi-pencil-square"></i> Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" value="John Doe" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="johndoe@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" value="+123 456 7890" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Profile Picture</label>
                            <input type="file" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save"></i> Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
