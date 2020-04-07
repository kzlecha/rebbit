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

function is_admin($user_id){
    /*
    check to see if the given in user is an admine
    */

    // prepare query
    $sql = "SELECT user_id FROM Admin WHERE user_id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // bind the parameters
        mysqli_stmt_bind_param($stmt, "s", $param_userid);
        $param_userid = $user_id;
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

// determine if knot admin
function is_knot_admin($user_id, $knot_id){
    /*
    check to see if the given in user is an admine
    */

    // prepare query
    $sql = "SELECT user_id FROM KnotAdmin WHERE knot_id = ? and user_id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // bind the parameters
        mysqli_stmt_bind_param($stmt, "s", $param_userid, $param_knotid);
        $param_userid = $user_id;
        $param_knotid = $knot_id;
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