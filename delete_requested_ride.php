<?php
        session_start();
        require "dbcon.php";


     if (isset($_GET['id'])) {
     	$id = $_GET['id'];

     	$sql = "DELETE FROM ride_request WHERE request_id = $id ";

     	$result = mysqli_query($con,$sql);

     	if ($result==TRUE) {

     		header('location:ride_request_status.php');
     	}else{
     	    echo "Error:".mysql_errno($conn);	
     	}
     }
?>