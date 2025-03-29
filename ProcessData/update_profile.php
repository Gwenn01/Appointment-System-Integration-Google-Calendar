<?php
session_start();
require(__DIR__ . '/../Database/database.php'); // adjust if needed

if (!isset($_SESSION['userid'])) {
    header("Location: ../login.php");
    exit();
}

$userId = $_SESSION['userid'];

// Get form inputs and sanitize
$name     = trim($_POST['name'] ?? '');
$phone    = trim($_POST['phone'] ?? '');
$gender   = trim($_POST['gender'] ?? '');
$birthday = trim($_POST['birthday'] ?? '');
$address  = trim($_POST['address'] ?? '');

// Validate required fields
if (empty($name) || empty($phone) || empty($gender) || empty($birthday) || empty($address)) {
    echo "<script>
        alert('All fields are required.');
        window.location.href = 'profile.php';
    </script>";
    exit();
}

// Update query
$query = "UPDATE users 
          SET name = ?, phone_number = ?, gender = ?, date_of_birth = ?, address = ?
          WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    echo "<script>
        alert('Database error. Please try again later.');
        window.location.href = '../dashboard.php?page=profile';
    </script>";
    exit();
}

mysqli_stmt_bind_param($stmt, "sssssi", $name, $phone, $gender, $birthday, $address, $userId);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>
        alert('Profile updated successfully!');
        window.location.href = '../dashboard.php?page=profile';
    </script>";
} else {
    echo "<script>
        alert('Something went wrong. Please try again.');
        window.location.href = '../dashboard.php?page=profile';
    </script>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
