<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="style.css">
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

    <div class="feedback_message">
        <p>Thank You <b><?php echo " ".$_POST["name"]; ?></b> for your valuable feedback.</p>
        <p>Dear <b> <?php echo " ".$_POST["name"]; ?> </b> </p>
        <p>Your Message:  <?php echo $_POST["message"]; ?></p><br>
    </div>

    <script>
      function validform()
      {
        var y=document.forms['regform']['username'].value;
        if(y=="")
        {
          alert("Name Empty");
          document.forms['regform']['username'].focus();
          return false;
        }
      }
    </script>

</body>
</html>