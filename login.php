<?php
require_once 'php/config.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['userPassword'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please fill all the required fields';
    } else {
        $stmt = $conn->prepare("SELECT id, userPassword FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($user = $result->fetch_assoc()) {
            if (hash('sha256', $password) === $user['userPassword']) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: /dashboard.php');
                exit();
            }
        }
        $error = 'Invalid email or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartStay</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <header class="main-header">
        <nav>
            <div class="logo">SmartStay</div>
            <ul class="nav-links">
                <li><a href="./index.php">Home</a></li>
                <li><a href="./register.php">Register</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="auth-container">
            <h2>Login to SmartStay</h2>
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form id="loginForm" method="POST" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="userPassword" required>
                </div>
                <button type="submit" class="btn-primary">Login</button>
            </form>
            <p class="auth-link">Don't have an account? <a href="./register.php">Register here</a></p>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 SmartStay. All rights reserved.</p>
    </footer>

    <script src="/js/validator.js"></script>
</body>
</html>