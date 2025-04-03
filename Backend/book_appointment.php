<?php
session_start();
require(__DIR__ . '/../Database/database.php');

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please login to book an appointment.'); window.location.href = '../index.php';</script>";
    exit();
}

try {
    $user_id = $_SESSION['userid'];
    $slot_date = $_POST['slot_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $service_name = $_POST['service'];
    $notes = trim($_POST['notes'] ?? '');

    // Validate input: start_time must be before end_time
    if ($start_time >= $end_time) {
        throw new Exception("End time must be after start time.");
    }

    // Check if the service exists
    $serviceQuery = "SELECT id FROM services WHERE service_name = ?";
    $stmt = mysqli_prepare($conn, $serviceQuery);
    if (!$stmt) throw new Exception("Service validation failed.");
    mysqli_stmt_bind_param($stmt, "s", $service_name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $service_id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (!$service_id) {
        throw new Exception("Invalid service selected.");
    }

    // Check for time conflict
    $conflictQuery = "
        SELECT COUNT(*) FROM time_slots 
        WHERE slot_date = ? AND is_booked = TRUE 
        AND (? < end_time AND ? > start_time)";
    $stmtConflict = mysqli_prepare($conn, $conflictQuery);
    if (!$stmtConflict) throw new Exception("Slot validation failed.");
    mysqli_stmt_bind_param($stmtConflict, "sss", $slot_date, $start_time, $end_time);
    mysqli_stmt_execute($stmtConflict);
    mysqli_stmt_bind_result($stmtConflict, $conflict_count);
    mysqli_stmt_fetch($stmtConflict);
    mysqli_stmt_close($stmtConflict);

    if ($conflict_count > 0) {
        throw new Exception("The selected time slot conflicts with an existing appointment. Please choose a different time.");
    }

    // Insert new slot as booked
    $insertSlot = "INSERT INTO time_slots (slot_date, start_time, end_time, is_booked) VALUES (?, ?, ?, TRUE)";
    $stmtInsertSlot = mysqli_prepare($conn, $insertSlot);
    if (!$stmtInsertSlot) throw new Exception("Failed to create timeslot.");
    mysqli_stmt_bind_param($stmtInsertSlot, "sss", $slot_date, $start_time, $end_time);
    mysqli_stmt_execute($stmtInsertSlot);
    $time_slot_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmtInsertSlot);

    // Insert appointment
    $insertAppt = "INSERT INTO appointments (user_id, service_id, time_slot_id, status, notes)
                   VALUES (?, ?, ?, 'pending', ?)";
    $stmtAppt = mysqli_prepare($conn, $insertAppt);
    if (!$stmtAppt) throw new Exception("Failed to prepare appointment request.");
    mysqli_stmt_bind_param($stmtAppt, "iiis", $user_id, $service_id, $time_slot_id, $notes);

    if (mysqli_stmt_execute($stmtAppt)) {
        echo "<script>alert('Appointment booked successfully!'); window.location.href = '../dashboard.php?page=home';</script>";
    } else {
        throw new Exception("Failed to book appointment. Please try again.");
    }

    mysqli_stmt_close($stmtAppt);
    mysqli_close($conn);

} catch (Exception $e) {
    $friendlyMessage = $e->getMessage();
    echo "<script>alert('$friendlyMessage'); window.location.href = '../dashboard.php?page=home';</script>";
    exit();
}
?>
