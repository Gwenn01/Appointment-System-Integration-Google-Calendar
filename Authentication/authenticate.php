<?php
session_start();
require('../Database/database.php');

if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // User found, set session variables
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        header('Location: ../index.php');
    } else {
        // User not found, show error message
        echo "Invalid username or password";
    }
   
}
?>
