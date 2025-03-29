<?php
if (isset($_POST['submit'])) {

    require_once('../Database/database.php');

    $name = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, name, phone_number, email, password, gender, date_of_birth, address)
            VALUES ('$username', '$name', '$phone_number', '$email', '$hashed_password', '$gender', '$birthday', '$address')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>
            alert('You registered successfully');
            window.location.href = '../index.php'; 
        </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "No data submitted.";
}
?>
