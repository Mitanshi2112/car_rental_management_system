<?php
session_start();
include("../includes/db.php");

$booking_id = intval($_GET['booking_id'] ?? 0);

if (!$booking_id) {
    die("Invalid Booking ID");
}


$query = "
SELECT 
    b.id AS booking_id, 
    b.total_amount, 
    b.payment_method, 
    b.start_date, 
    b.end_date, 
    b.created_at AS booking_date,
    u.username AS user_name,
    c.car_name, 
    c.car_brand, 
    c.car_model, 
    c.reg_no
FROM bookings b
LEFT JOIN users u ON b.user_id = u.id
LEFT JOIN cars c ON b.car_id = c.id
WHERE b.id = $booking_id
LIMIT 1";

$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("No booking found for this ID.");
}

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .receipt-container {
            max-width: 600px;
            background: #fff;
            margin: 50px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #2e7d32;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        td:first-child {
            font-weight: bold;
            color: #333;
            width: 40%;
        }
        .btn-back {
            display: block;
            text-align: center;
            margin-top: 25px;
            padding: 10px 15px;
            background: #2e7d32;
            color: white;
            border-radius: 8px;
            text-decoration: none;
        }
        .btn-back:hover {
            background: #1b5e20;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <h2>Booking Receipt</h2>
        <table>
            <tr>
                <td>Booking ID</td>
                <td><?php echo $data['booking_id']; ?></td>
            </tr>
            <tr>
                <td>User Name</td>
                <td><?php echo htmlspecialchars($data['user_name']); ?></td>
            </tr>
            <tr>
                <td>Car Name</td>
                <td><?php echo htmlspecialchars($data['car_name']); ?></td>
            </tr>
            <tr>
                <td>Number Plate</td>
                <td><?php echo htmlspecialchars($data['number_plate']); ?></td>
            </tr>
            <tr>
                <td>Start Date</td>
                <td><?php echo $data['start_date']; ?></td>
            </tr>
            <tr>
                <td>End Date</td>
                <td><?php echo $data['end_date']; ?></td>
            </tr>
            <tr>
                <td>Booking Date</td>
                <td><?php echo $data['booking_date']; ?></td>
            </tr>
            <tr>
                <td>Payment Method</td>
                <td><?php echo strtoupper($data['payment_method']); ?></td>
            </tr>
            <tr>
                <td>Total Amount</td>
                <td>₹<?php echo number_format($data['total_amount']); ?></td>
            </tr>
        </table>
        <a href="../dashboard.php" class="btn-back">Back to Home</a>
    </div>
</body>
</html>
