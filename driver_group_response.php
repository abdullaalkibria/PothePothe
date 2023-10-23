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
                <li><a href="driver_profile.php">Driver Profile</a></li>
                <li><a href="listof_request_status.php">Single Ride Requests</a></li>
                <li><a href="driver_accepted_ride.php">Accepted Single Ride</a></li>
                <li><a href="driver_group_ride_list.php">Group Ride Request</a></li>
                <li><a href="driver_accepted_group.php">Accepted Group Ride</a></li>
            
                <li>
                    <form action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> " method="get">
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
            <a class="profile-button" href="edit_profile.html">Edit Profile</a>
                <a class="profile-button" href="manage_profile.html">Manage Account</a>
            </div>
        </div>

        <?php
            $result_single_request = null; // Initialize the variable
            if (isset($_GET['groupId']) ) {
                $group_id = $_GET['groupId'];

                $response_sql = "SELECT 
                group_ride.group_id,
                group_ride.r_from,
                group_ride.r_to,
                group_ride.r_date,
                group_ride.r_time,
                SUM(addto_group.no_of_passenger) AS total 
                FROM group_ride, addto_group
                where addto_group.group_id = $group_id AND group_ride.group_id = $group_id; ";

                $response_query = mysqli_query($con, $response_sql);
                $result_single_request = mysqli_fetch_assoc($response_query);
                // $passenger_id = $result_single_request['r_user_id'];
            }

        ?>

        <div class="rider_response" style="margin-left: 20%; margin-top: 40px;">
        
            <?php if ($result_single_request) : ?>
                <form action="group_response.php" method="get" onsubmit="return validform()"  name="response_form" >
                <p>Group ID: <input type="number" value="<?php echo $group_id; ?>" name="groupId"><span class="errmsg">(Do not change this value.)</span></p>
                
                <p>From : <?php echo $result_single_request['r_from']; ?> </p>
                <p>To :   <?php echo $result_single_request['r_to']; ?></p>
                <p>Date : <?php echo $result_single_request['r_date']; ?> </p>
                <p>Time : <?php echo $result_single_request['r_time']; ?></p>
                <p>Total Passengers : <?php echo $result_single_request['total']; ?></p>

                <!-- <?php 

                    // if (isset($_POST['accept_request'])) {
                    //     $ammount = $_POST["ammount"];
                    //     mysqli_query($con,"INSERT INTO accepted_ride (request_id, passenger_id, driver_id, ammount) VALUES ('$request_id', '$passenger_id', '$driver_id', '$ammount')") or die("".mysqli_error());
                    //     echo "Accepted";
                    // }

                ?> -->

                    <p>Ammount (TAKA): <input type="number" name="ammount"></p>
                    <p><input type="submit" name="accept_group" value="Accept"></p>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <script>
      function validform()
      {
        var ammount = document.forms['accept_request']['ammount'].value;
        
        if(ammount=="")
        {
          alert("Ammount can't be empty!");
          document.forms['accept_request']['ammount'].focus();
          return false;
        }
      }
    </script>

</body>

</html>
