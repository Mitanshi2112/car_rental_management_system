<?php
include 'includes/db.php';

function createNotification($conn, $user_id, $message) {
    $safe_message = mysqli_real_escape_string($conn, $message);
    $safe_user_id = (int)$user_id;

    $sql = "INSERT INTO notifications (user_id, message) VALUES ('$safe_user_id', '$safe_message')";
    
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}
?>