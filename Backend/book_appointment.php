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

    // Check if user already has an appointment on this date
    $dateCheckQuery = "
        SELECT a.id
        FROM appointments a
        JOIN time_slots t ON a.time_slot_id = t.id
        WHERE a.user_id = ? AND t.slot_date = ? AND a.status IN ('pending', 'confirmed')
    ";
    $stmt = mysqli_prepare($conn, $dateCheckQuery);
    mysqli_stmt_bind_param($stmt, "is", $user_id, $slot_date);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        throw new Exception("You already have an appointment scheduled on this date.");
    }
    mysqli_stmt_close($stmt);

    // Check if user already booked the same slot (prevent double booking at same time)
    $userConflictQuery = "
        SELECT a.id
        FROM appointments a
        JOIN time_slots t ON a.time_slot_id = t.id
        WHERE a.user_id = ? AND t.slot_date = ? AND t.start_time = ?
        AND a.status IN ('pending', 'confirmed')
    ";
    $stmt = mysqli_prepare($conn, $userConflictQuery);
    mysqli_stmt_bind_param($stmt, "iss", $user_id, $slot_date, $start_time);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        throw new Exception("You already have an appointment at this time.");
    }
    mysqli_stmt_close($stmt);

    // Check if the slot is already booked by someone else
    $slotConflictQuery = "SELECT id FROM time_slots WHERE slot_date = ? AND start_time = ? AND is_booked = 1";
    $stmt = mysqli_prepare($conn, $slotConflictQuery);
    mysqli_stmt_bind_param($stmt, "ss", $slot_date, $start_time);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        throw new Exception("This time slot is already taken. Please choose another.");
    }
    mysqli_stmt_close($stmt);

    // Create time slot
    $insertSlot = "INSERT INTO time_slots (slot_date, start_time, is_booked) VALUES (?, ?, 1)";
    $stmt = mysqli_prepare($conn, $insertSlot);
    mysqli_stmt_bind_param($stmt, "ss", $slot_date, $start_time);
    mysqli_stmt_execute($stmt);
    $time_slot_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    // Insert appointment
    $insertAppt = "INSERT INTO appointments (user_id, service_id, time_slot_id, status, notes)
                   VALUES (?, ?, ?, 'pending', ?)";
    $stmt = mysqli_prepare($conn, $insertAppt);
    mysqli_stmt_bind_param($stmt, "iiis", $user_id, $service_id, $time_slot_id, $notes);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert(" . json_encode("Appointment booked successfully!") . "); window.location.href = '../dashboard.php?page=home';</script>";
    } else {
        throw new Exception("Something went wrong while booking. Please try again.");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

} catch (Exception $e) {
    echo "<script>alert(" . json_encode($e->getMessage()) . "); window.location.href = '../dashboard.php?page=home';</script>";
    exit();
}
?>
