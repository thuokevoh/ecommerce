<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['user_id']) || !in_array('customer', $_SESSION['roles'])) {
    header("Location: ../public/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> (Customer)!</h2>
        <p>This is your Customer Dashboard.</p>

        <ul>
            <li>🛒 View My Orders</li>
            <li>❤️ Wishlist (coming soon)</li>
            <li>🔒 Update Profile</li>
        </ul>

        <p><a href="../public/logout.php">🚪 Logout</a></p>
    </div>
</body>
</html>
