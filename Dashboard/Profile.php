<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Appointment System</title>
    <link rel="stylesheet" href="style/profile.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid #007bff;
            margin-bottom: 15px;
        }

        .edit-profile-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-profile-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="profile-container">
        <h2 class="mb-3"><i class="bi bi-person-circle"></i> My Profile</h2>

        <!-- Profile Picture -->
        <img src="https://via.placeholder.com/120" alt="Profile Picture" class="profile-picture">

        <!-- User Info -->
        <h4>John Doe</h4>
        <p class="text-muted"><i class="bi bi-envelope"></i> johndoe@example.com</p>
        <p class="text-muted"><i class="bi bi-telephone"></i> +123 456 7890</p>

        <!-- Edit Profile Button -->
        <button class="edit-profile-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <i class="bi bi-pencil"></i> Edit Profile
        </button>

        <hr>

        <!-- Change Password -->
        <h5><i class="bi bi-key"></i> Change Password</h5>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
