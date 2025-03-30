<?php
session_start();
require(__DIR__ . '/../Database/database.php'); // Adjust path if needed

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please login to book an appointment.'); window.location.href = '../index.php';</script>";
    exit();
}

$user_id = $_SESSION['userid'];
$slot_date = $_POST['slot_date'];
$slot_time = $_POST['slot_time'];
$service_name = $_POST['service'];
$notes = trim($_POST['notes'] ?? '');

// Check if the service exists
$serviceQuery = "SELECT id FROM services WHERE service_name = ?";
$stmt = mysqli_prepare($conn, $serviceQuery);
mysqli_stmt_bind_param($stmt, "s", $service_name);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $service_id);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// If service not found, stop
if (!$service_id) {
    echo "<script>alert('Invalid service selected.'); window.location.href = 'dashboard.php';</script>";
    exit();
}

// Check or insert timeslot
$checkSlot = "SELECT id, is_booked FROM time_slots WHERE slot_date = ? AND slot_time = ?";
$stmtSlot = mysqli_prepare($conn, $checkSlot);
mysqli_stmt_bind_param($stmtSlot, "ss", $slot_date, $slot_time);
mysqli_stmt_execute($stmtSlot);
mysqli_stmt_bind_result($stmtSlot, $time_slot_id, $is_booked);
mysqli_stmt_fetch($stmtSlot);
mysqli_stmt_close($stmtSlot);

// If already booked
if ($is_booked) {
    echo "<script>alert('Time slot already booked. Please choose another.'); window.location.href = 'dashboard.php';</script>";
    exit();
}

// If slot doesn't exist, insert it
if (!$time_slot_id) {
    $insertSlot = "INSERT INTO time_slots (slot_date, slot_time, is_booked) VALUES (?, ?, TRUE)";
    $stmtInsertSlot = mysqli_prepare($conn, $insertSlot);
    mysqli_stmt_bind_param($stmtInsertSlot, "ss", $slot_date, $slot_time);
    mysqli_stmt_execute($stmtInsertSlot);
    $time_slot_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmtInsertSlot);
} else {
    // Slot exists and available, mark as booked
    $updateSlot = "UPDATE time_slots SET is_booked = TRUE WHERE id = ?";
    $stmtUpdateSlot = mysqli_prepare($conn, $updateSlot);
    mysqli_stmt_bind_param($stmtUpdateSlot, "i", $time_slot_id);
    mysqli_stmt_execute($stmtUpdateSlot);
    mysqli_stmt_close($stmtUpdateSlot);
}

// Now insert appointment
$insertAppt = "INSERT INTO appointments (user_id, service_id, time_slot_id, status, notes)
               VALUES (?, ?, ?, 'pending', ?)";
$stmtAppt = mysqli_prepare($conn, $insertAppt);
mysqli_stmt_bind_param($stmtAppt, "iiis", $user_id, $service_id, $time_slot_id, $notes);
if (mysqli_stmt_execute($stmtAppt)) {
    echo "<script>alert('Appointment booked successfully!'); window.location.href = '../Dashboard/dashboard.php?page=home';</script>";
} else {
    echo "<script>alert('Failed to book appointment. Please try again.'); window.location.href = '../Dashboard/dashboard.php?page=home;</script>";
}
mysqli_stmt_close($stmtAppt);
mysqli_close($conn);
?>
