
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

  // Check if the email already exists
  $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
  $stmt->execute([$email]);
  if ($stmt->fetch()) {
    echo "Email already registered.";
    exit;
  }

  // Hash the password securely
  $passwordHash = password_hash($password, PASSWORD_DEFAULT);

  // Insert the new user
  $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash, role, created_at) VALUES (?, ?, ?, ?, NOW())');
  if ($stmt->execute([$username, $email, $passwordHash, 'customer'])) {
    echo "Registration successful! You can now <a href='login.php'>log in</a>.";
  } else {
    echo "Error registering user.";
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
