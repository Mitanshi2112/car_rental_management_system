<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'includes/db.php'; 
include 'add_notification.php'; 

$user_id = $_SESSION['user_id'];

 $pending_query = "SELECT b.*, c.car_name FROM bookings b JOIN cars c ON b.car_id = c.id WHERE b.user_id = $user_id AND b.status = 'pending' ORDER BY b.created_at DESC"; 
$pending_result = mysqli_query($conn, $pending_query);

$completed_query = "SELECT b.*, c.car_name 
                    FROM bookings b 
                    JOIN cars c ON b.car_id = c.id
                    WHERE b.user_id = $user_id 
                    AND b.status IN ('completed', 'booked', 'confirmed') 
                    ORDER BY b.created_at DESC";

$completed_result = mysqli_query($conn, $completed_query);


if (isset($_GET['action']) && $_GET['action'] == 'pay' && isset($_GET['booking_id'])) {
    $booking_id = (int)$_GET['booking_id'];
    
    $update_query = "UPDATE bookings SET status = 'completed' WHERE id = $booking_id AND user_id = $user_id";
    
    if (mysqli_query($conn, $update_query)) {
        
        $car_name = "Booking ID " . $booking_id; 
        $notification_message = "Payment for " . $car_name . " has been successfully completed.";
        
        createNotification($conn, $user_id, $notification_message);
        
        header("Location: payment.php?status=paid");
        exit();
    } else {
        header("Location: payment.php?status=failed");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment History</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .payment-history-container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .payment-list-section {
            margin-bottom: 40px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }
        .payment-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 10px;
            border-bottom: 1px solid #eee;
        }
        .payment-item:last-child { border-bottom: none; }
        .pending-item { background-color: #fff8e1; } 
        .completed-item { background-color: #e8f5e9; } 
        .pay-btn {
            background-color: #007bff;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    
    <div class="payment-history-container">
        <h1><i class="fa-solid fa-credit-card"></i> Your Payment History</h1>

        <div class="payment-list-section">
            <h2 style="color: #ff9800;">Pending Payments (<?php echo mysqli_num_rows($pending_result); ?>)</h2>
            <?php if (mysqli_num_rows($pending_result) > 0): ?>
                <?php while ($item = mysqli_fetch_assoc($pending_result)): ?>
                    <div class="payment-item pending-item">
                        <div>
 <strong><?php echo htmlspecialchars(isset($item['car_name']) ? $item['car_name'] : 'N/A'); ?></strong> 
                             <p>Amount: ₹<?php echo number_format($item['total_amount'], 2); ?></p>
<small>Date: <?php if (isset($item['start_date']) && !empty($item['start_date'])) { echo date('d M Y', strtotime($item['start_date'])); } else { echo 'Date Not Found'; } ?></small>                        </div>
                       <a href="bookings/payment.php?booking_id=<?php echo $item['id']; ?>" class="pay-btn"> 
    Pay Now
</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>You have no pending payments.</p>
            <?php endif; ?>
        </div>

        <div class="payment-list-section">
            <h2 style="color: #4caf50;">Allbooking history(<?php echo mysqli_num_rows($completed_result); ?>)</h2>
            <?php if (mysqli_num_rows($completed_result) > 0): ?>
                <?php while ($item = mysqli_fetch_assoc($completed_result)): ?>
                    <div class="payment-item completed-item">
                        <div>
                            <strong><?php echo htmlspecialchars($item['car_name']); ?></strong>
                            <p>Amount: ₹<?php echo number_format($item['total_amount'], 2); ?></p>
<small>Paid Date: <?php if (isset($item['created_at']) && !empty($item['created_at']) && $item['created_at'] != '0000-00-00') { echo date('d M Y', strtotime($item['created_at'])); } else { echo 'Date Not Found'; } ?></small>                </div>
                        <span style="color: #4caf50; font-weight: bold;"><i class="fa-solid fa-check"></i> Paid</span>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No completed payment records found.</p>
            <?php endif; ?>
        </div>
        
        <p style="text-align: center;"><a href="dashboard.php">Go Back to Dashboard</a></p>
    </div>
</body>
</html>