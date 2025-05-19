<?php
require_once 'php/config.php';
requireLogin();

// Fetch user's bookings
$stmt = $conn->prepare("
    SELECT b.*, r.roomName as room_name, r.image_url 
    FROM bookings b 
    JOIN rooms r ON b.room_id = r.id 
    WHERE b.user_id = ? 
    ORDER BY b.created_at DESC
");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$bookings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - SmartStay</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <header class="main-header">
        <nav>
            <div class="logo">SmartStay</div>
            <ul class="nav-links">
                <li><a href="./index.php">Home</a></li>
                <li><a href="./logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="dashboard-container">
            <h2>My Bookings</h2>

            <div class="filter-bar">
                <label for="statusFilter">Filter by Status:</label>
                <select id="statusFilter" onchange="filterBookings()">
                    <option value="all">All</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            
            <div id="bookingsContainer" class="bookings-grid">
                <!--  -->
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 SmartStay. All rights reserved.</p>
    </footer>

    <script src="./js/dashboard.js"></script>
</body>
</html>