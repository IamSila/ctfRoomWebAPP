<?php
// register.php
session_start();
require 'includes/config.php'; // Database configuration

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate inputs
    if ($password !== $confirmPassword) {
        $error = "Passwords do not match";
    } else {
        // Check if username exists
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Username already exists";
        } else {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashedPassword);

            if ($stmt->execute()) {
                $success = "Registration successful! Please login.";
                header("Refresh: 3; url=login.php");
            } else {
                $error = "Registration failed: " . $conn->error;
            }
            $stmt->close();
        }
        $check->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="src/css/register.css">
</head>
<body>
    <section class="section-1">
        <div class="container-register">
            <h1>Register</h1>
            
            <?php if ($error): ?>
                <center><h4 style="color: firebrick"><?php echo htmlspecialchars($error); ?></h4></center>
            <?php elseif ($success): ?>
                <center><h4 style="color: green"><?php echo htmlspecialchars($success); ?></h4></center>
            <?php endif; ?>
            
            <p>Welcome! Register with your details</p>

            <form action="" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); ?>">

                <label for="username">Username</label>
                <input type="text" name="username" placeholder="a12-3322-1990" required>

                <label for="password">Password:</label>
                <input type="password" name="password" placeholder="password" required>

                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" name="confirmPassword" placeholder="confirm password" required>

                <div class="register-btn">
                    <button type="submit">REGISTER</button>
                </div>
            </form>

            <div class="login-footer">
                <p>Have an Account? <a href="login.php">Login</a></p>
                <a href="forgot_password.php">Forgot Your password?</a>
            </div>
        </div>
    </section>
</body>
</html>
