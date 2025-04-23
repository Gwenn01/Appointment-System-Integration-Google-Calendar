<?php
session_start();
require(__DIR__ . '/../Database/database.php');

if (isset($_POST['appointment_id']) && isset($_SESSION['userid'])) {
    $appt_id = $_POST['appointment_id'];
    $user_id = $_SESSION['userid'];

    // Check the appointment time
    $query = "
        SELECT t.slot_date, t.start_time
        FROM appointments a
        JOIN time_slots t ON a.time_slot_id = t.id
        WHERE a.id = ? AND a.user_id = ? AND a.status != 'cancelled'
    ";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $appt_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $apptDateTime = new DateTime($row['slot_date'] . ' ' . $row['start_time']);
        $now = new DateTime();

        $diff = $apptDateTime->getTimestamp() - $now->getTimestamp();

        if ($diff <= 3600) { // 3600 seconds = 1 hour
            echo "<script>alert('You can no longer cancel this appointment because it is less than 1 hour away.'); window.location.href = '../dashboard.php?page=home';</script>";
            exit();
        }

        // Proceed to cancel
        $stmtCancel = mysqli_prepare($conn, "UPDATE appointments SET status = 'cancelled' WHERE id = ? AND user_id = ?");
        mysqli_stmt_bind_param($stmtCancel, "ii", $appt_id, $user_id);
        mysqli_stmt_execute($stmtCancel);
        mysqli_stmt_close($stmtCancel);

        echo "<script>alert('Appointment cancelled successfully!'); window.location.href = '../dashboard.php?page=home';</script>";
        exit();
    }

    mysqli_stmt_close($stmt);
}

// Fallback
echo "<script>alert('Invalid cancellation request.'); window.location.href = '../dashboard.php?page=home';</script>";
exit();
