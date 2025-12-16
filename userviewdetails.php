<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/includes/db.php'; 

$booking_id = intval($_GET['id'] ?? 0);
$user_id = intval($_SESSION['user_id']);

$sql = "SELECT b.*, c.car_name, c.car_model, c.image, c.price_day 
        FROM bookings b 
        LEFT JOIN cars c ON b.car_id = c.id 
        WHERE b.id = ? AND b.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    die("Booking not found or you don't have permission.");
}

$start = new DateTime($booking['start_date']);
$end = new DateTime($booking['end_date']);
$days = $end->diff($start)->days + 1;
$total_amount = $days * $booking['price_day'];
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Details</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f0f0f0; padding:20px; }
        .card { max-width:500px; margin:auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,.15); }
        img { width:100%; height:250px; object-fit:contain; border-radius:6px; }
        h2 { margin-top:0; }
        p { margin:6px 0; }
    </style>
</head>
<body>
    <div class="card">
        <h2><?php echo htmlspecialchars($booking['car_name']); ?> (<?php echo htmlspecialchars($booking['car_model']); ?>)</h2>
        <img src="<?php echo htmlspecialchars($booking['image'] ?: 'images/default-car.png'); ?>" alt="car">
        <p><strong>From:</strong> <?php echo htmlspecialchars($booking['start_date']); ?></p>
        <p><strong>To:</strong> <?php echo htmlspecialchars($booking['end_date']); ?></p>
        <p><strong>Total Amount:</strong> ₹<?php echo htmlspecialchars($total_amount); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($booking['status']); ?></p>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($booking['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($booking['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($booking['phone']); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($booking['location']); ?></p>
        <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($booking['payment_method']); ?></p>
        <p><strong>Booked on:</strong> <?php echo htmlspecialchars($booking['created_at']); ?></p>
        <p><a href="userdetails.php">Back to My Bookings</a></p>
    </div>
</body>
</html>
