<?php
session_start();
include("../includes/db.php");

$today = date('Y-m-d');

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

if(!isset($_GET['car_id'])) {
    echo "Error: Please select a car to book.";
    exit;
}

$car_id = intval($_GET['car_id']);

$sql = "SELECT * FROM cars WHERE id = $car_id";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0) {
    $car = mysqli_fetch_assoc($result);
} else {
    echo "Error: Car not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Car Booking</title>
    <link rel="stylesheet" href="../css/booking.css">
    <style>
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

<a href="../dashboard.php" class="back-arrow">&#8592;</a>

    <div class="container">
        <!-- Left side car details -->
        <div class="car-details">
            <img src="../admin/uploads/<?php echo $car['image']; ?>" alt="<?php echo $car['car_name']; ?>" class="car-image">
            <h2><?php echo $car['car_name']; ?> (<?php echo $car['car_model']; ?>)</h2>
            <div class="car-specs">
                <p>🚗 Brand: <?php echo $car['car_name']; ?></p>
                <p>💺 Seats: <?php echo $car['seats']; ?></p>
                <p>⚙️ Transmission: <?php echo $car['transmission']; ?></p>
                <p>⛽ Fuel: <?php echo $car['fuel_type']; ?></p>
                <p>💰 Price: ₹<?php echo $car['price_day']; ?>/day</p>
            </div>
            <p><?php echo $car['description']; ?></p>
        </div>

       


        <!-- Right side booking form -->
        <div class="form-container">
            <h2>Book Your Car</h2>
            <form action="booking_submit.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $_SESSION['full_name']; ?>" readonly>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $_SESSION['user_email']; ?>" readonly>


                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>
                  
                
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" min="<?php echo $today; ?>" required> 

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" min="<?php echo $today; ?>" required>

                <!-- Pickup Location -->
                <label for="pickup_location">Pickup Location:</label>
                <select id="pickup_location" name="pickup_location" required>
                    <option value="">Select pickup</option>
                    <option value="Jamnagar">Jamnagar</option>
                    <option value="Rajkot">Rajkot</option>
                    <option value="Ahmedabad">Ahmedabad</option>
                    <option value="Surat">Surat</option>
                    <option value="Vadodara">Vadodara</option>
                </select>

                <!-- Drop Location -->
                <label for="drop_location">Drop Location:</label>
                <select id="drop_location" name="drop_location" required>
                    <option value="">Select drop</option>
                    <option value="Jamnagar">Jamnagar</option>
                    <option value="Rajkot">Rajkot</option>
                    <option value="Ahmedabad">Ahmedabad</option>
                    <option value="Surat">Surat</option>
                    <option value="Vadodara">Vadodara</option>
                </select>

                 <!-- Aadhaar Upload Field -->
    <label for="aadhar">Please upload your Aadhaar card photo:</label>
    <input type="file" id="aadhar" name="aadhar" accept="image/*" required>

                <button type="submit">Confirm Booking</button>
            </form>
        </div>
    </div>
</body>
</html>
