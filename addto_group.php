<?php
session_start();

    require "dbcon.php";
    $em = $_SESSION['email']; 
    $sql = "SELECT * FROM passenger_info where email = '$em' ";
    $query = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($query);
    $passenger_id = $result['id'];

   if (isset($_GET['addto_group'])) {
        $group_id = $_GET['id'];
        $noof_passenger = $_GET["numb_of_passenger"];
    
        $result = mysqli_query($con,"INSERT INTO addto_group (group_id, passenger_id, no_of_passenger) VALUES ('$group_id', '$passenger_id', '$noof_passenger')") or die("".mysqli_error());


      if($result === TRUE)
      {

        header('location:passenger_added_group_list.php');

      }else{
      	  echo "Error:".mysql_errno($conn);
      }
   }

?>