<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect them to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "include/config.php";
 
// Define variables and initialize with empty values
$user_name = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["user_name"]))){
        $username_err = "Please enter username.";
    } else{
        $user_name = trim($_POST["user_name"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT user_id, user_name, password FROM User WHERE user_name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $user_name;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $user_name, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $user_id;
                            $_SESSION["user_name"] = $user_name;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
 <!-- TODO: Add linkage to Reset Password page -->

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Rebbit - Your world of frogs</title>
    </head>

<!-- JS form validation -->
<script>
function validateForm() {
    // Check username 
  var userCheck = document.forms["login"]["user_name"].value;
  if (userCheck == "") {
    alert("You must enter a username to login");
    return false;
  }
    // Check password
  var passCheck = document.forms["login"]["password"].value;
  if (passCheck == "") {
    alert("You must enter a password to login");
    return false;
  }
}
</script>

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

<body style="margin: 0.25em; background-color: #f1f0f0;">    <!-- NAVIGATION BAR-->
    <?php
        require_once "include/navbar.php";
    ?>

<div style="padding: 10px; padding-top: 2em;">
    <!-- Login Form -->
    <div class="wrapper form_rebbit">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form id="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <div class="col-md-6">
                    <label>Username</label>
                    <input type="text" name="user_name" class="form-control" value="<?php echo $user_name; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <div class="col-md-6">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
            </div>
            <div class="form-group col-md-6">
                <input type="submit" class="btn btn-primary submit_btn" value="Login">
            </div>
            <p style="font-size:small">Don't have an account? <a class="rebbit_link" href="register.php">Sign up</a></p>
            <p style="font-size: small;">Forgot your password? <a class="rebbit_link" href="reset.php">Reset password</a></p>
        </form>
    </div>  
</div>
    
      
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="../bootstrap/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
</body>
</html>