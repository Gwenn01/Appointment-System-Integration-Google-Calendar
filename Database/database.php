<?php
    $host = 'localhost:3307';
    $username = 'root';
    $password = 'gwen123';
    $database = 'db_appointment_system';

    // Force all inputs to be strings
    $conn = mysqli_connect($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        echo "Connected successfully";
    }
?>
