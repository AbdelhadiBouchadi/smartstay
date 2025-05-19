<?php
require_once 'php/config.php';

// Fetch available rooms
$sql = "SELECT * FROM rooms WHERE is_available = true";
$result = $conn->query($sql);
$rooms = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartStay - Luxury Room Booking</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <header class="main-header">
        <nav>
            <div class="logo">SmartStay</div>
            <ul class="nav-links">
                <li><a href="./index.php">Home</a></li>
                <?php if (isLoggedIn()): ?>
                    <li><a href="./dashboard.php">My Bookings</a></li>
                    <li><a href="./logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="./login.php">Login</a></li>
                    <li><a href="./register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h1>Welcome to <span class="logo-secondary">
                SmartStay
            </span></h1>
            <p>Discover our luxurious rooms and book your perfect stay</p>
        </section>

        <section class="rooms-grid">
            <?php foreach ($rooms as $room): ?>
            <div class="room-card">
                <img src="<?php echo htmlspecialchars($room['image_url']); ?>" alt="<?php echo htmlspecialchars($room['roomName']); ?>">
                <div class="room-info">
                    <h3><?php echo htmlspecialchars($room['roomName']); ?></h3>
                    <p><?php echo htmlspecialchars($room['roomDescription']); ?></p>
                    <p class="price">$<?php echo number_format($room['price'], 2); ?> per night</p>
                    <a href="/smartstay/book.php?room_id=<?php echo $room['id']; ?>" class="btn-book">Book Now</a>
                </div>
            </div>
            <?php endforeach; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 SmartStay. All rights reserved.</p>
    </footer>

    <script src="/js/script.js"></script>
</body>
</html>