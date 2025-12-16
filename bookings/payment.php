<?php
session_start();
include("../includes/db.php");

$booking_id = $_GET['booking_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; background: #f0f2f5; }
        .payment-box { background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); display: inline-block; max-width: 500px; }
        .option-button { display: block; width: 100%; padding: 15px; margin-top: 15px; border-radius: 8px; font-size: 1.1em; cursor: pointer; transition: background-color 0.3s; border: none; }
        
        .cod { background: #4caf50; color: white; }
        .cod:hover { background: #45a049; }
        
        .card { background: #ff9800; color: white; }
        .card:hover { background: #e68a00; }
        
        .back-arrow {
    position: fixed;         
    top: 15px;                
    left: 15px;               
    font-size: 34px;          
    color: white;             
    text-decoration: none;
    font-weight: bold;
    background-color: rgba(255, 255, 255, 0.15); 
    border-radius: 50%;       
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    z-index: 9999;
}

.back-arrow:hover {
    background-color: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}
    </style>
</head>
<body>

<a href="../bookings/booking_form.php" class="back-arrow">&#8592;</a>

    <div class="payment-box">
        <h2>Choose a Payment Method</h2>
        <p>Your Booking ID: <b><?php echo $booking_id; ?></b></p>
        <p>Please select your preferred payment method.</p>
        
        <a href="payment_success.php?booking_id=<?php echo $booking_id; ?>&method=cod">
            <button class="option-button cod">Pay with Cash</button>
        </a>
        
        <a href="card_payment.php?booking_id=<?php echo $booking_id; ?>">
            <button class="option-button card">Pay with Card</button>
        </a>
    </div>
</body>
</html>
