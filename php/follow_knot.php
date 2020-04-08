<?php

    session_start();

    require_once "include/config.php";

    $loggedin = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;

    // if the user is not logged in, exit
    if(!$loggedin){
        header("page_not_found.php");
    }

    $user_id = $_SESSION["user_id"];
    $knot_id = $_GET["knot_id"];

    $sql = "INSERT INTO FollowingKnot (user_id, knot_id, create_date) VALUES (?, ?, NOW())";

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $param_userid, $param_knotid);
        
        // Set parameters
        $param_userid = $user_name;
        $param_knotid = $knot_id;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            header("location: knot.php?knot_id=".$knot_id."");
        } else{
            echo "Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);


?>