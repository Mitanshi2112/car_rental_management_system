<?php
session_start();
if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit; 
}

require 'includes/db.php';

$booking_id = intval($_GET['id'] ?? 0);
$user_id = intval($_SESSION['user_id']);

// check owner
$check = $conn->prepare("SELECT status FROM bookings WHERE id=? AND user_id=?");
$check->bind_param("ii", $booking_id, $user_id);
$check->execute();
$result = $check->get_result();
$row = $result->fetch_assoc();

if (!$row) { 
    die("Not allowed"); 
}

if ($row['status'] === 'Cancelled') { 
    header("Location: bookings.php"); 
    exit; 
}

// update status to Cancelled
$upd = $conn->prepare("UPDATE bookings SET status='Cancelled' WHERE id=? AND user_id=?");
$upd->bind_param("ii", $booking_id, $user_id);
$upd->execute();

header("Location: ../userdetails.php?status=cancelled");
exit;
?>
