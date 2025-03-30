<?php
session_start();
require('../Database/database.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify hashed password
        if ($password === $user['password']) {
            $_SESSION['username'] = $username;
            $_SESSION['adminid'] = $user['id'];
            header('Location: ../admin_dashboard.php');
            exit;
        } else {
            $_SESSION['error'] = "Invalid Password";
            echo "<script>alert('Incorrt password'); window.location.href='../admin_login.php';</script>";
        }
    } else {
        $_SESSION['error'] = "Invalid Username";
        echo "<script>alert('Username not found'); window.location.href='../admin_login.php';</script>";
    }
}
?>
