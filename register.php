<?php
require_once 'php/config.php';

if (isLoggedIn()) {
    header('Location: /dashboard.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['userPassword'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'Please fill in all fields';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        $hashed_password = hash('sha256', $password);
        
        $stmt = $conn->prepare("INSERT INTO users (username, email, userPassword) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            header('Location: /smartstay/dashboard.php');
            exit();
        } else {
            $error = 'Registration failed. Email or username might already exist.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SmartStay</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <header class="main-header">
        <nav>
            <div class="logo">SmartStay</div>
            <ul class="nav-links">
                <li><a href="./index.php">Home</a></li>
                <li><a href="./login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="auth-container">
            <h2>Create an Account</h2>
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form id="registerForm" method="POST" onsubmit="return validateRegistration()">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="userPassword">Password</label>
                    <input type="password" id="password" name="userPassword" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn-primary">Register</button>
            </form>
            <p class="auth-link">Already have an account? <a href="./login.php">Login here</a></p>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 SmartStay. All rights reserved.</p>
    </footer>

    <script src="./js/validator.js"></script>
</body>
</html>