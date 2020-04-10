<?php

    session_start();

    require_once "include/config.php";

    // if post_id or user_id is null, exit
    if(!isset($_POST["post_id"]) || empty($_POST['post_id'])){
        header("location: index.php");
    }else if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        // they can't comment
        header("location: post.php?post_id=".filter_input(INPUT_POST, 'post_id'));
    }
    $user_id = $_SESSION["user_id"];
    $post_id = filter_input(INPUT_POST, 'post_id');
    $comment_body = filter_input(INPUT_POST, 'comment_body');

    $sql = "INSERT INTO Comment (user_id, post_id, comment_body) VALUES (?,?,?)";

    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $param_userid, $param_postid, $param_commentbody);
        $param_userid = $user_id;
        $param_postid = $post_id;
        $param_comment = $comment;

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }else{
        echo "Oops! Something went wrong. Please try again later";
    }
    header("location: post.php?post_id=".filter_input(INPUT_POST, 'post_id'));

?>