<?php
$host = 'localhost';       // Your database host (usually localhost)
$db   = 'ecommerce_db';    // Your database name
$user = 'root';            // Your database user (default for XAMPP is root)
$pass = 'maestro';                // Your database password (default is empty in XAMPP)
$charset = 'utf8mb4';      // Character set

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    // Create a PDO instance (connect to the database)
    $pdo = new PDO($dsn, $user, $pass);

    // Set error mode to exceptions for debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If connection fails, display the error message and stop
    die("Database connection failed: " . $e->getMessage());
}
?>
