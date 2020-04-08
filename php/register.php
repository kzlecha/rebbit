<?php
// Configuration file 
require_once "include/config.php";
 
// User name and password defined, left with empty variables 
$user_name = $password = $confirm_password = $email = $confirm_email = "";
$username_err = $password_err = $confirm_password_err = $email_err = $confirm_email_err = "";
 
// When form is submitted process the data 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
 // TODO: Add photo option and js validation 

    // Username validation 
    if(empty(trim($_POST["user_name"]))){
        $username_err = "Please create a username. ";
    }elseif(strlen(trim($_POST["user_name"])) > 32) {
        // Password must be greater than 8 char
        $username_err = "Password must have less than 32 characters.";
    }else{
        // Select statement of user_name
        $sql = "SELECT user_id FROM User WHERE user_name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["user_name"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Sorry, this username is already taken.";
                } else{
                    $username = trim($_POST["user_name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate email
    if(empty(trim($_POST["confirm_email"]))){
        // Cannot be left empty
        $email_err = "Please enter an email.";   
    } elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $confirm_email)){ 
        // Password must contain at least one number
        $confirm_email_err = "Please enter a valid email.";
    } else{
        // Check if email matches 
        $confirm_email = trim($_POST["confirm_email"]);
        if(empty($password_err) && ($email != $confirm_email)){
            $confirm_email_err = "Email does not match.";
        }
    }

    // Validate confirm email
    if(empty(trim($_POST["email"]))){
        // Cannot be left empty
        $email_err = "Please enter an email.";   
    } elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){ 
        // Password must contain at least one number
        $email_err = "Please enter a valid email.";  
    } 
    
   // Validate password
    if(empty(trim($_POST["password"]))){
        // Cannot be left empty
        $password_err = "Please enter a password.";   
    } elseif(strlen(trim($_POST["password"])) < 8) {
        // Password must be greater than 8 char
        $password_err = "Password must have at least 8 characters.";
    } elseif(!preg_match("#[0-9]+#", $password)){
        // Password must contain at least one number
        $password_err = "Your password must contain at least one number.";
    } elseif(!preg_match("#[A-Z]+#", $password)){
        // Password must contain one uppercase letter
        $password_err = "Your password must contain one uppercase letter";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        // Check if password matches 
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password does not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (user_name, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $user_name;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash 
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
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
        <h2>Sign Up</h2>
        <p>Please create a username and password to create an account along with an email and photo to create an account. </p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group row<?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <div class="col-md-6">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $user_name; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
            </div>    
            <div class="form-group row<?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <div class="col-md-6">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                    <span class="help-block"><?php echo $email_err; ?></span>
                </div>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <div class="col-md-6">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <div class="col-md-6">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
            </div>
            <div class="form-group col-md-6">
                <input type="submit" class="btn btn-primary submit_btn" value="Submit">
            </div>
            <p style="font-size: small;">Already have an account? <a class="rebbit_link" href="login.php">Login</a></p>
            <p style="font-size: small;">Forgot your password? <a class="rebbit_link" href="reset.php">Reset password</a></p>
        </form>
    </div>    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="../bootstrap/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </body>
</html>