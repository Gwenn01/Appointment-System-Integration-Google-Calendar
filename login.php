<?php
session_start();  // Start the session at the beginning

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('databse.php');  // Make sure the database connection is correct
    // Get the values from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $result = $conn->query("SELECT username, password FROM users");

    // Check if the username exists
    $loginSuccess = false;  // Variable to track if login is successful

    if ($result->num_rows > 0) {
        // Fetch the result as an associative array
        while ($row = $result->fetch_assoc()) {
            if ($row['username'] == $username && $row['password'] == $password) {
                $loginSuccess = true;  // Successful login
                break;  // Exit the loop if login is successful
            }
        }
    }

    if ($loginSuccess) {
        header("Location: dashboard.php");  // Redirect to dashboard.php
        exit();
    } else {
        $_SESSION['error'] = "Invalid username or password";  // Set the error message
        header("Location: index.php");  // Redirect back to login page
        exit();
    }
}
?>
