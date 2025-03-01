<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login | Appointment System</title>
    <link rel="stylesheet" href="style/login.css">
</head>
<body>

<div class="container">
    <div class="login-card"> <!-- Updated class -->
        <h2>Customer Login</h2>
        <p class="subtitle">Sign in to book your appointment</p>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="authenticate.php" method="POST">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <p class="link">Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>
</div>

</body>
</html>
