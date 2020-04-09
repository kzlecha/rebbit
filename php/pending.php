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
    ?>

	<form class="login-form form_rebbit" action="login.php" method="post" style="text-align: center;">
		<p>
			We sent an email to your email to help you recover your account. 
		</p>
        <p>Please <a class="rebbit_link" href="login.php">login</a> to your account with the link set to reset your password </p>
	</form>
		
</body>
</html>