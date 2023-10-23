<?php
session_start();

    require "dbcon.php";
    $em = $_SESSION['email']; 
    $sql = "SELECT * FROM rider_info where email = '$em' ";
    $query = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($query);
    $driver_id = $result['id'];

   if (isset($_GET['accept_request'])) {
        $request_id = $_GET['requestId'];
        $passenger_id = $_GET['passengerId'];
        $ammount = $_GET["ammount"];
        $result = mysqli_query($con,"INSERT INTO accepted_ride (request_id, passenger_id, driver_id, ammount) VALUES ('$request_id', '$passenger_id', '$driver_id', '$ammount')") or die("".mysqli_error());
        //echo "Accepted";

      if($result === TRUE)
      {

        header('location:driver_accepted_ride.php');

      }else{
      	  echo "Error:".mysql_errno($conn);
      }
   }

?>