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
    <title>Driver Profile | PothePothe</title>
    <!-- Leaflet css -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.79.0/dist/L.Control.Locate.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
</head>

<body style="background-image: url('bg3.jpg');background-size: cover; background-position: center; width: 100%; height: 100%;">
    <header>
    <div class="logo"><a href="index.php"><img src="logo2.png" height="25px"></a></div>
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

    <div class="container" style="width: 100%;">
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
                <p><b> <?php echo "License: ".$result['dlicense'];?></b></p>
            </div>
            <div class="profileAction">
            <a class="profile-button" href="edit_profile.html">Edit Profile</a>
                <a class="profile-button" href="manage_profile.html">Manage Account</a>
            </div>
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
<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.79.0/dist/L.Control.Locate.min.js" charset="utf-8">
</script>
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

//user location 

L.control.locate().addTo(map);

// Real Time Location Feature

// if(!navigator.geolocation) {
//     console.log("Your browser doesn't support geolocation feature!")
// } else {
//     setInterval(() => {
//         navigator.geolocation.getCurrentPosition(getPosition)
//     }, 5000);
// }

var marker, circle;

function getPosition(position) {
    // console.log(position)
    var lat = position.coords.latitude
    var long = position.coords.longitude
    var accuracy = position.coords.accuracy

    if (marker) {
        map.removeLayer(marker)
    }

    if (circle) {
        map.removeLayer(circle)
    }

    marker = L.marker([lat, long])
    circle = L.circle([lat, long], {
        radius: accuracy
    })

    var featureGroup = L.featureGroup([marker, circle]).addTo(map)

    map.fitBounds(featureGroup.getBounds())

    console.log("Your coordinate is: Lat: " + lat + " Long: " + long + " Accuracy: " + accuracy)
}
</script>