<?php

session_start();

// Configuration file 
require_once "include/config.php";
// require_once "include/authorization.php";

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false){
    // if the user is not logged in, they cannot create a knot
    header("login.php");
}

// User name and password defined, left with empty variables 
$knot_name = "";
$knot_err = "";
// $username_err = $password_err = $knot_err = "";
 
// When form is submitted process the data 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Username validation 
    if(empty(trim($_POST["knot_name"]))){
        $username_err = "Please create a knot name. ";
    }elseif(strlen(trim($_POST["knot_name"])) > 64) {
        // Password must be greater than 8 char
        $username_err = "Knot Name must have less than 64 characters.";
    }else{
        // Select statement of user_name
        $sql = "SELECT knot_id FROM Knot WHERE knot_name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_knotname);
            
            // Set parameters
            $param_knotname = trim($_POST["knot_name"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Sorry, this knot is already taken.";
                } else{
                    $username = trim($_POST["knot_name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // TODO: validate user login
    // Ensure the user is logged in
    // $valid_user = login_verified($_POST["username"], $_POST["password"]);
    
    // Check input errors before inserting in database
    if(empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO knot (knot_name) VALUES (?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_knotname);
            
            // Set parameters
            $param_knotname = $knot_name;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: knot.php?knot_name=".$knot_name."");
            } else{
                echo "Something went wrong. Please try again later.";
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
    <title>Rebbit - Your world of frogs</title>
</head>
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

.reset_btn{
    color:darkseagreen;
}

.rebbit_link{
    color: darkseagreen;
}

.submit_btn:hover{
    background-color: #9eb9ab;
    border-color: darkseagreen;
}

.reset_btn:hover{
    color: #9eb9ab;
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

    <!-- Sign Up Form -->
    <div class="wrapper form_rebbit" style="padding-top: 40px; padding: 20px;">
        <h2>Create Knot</h2>
        <p>Please create a Knot.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($knot_err)) ? 'has-error' : ''; ?>">
                <div class="col-md-6">
                    <label>Knot Name:</label>
                    <input type="text" name="knot_name" class="form-control" value="<?php echo $knot_name; ?>" maxlength=64>
                    <span class="help-block"><?php echo $knot_err; ?></span>
                </div>
            </div>
            <div class="form-group col-md-6">
                <input type="submit" class="btn btn-primary submit_btn" value="Submit">
                <input type="reset" class="btn btn-default reset_btn" value="Reset">
            </div>
        </form>
    </div>    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="../bootstrap/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>