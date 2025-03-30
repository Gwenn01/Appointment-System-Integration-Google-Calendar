<?php
require(__DIR__ . '/../Database/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $type = $_POST['type'];

    if ($type === 'appointment') {
        $stmt = mysqli_prepare($conn, "UPDATE appointments SET status = 'cancelled' WHERE id = ?");
    } elseif ($type === 'registration') {
        $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

echo "<script>alert('reject successfully!'); window.location.href = '../admin_dashboard.php';</script>";
exit();
