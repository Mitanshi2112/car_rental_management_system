<?php
session_start();
if(!isset($_SESSION['admin'])){ header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Cars</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Car List</h2>
  <table border="1" align="center">
    <tr><th>ID</th><th>Name</th><th>Price</th><th>Status</th></tr>
    <tr><td>1</td><td>Hyundai Creta</td><td>2000/day</td><td>Available</td></tr>
    <tr><td>2</td><td>Swift Dzire</td><td>1500/day</td><td>Booked</td></tr>
  </table>
</body>
</html>