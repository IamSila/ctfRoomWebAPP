<?php
session_start();
require 'includes/config.php'; // Database configuration

// Initialize error message
$error = '';

// Generate CSRF token if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Invalid form submission. Please try again.";
    } else {
        // Proceed with login validation
        $username = $conn->real_escape_string($_POST['username']);
        $password = $_POST['password'];
        
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                // Regenerate session ID for security
                session_regenerate_id(true);
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid username or password";
            }
        } else {
            $error = "Invalid username or password";
        }
        $stmt->close();
    }
    
    // Regenerate CSRF token after form submission
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="src/css/login.css">
</head>
<body>
    <section class="section-1">
        <div class="container-login">
            <h1>Login</h1>
            <?php if ($error): ?>
                <center><h4 style="color: firebrick;"><?= htmlspecialchars($error) ?></h4></center>
            <?php endif; ?>
            <p>Welcome! Login to access all features</p>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <button type="submit">LOGIN</button>
            </form>
            <div class="login-footer">
                <p>Not a user? <a href="register.php">Sign Up</a></p>
                <a href="forgot_password.php">Forgot password?</a>
            </div>
        </div>
    </section>
</body>
</html>

