<?php
    session_start();
    require "dbcon.php";
?>
<?php
// If the session variable is empty, this
// means the user is yet to log in
// User will be sent to 'login.php' page
// to allow the user to log in
if (!isset($_SESSION['email'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: login.php');
    exit(); // Add exit to stop script execution after redirection
}

// Logout button will destroy the session, and
// will unset the session variables
// User will be headed to 'login.php'
// after logging out
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['email']);
    header("location: index.php");
    exit(); // Add exit to stop script execution after redirection
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="driver_profile.css">
    <link rel="stylesheet" href="style.css">
    <title>List of ride request | PothePothe</title>
</head>

<body>
    <header>
        <div class="logo">Pothe Pothe</div>
        <nav>
            <ul>
                <li>
                    <a href="driver_profile.php">Driver Profile</a>
                </li>
                <li>
                    <a href="listof_request_status.php">List of Ride Requests</a>
                </li>
                <li>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
                        <input type="submit" name="logout" value="Logout">
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container" style="width: 100%">
        <div class="profile-container">
            <!-- Accessible only to the users that have logged in already -->
            <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success">
                <h3>
                    <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
            <?php endif ?>

            <!-- information of the user logged in -->
            <!-- welcome message for the logged in user -->
            <?php
                $em = $_SESSION['email']; 
                $sql = "SELECT * FROM rider_info where email = '$em' ";
                $query = mysqli_query($con, $sql);
                $result = mysqli_fetch_assoc($query);
                $driver_id = $result['id'];
            ?>

            <div class="profile-header">
                <img src="logo.png" alt="Profile Picture" class="profile-picture">
                <h2 class="profile-name">
                    <?php echo $result['fname']." ". $result['lname']; ?>
                </h2>
                <p class="profile-email">
                    <?php echo $result['email']; ?>
                </p>
            </div>
            <div>
                <p><b><?php echo "Phone: ".$result['phone'];?></b></p>
                <p><b> <?php echo "License: ".$result['dlicense'];?></b></p>
            </div>
            <div class="profileAction">
                <p><button class="profile-button">Edit Profile</button></p>
                <p><button class="profile-button">Manage Account</button></p>
            </div>
        </div>

        <?php
            $result_single_request = null; // Initialize the variable
            if (isset($_GET['requestId']) and isset($_GET['userId']) ) {
                $request_id = $_GET['requestId'];
               // $_SESSION['request_id'] = $request_id;
                $passenger_id = $_GET['userId'];
               // $s_r_id = $_SESSION['request_id'];
                $response_sql = "SELECT * FROM ride_request where request_id = '$request_id'";
                $response_query = mysqli_query($con, $response_sql);
                $result_single_request = mysqli_fetch_assoc($response_query);
                $passenger_id = $result_single_request['r_user_id'];
            }

        ?>

        <div class="rider_response" style="margin-left: 20%; margin-top: 40px;">
        
            <?php if ($result_single_request) : ?>
                <form action="response.php" method="get" onsubmit="return validform()"  name="response_form" >
                <p>Request ID: <input type="number" value="<?php echo $request_id; ?>" name="requestId"><span class="errmsg">(Do not change this value.)</span></p>
                <p>Passenger ID: <input type="number" value="<?php echo $passenger_id; ?>" name="passengerId"><span class="errmsg">(Do not change this value.)</span></p>
                <p>From : <?php echo $result_single_request['r_from']; ?> </p>
                <p>To :   <?php echo $result_single_request['r_to']; ?></p>
                <p>Date : <?php echo $result_single_request['r_date']; ?> </p>
                <p>Time : <?php echo $result_single_request['r_time']; ?></p>
                

                <!-- <?php 

                    // if (isset($_POST['accept_request'])) {
                    //     $ammount = $_POST["ammount"];
                    //     mysqli_query($con,"INSERT INTO accepted_ride (request_id, passenger_id, driver_id, ammount) VALUES ('$request_id', '$passenger_id', '$driver_id', '$ammount')") or die("".mysqli_error());
                    //     echo "Accepted";
                    // }

                ?> -->

                    <p>Ammount (TAKA): <input type="number" name="ammount"></p>
                    <p><input type="submit" name="accept_request" value="Accept"></p>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <script>
      function validform()
      {
        var ammount = document.forms['response_form']['ammount'].value;
        
        if(ammount=="")
        {
          alert("Ammount can't be empty!");
          document.forms['response_form']['ammount'].focus();
          return false;
        }
      }
    </script>

</body>

</html>
