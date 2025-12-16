<?php
include("../includes/db.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Request");
}

$id = (int)$_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM cars WHERE id=$id");
if (mysqli_num_rows($query) == 0) {
    die("Car not found!");
}
$car = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $car_name = $_POST['car_name'];
    $car_model = $_POST['car_model'];
    $car_type = $_POST['car_type'];
    $fuel_type = $_POST['fuel_type'];
    $transmission = $_POST['transmission'];
    $seats = $_POST['seats'];
    $price_hour = $_POST['price_hour'];
    $price_day = $_POST['price_day'];
    $availability = $_POST['availability'];
    $reg_no = $_POST['reg_no'];
    $facilities = $_POST['facilities'];
    $description = $_POST['description'];

    $update = mysqli_query($conn, "UPDATE cars SET 
        car_name='$car_name',
        car_model='$car_model',
        car_type='$car_type',
        fuel_type='$fuel_type',
        transmission='$transmission',
        seats='$seats',
        price_hour='$price_hour',
        price_day='$price_day',
        availability='$availability',
        reg_no='$reg_no',
        facilities='$facilities',
        description='$description'
        WHERE id=$id");

    if ($update) {
        header("Location: cars.php?msg=Car Updated Successfully");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Car</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <h2>Edit Car</h2>
    <form method="post">
        <label>Car Name:</label>
        <input type="text" name="car_name" value="<?= $car['car_name'] ?>" required><br>

        <label>Car Model:</label>
        <input type="text" name="car_model" value="<?= $car['car_model'] ?>" required><br>

        <label>Car Type:</label>
        <input type="text" name="car_type" value="<?= $car['car_type'] ?>"><br>

        <label>Fuel Type:</label>
        <input type="text" name="fuel_type" value="<?= $car['fuel_type'] ?>"><br>

        <label>Transmission:</label>
        <input type="text" name="transmission" value="<?= $car['transmission'] ?>"><br>

        <label>Seats:</label>
        <input type="number" name="seats" value="<?= $car['seats'] ?>"><br>

        <label>Price/Hour:</label>
        <input type="number" name="price_hour" value="<?= $car['price_hour'] ?>"><br>

        <label>Price/Day:</label>
        <input type="number" name="price_day" value="<?= $car['price_day'] ?>"><br>

        <label>Availability:</label>
        <select name="availability">
            <option value="available" <?= $car['availability'] == 'available' ? 'selected' : '' ?>>Available</option>
            <option value="not_available" <?= $car['availability'] == 'not_available' ? 'selected' : '' ?>>Not Available</option>
        </select><br>

        <label>Reg. No:</label>
        <input type="text" name="reg_no" value="<?= $car['reg_no'] ?>"><br>

        <label>Facilities:</label>
        <input type="text" name="facilities" value="<?= $car['facilities'] ?>"><br>

        <label>Description:</label>
        <textarea name="description"><?= $car['description'] ?></textarea><br>

        <button type="submit" name="update">Update Car</button>
    </form>
</body>
</html>
