<?php
session_start();
include("includes/db.php");

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        if(password_verify($password, $row['password'])){
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['username'];
           $_SESSION['user_email'] = $row['email'];
            $_SESSION['full_name'] = $row['fullname'];

            header("Location:dashboard.php");
            exit;
        } else {
              $error = "Invalid Password!";        }
    } else {
              $error = "User not found!";    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
  <div class="container">
    <h1>Login</h1>

     <?php if(isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
   <form method="post" action="login.php">
  <input type="text" name="username" placeholder="Username" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <button type="submit" name="login" class="btn">Login</button>
</form>

    <p>New user? <a href="register.php">Sign Up</a></p>
  </div>
</body>
</html>
