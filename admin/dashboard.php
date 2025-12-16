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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="dashboard.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <i class="fas fa-home home-icon"></i>
<button onclick="window.location.href='car_list.php'"><i class="fas fa-car"></i><span>Car List</span></button>
    <button onclick="window.location.href='add_car.php'">
      <i class="fas fa-plus"></i><span>Add Car</span>
      </button>
<button onclick="window.location.href='booking.php'"><i class="fas fa-calendar-check"></i><span>Bookings</span></button>
    <button onclick="window.location.href='logout.php'"><i class="fas fa-sign-out-alt"></i><span>Logout</span></button>
  </div>

  <!-- topbar -->
  <div class="main">
    <div class="top-bar">
      <h1><i class="fas fa-car"></i>Ride on Rental </h1>
      <div class="right-icons">
        <div class="notification-wrapper">
          <input type="checkbox" id="notif-toggle" hidden />
          <label for="notif-toggle" class="fas fa-bell notification-icon"></label>
          <span class="notif-indicator"></span> 
  
          <div class="notification-dropdown">
            <h4>Notifications</h4>
            <ul>
              <li>New booking: John Doe booked Honda Civic</li>
              <li>New booking: Jane Smith booked Toyota Corolla</li>
            </ul>
          </div>
        </div>
        <div class="date-time" id="datetime"></div>
      </div>
    </div>
    


   <!-- Recently Added Cars -->
<h2>Recently Added Cars</h2>

<table>
  <tr>
    <th>Car Name</th>
    <th>Model</th>
    <th>Status</th>
    <th>Actions</th> 
  </tr>
  <?php
  
$cars = mysqli_query($conn, "SELECT * FROM cars ORDER BY id DESC LIMIT 5");

if (!$cars) {
    echo "<tr><td colspan='4'>Query error: " . htmlspecialchars(mysqli_error($conn)) . "</td></tr>";
} elseif (mysqli_num_rows($cars) > 0) {
    while ($car = mysqli_fetch_assoc($cars)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($car['car_name']) . "</td>";
        echo "<td>" . htmlspecialchars($car['car_model']) . "</td>";
        echo "<td>";
        $avail = strtolower($car['availability'] ?? '');
        if ($avail === 'available') {
            echo "<span class='status available'>Available</span>";
        } else {
            echo "<span class='status booked'>Not Available</span>";
        }
        echo "</td>";
        echo "<td>
                <a href='edit_car.php?id=" . (int)$car['id'] . "' style='color:blue;margin-right:10px;'>Edit</a>
                <a href='delete_car.php?id=" . (int)$car['id'] . "' style='color:red;' onclick=\"return confirm(\"Delete this car?\")\">Delete</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No cars available</td></tr>";
}
?>

</table>

    <!-- Recent Bookings -->
    <h2>Recent Bookings</h2>
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
      

$bookings = mysqli_query($conn, "SELECT b.id, u.fullname, u.email, c.car_name, b.start_date AS booking_date, b.end_date AS return_date, b.status 
FROM bookings b JOIN users u ON b.user_id = u.id JOIN cars c ON b.car_id = c.id
ORDER BY b.id DESC LIMIT 5");
        if (mysqli_num_rows($bookings) > 0) {
            while ($b = mysqli_fetch_assoc($bookings)) {
                echo "<tr>
                        <td>#{$b['id']}</td>
                        <td>{$b['fullname']}</td>
                        <td>{$b['email']}</td>
                        <td>{$b['car_name']}</td>
                        <td>{$b['booking_date']}</td>
                        <td>{$b['return_date']}</td>
                        <td>";
                if ($b['status'] == 'confirmed') {
                    echo "<span class='status paid'>Paid</span>";
                } else {
                    echo "<span class='status pending'>Pending</span>";
                }
                echo "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No bookings found</td></tr>";
        }
      ?>
    </table>
  </div>

  <!-- Date/Time JS -->
  <script>
    function updateTime() {
      const now = new Date();
      const options = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
      const dateTime = `${now.getDate().toString().padStart(2, '0')}/${(now.getMonth()+1).toString().padStart(2, '0')}/${now.getFullYear()} | ${now.toLocaleTimeString([], options)}`;
      document.getElementById("datetime").innerText = dateTime;
    }
    setInterval(updateTime, 1000);
    updateTime();
  </script>

</body>
</html>
