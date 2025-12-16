<?php
session_start();
include "../includes/db.php";
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Bookings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link rel="stylesheet" href="bookinglist.css">
    
</head>
<body>
 <div class="back-to-dashboard">
    <a href="dashboard.php">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
</div>
    <div class="main">
        <h2><i class="fa-solid fa-list-check"></i> All Bookings List</h2>

        <table>
            <tr>
                <th>Booking ID</th>
                <th>User</th>
                <th>Email</th>
                <th>Car</th>
                <th>Booking Date</th>
                <th>Return Date</th>
                <th>Payment Status</th>
            </tr>
            <?php
            $bookings = mysqli_query($conn, "SELECT 
                b.id, u.fullname, u.email, c.car_name, b.start_date, b.end_date, b.status
                FROM bookings b 
                JOIN users u ON b.user_id = u.id 
                JOIN cars c ON b.car_id = c.id
                ORDER BY b.id DESC"); 
            
            if (mysqli_num_rows($bookings) > 0) {
                while ($b = mysqli_fetch_assoc($bookings)) {
                    echo "<tr>";
                    echo "<td>#{$b['id']}</td>";
                    echo "<td>{$b['fullname']}</td>";
                    echo "<td>{$b['email']}</td>";
                    echo "<td>{$b['car_name']}</td>";
                    echo "<td>{$b['start_date']}</td>";
                    echo "<td>{$b['end_date']}</td>";
                    echo "<td>";
                    
                    // Status Display
                    if ($b['status'] == 'confirmed') {
                        echo "<span class='status confirmed'>Confirmed</span>";
                    } elseif ($b['status'] == 'pending') {
                        echo "<span class='status pending'>Pending</span>";
                    } else {
                        echo "<span class='status cancelled'>Cancelled</span>";
                    }
                    
                    echo "</td>";
                    
                   
                    echo "</td>";
                    
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No bookings found in the database.</td></tr>";
            }
            ?>
        </table>

    </div>
</body>
</html>
