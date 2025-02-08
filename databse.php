<?php 
$host = 'localhost';
$username = 'gwen';
$password = '123';
$database = "appointment_db";

$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>