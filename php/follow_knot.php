<?php

    session_start();

    $loggedin = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;

    // if the user is not logged in, exit
    if(!$loggedin){
        header("page_not_found.php");
    }

    $user_id = $_SESSION["user_id"];
    $knot_id = $_GET["knot_id"];

?>