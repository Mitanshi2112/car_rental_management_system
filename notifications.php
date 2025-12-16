<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'includes/db.php';
$user_id = $_SESSION['user_id'];

// 1. सभी अपठित नोटिफिकेशन्स को "पठित" के रूप में चिह्नित करें
$mark_read_query = "UPDATE notifications SET is_read = TRUE WHERE user_id = $user_id AND is_read = FALSE";
mysqli_query($conn, $mark_read_query);

// 2. उपयोगकर्ता के लिए सभी नोटिफिकेशन्स प्राप्त करें
$notifications_query = "SELECT * FROM notifications WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 20";
$notifications_result = mysqli_query($conn, $notifications_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        .notification-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .notification-item {
            padding: 15px;
            margin-bottom: 10px;
            border-left: 5px solid #007bff;
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        .notification-item.unread {
            border-left: 5px solid #dc3545; /* लाल रंग */
            background-color: #fff3f3; /* हल्का गुलाबी पृष्ठभूमि */
            font-weight: bold;
        }
        .timestamp {
            display: block;
            font-size: 0.8em;
            color: #6c757d;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="notification-container">
        <h1><i class="fa-solid fa-bell"></i> Your Notifications</h1>
        <hr>

        <?php
        if (mysqli_num_rows($notifications_result) > 0) {
            while ($notification = mysqli_fetch_assoc($notifications_result)) {
                $is_unread_class = $notification['is_read'] ? '' : ' unread';
        ?>
            <div class="notification-item<?php echo $is_unread_class; ?>">
                <?php echo htmlspecialchars($notification['message']); ?>
                <span class="timestamp"><?php echo date('d M, h:i A', strtotime($notification['created_at'])); ?></span>
            </div>
        <?php
            }
        } else {
            echo "<p>No notifications yet.</p>";
        }
        ?>
        <p><a href="dashboard.php">Go Back to Dashboard</a></p>
    </div>
</body>
</html>