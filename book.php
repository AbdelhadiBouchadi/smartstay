<?php
require_once 'php/config.php';
requireLogin();

$room_id = $_GET['room_id'] ?? null;
$error = '';
$success = '';

if (!$room_id) {
    header('Location: /');
    exit();
}

// Fetch room details
$stmt = $conn->prepare("SELECT * FROM rooms WHERE id = ?");
$stmt->bind_param("i", $room_id);
$stmt->execute();
$room = $stmt->get_result()->fetch_assoc();

if (!$room) {
    header('Location: ./smartstay/dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $check_in = $_POST['check_in'] ?? '';
    $check_out = $_POST['check_out'] ?? '';
    
    if (empty($check_in) || empty($check_out)) {
        $error = 'Please select check-in and check-out dates';
    } else {
        $check_in_date = new DateTime($check_in);
        $check_out_date = new DateTime($check_out);
        $nights = $check_in_date->diff($check_out_date)->days;
        $total_price = $room['price'] * $nights;

        $stmt = $conn->prepare("INSERT INTO bookings (user_id, room_id, check_in, check_out, total_price) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iissd", $_SESSION['user_id'], $room_id, $check_in, $check_out, $total_price);
        
        if ($stmt->execute()) {
            $success = 'Booking successful! View your bookings in the dashboard.';
        } else {
            $error = 'Booking failed. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room - SmartStay</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <header class="main-header">
        <nav>
            <div class="logo">SmartStay</div>
            <ul class="nav-links">
                <li><a href="./index.php">Home</a></li>
                <li><a href="./dashboard.php">My Bookings</a></li>
                <li><a href="./logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="booking-container">
            <div class="room-card">
                <img src="<?php echo htmlspecialchars($room['image_url']); ?>" alt="<?php echo htmlspecialchars($room['roomName']); ?>">
                <h2><?php echo htmlspecialchars($room['roomName']); ?></h2>
                <p><?php echo htmlspecialchars($room['roomDescription']); ?></p>
                <p class="price">$<?php echo number_format($room['price'], 2); ?> per night</p>
            </div>

            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form id="bookingForm" method="POST" onsubmit="return validateBooking()">
                <div class="form-group">
                    <label for="check_in">Check-in Date</label>
                    <input type="date" id="check_in" name="check_in" required min="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="form-group">
                    <label for="check_out">Check-out Date</label>
                    <input type="date" id="check_out" name="check_out" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                </div>
                
                <button type="submit" class="btn-primary">Book Now</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 SmartStay. All rights reserved.</p>
    </footer>

    <script src="/js/booking.js"></script>
</body>
</html>