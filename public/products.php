<?php
session_start();
require '../includes/db_connect.php';

// Fetch all products from database ordered by newest first
$stmt = $pdo->query('SELECT * FROM products ORDER BY created_at DESC');
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Products</title>
    <link rel="stylesheet" href="../assets/style.css" />
    <style>
        .product-item {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Product List</h2>

        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <div class="product-item">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <strong>Price: $<?php echo htmlspecialchars($product['price']); ?></strong>
                    <br>

                    <!-- Always show edit link -->
                    <a href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>

                    <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['seller', 'admin'])): ?>
                        |
                        <!-- NEW: Delete link -->
                        <a href="delete_product.php?id=<?php echo $product['id']; ?>"
                           onclick="return confirm('Are you sure you want to delete this product?');">
                           Delete
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
