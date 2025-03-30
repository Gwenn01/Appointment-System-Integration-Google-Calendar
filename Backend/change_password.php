<?php
session_start();
require(__DIR__ . '/../Database/database.php'); // Adjust path if needed

if (!isset($_SESSION['userid'])) {
    header("Location: ../login.php");
    exit();
}

$userId = $_SESSION['userid'];

// Get form inputs
$current_password = $_POST['current_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validate input
if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
    exit("All fields are required.");
}

if ($new_password !== $confirm_password) {
    exit("New password and confirm password do not match.");
}

// Fetch current password from DB
$query = "SELECT password FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $hashedPasswordFromDB);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Verify current password
if (!password_verify($current_password, $hashedPasswordFromDB)) {
    exit("Current password is incorrect.");
}

// Hash new password
$new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Update in DB
$updateQuery = "UPDATE users SET password = ? WHERE id = ?";
$updateStmt = mysqli_prepare($conn, $updateQuery);
mysqli_stmt_bind_param($updateStmt, "si", $new_hashed_password, $userId);

if (mysqli_stmt_execute($updateStmt)) {
    echo "<script>
        alert('Password updated successfully!');
        window.location.href = '../dashboard.php?page=profile';
    </script>";
} else {
    echo "<script>
        alert('Error updating password. Please try again.');
        window.location.href = '../dashboard.php?page=profile';
    </script>";
}

mysqli_stmt_close($updateStmt);
mysqli_close($conn);
?>
