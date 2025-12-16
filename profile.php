<?php
session_start();
include 'includes/db.php'; 

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$sql_user = "SELECT fullname, username, email, profile_pic, phone_number FROM users WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();

if (!$user) {
    echo "User not found!";
    exit;
}

$total_bookings = 0;
$active_bookings = 0;
$completed_bookings = 0;
$cancelled_bookings = 0;

$sql_total = "SELECT COUNT(*) AS count FROM bookings WHERE user_id = ?";
$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param("i", $user_id);
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$total_bookings = $result_total->fetch_assoc()['count'];

$sql_active = "SELECT COUNT(*) AS count FROM bookings WHERE user_id = ? AND status = 'pending'";
$stmt_active = $conn->prepare($sql_active);
$stmt_active->bind_param("i", $user_id);
$stmt_active->execute();
$result_active = $stmt_active->get_result();
$active_bookings = $result_active->fetch_assoc()['count'];

$sql_completed = "SELECT COUNT(*) AS count FROM bookings WHERE user_id = ? AND status = 'completed'";
$stmt_completed = $conn->prepare($sql_completed);
$stmt_completed->bind_param("i", $user_id);
$stmt_completed->execute();
$result_completed = $stmt_completed->get_result();
$completed_bookings = $result_completed->fetch_assoc()['count'];

$sql_cancelled = "SELECT COUNT(*) AS count FROM bookings WHERE user_id = ? AND status = 'cancelled'";
$stmt_cancelled = $conn->prepare($sql_cancelled);
$stmt_cancelled->bind_param("i", $user_id);
$stmt_cancelled->execute();
$result_cancelled = $stmt_cancelled->get_result();
$cancelled_bookings = $result_cancelled->fetch_assoc()['count'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="back-to-dashboard">
    <a href="dashboard.php">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
</div>
   <div class="profile-wrapper">
    <div class="top-profile">
        <div class="cover-photo"></div>
        <div class="profile-picture-container">
            <img src="<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="User Profile Picture" class="profile-picture">
        </div>
        
        <form action="upload_pic.php" method="POST" enctype="multipart/form-data">
            <label for="profile_pic_upload" class="upload-btn">
                Set Profile Photo
            </label>
            <input type="file" name="profile_pic" id="profile_pic_upload" onchange="this.form.submit();" hidden>
        </form>
    </div>

    <div class="profile-card">
        <div class="info-item"><strong>Full Name:</strong> <?php echo htmlspecialchars($user['fullname']); ?></div>
        <div class="info-item"><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></div>
        <div class="info-item"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></div>
    </div>

    <div class="profile-card">
        <h2><i class="fa-solid fa-chart-line"></i> Activity Overview</h2>
        <div class="activity-grid">
            <div class="activity-box">
                <i class="fa-solid fa-car"></i>
                <h3>Total Bookings</h3>
                <p><?php echo $total_bookings; ?></p>
            </div>
            <div class="activity-box">
                <i class="fa-solid fa-clock"></i>
                <h3>Active</h3>
                <p><?php echo $active_bookings; ?></p>
            </div>
            <div class="activity-box">
                <i class="fa-solid fa-check-circle"></i>
                <h3>Completed</h3>
                <p><?php echo $completed_bookings; ?></p>
            </div>
            <div class="activity-box">
                <i class="fa-solid fa-times-circle"></i>
                <h3>Cancelled</h3>
                <p><?php echo $cancelled_bookings; ?></p>
            </div>
        </div>
    </div>

    <div class="logout-box">
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

</div>

</body>
</html>