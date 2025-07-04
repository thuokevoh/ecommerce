<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($password)) {
        echo "Please fill all fields.";
        exit;
    }

    // Check if email already exists
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo "Email already registered.";
        exit;
    }

    // Hash the password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $pdo->beginTransaction();

        // Insert the user
        $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash, created_at) VALUES (?, ?, ?, NOW())');
        $stmt->execute([$username, $email, $passwordHash]);

        $userId = $pdo->lastInsertId();

        // Find the role_id for "customer"
        $stmt = $pdo->prepare('SELECT id FROM roles WHERE name = ?');
        $stmt->execute(['customer']);
        $role = $stmt->fetch();

        if (!$role) {
            throw new Exception("Default role not found!");
        }

        $roleId = $role['id'];

        // Insert into user_roles
        $stmt = $pdo->prepare('INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)');
        $stmt->execute([$userId, $roleId]);

        $pdo->commit();

        echo "Registration successful! You can now <a href='login.php'>log in</a>.";

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error registering user: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Register - E-commerce</title>
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
    <div class="container">
        <h2>Create Your Account</h2>
        <form action="register.php" method="post">
            <label>Username:<br />
                <input type="text" name="username" required />
            </label>

            <label>Email:<br />
                <input type="email" name="email" required />
            </label>

            <label>Password:<br />
                <input type="password" name="password" required />
            </label>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
