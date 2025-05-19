<?php
require_once 'config.php';
requireLogin();

$status = $_POST['status'] ?? 'all';
$userId = $_SESSION['user_id'];

$sql = "
    SELECT b.*, r.roomName as room_name, r.image_url 
    FROM bookings b 
    JOIN rooms r ON b.room_id = r.id 
    WHERE b.user_id = ?
";

if ($status !== 'all') {
    $sql .= " AND b.bookingStatus = ?";
}

$sql .= " ORDER BY b.created_at DESC";

$stmt = $conn->prepare($sql);
if ($status !== 'all') {
    $stmt->bind_param("is", $userId, $status);
} else {
    $stmt->bind_param("i", $userId);
}
$stmt->execute();
$results = $stmt->get_result();

$bookings = [];
while ($row = $results->fetch_assoc()) {
    $bookings[] = $row;
}

echo json_encode(['success' => true, 'bookings' => $bookings]);
?>
