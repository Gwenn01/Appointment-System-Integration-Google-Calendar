<?php
require(__DIR__ . '/../Database/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentId = $_POST['id'];
    $newStatus = $_POST['status'];

    $stmt = mysqli_prepare($conn, "UPDATE appointments SET status = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $newStatus, $appointmentId);
    mysqli_stmt_execute($stmt);
}

echo "<script>alert('update status successfully!'); window.location.href = '../admin_dashboard.php';</script>";
exit();
