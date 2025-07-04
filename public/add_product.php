<?php
session_start();
require '../includes/db_connect.php';

// Allow only logged-in users with admin role to add products
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];

    if (empty($name) || empty($price)) {
        $message = "Name and price are required.";
    } else {
        $image = ''; // we’ll handle image upload later
        $stmt = $pdo->prepare('INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)');
        if ($stmt->execute([$name, $description, $price, $image])) {
            $message = "Product added successfully!";
        } else {
            $message = "Error adding product.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add Product</title>
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
    <div class="container">
        <h2>Add Product</h2>
        <?php if (!empty($message)) : ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form action="add_product.php" method="post">
            <label>Product Name:
                <input type="text" name="name" required />
            </label>

            <label>Description:
                <textarea name="description"></textarea>
            </label>

            <label>Price:
                <input type="number" name="price" step="0.01" required />
            </label>

            <button type="submit">Add Product</button>
        </form>
    </div>
</body>
</html>
