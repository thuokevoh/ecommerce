<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['user_id']) || !in_array('admin', $_SESSION['roles'])) {
    header("Location: ../public/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> (Admin)!</h2>
        <p>This is your Admin Dashboard.</p>

        <ul>
            <li>👥 Manage Users</li>
            <li>📦 Review All Products</li>
            <li>📈 Site Analytics (coming soon)</li>
        </ul>

        <p><a href="../public/logout.php">🚪 Logout</a></p>
    </div>
</body>
</html>
