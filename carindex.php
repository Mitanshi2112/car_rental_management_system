<?php
include 'includes/db.php';

if (isset($_GET['id'])) {
    $car_id = intval($_GET['id']);  
    $sql = "SELECT * FROM cars WHERE id = $car_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $car = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title><?php echo htmlspecialchars($car['car_name']); ?> - Details</title>
            <link rel="stylesheet" href="css/index.css">
        </head>
        <body>
            <h1><?php echo htmlspecialchars($car['car_name']); ?></h1>
            <p><strong>Brand:</strong> <?php echo htmlspecialchars($car['car_brand']); ?></p>
            <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['car_name']); ?>" style="width:300px;">
            <p><a href="index.php">← Back to Home</a></p>
        </body>
        </html>
        <?php
    } else {
        echo "Car not found!";
    }
} else {
    echo "Invalid request!";
}
?>
