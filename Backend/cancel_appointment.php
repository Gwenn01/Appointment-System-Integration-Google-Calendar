<?php
session_start();
require(__DIR__ . '/../Database/database.php');

if (isset($_POST['appointment_id']) && isset($_SESSION['userid'])) {
    $appt_id = $_POST['appointment_id'];
    $user_id = $_SESSION['userid'];

    // Make sure this user owns the appointment
    $stmt = mysqli_prepare($conn, "UPDATE appointments SET status = 'cancelled' WHERE id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $appt_id, $user_id);
    mysqli_stmt_execute($stmt);
}

echo "<script>alert('Appointment cancel successfully!'); window.location.href = '../dashboard.php';</script>";
exit();
