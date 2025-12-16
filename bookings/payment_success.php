
<?php
session_start();
include("../includes/db.php");

$booking_id = intval($_GET['booking_id']);
$method = htmlspecialchars($_GET['method'] ?? 'cod');

if ($conn && $booking_id) {
    $upd = $conn->prepare("UPDATE bookings SET status = 'confirmed', payment_method = ? WHERE id = ?");
    $upd->bind_param("si", $method, $booking_id);
    $upd->execute();
    $upd->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Successful</title>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 100px;
            background: #f0f2f5;
        }
        .success-box {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            display: inline-block;
            animation: pop 0.6s ease;
        }
        .success-box h1 {
            color: green;
            font-size: 2.5em;
        }
        .success-box p {
            font-size: 1.2em;
            margin-top: 10px;
        }
        @keyframes pop {
            0% { transform: scale(0.5); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="success-box">
        <h1>✅ Order Successful!</h1>
        <p>Your Booking ID: <b><?php echo $booking_id; ?></b></p>
        <p>Payment Method: <b><?php echo strtoupper($method); ?></b></p>
        <p>Thank you for booking with us 🎉</p>

        
<a href="../receipt.php?booking_id=<?php echo $booking_id; ?>" class="btn">View Receipt</a>
  
    </div>

    <script>
        function launchConfetti() {
            var duration = 3 * 1000;
            var end = Date.now() + duration;

            (function frame() {
                confetti({
                    particleCount: 5,
                    angle: 60,
                    spread: 55,
                    origin: { x: 0 }
                });
                confetti({
                    particleCount: 5,
                    angle: 120,
                    spread: 55,
                    origin: { x: 1 }
                });
                if (Date.now() < end) {
                    requestAnimationFrame(frame);
                }
            })();
        }

        window.onload = launchConfetti;
    </script>
</body>
</html>
