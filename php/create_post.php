<?php

session_start();

// Configuration file 
require_once "include/config.php";
// require_once "include/authorization.php";

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false){
    // if the user is not logged in, they cannot create a knot
    header("login.php");
}

if(!isset($_GET["knot_id"])){
    header("index.php");
}

// User name and password defined, left with empty variables 
$post_title = $post_body = $post_err = "";
 
// When form is submitted process the data 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Username validation 
    if(empty(trim($_POST["post_title"]))){
        $post_err = "Please create a post title.";
    }elseif(strlen(trim($_POST["post_title"])) > 256) {
        // Password must be greater than 8 char
        $post_err = "Post Title must have less than 256 characters.";
    }else{
        $post_title = $_POST["post_title"];
    }
    
    if(strlen(trim($_POST["post_body"])) > 256) {
        // Password must be greater than 8 char
        $post_err = "Post Body must have less than 256 characters.";
    }else{
        $post_body = $_POST["post_body"];
    }
        
    // Check input errors before inserting in database
    if(empty($post_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO Post (user_id, knot_id, post_title, post_body, image_location) VALUES (?, ?, ?, ?, 'imag')";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iiss", $param_userid, $param_knotid, $param_title, $param_body);
            $param_userid = $_SESSION["user_id"];
            $param_knotid = $_GET["knot_id"];
            $param_title = $post_title;
            $param_body = $post_body;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // set the creator as the admin
                $sql = "SELECT post_id FROM Post WHERE user_id = ? AND knot_id = ? AND post_title = ?";
                if($stmt = mysqli_prepare($link, $sql)){
                    
                    mysqli_stmt_bind_param($stmt, "iis", $param_userid, $param_knotid, $param_title);
                    $param_userid = $_SESSION["user_id"];
                    $param_knotid = $_GET["knot_id"];
                    $param_title = $post_title;

                    if(mysqli_stmt_execute($stmt)){
                        mysqli_stmt_bind_result($stmt, $post_id);
                        if(mysqli_stmt_fetch($stmt)){
                            header("location: post.php?post_id=".$post_id);
                        }
                    }
                }
                    
                header("location: index.php");
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
        <h2>Create Post</h2>
        <p>Please create a Post.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($knot_err)) ? 'has-error' : ''; ?>">
                <div class="col-md-6">
                    <label>Post Title:</label>
                    <input type="text" name="post_title" class="form-control" value="<?php echo $post_title; ?>" maxlength=64>
                </div>
                <div class="col-md-6">
                    <label>Post Body:</label>
                    <textarea name="post_body" class="form-control" value="<?php echo $post_body; ?>" maxlength=64></textarea>
                </div>
                <div class="col-md-6">
                    <span class="help-block"><?php echo $post_err; ?></span>
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