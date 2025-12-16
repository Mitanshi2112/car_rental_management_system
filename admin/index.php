<?php
session_start();
include("../includes/db.php");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $username;
        header("Location:/rental_spot/admin/dashboard.php");
        exit();
    } else {
       echo "<script>alert('Invalid Login Details'); window.location.href='index.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
     <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="login-box">
        <h2>Admin Login</h2> 
        <form action="index.php" method="post">
            <input type="text" name="username" required placeholder="Username"><br><br>
            
            <input type="password" name="password" required placeholder="Password"><br><br>
            
            <button type="submit" name="login">Login</button>
            
            </form>
    </div>
</body>
</html>