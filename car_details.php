<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include("includes/db.php");

$carId = $_GET['id'] ?? null;

if (!$carId) {
    echo "Car not found!";
    exit;
}

$query = "SELECT * FROM cars WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $carId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$car = mysqli_fetch_assoc($result);

if (!$car) {
    echo "Car not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($car['car_name']); ?> Details</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/car_details.css">
</head>
<body>
  <div class="car-detail-wrapper">
    <div class="car-detail-card">
      <div class="car-image">
        <div class="logo-overlay">
          <i class="fa-solid fa-car-side"></i>
        </div>
        <img src="admin/uploads/<?php echo htmlspecialchars($car['image']); ?>" 
             alt="<?php echo htmlspecialchars($car['car_name']); ?>">
      </div>

      <div class="car-info">
        <h1><?php echo htmlspecialchars($car['car_name']); ?> (<?php echo htmlspecialchars($car['car_model']); ?>)</h1>

        <p><i class="fa-solid fa-car"></i> <strong>Type:</strong> <?php echo htmlspecialchars($car['car_type']); ?></p>
        <p><i class="fa-solid fa-gas-pump"></i> <strong>Fuel:</strong> <?php echo htmlspecialchars($car['fuel_type']); ?></p>
        <p><i class="fa-solid fa-gears"></i> <strong>Transmission:</strong> <?php echo htmlspecialchars($car['transmission']); ?></p>
        <p><i class="fa-solid fa-users"></i> <strong>Seats:</strong> <?php echo htmlspecialchars($car['seats']); ?></p>
        <p><i class="fa-solid fa-clock"></i> <strong>Price (per hour):</strong> ₹<?php echo htmlspecialchars($car['price_hour']); ?></p>
        <p><i class="fa-solid fa-calendar-day"></i> <strong>Price (per day):</strong> ₹<?php echo htmlspecialchars($car['price_day']); ?></p>
        <p><i class="fa-solid fa-circle-<?php echo ($car['availability'] === 'available') ? 'check' : 'xmark'; ?>"></i> 
           <strong>Availability:</strong> <?php echo htmlspecialchars($car['availability']); ?></p>
        <p><i class="fa-solid fa-id-card"></i> <strong>Reg No:</strong> <?php echo htmlspecialchars($car['reg_no']); ?></p>
        <p><i class="fa-solid fa-star"></i> <strong>Facilities:</strong> <?php echo htmlspecialchars($car['facilities']); ?></p>
        <p><i class="fa-solid fa-align-left"></i> <strong>Description:</strong> <?php echo htmlspecialchars($car['description']); ?></p>

        <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
        <a href="bookings/booking_form.php?car_id=<?php echo $car['id']; ?>" class="btn">Book Now</a>
      </div>
    </div>
  </div>
</body>
</html>
