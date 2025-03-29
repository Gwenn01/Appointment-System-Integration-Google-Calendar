<?php
session_start();
session_destroy(); // Ends the session

echo "<script>
    alert('You have been logged out successfully!');
    window.location.href = '../index.php'; // Adjust to your login page path
</script>";
exit;
?>
