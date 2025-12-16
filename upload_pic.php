<?php
session_start();
include 'includes/db.php'; 


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];


if (isset($_FILES['profile_pic'])) {
    $file = $_FILES['profile_pic'];

    
    $upload_dir = 'uploads/profiles/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); 
    }

    
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_file_name = uniqid() . '.' . $file_extension;
    $upload_path = $upload_dir . $new_file_name;

   
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        $sql = "UPDATE users SET profile_pic = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $upload_path, $user_id);
        $stmt->execute();
        $stmt->close();
        
        header('Location: profile.php'); 
        exit;
    } else {
        die("Error: Could not move the uploaded file.");
    }
} else {
    header('Location: profile.php');
    exit;
}
?>