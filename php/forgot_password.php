<?php

session_start();

require_once "include/config.php";

$email="";
$err_email = "";
if (isset($_POST['reset-password'])) {
	$email = $_POST['email'];
  
  $sql = "SELECT email FROM User WHERE email=?";
  $stmt = mysqli_prepare($link, $stmt);

  if (empty($email)) {
  	$err_email  = "Your email is required";
    echo($err_email);
  }else {
      // bind the parameters
      mysqli_stmt_bind_param($stmt, "s", $param_email);
      $param_email = $email;
      
      if(mysqli_stmt_execute($stmt)){
          mysqli_stmt_store_result($stmt);
          if(mysqli_stmt_num_rows($stmt) != 1){
            $err_email = "Sorry, no user exists on our system with that email";
            echo($err_email);
          }
      }
  }

    if($err_email == ""){
        $to = $email;
        $subject = "Reset your password on Rebbit";
        $msg = "Hi there, reset your password here: localhost:8080/rebbit/php/resetPassword.php";
        $msg = wordwrap($msg,70);
        $headers = "From: rebbitdev@gmail.com";
        mail($to, $subject, $msg, $headers);
        header('location: pending.php');
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Rebbit - Reset Password</title>
    </head>
<style>
h1, h2, h3{
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
} 
p{
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
}  
.form_rebbit{
    background-color: #4f676c;
    padding: 20px;
    overflow: auto;
    color: #e9f5ef;
    border-radius: 25px;
    max-width: 600px;
}
.submit_btn{
    background-color: darkseagreen;
    border-color: #9eb9ab;
}
.submit_btn:hover{
    background-color: #9eb9ab;
    border-color: darkseagreen;
}
.rebbit_link{
    color: darkseagreen;
}
.rebbit_link:hover{
    color: #86e4aa;
}
</style>

<body style="margin: 0.25em; background-color: #f1f0f0;">    
<!-- NAVIGATION BAR-->
    <?php
        require_once "include/navbar.php";

        if(isset($_SESSION['user_name'])){
          echo("<div style=\"padding:15px\"><p style=\"color:#4f676c\"><i>Hello, ".$_SESSION['user_name']." </i></p></div>");
        }
    ?>

	<form class="login-form form_rebbit" method="post" style = "margin-left: 5%">
		<h2 class="form-title">Reset password</h2>
		<div class="form-group">
			<label>Your email address</label>
			<input type="email" name="email">
		</div>
		<div class="form-group">
			<button type="submit" name="reset-password" class="submit_btnn">Submit</button>
		</div>
	</form>
</body>
</html>
</html>