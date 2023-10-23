<?php
  require "dbcon.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pothe Pothe - Home</title>
  <link rel="stylesheet" href="driver_profile.css">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" type="image/x-icon" href="logo2.png">
</head>

<body style="background-image: url('bg.png');background-size: cover; background-position: center; width: 100%; height: 100%;">
<script src="script.js"></script>  
<header>
  <div class="logo"><a href="index.php"><img src="logo2.png" height="50px"></a></div>
    <nav id="menu-bar" class="sticky">
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

  <section style="background-image: url('driving.webp'); background-size: cover; background-position: center; width: 100%; height: 500px;">
<div class="description" style="background-color: #f4dd1f;margin-left: 10%; background-size: cover; background-position: left; width: 40%; height: 300px;opacity:0.7;">
    <h1>Welcome to Pothe Pothe</h1>
    <p>Discover a new way to travel with Pothe Pothe. We offer reliable transportation services with our dedicated riders. Sign up as a passenger or become a rider to join our community today!</p>
    <div class="buttons">
      <a href="passenger_signup.php" class="signup-btn">Sign Up as a Passenger</a>
      <a href="rider_signup.php" class="signup-btn">Sign Up as a Rider</a>
    </div>
</div>
  </section>
<section style="margin-left: 10%; width: 100%; height: 500px;">
    <h1>Focused on safety, wherever you go</h1>

    <div>
      <img src="DotCom_Update_Rider_bg2x.webp"; style="width: 39%; height: 350px; margin-right:2%;"></img>
      <img src="Cities_Home_Img2x.webp"; style="width: 39%; height: 350px; "></img>
      <h3>Our commitment to your safety</h3>
      <p>With every safety feature and every standard in our Community Guidelines, we're committed to helping to create a safe environment for our users.</p>
    </div>

  </section>

  <section style="background-image: url('Safety_Home_Img2x.webp'); background-size: cover; background-position: center; width: 100%; height: 600px;">
<div class="feedback" style="background-color: #48d2d2;margin-left: 10%; background-size: cover; background-position: left; width: 40%; height: 400px; opacity:0.7"> 
    <h2>Feedback</h2>
    <div class="comments">
      <!-- Comments section will be here -->
    </div>
    <form id="feedbackForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validform()" name="feedback_form" method="post" class="feedback-form">
      <input type="text" placeholder="Your Name" name="name" required>
      <input id="emailInput" type="email" placeholder="Your Email" name="email" required>
      <textarea placeholder="Your Message" name="message" required></textarea>
      <input type="submit" value="Submit" name="feedback">
      <?php
        if (isset($_POST['feedback'])) {
            $userEmail = $_POST["email"]; 
            if (!isValidEmail($userEmail)) {
      ?>
      <span class="errmsg">
        <?php echo "Invalid email address. Please enter a valid email (e.g., user@example.com).";?>
      </span>
      <?php
            } else {
          $name=$_POST['name'];
          $email=$_POST['email'];
          $message = $_POST['message'];
          mysqli_query($con,"INSERT INTO feedback (name,email, message) VALUES ('$name','$email','$message')") or die("".mysqli_error());
      ?>
          <span class="successmsg">
          <?php   echo "Thanks for your valuable feedback."; ?>
          </span>
      <?php
            }
        }
        function isValidEmail($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }
      ?>

    </form>
    </div>
</div>
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


    <script>
      function validform()
      {
        var name = document.forms['feedback_form']['name'].value;
        var email = document.forms['feedback_form']['email'].value;
        var message = document.forms['feedback_form']['message'].value;
        if(name=="")
        {
          alert("Name can't be Empty!");
          document.forms['feedback_form']['name'].focus();
          return false;
        }
        
        if(email == "")
        {
          alert("Email can't be Empty!");
          document.forms['feedback_form']['email'].focus();
          return false;
        }

        if(message == "")
        {
          alert("Message can't be empty!");
          document.forms['feedback_form']['message'].focus();
          return false;
        }
      }
    </script>
</body>
</html>
