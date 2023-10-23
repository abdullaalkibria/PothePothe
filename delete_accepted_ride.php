<?php
        session_start();
        require "dbcon.php";


     if (isset($_GET['id'])) {
     	$id = $_GET['id'];

     	$sql = "DELETE FROM accepted_ride WHERE accepted_id = $id ";

     	$result = mysqli_query($con,$sql);

     	if ($result==TRUE) {

     		header('location:driver_accepted_ride.php');
     	}else{
     	    echo "Error:".mysql_errno($conn);	
     	}
     }
?>