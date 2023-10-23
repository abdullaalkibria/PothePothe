<?php
require "dbcon.php";
// Starting the session, necessary
// for using session variables
session_start();

// User login
if (isset($_POST['rider_login'])) {
	
	// Data sanitization to prevent SQL injection
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$password = mysqli_real_escape_string($con, $_POST['password']);

	// Error message if the input field is left blank
	if (empty($email)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}


		
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $results = mysqli_query($con, $query);

    // $results = 1 means that one user with the
    // entered username exists
    if (mysqli_num_rows($results) == 1) {
        
        // Storing username in session variable
        $_SESSION['email'] = $email;
        
        // Welcome message
        $_SESSION['success'] = "You have logged in!";
        
        // Page on which the user is sent
        // to after logging in
        header('location: index.php');
    }
}

?>
