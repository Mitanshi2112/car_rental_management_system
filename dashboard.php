<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'includes/db.php';

$user_id = $_SESSION['user_id'];
$unread_notifications_query = "SELECT COUNT(*) AS unread_count FROM notifications WHERE user_id = $user_id AND is_read = FALSE";
$unread_result = mysqli_query($conn, $unread_notifications_query);
$unread_data = mysqli_fetch_assoc($unread_result);
$unread_count = $unread_data['unread_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link rel="stylesheet" href="css/dashboard.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
  <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
  <p>Your email: <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
  
  <div class="dashboard-layout">
    
    <!-- Sidebar -->
    <div class="sidebar">
      <h2><i class="fa-solid fa-house"></i></h2>

      <button class="menu-btn" onclick="window.location.href='userdetails.php'">
        <i class="fa-solid fa-calendar-check"></i> Bookings
      </button>

      <button class="menu-btn" onclick="window.location.href='payment.php'">
        <i class="fa-solid fa-credit-card"></i> Payment
      </button>

    
      
  
  <?php if ($unread_count > 0): ?>
    <span class="notification-badge"><?php echo $unread_count; ?></span>
  <?php endif; ?>
</button>

      

      <button class="menu-btn" onclick="window.location.href='profile.php'">
        <i class="fa-solid fa-user"></i> Profile
      </button>

      <button class="menu-btn" onclick="window.location.href='logout.php'">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
      </button>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      
      <!-- Topbar -->
      <div class="topbar">
        <div class="logo">Ride on Rental🚗</div>
        <div class="links">
          <a href="about.php">About Us</a> | <a href="help.php">Help</a>
        </div>
      </div>

      <!-- Search Section -->
      <div class="search-section">
        <input type="text" id="searchBox" placeholder="Search cars..." onkeyup="searchCars()">
        <button onclick="searchCars()">Search</button>
      </div>

      <!-- Cars Grid -->
      <div class="car-grid" id="carGrid">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM cars ORDER BY id DESC");
        if ($result && mysqli_num_rows($result) > 0) {
            while ($car = mysqli_fetch_assoc($result)) {
        ?>
            <div class="car-card">
              <img src="admin/uploads/<?php echo htmlspecialchars($car['image']); ?>" 
                   alt="<?php echo htmlspecialchars($car['car_name']); ?>" 
                   style="width:100%; height:150px; object-fit:cover; border-radius:10px;">

              <h3><?php echo htmlspecialchars($car['car_name']); ?></h3>
              <p>Model: <?php echo htmlspecialchars($car['car_model']); ?></p>
              <p>₹<?php echo htmlspecialchars($car['price_day']); ?>/day</p>

              <a href="car_details.php?id=<?php echo $car['id']; ?>" 
                 class="btn-view-details">View Details</a>
            </div>
        <?php
            }
        } else {
            echo "<p>No cars available right now.</p>";
        }
        ?>
      </div>

    </div>
  </div>

  <script>
    function searchCars() {
      let input = document.getElementById("searchBox").value.toLowerCase();
      let cards = document.getElementsByClassName("car-card");

      for (let i = 0; i < cards.length; i++) {
        let carName = cards[i].getElementsByTagName("h3")[0].innerText.toLowerCase();
        if (carName.includes(input)) {
          cards[i].style.display = "block";
        } else {
          cards[i].style.display = "none";
        }
      }
    }
  </script>

</body>
</html>
