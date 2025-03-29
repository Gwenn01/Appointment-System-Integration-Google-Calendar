<?php
// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: ../login.php");
    exit();
}

// Database connection
require(__DIR__ . '/../Database/database.php');

// Fetch user info
$userId = $_SESSION['userid'];
$query = "SELECT * FROM users WHERE id = $userId";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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

    .profile-info {
      text-align: left;
      margin-top: 20px;
    }

    .profile-info p {
      font-size: 16px;
      margin: 8px 0;
    }

    .profile-info i {
      width: 24px;
    }
  </style>
</head>
<body>

<div class="profile-container">
  <h2 class="mb-3"><i class="bi bi-person-circle"></i> My Profile</h2>
  <!-- User Info -->
  <h4><?php echo htmlspecialchars($user['name']); ?></h4>

  <div class="profile-info">
    <p><i class="bi bi-envelope"></i> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><i class="bi bi-telephone"></i> <?php echo htmlspecialchars($user['phone_number']); ?></p>
    <p><i class="bi bi-gender-ambiguous"></i> <?php echo htmlspecialchars($user['gender']); ?></p>
    <p><i class="bi bi-calendar-event"></i> <?php echo htmlspecialchars($user['date_of_birth']); ?></p>
    <p><i class="bi bi-house-door"></i> <?php echo htmlspecialchars($user['address']); ?></p>
  </div>

  <!-- Edit Profile Button -->
  <button class="edit-profile-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">
    <i class="bi bi-pencil"></i> Edit Profile
  </button>

  <hr>

  <!-- Change Password -->
  <h5><i class="bi bi-key"></i> Change Password</h5>
  <form method="POST" action="ProcessData/change_password.php">
    <div class="mb-2">
      <input type="password" name="current_password" class="form-control" placeholder="Current Password" required>
    </div>
    <div class="mb-2">
      <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
    </div>
    <div class="mb-3">
      <input type="password" name="confirm_password" class="form-control" placeholder="Confirm New Password" required>
    </div>
    <button type="submit" class="btn btn-success w-100"><i class="bi bi-save"></i> Update Password</button>
  </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="ProcessData/update_profile.php">
        <div class="modal-header">
          <h5 class="modal-title" id="editProfileModalLabel"><i class="bi bi-pencil"></i> Edit Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">
          <!-- Hidden ID -->
          <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

          <div class="mb-3">
            <label>Full Name</label>
            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
          </div>

          <div class="mb-3">
            <label>Phone Number</label>
            <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
          </div>

          <div class="mb-3">
            <label>Gender</label>
            <select class="form-control" name="gender" required>
              <option value="male" <?php if ($user['gender'] == 'male') echo 'selected'; ?>>Male</option>
              <option value="female" <?php if ($user['gender'] == 'female') echo 'selected'; ?>>Female</option>
              <option value="other" <?php if ($user['gender'] == 'other') echo 'selected'; ?>>Other</option>
            </select>
          </div>

          <div class="mb-3">
            <label>Birthday</label>
            <input type="date" class="form-control" name="birthday" value="<?php echo $user['date_of_birth']; ?>" required>
          </div>

          <div class="mb-3">
            <label>Address</label>
            <textarea class="form-control" name="address" rows="2" required><?php echo htmlspecialchars($user['address']); ?></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
