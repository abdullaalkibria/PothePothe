<?php
        session_start();
        require "dbcon.php";


     if (isset($_GET['id'])) {
     	$id = $_GET['id'];

     	$sql = "DELETE FROM group_accepted WHERE accepted_id = $id ";

     	$result = mysqli_query($con,$sql);

     	if ($result==TRUE) {

     		header('location:driver_accepted_group.php');
     	}else{
     	    echo "Error:".mysql_errno($conn);	
     	}
     }
?>