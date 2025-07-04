<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['user_id']) || !in_array('seller', $_SESSION['roles'])) {
    header("Location: ../public/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> (Seller)!</h2>
        <p>This is your Seller Dashboard.</p>

        <ul>
            <li><a href="../public/add_product.php">Add Product</a></li>
            <li><a href="../public/products.php">View All Products</a></li>
            <li><a href="../public/edit_product.php">Edit Products</a></li>
        </ul>

        <p><a href="../public/logout.php">Logout</a></p>
    </div>
</body>
</html>
