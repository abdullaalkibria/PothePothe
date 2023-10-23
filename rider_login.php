
<?php
session_start();
require "dbcon.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pothe Pothe - Login</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="passenger_login.css">
  <link rel="icon" type="image/x-icon" href="logo2.png">
</head>
<body style="background-image: url('bg3.jpg');background-size: cover; background-position: center; width: 100%; height: 100%;">
  <header>
  <div class="logo"><a href="index.php"><img src="logo2.png" height="50px"></a></div>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="about_us.html">About Us</a></li>
        <li><a href="#contact">Contact Us</a></li>
        <li><a href="passenger_login.php">Passenger Login</a></li>
        <li><a href="rider_login.php">Rider Login</a></li>
      </ul>
    </nav>
  </header>

  <section class="login-form" style="margin-bottom: 10%;">
    <h1>Log In as Driver</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
      <div class="form-group">
        <label for="email">Email *</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password *</label>
        <input type="password" id="password" name="password" required>
      </div>

<div class="errmsg">
<?php
if(isset($_POST['rider_login']))
{
	
	$email = $_POST['email'];
	$password = $_POST['password'];
  $_SESSION['email'] = $email;

		
   // Query to retrieve user info
	$sql = "SELECT * FROM rider_info WHERE email='$email' AND password='$password'";
	$result = $con->query($sql);

    // $results = 1 means that one user with the
    // entered username exists
    if (mysqli_num_rows($result) == 1) {
        // Storing username in session variable
        $_SESSION['email'] = $email;
        
        // Welcome message
        $_SESSION['success'] = "You have logged in!";
        
        // Page on which the user is sent
        // to after logging in
        header('location: driver_profile.php');
    }
    else{
      echo "Doesn't match the email or password!";
    }
	$con->close();
}
?>
</div>
  
      <p>forgotten password? <a href="forgot-password.html">recover password</a></p>
      <input class="button" type="submit" name="rider_login" value="Log In">
    </form>
    <p>Don't have an account? <a href="rider_signup.php">Sign up here</a></p>
  </section>

  <footer class="site-footer">
        <div class="footer-column" style="margin-left: 10%;">
            <h3>Navigation</h3>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="about_us.html">About Us</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>Connect with Us</h3>
            <ul class="social-links">
                <li><a href="https://www.facebook.com/"><img src="fbicon.png" alt="Facebook"></a></li>
                <li><a href="https://twitter.com/?lang=en"><img src="ntiocon.png" alt="Twitter"></a></li>
                <li><a href="https://www.instagram.com/"><img src="insicon.png" alt="Instagram"></a></li>
            </ul>
            <p>&copy; 2023 PothePothe. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
