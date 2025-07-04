<?php
session_start();
require '../includes/db_connect.php';

// Only allow logged-in sellers or admins
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['seller', 'admin'])) {
    header("Location: login.php");
    exit;
}

// Check if an ID was passed
if (!isset($_GET['id'])) {
    echo "No product ID provided.";
    exit;
}

$productId = (int) $_GET['id'];

// OPTIONAL: Check that this product belongs to the current seller (for sellers only)
if ($_SESSION['role'] === 'seller') {
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ? AND seller_id = ?');
    $stmt->execute([$productId, $_SESSION['user_id']]);
    $product = $stmt->fetch();

    if (!$product) {
        echo "Product not found or you don’t have permission to delete it.";
        exit;
    }
}

// Delete product
$stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
$stmt->execute([$productId]);

header("Location: products.php");
exit;
