<?php
session_start();  // Make sure session is started at the top

if (isset($_SESSION['error'])) {
    // Display error message with better styling
    echo '<div class="error-message">';
    echo '<p>' . $_SESSION['error'] . '</p>';
    echo '</div>';

    unset($_SESSION['error']);  // Unset the error message after displaying it
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .input-group input:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .login-btn {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-btn:hover {
            background-color: #45a049;
        }

       
        .error-message {
            background-color: #ffcccc;
            color: #d8000c;
            border: 1px solid #d8000c;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
            text-align: center;
        }

        .error-message p {
            margin: 0;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>

</body>
</html>
