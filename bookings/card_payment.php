<?php
session_start();
include("../includes/db.php");

if(!isset($_GET['booking_id'])) {
    die("Error: Booking ID missing.");
}
$booking_id = intval($_GET['booking_id']);

$total_amount = 4500; 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Card Payment</title>
    <link rel="stylesheet" href="../css/card_form.css">
    <style>
        .payment-container { font-family: Arial, sans-serif; max-width: 450px; margin: 50px auto; padding: 30px; border-radius: 12px; background: #fff; box-shadow: 0 6px 15px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; text-align: left; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; font-size: 1em; }
        .row { display: flex; gap: 20px; }
        .expiry, .cvv { flex: 1; }
        .pay-button { background: #007bff; color: white; padding: 12px; border: none; border-radius: 8px; font-size: 1.2em; width: 100%; cursor: pointer; margin-top: 15px; transition: background-color 0.3s; }
        .pay-button:hover { background: #0056b3; }
        .safe-notice { color: #888; font-size: 0.9em; margin-top: 15px; }
    </style> 
    </head>
<body>
    <div class="payment-container">
        <h2>Complete Payment (Dummy Gateway)</h2>
        <h3>Booking ID: **<?php echo $booking_id; ?>** | Amount: ₹<?php echo $total_amount; ?></h3>

        <form action="payment_success.php" method="GET">
            <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
            <input type="hidden" name="method" value="card">
            
            <div class="form-group">
                <label for="card_number">Card Number</label>
                <input type="text" id="card_number" name="card_number" placeholder="XXXX XXXX XXXX XXXX" maxlength="16" required>
            </div>

            <div class="form-group">
                <label for="name_on_card">Name on Card</label>
                <input type="text" id="name_on_card" name="name_on_card" required>
            </div>

            <div class="row">
                <div class="form-group expiry">
                    <label for="expiry">Expiry Date (MM/YY)</label>
                    <input type="text" id="expiry" name="expiry" placeholder="MM/YY" maxlength="5" required>
                </div>
                <div class="form-group cvv">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" placeholder="XXX" maxlength="3" required>
                </div>
            </div>

            <button type="submit" class="pay-button">Pay ₹<?php echo $total_amount; ?></button>
            <p class="safe-notice">🔒 Your payment is securely processed (Project Simulation)</p>
        </form>
    </div>
</body>
</html>