<?php
session_start();
include("includes/db.php");

$message="";

$fullname="";
$email="";
$username="";

if(isset($_POST['register'])){
    $fullname = $_POST['fullname'];
    $email    = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check=$conn->prepare("SELECT id FROM users WHERE email =?");
    $check->bind_param("s",$email);
    $check->execute();
    $check->store_result();

    if($check->num_rows > 0){
      $message="Email already exists.Please login instead!";
      $email="";
    } else {

    

    $sql = "INSERT INTO users (fullname,email,username,password) 
            VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $fullname,$email,$username,$password);

    if($stmt->execute()){
        header("Location: login.php?registered=1");
        exit;
    } else {
        echo "Error: ".$conn->error;
    }
    }
    $check->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="css/register.css">
</head>
<body>
  <div class="container">
    <h1>Sign Up</h1>

        <?php if (!empty($message)) { echo "<p style='color:red; font-weight:bold;'>$message</p>"; } ?>

    <form method="post" action="register.php">
      <input type="text"  name="fullname" placeholder="Full Name" value="<?php echo htmlspecialchars($fullname); ?>"required><br>
      <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>"required><br>
      <input type="text" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>"required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit"name="register" class="btn">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
