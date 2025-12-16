<?php
session_start();
include '../includes/db.php'; 

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM cars ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Car List</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> <!-- For icons -->
</head>
<body>

<div class="back-to-dashboard">
    <a href="dashboard.php">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
</div>
    <div class="car-list-container">
        <h1>Car List</h1>
        <a href="add_car.php" class="add-car-btn"><i class="fas fa-plus"></i> Add New Car</a>
        <table class="car-table">
            <thead>
                <tr>
                    <th><i class="fas fa-car"></i> Car Name</th>
                    <th><i class="fas fa-calendar-alt"></i> Model</th>
                    <th><i class="fas fa-cogs"></i> Transmission</th>
                    <th><i class="fas fa-chair"></i> Seats</th>
                    <th><i class="fas fa-gas-pump"></i> Fuel</th>
                    <th><i class="fas fa-rupee-sign"></i> Price/Day</th>
                    <th><i class="fas fa-info-circle"></i> Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($car = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($car['car_name']); ?></td>
                        <td><?php echo htmlspecialchars($car['car_model']); ?></td>
                        <td><?php echo htmlspecialchars($car['transmission']); ?></td>
                        <td><?php echo htmlspecialchars($car['seats']); ?></td>
                        <td><?php echo htmlspecialchars($car['fuel_type']); ?></td>
                        <td>₹<?php echo htmlspecialchars($car['price_day']); ?></td>
                        <td>
                            <?php
                            $status = strtolower($car['availability']);
                            if ($status === 'available') {
                                echo '<span class="badge available">Available</span>';
                            } elseif ($status === 'booked') {
                                echo '<span class="badge booked">Booked</span>';
                            } elseif ($status === 'maintenance') {
                                echo '<span class="badge maintenance">Maintenance</span>';
                            } else {
                                echo '<span class="badge unknown">Unknown</span>';
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
