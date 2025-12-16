<?php

include("../includes/db.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Request");
}

$id = (int)$_GET['id'];

$delete = mysqli_query($conn, "DELETE FROM cars WHERE id=$id");

if ($delete) {
    header("Location:dashboard.php?msg=Car Deleted Successfully");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
