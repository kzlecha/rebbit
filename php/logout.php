<?php
// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();

// set logged_in to be false
$_SESSION["loggedin"] = false;
 
// Redirect to login page
header("location: login.php");
exit;
?>