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
    <title>Ride Request Status | PothePothe</title>
</head>

<body>
    <header>
        <div class="logo">Pothe Pothe</div>
        <nav>
            <ul>
                

                <li>
                    <a href="passenger_profile.php">Profile</a>
                </li>
                <li>
                    <a href="passenger_group_ride.php">Create New Group</a>
                </li>

                <li>
                    <a href="passenger_accepted_group_ride.php">Accepted Group Ride</a>
                </li>

                <li>
                    <a href="accepted_ride_passengerview.php">Accepted Ride</a>
                </li>

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



        <?php
            $r_user_id = $result['id'];//user id from session variable
            $count = "SELECT COUNT(*) as count FROM group_ride WHERE passenger_id = $r_user_id ";
            $r_sql = "SELECT * FROM group_ride where passenger_id = $r_user_id ORDER BY group_id DESC ";
            $r_query = mysqli_query($con, $r_sql);
            //$r_result = mysqli_fetch_assoc($r_query);
        ?>

        <div class="ride_request_status_containter">
            <h2>List of Created Group Ride</h2>

            <table>
                <tr>
                    <th>Serial No</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>No.of Passenger</th>
                    <th>Group ID</th>
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
                    <td><?php echo $r_result['passenger_number']; ?></td>
                    <td><?php echo $r_result['group_identity']; ?></td>
                    <td> <a href="add_with_group.php?id=<?php echo $r_result['group_id']; ?>">Add with Group</a></td>
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