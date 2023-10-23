<?php
require "dbcon.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pothe Pothe - Rider Sign Up</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="rider_signup.css">

</head>
<body>
  <header>
    <div class="logo">Pothe Pothe</div>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#about">About Us</a></li>
        <li><a href="#contact">Contact Us</a></li>
        <li><a href="passenger_login.php">Passenger Login</a></li>
        <li><a href="rider_login.php">Rider Login</a></li>
      </ul>
    </nav>
  </header>

  <section class="signup-form">
    <h1>Rider Sign Up</h1>

    <div class="errmsg">
      <?php
        if(isset($_POST['rider_signup']))
        {
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $nid=$_POST['nid'];
        $dlicense=$_POST['dlicense'];
        $paddress = $_POST['paddress'];
        $preaddress = $_POST['preaddress'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];


        // Check Unique Email, phone, nid, dlicense etc..
        $check_unique = "SELECT * FROM rider_info WHERE email='$email' OR phone='$phone' OR nid='$nid' OR dlicense='$dlicense'";
        $result = mysqli_query($con, $check_unique);

        $num_rows = mysqli_num_rows($result);

        if($num_rows >= 1){
            echo "Have already account using your Email or Phone No or NID or Dlicense.";
        }elseif ($password == $cpassword){
            mysqli_query($con,"INSERT INTO rider_info (fname,lname, email, phone, nid, dlicense, paddress, preaddress, password)
            VALUES ('$fname','$lname', '$email', '$phone', '$nid', '$dlicense', '$paddress', '$preaddress', '$password')") or die("".mysqli_error());
            header('location:rider_login.php');
        }


        // if($password == $cpassword)
        // {
        //   mysqli_query($con,"INSERT INTO rider_info (fname,lname, email, phone, nid, dlicense, paddress, preaddress, password)
        //   VALUES ('$fname','$lname', '$email', '$phone', '$nid', '$dlicense', '$paddress', 'preaddress', '$password')") or die("".mysqli_error());
        //   echo "Thanks for Sign Up.";
        // }
        
        }
        ?>
    </div>


    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="rider_signup_form" method="post" onsubmit="return validform()">
      <div class="form-group">
        <label for="first-name">First Name *</label>
        <input type="text" id="first-name" name="fname" required>
      </div>
      <div class="form-group">
        <label for="last-name">Last Name</label>
        <input type="text" id="last-name" name="lname">
      </div>
      <div class="form-group">
        <label for="email">Email ID *</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="phone">Phone No *</label>
        <input type="number" id="phone" name="phone" required>
      </div>
      <div class="form-group">
        <label for="nid">NID Number *</label>
        <input type="number" id="nid" name="nid" required>
      </div>
      <div class="form-group">
        <label for="driving-license">Driving License *</label>
        <input type="number" id="dlicense" name="dlicense" required>
      </div>
      <div class="form-group">
        <label for="permanent-address">Permanent Address *</label>
        <input type="text" id="pmntaddress" name="paddress" required>
      </div>
      <div class="form-group">
        <label for="present-address">Present Address *</label>
        <input type="text" id="prsntaddress" name="preaddress" required>
      </div>
      <div class="form-group">
        <label for="password">New Password *</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <label for="confirm-password">Confirm Password *</label>
        <input type="password" id="confirm-password" name="cpassword" required>
      </div>
      
      <input class="button" value="Submit" name="rider_signup" type="submit">
    </form>
    <p>Already have an account? <a href="rider_login.php">Log in here</a></p>
  </section>


  
  <script>
      function validform() {
        var fname = document.forms['rider_signup_form']['fname'].value;
        var email = document.forms['rider_signup_form']['email'].value;
        var phone = document.forms['rider_signup_form']['phone'].value;
        var nid = document.forms['rider_signup_form']['nid'].value;
        var dlicense = document.forms['rider_signup_form']['dlicense'].value;
        var paddress = document.forms['rider_signup_form']['paddress'].value;
        var password = document.forms['rider_signup_form']['password'].value;
        var cpassword = document.forms['rider_signup_form']['cpassword'].value;
        
        // Email validation
        var emailRegex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/;
        if (email === "" || !email.match(emailRegex)) {
          alert("Please enter a valid email address.");
          document.forms['rider_signup_form']['email'].focus();
          return false;
        }

        // Phone number validation (must be numeric)
        var phoneRegex = /^\d+$/;
        if (phone === "" || !phone.match(phoneRegex)) {
          alert("Phone number can only contain numbers.");
          document.forms['rider_signup_form']['phone'].focus();
          return false;
        }

        // Password validation (at least 8 characters)
        if (password === "" || password.length < 8) {
          alert("Password must be at least 8 characters.");
          document.forms['rider_signup_form']['password'].focus();
          return false;
        }

        if (password !== cpassword) {
          alert("Passwords don't match.");
          document.forms['rider_signup_form']['password'].focus();
          document.forms['rider_signup_form']['cpassword'].focus();
          return false;
        }

        // Other field validations (you can add more as needed)
        if (fname === "") {
          alert("First Name can't be empty!");
          document.forms['rider_signup_form']['fname'].focus();
          return false;
        }
        
        if (nid === "") {
          alert("NID number can't be empty!");
          document.forms['rider_signup_form']['nid'].focus();
          return false;
        }

        if (dlicense === "") {
          alert("Driving License can't be empty!");
          document.forms['rider_signup_form']['dlicense'].focus();
          return false;
        }

        if (paddress === "") {
          alert("Permanent address can't be empty!");
          document.forms['rider_signup_form']['paddress'].focus();
          return false;
        }

        // If all validations pass, the form will be submitted
        return true;
      }

  </script>



</body>
</html>
