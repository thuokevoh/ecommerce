<?php
session_start();
require '../includes/db_connect.php';

// Check if user is logged in and is seller or admin
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['seller', 'admin'])) {
    header("Location: login.php");
    exit;
}

// Check for product ID
if (!isset($_GET['id'])) {
    echo "Product ID missing.";
    exit;
}

$product_id = $_GET['id'];

// Fetch product data
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    echo "Product not found.";
    exit;
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    if (empty($name) || empty($price)) {
        $message = "Name and price are required.";
    } else {
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ?, updated_at = NOW() WHERE id = ?");
        if ($stmt->execute([$name, $description, $price, $stock, $product_id])) {
            $message = "Product updated successfully!";
            // Reload updated product data
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch();
        } else {
            $message = "Error updating product.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
    <div class="container">
        <h2>Edit Product</h2>
        <?php if (!empty($message)) : ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form method="post">
            <label>Name:
                <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required />
            </label>

            <label>Description:
                <textarea name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </label>

            <label>Price:
                <input type="number" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" step="0.01" required />
            </label>

            <label>Stock:
                <input type="number" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" />
            </label>

            <button type="submit">Update Product</button>
        </form>

        <p><a href="products.php">Back to Product List</a></p>
    </div>
</body>
</html>
