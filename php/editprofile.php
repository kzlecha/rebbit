<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "include/config.php";
 
// Define variables and initialize with empty values
$new_username = $new_email = "";
$new_username_err = $new_email_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new username
    if(empty(trim($_POST["new_username"]))){
        $new_username_err = "Please enter the new username.";     
    } else{
        $new_username = trim($_POST["new_username"]);
    }
    
    // Validate new email
    if(empty(trim($_POST["new_email"]))){
        $new_email_err = "Please enter new email.";
    } else{
        $new_email = trim($_POST["new_email"]);
    }

    // Check input errors before updating the database
    if(empty($new_username_err) && empty($new_email_err)){
        // Prepare an update statement
        $sql = "UPDATE User SET user_name = ?, email = ? WHERE user_id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssi", $param_New_username, $param_New_email, $param_userid);
            
            // Set parameters
            $param_New_username = $new_username;
            $param_New_email = $new_email;
            $param_userid = $_SESSION["user_id"];
            
            if(mysqli_stmt_execute($stmt)){
                session_destroy();
                header("location: profile.php");
                exit();
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

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Rebbit - Update profile</title>
</head>

<!-- JS form validation -->
<script>
function validateForm() {
    // Check new username
  var newUsernameCheck = document.forms["edit"]["new_password"].value;
  if (newUsernameCheck == "") {
    alert("Password must be filled out");
    return false;
  }
    // Check new email
  var newEmailCheck = document.forms["edit"]["confirm_password"].value;
  if (newEmailCheck == "") {
    alert("You must confirm password to continue");
    return false;
  }
}

</script>
<style>
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

<!-- RESET FORM -->
<div style="padding: 10px; padding-top: 2em;">
    <div class="wrapper form_rebbit">
        <h2>Edit Profile</h2>
        <p>Please enter a new username and/or email</p>
        <p>Fields cannot be left empty</p>
        <form id="edit" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()" method="post"> 
            <div class="form-group <?php echo (!empty($new_username_err)) ? 'has-error' : ''; ?>">
                <label>New Username</label>
                <input type="text" name="new_username" class="form-control" value="<?php echo $new_username; ?>">
                <span class="help-block"><?php echo $new_username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($new_email_err)) ? 'has-error' : ''; ?>">
                <label>New Email</label>
                <input type="text" name="new_email" class="form-control">
                <span class="help-block"><?php echo $new_email_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary submit_btn" value="Submit">
                <a class="btn btn-link rebbit_link" href="welcome.php">Cancel</a>
            </div>
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