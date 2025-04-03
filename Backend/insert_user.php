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
    $verify_token = bin2hex(random_bytes(16)); // secure random token

    try {
        $sql = "INSERT INTO users (username, name, phone_number, email, password, gender, date_of_birth, address)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $username, $name, $phone_number, $email, $hashed_password, $gender, $birthday, $address);
        $stmt->execute();

        echo "<script>
            alert('Registered successfully!');
            window.location.href = '../index.php';
        </script>";

    } catch (mysqli_sql_exception $e) {
        // Handle duplicate entry error (error code 1062)
        if ($e->getCode() === 1062) {
            $errorMessage = "Duplicate entry detected!";
            if (strpos($e->getMessage(), 'phone_number') !== false) {
                $errorMessage = "Phone number already exists!";
            } elseif (strpos($e->getMessage(), 'username') !== false) {
                $errorMessage = "Username already taken!";
            } elseif (strpos($e->getMessage(), 'email') !== false) {
                $errorMessage = "Email already registered!";
            }

            echo "<script>
                alert('$errorMessage');
                window.location.href = '../signup.php';
            </script>";
        } else {
            // Other DB error
            echo "Database error: " . $e->getMessage();
        }
    }
}
?>
