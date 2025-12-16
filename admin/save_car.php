<?php
include '../includes/db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_name     = $_POST['car_name'];
    $car_model    = $_POST['car_model'];
    $car_type     = $_POST['car_type'];
    $fuel_type    = $_POST['fuel_type'];
    $transmission = $_POST['transmission'];
    $seats        = $_POST['seats'];
    $price_hour   = $_POST['price_hour'];
    $price_day    = $_POST['price_day'];
    $availability = $_POST['availability'];
    $reg_no       = $_POST['reg_no'];
    $description  = $_POST['description'];
    $facilities   = isset($_POST['facilities']) ? implode(", ", $_POST['facilities']) : "";

    $car_image = "";
    if (!empty($_FILES['car_image']['name'])) {
        $uploadDir  = "uploads/"; 
        $car_image  = time() . "_" . basename($_FILES['car_image']['name']); 
        $targetPath = $uploadDir . $car_image;

        if (move_uploaded_file($_FILES['car_image']['tmp_name'], $targetPath)) {
        } else {
            echo "❌ Image upload failed.";
            exit;
        }
    }

    $sql = "INSERT INTO cars 
        (car_name, car_model, car_type, fuel_type, transmission, seats, price_hour, price_day, availability, reg_no, facilities, image, description) 
        VALUES 
        ('$car_name', '$car_model', '$car_type', '$fuel_type', '$transmission', '$seats', '$price_hour', '$price_day', '$availability', '$reg_no', '$facilities', '$car_image', '$description')";

    if (mysqli_query($conn, $sql)) {
        echo "✅ Car added successfully.";
        header("Location: dashboard.php"); 
        exit;
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }
}
?>
