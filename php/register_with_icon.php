<?php
// Configuration file 
require_once "include/config.php";
 
//$user_name = $_POST['user_name'] ?? ''; $username_err = $_POST['username_err'] ?? ''; 
//$password = $_POST['password'] ?? ''; $password_err = $_POST['password_err'] ?? '';
//$confirm_password = $_POST['confirm_password'] ?? ''; $confirm_password_err = $_POST['confirm_password_err'] ?? '';
//$email = $_POST['email'] ?? ''; $email_err = $_POST['email_err'] ?? '';
//$confirm_email = $_POST['confirm_email'] ?? ''; $confirm_email_err = $_POST['confirm_email_err'] ?? '';

// Username, password, and email created as empty variables 
$user_name = $password = $confirm_password = $email = $confirm_email = $image_location = "";
$username_err = $password_err = $confirm_password_err = $email_err = $confirm_email_err = $image_location_err = "";

// When form is submitted process the data 
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Username validation 
    if(empty(trim($_POST["user_name"]))){
        $username_err = "Please create a username. ";
    }elseif(strlen(trim($_POST["user_name"])) > 32) {
        // username must be less that 32 char
        $username_err = "Username must have less than 32 characters.";
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
                    $user_name = trim($_POST["user_name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } else{
        // Prepare a select statement
        	$mystring = trim($_POST["email"]);
        	$word = '@';
        	$word2 = '.';
        	if(strpos($mystring, $word) > 0 and strpos($mystring, $word) >0 ){
        		$email = trim($_POST["email"]);
        	}else{
        		$email_err = "Please enter a valid email";
        	}
        }

    // Validate confirm email
    if(empty(trim($_POST["confirm_email"]))){
        $email_err = "Please confirm email.";
    } elseif(empty($email_err)){
        $confirm_email = trim($_POST["confirm_email"]);
        if(empty($password_err) && ($email != $confirm_email)){
            $confirm_email_err = "Email does not match.";
        }
    } else {
        // Prepare a select statement
        	$mystring = trim($_POST["confirm_email"]);
        	$word = '@';
        	$word2 = '.';
        	if(strpos($mystring, $word) > 0 and strpos($mystring, $word) >0 ){
        		$confirm_email = trim($_POST["confirm_email"]);
        	}else{
        		$confirm_email_err = "Please enter a valid email";
        	}
    }
    
   // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    
    // Validate image
    if(empty(trim($_POST["image_location"]))){
        $image_location_err = "Please upload image";     
    } else{
       $image_location = trim($_POST["image_location"]);
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($confirm_email_err) && empty($image_location_err)){
        
        // Prepare an insert statement
        //$sql = "INSERT INTO User (user_name, password, email, img_location) VALUES (?, ?, ?, ?)";
        $sql = "INSERT INTO User (user_name, password, email, image_location) VALUES (?, ?, ?, ?)";


        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_email);
            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $param_email, $param_img);

            // Set parameters
            $param_username = $user_name;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash 
            $param_email = $email;
            $param_img = $image_location;
            
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

<!-- JS form validation -->
<script>
function validateForm() {
    // Check username
  var userCheck = document.forms["register"]["username"].value;
  if (userCheck == "") {
    alert("You must enter a username to register");
    return false;
  }
    // Check password
  var passCheck = document.forms["register"]["password"].value;
  if (passCheck == "") {
    alert("You must enter a password to register");
    return false;
  }
    // Check confirm password 
  var confirmPassCheck = document.forms["register"]["confirm_password"].value;
  if (confirmPassCheck == "") {
    alert("You must re-enter your password");
    return false;
  }
    // Check email 
  var emailCheck = document.forms["register"]["email"].value;
  if (emailCheck == "") {
    alert("You must enter an email");
    return false;
  }
    // Check confirm email 
  var confirmEmailCheck = document.forms["register"]["confirm_email"].value;
  if (confirmEmailCheck == "") {
    alert("Re-enter email");
    return false;
  }
    // Check image 
  var imgCheck = document.getElementById('img');
  if(imgCheck.getAttribute('src') == "")
  {
    alert("Empty");
  }
  else
  {
    alert("Filled");
  }
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
    padding-left: 10px;
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
        <p>Please enter your email and create a username and password to create an account. </p>
        <form id="register" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()" method="post">
            <!-- USERNAME -->
            <div class="form-group row<?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <div class="col-md-6">
                    <label>Username</label>
                    <input type="text" name="user_name" class="form-control" value="<?php echo $user_name; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
            </div>    
            <!-- EMAIL -->
            <div class="form-group row<?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <div class="col-md-6">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                    <span class="help-block"><?php echo $email_err; ?></span>
                </div>
            </div>
            <div class="form-group <?php echo (!empty($confirm_email_err)) ? 'has-error' : ''; ?>">
                <div class="col-md-6">
                    <label>Confirm Email</label>
                    <input type="email" name="confirm_email" class="form-control" value="<?php echo $confirm_email; ?>">
                    <span class="help-block"><?php echo $confirm_email_err; ?></span>
                </div>
            </div>
            <!-- PASSWORD -->
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <div class="col-md-6">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
            </div>
            <!-- CONFIRM PASSWORD -->
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <div class="col-md-6">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
            </div>
            <!-- IMAGE -->
            <div class="form-group <?php echo (!empty($image_location_err)) ? 'has-error' : ''; ?>">
                <div class="col-md-6">
                    <input type="file" id="img" name="image_location" accept="image/*">
                    <span class="help-block"><?php echo $image_location_err; ?></span>
                </div>
            </div>
            <!-- SUBMIT -->
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