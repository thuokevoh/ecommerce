<?php
session_start();
require '../includes/db_connect.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $message = "Please enter both email and password.";
    } else {
        // Fetch user by email
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Fetch ALL roles for this user from user_roles
            $stmt = $pdo->prepare("
                SELECT r.name 
                FROM user_roles ur
                JOIN roles r ON ur.role_id = r.id
                WHERE ur.user_id = ?
            ");
            $stmt->execute([$user['id']]);
            $roles = $stmt->fetchAll(PDO::FETCH_COLUMN);

            // Save array of roles into session
            $_SESSION['roles'] = $roles;

            // Redirect based on first matching dashboard
            if (in_array('admin', $roles)) {
                header("Location: ../admin/dashboard.php");
            } elseif (in_array('seller', $roles)) {
                header("Location: ../seller/dashboard.php");
            } elseif (in_array('customer', $roles)) {
                header("Location: ../customer/dashboard.php");
            } else {
                echo "You have no roles assigned.";
                exit;
            }
            exit;
        } else {
            $message = "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($message)) : ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <label>Email:
                <input type="email" name="email" required />
            </label>
            <label>Password:
                <input type="password" name="password" required />
            </label>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
