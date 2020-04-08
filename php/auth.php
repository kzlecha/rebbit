<?php
    session_start();  
	$authenticated = $_SESSION['authenticatedUser']  == null ? false : true;

	if (!$authenticated)
	{
		$loginMessage = "You have not been authorized to access this feature " . $_SERVER['REQUEST_URI'];
        $_SESSION['loginMessage']  = $loginMessage;        
		header('Location: login.php');
	}
?>