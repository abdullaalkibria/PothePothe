<?php
$user="root";
$pass="";
$dbname="rsp";
$con=mysqli_connect("localhost",$user,$pass,$dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

//mysqli_close($con);
?> 