<?php
require_once 'config.php';
requireLogin();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$booking_id = $_POST['booking_id'] ?? null;

if (!$booking_id) {
    echo json_encode(['success' => false, 'message' => 'Booking ID is required']);
    exit();
}

// Verify the booking belongs to the current user
$stmt = $conn->prepare("
    SELECT bookingStatus 
    FROM bookings 
    WHERE id = ? AND user_id = ? AND bookingStatus = 'pending'
");
$stmt->bind_param("ii", $booking_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if (!$result->fetch_assoc()) {
    echo json_encode(['success' => false, 'message' => 'Invalid booking or already cancelled']);
    exit();
}

// Update booking status to cancelled
$stmt = $conn->prepare("UPDATE bookings SET bookingStatus = 'cancelled' WHERE id = ?");
$stmt->bind_param("i", $booking_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to cancel booking']);
}
?>