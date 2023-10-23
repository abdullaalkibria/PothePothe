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
    <title>Passenger Profile | PothePothe</title>
    <link rel="icon" type="image/x-icon" href="logo2.png">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
</head>

<body style="background-image: url('bg3.jpg');background-size: cover; background-position: center; width: 100%; height: 100%;">
  <header>
  <div class="logo"><a href="index.php"><img src="logo2.png" height="50px"></a></div>
        <nav>
            <ul>
                <li><a href="passenger_profile.php">Profile</a></li>
                <li><a href="ride_request_status.php">Ride Request Status</a></li>
                <li><a href="passenger_group_ride.php">Create New Group</a></li>
                <li><a href="passenger_created_group_ride.php">Created Group List</a></li>
                <li><a href="passenger_addto_group_list.php">Add with Group Ride</a></li>
                <li><a href="passenger_added_group_list.php">Joined Group</a></li>
                <li><a href="accepted_ride_passengerview.php">Accepted Ride</a></li>
                
                <li>
                    <form action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> " method="get">
                        <input type="submit" name="logout" value="Logout">
                    </form>
                </li>
            </ul>
        </nav>
    </header>


    <div class="container" style="width: 100%; height: 100vh">

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
            $sql = "SELECT * FROM passenger_info where email = '$em' ";
            $query = mysqli_query($con, $sql);
            $result = mysqli_fetch_assoc($query);
            ?>

            <div class="profile-header">
                <img src="R.png" alt="Profile Picture" class="profile-picture">
                <h2 class="profile-name">
                    <?php echo $result['fname']." ". $result['lname']; ?>
                </h2>
                <p class="profile-email">
                    <?php echo $result['email']; ?>
                </p>
            </div>
            <div>
                <h3><?php echo "Phone: ".$result['phone'];?></h3>
                <h3><?php echo "NID: ".$result['nid'];?></h3>
            </div>
            <div class="profileAction">
            <a class="profile-button" href="edit_profile.html">Edit Profile</a>
                <a class="profile-button" href="manage_profile.html">Manage Account</a>
            </div>
        </div>

        <div class="ride_request_container">
            <h5>Let's Request a ride</h5>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <span>From :</span>
                <input type="text" name="r_from" placeholder="From" required>
                <span>To : </span>
                <input type="text" name="r_to" placeholder="To" required>
                <span>Date :</span>
                <input type="date" name="r_date" id="datetime" required>
                <span>Time :</span>
                <input type="time" name="r_time" required>
                <input type="submit" value="Ride Request" name="ride_request">
            </form>

            <?php
                if (isset($_POST['ride_request'])) {
                    $r_user_id = $result['id'];//user id from session variable
                    $r_from = $_POST['r_from'];
                    $r_to = $_POST['r_to'];
                    $r_date = $_POST['r_date'];
                    $r_time = $_POST['r_time']; 

                    // Sanitize the input (you can add more validation as needed)
                    $inputDate = filter_var($r_date, FILTER_SANITIZE_STRING);
                    $inputTime = filter_var($r_time, FILTER_SANITIZE_STRING);

                    if ($r_from == "" or $r_to == "" or $r_date == "" or $r_time == "") {
            ?>

            <span class="errmsg">
                <?php echo "Please fill the form correctly.";?>
            </span>
            <?php
                    } else {
                    
                    mysqli_query($con,"INSERT INTO ride_request (r_from, r_to, r_date, r_time, r_user_id) VALUES ('$r_from', '$r_to', '$inputDate', '$inputTime', '$r_user_id')") or die("".mysqli_error());
                    
            ?>

            <span class="successmsg">
                <?php   echo "Thanks for your request."; ?>
            </span>
            <?php
                    }
                }
            ?>
        </div>
        <div id="map">
            <!---<iframe src="map.php" frameborder="0" scrolling="no"></iframe>--->
        </div>
    </div>
</body>

</html>


<!-- leaflet js cdn -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script>
var map = L.map('map').setView([23.684994, 90.356331], 13);

var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
});

osm.addTo(map);

// google street 
googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
    maxZoom: 20,
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
});
//googleStreets.addTo(map);

//google satellite
googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
    maxZoom: 20,
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
});
// googleSat.addTo(map)


//leaflet search

L.Control.geocoder().addTo(map);
</script>