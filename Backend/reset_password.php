<?php
session_start();
require(__DIR__ . '/../Database/database.php');

// Step 2: Validate token
if (!isset($_GET['token']) || $_GET['token'] !== ($_SESSION['reset_token'] ?? null)) {
    echo "<script>alert('Invalid or expired token'); window.location.href='forgot_password.php';</script>";
    exit;
}

$email = $_SESSION['reset_email'];

// Step 3: Handle Password Reset
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPass = $_POST['new_password'];
    $confirmPass = $_POST['confirm_password'];

    if ($newPass !== $confirmPass) {
        $error = "Passwords do not match.";
    } else {
        $hashed = password_hash($newPass, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed, $email);
        $stmt->execute();
        $stmt->close();

        // Clear session reset data
        unset($_SESSION['reset_token'], $_SESSION['reset_email']);
        echo "<script>alert('Password has been reset!'); window.location.href='../index.php';</script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 500px;">
    <h3 class="mb-3 text-center">Reset Your Password</h3>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <button class="btn btn-success w-100">Reset Password</button>
    </form>
</div>
</body>
</html>
