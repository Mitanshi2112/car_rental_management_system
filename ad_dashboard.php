<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
</head>
<body>
  <h2>Welcome, <?php echo $_SESSION['admin_name']; ?> 👋</h2>
  <ul>
    <li><a href="cars.php">Manage Cars</a></li>
    <li><a href="user.php">View Users</a></li>
    <li><a href="bookings.php">View Bookings</a></li>
    <li><a href="../logout.php">Logout</a></li>
  </ul>
</body>
</html>