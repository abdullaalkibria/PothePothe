<?php
    session_start();
    require "dbcon.php";
?>
<?php
// If the session variable is empty, this
// means the user is yet to login
// User will be sent to 'login.php' page
// to allow the user to login
if (!isset($_SESSION['email'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: login.php');
}
  
// Logout button will destroy the session, and
// will unset the session variables
// User will be headed to 'login.php'
// after logging out
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['email']);
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="driver_profile.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="logo2.png">
    <title>List of ride request | PothePothe</title>
</head>

<body style="background-image: url('bg3.jpg');background-size: cover; background-position: center; width: 100%; height: 100%;">
  <header>
  <div class="logo"><a href="index.php"><img src="logo2.png" height="50px"></a></div>
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
                <p><b><?php echo "License: ".$result['dlicense'];?></b></p>
            </div>
            <div class="profileAction">
            <a class="profile-button" href="edit_profile.html">Edit Profile</a>
                <a class="profile-button" href="manage_profile.html">Manage Account</a>
            </div>
        </div>
        <?php

            // $sql_accept_ride = "SELECT
            // group_ride.group_id,
            // group_ride.r_from,
            // group_ride.r_to,
            // group_ride.r_date,
            // group_ride.r_time,
            // SUM(addto_group.no_of_passenger) AS total 
            // FROM group_ride, addto_group
            // where addto_group.group_id = $group_id AND group_ride.group_id = $group_id; ";
            


            $sql_accept_ride = "SELECT
            group_ride.group_id,
            group_ride.r_from,
            group_ride.r_to,
            group_ride.r_date,
            group_ride.r_time,
            group_accepted.ammount,
            passenger_info.phone, 
            group_accepted.accepted_id
            FROM
                group_ride
            INNER JOIN
                group_accepted ON group_accepted.group_id = group_ride.group_id
            INNER JOIN
                passenger_info ON passenger_info.id = group_ride.passenger_id
            
            GROUP BY 
            group_accepted.group_id
            ORDER BY
                group_accepted.accepted_id DESC;
        ";


            $r_query = mysqli_query($con, $sql_accept_ride);
        ?>

        <div class="ride_request_status_containter">
            <h2>Accepted Group Ride</h2>
            <table>
                <tr>
                    <th>Serial</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Passenger Phone</th>
                    <th>Fare(TAKA)</th>
                    <th>Action</th>

                </tr>
                <?php  
                    $indx = 1;
                    while( $r_result = mysqli_fetch_assoc($r_query) )
                    {
                ?>
                <tr>
                    <td><?php echo $indx; ?></td>
                    <td><?php echo $r_result['r_from']; ?></td>
                    <td><?php echo $r_result['r_to']; ?></td>
                    <td><?php echo $r_result['r_date']; ?></td>
                    <td><?php echo $r_result['r_time']; ?></td>
                    <td><?php echo $r_result['phone']; ?></td>
                    <td><?php echo $r_result['ammount']; ?></td>
                    <td>
                        <!-- <a href="request_response.php?requestId=<?php //echo $r_result['request_id'];?>&userId=<?php //echo $r_result['r_user_id'];?>"> -->
                        <a href="delete_accepted_group.php?id=<?php echo $r_result['accepted_id']; ?>">Cancle Ride</a>
                        <!-- </a> -->
                    </td>
                </tr>
                <?php
                    $indx++;
                    }
                ?>
            </table>
        </div>
    </div>
</body>

</html>
