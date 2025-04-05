<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require(__DIR__ . '/../Database/database.php');

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please login to book an appointment.'); window.location.href = '../index.php';</script>";
    exit();
}

try {
    $user_id = $_SESSION['userid'];
    $slot_date = $_POST['slot_date'];
    $start_time = $_POST['start_time'];
    $service_id = $_POST['service'];
    $notes = trim($_POST['notes'] ?? '');

    // Conflict check
    $conflictQuery = "
        SELECT t.start_time
        FROM appointments a
        JOIN time_slots t ON a.time_slot_id = t.id
        WHERE t.slot_date = ? AND t.is_booked = 1
    ";
    $stmt = mysqli_prepare($conn, $conflictQuery);
    mysqli_stmt_bind_param($stmt, "s", $slot_date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['start_time'] === $start_time) {
            throw new Exception("This time slot is already booked. Please choose a different time.");
        }
    }

    // Insert booked slot
    $insertSlot = "INSERT INTO time_slots (slot_date, start_time, is_booked) VALUES (?, ?, 1)";
    $stmt = mysqli_prepare($conn, $insertSlot);
    mysqli_stmt_bind_param($stmt, "ss", $slot_date, $start_time);
    mysqli_stmt_execute($stmt);
    $time_slot_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    // Insert appointment
    $insertAppt = "INSERT INTO appointments (user_id, service_id, time_slot_id, status, notes) VALUES (?, ?, ?, 'pending', ?)";
    $stmt = mysqli_prepare($conn, $insertAppt);
    mysqli_stmt_bind_param($stmt, "iiis", $user_id, $service_id, $time_slot_id, $notes);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert(" . json_encode("Appointment booked successfully!") . "); window.location.href = '../dashboard.php?page=home';</script>";
    } else {
        throw new Exception("Failed to book appointment. Please try again.");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

} catch (Exception $e) {
    echo "<script>alert(" . json_encode($e->getMessage()) . "); window.location.href = '../dashboard.php?page=home';</script>";
    exit();
}
?>
