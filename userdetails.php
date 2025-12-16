<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/includes/db.php'; 

$user_id = intval($_SESSION['user_id']);

try {
} catch (Exception $e) {
}

$sql = "SELECT b.id AS booking_id, b.start_date, b.end_date, b.status, b.created_at, b.name AS user_name, b.email AS user_email, b.phone AS user_phone, b.location, b.payment_method,
               c.id AS car_id, c.car_name AS car_name, c.car_model AS car_model, c.image AS car_image, c.price_hour, c.price_day
        FROM bookings b
        LEFT JOIN cars c ON b.car_id = c.id
        WHERE b.user_id = ?
        ORDER BY b.created_at DESC";


$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); $stmt->execute();
$bookings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>My Bookings</title>
  <link rel="stylesheet" href="css/userdetils.css"> 
  <style>
    body { font-family: Arial, sans-serif; background:#b3d1f0; }
    .container { max-width:1100px; margin:30px auto; padding:10px; }
    .booking-grid { display:flex; flex-wrap:wrap; gap:18px; }
    .card { width:300px; background:#fff; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,.12); padding:12px; }
    .card img { width:100%; height:160px; object-fit:contain; background:#f7f7f7; border-radius:6px; }
    .muted { color:#666; font-size:14px; }
    .actions a{ text-decoration:none; color:#0a58ca; margin-right:8px; }
  </style>
</head>
<body>
  <div class="container">
    <div class="header-container">
            <h2>Your Bookings</h2>
            <a href="dashboard.php" class="dashboard-link" title="Go to Dashboard">
                &#x2192; 
            </a>
        </div>

          
    <?php 
    if (isset($_GET['status'])) {
        $msg_style = 'padding: 10px; border-radius: 4px; margin-bottom: 15px;';
        if ($_GET['status'] == 'cancelled') {
            echo '<p style="' . $msg_style . ' background: #d4edda; color: #155724; border: 1px solid #c3e6cb;">✅ Booking successfully Cancelled.</p>';
        } else if ($_GET['status'] == 'error') {
            echo '<p style="' . $msg_style . ' background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">❌ There was an error cancelling the booking.</p>';
        }
    }
    ?>
    <?php if (!$bookings || count($bookings) === 0): ?>
      <p>No bookings yet. <a href="index.php">Browse cars</a></p>
    <?php else: ?>
      <div class="booking-grid">
        <?php foreach ($bookings as $b): ?>

          <?php
  $start = new DateTime($b['start_date']);
  $end = new DateTime($b['end_date']);
  $days = $end->diff($start)->days + 1;
  $total_amount = $days * $b['price_day'];
  ?>
          <div class="card">
            <h3><?php echo htmlspecialchars($b['car_name'] ?: 'Car'); ?></h3>
            <p class="muted">Model: <?php echo htmlspecialchars($b['car_model']); ?></p>
            <p><strong>From:</strong> <?php echo htmlspecialchars($b['start_date']); ?></p>
            <p><strong>To:</strong> <?php echo htmlspecialchars($b['end_date']); ?></p>
            <p><strong>Amount:</strong> ₹<?php echo htmlspecialchars($total_amount); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($b['status']); ?></p>
            <p class="muted">Booked on: <?php echo htmlspecialchars($b['created_at']); ?></p>
            <div class="actions">
              <a href="userviewdetails.php?id=<?php echo intval($b['booking_id']); ?>">View Details</a>
              <?php if($b['status'] !== 'Cancelled' && $b['status'] !== 'Completed'): ?>
                <a href="usercancel.php?id=<?php echo intval($b['booking_id']); ?>" onclick="return confirm('Cancel this booking?')">Cancel</a>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</body>
</html>
