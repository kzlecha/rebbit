<?php

require_once "config.php";

function login_verified($user_name, $password){
    /*
    @param username: string representing the inputted username
    @param password: string representing password before hash
    ----
    determines of the user is authorized to do an action
    */

    if(!isset($_SESSION["loggedin"])){
        // if the user is not logged in, redirect to login page
        header("login.php");
    }

    if($user_name != $_SESSION["user_name"]){
        return false;
    }

    // otherwise, check if the login information is correct
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
                mysqli_stmt_bind_result($stmt, $user_id, $user_name, $hashed_password);
                if(mysqli_stmt_fetch($stmt)){

                    if(password_verify($password, $hashed_password)){
                        return true;
                    } else{
                        return false;
                    }
                }
            } else{
                return false;
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
            return false;
        }
    }

}

function is_admin(){
    /*
    check to see if the logged in user is an admine
    */

    if(!isset($_SESSION["loggedin"])){
        // if the user is not logged in, redirect to login page
        return false;
    }

    if(!isset($_SESSION["user_id"])){
        // this should never happen if the user is not logged in but to ensure that no execeptions occur
        return false;
    }

    // prepare query
    $sql = "SELECT user_id FROM Admin WHERE user_id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // bind the parameters
        mysqli_stmt_bind_param($stmt, "s", $param_userid);
        $param_userid = $_SESSION["user_id"];
        if(mysqli_stmt_num_rows($stmt) == 1){
            return true;
        }else{
            return false;
        }
    }else{
        echo "an error occured, please try again";
        return false;
    }
    
}

?>