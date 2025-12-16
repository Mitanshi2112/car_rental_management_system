<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);

if (isset($_POST['car_id'])) {
    $car_id    = intval($_POST['car_id']);
    $name      = trim($_POST['name']);
    $email     = trim($_POST['email']);
    $phone     = trim($_POST['phone']);
    $start     = trim($_POST['start_date']);
    $end       = trim($_POST['end_date']);

     $start     = trim($_POST['start_date']);
      $end       = trim($_POST['end_date']);

    if (empty($name) || empty($email) || empty($phone) || empty($start) || empty($end)) {
        echo "Please fill all required fields.";
        exit;
    }


    $today = date('Y-m-d');
    if ($start < $today || $end < $today) {
        echo "Error: Booking dates cannot be in the past.";
        exit;
    }

    if ($end < $start) {
        echo "Error: End Date cannot be before Start Date.";
        exit;
    }
    $car_query = $conn->prepare("SELECT price_day FROM cars WHERE id = ?");
    $car_query->bind_param("i", $car_id);
    $car_query->execute();
    $car_result = $car_query->get_result();

    if ($car_result->num_rows === 0) {
        echo "Error: Car price not found.";
        exit;
    }
    $car_data = $car_result->fetch_assoc();
    $price_per_day = $car_data['price_day'];
    $car_query->close();


    $date1 = new DateTime($start);
    $date2 = new DateTime($end);
    $interval = $date1->diff($date2);
    $duration_days = $interval->days + 1; 

    $total_amount = $price_per_day * $duration_days;
    
    $aadhar_path = null;
    if (isset($_FILES['aadhar']) && $_FILES['aadhar']['error'] == 0) {
        $target_dir = "../uploads/aadhar/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name = time() . "_" . basename($_FILES["aadhar"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["aadhar"]["tmp_name"], $target_file)) {
            $aadhar_path = $target_file;
        } else {
            echo "Error: Unable to upload Aadhaar card.";
            exit;
        }
    } else {
        echo "Please upload your Aadhaar card photo.";
        exit;
    }


$sql = "INSERT INTO bookings (user_id, car_id, name, email, phone, start_date, end_date, total_amount, aadhar_image, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')"; 
    
    if ($conn) {
        $stmt = $conn->prepare($sql);
$stmt->bind_param("iisssssds", $user_id, $car_id, $name, $email, $phone, $start, $end, $total_amount, $aadhar_path);;
        if ($stmt->execute()) {
            $booking_id = $conn->insert_id; 
            $stmt->close();
            header("Location: payment.php?booking_id=" . $booking_id);
            exit;
        } else {
            echo "Error: " . $conn->error;
            exit;
        }
    } else {
        echo "Error: Database connection failed.";
        exit;
    }
}
?>
