<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Appointment System</title>
    <link rel="stylesheet" href="style/login.css">
</head>
<body>

<div class="container">
    <div class="admin-login-card"> <!-- Updated class -->
        <h2>Admin Login</h2>
        <p class="subtitle">Sign in to manage appointments in DR. Layug's Clinic</p>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="Authentication/admin_authenticate.php" method="POST">
            <label>Admin Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit" name="submit">Login</button>
        </form>

        <p class="link"><a href="index.php">Back to Customer Login</a></p>
    </div>
</div>

</body>
</html>
