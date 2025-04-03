<?php
session_start();
require('../Database/database.php');

if (isset($_POST['submit'])) {
    try {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        if (!$stmt) {
            throw new Exception("Something went wrong. Please try again later.");
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify hashed password
            if (password_verify($password, $user['password'])) {
                // Store all user data in session
                $_SESSION['userid'] = $user['id'];
                $_SESSION['username'] = $username;
                header('Location: ../dashboard.php');
                exit;
            } else {
                $_SESSION['error'] = "Incorrect password";
            }
        } else {
            $_SESSION['error'] = "Username not found";
        }
    } catch (Exception $e) {
        // Log the actual error if needed: error_log($e->getMessage());
        $_SESSION['error_code'] = "An unexpected error occurred. Please try again.";
    }

    // Redirect back to login page with error
    header('Location: ../index.php');
    exit;
}
?>
