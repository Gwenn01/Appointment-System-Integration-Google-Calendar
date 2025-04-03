<?php
session_start();
require('../Database/database.php');

if (isset($_POST['submit'])) {
    try {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
        if (!$stmt) {
            throw new Exception("Something went wrong. Please try again later.");
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify password (plain text comparison here; recommend using password hashing)
            if ($password === $user['password']) {
                $_SESSION['username'] = $username;
                $_SESSION['adminid'] = $user['id'];
                header('Location: ../admin_dashboard.php');
                exit;
            } else {
                $_SESSION['error'] = "Incorrect password";
            }
        } else {
            $_SESSION['error'] = "Username not found";
        }
    } catch (Exception $e) {
        // Optional: Log the actual error for debugging
        // error_log($e->getMessage());
        $_SESSION['error_code'] = "An unexpected error occurred. Please try again.";
    }

    // Redirect back with error
    header('Location: ../admin_login.php');
    exit;
}
?>
