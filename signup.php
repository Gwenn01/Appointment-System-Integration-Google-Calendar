<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Sign Up | Appointment System</title>
    <link rel="stylesheet" href="style/login.css"> <!-- Link CSS file -->
</head>
<body>

<div class="container">
    <div class="signup-card"> <!-- Updated class -->
        <h2>Create an Account</h2>
        <p class="subtitle">Join us to book appointments easily</p>

        <form action="register.php" method="POST">
            <label>Full Name</label>
            <input type="text" name="fullname" required>

            <label>Username</label>
            <input type="text" name="username" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Sign Up</button>
        </form>

        <p class="link">Already have an account? <a href="login.php">Login</a></p>
    </div>
</div>

</body>
</html>
