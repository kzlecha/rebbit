<?php

session_start();

require_once "include/config.php";

?>

<!doctype html>
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
    body{
        background-color: #d9eee3;
        margin: 0.25em; 
    }
    .flex_post{
        display: flex;
        flex-wrap: nowrap;
        align-items: flex-start;
        background-color: #f1f0f0;
        overflow: auto;
        border-radius: 25px;
        margin-top: 8px;
        margin-left: 20px;
        margin-right: 20px;
        margin-bottom: 10px;
        padding-top: 15px;
        padding-bottom: 15px;
    }
    .post_info{
        padding: 10px;
        max-height: 400px;
        flex-basis: 400px;
    }
    .post_desc{
        color: #50504e;
        font-size: small;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        max-height: 150px;
        overflow: hidden;
    }
    .post_title{
        color: #50504e;
        font-weight: 200;
        display: inline;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }
    .post_knot{
        font-weight: 600;
        color: #4f676c;
        font-family: 'Courier New', Courier, monospace;
        margin-top: 2px;
        font-size: small;
    }
    .post_date{
        font-family: 'Courier New', Courier, monospace;
        font-size: smaller;
        display: inline;
        color: #5b767c ;
    }
    .post_upvote{
        flex-basis: 60px;
        min-width: 40px;
        margin: auto;
    }
    
    .post_img{
        min-width: 80px;
        max-width: 200px;
        margin: auto;
    }
    .comment_button{
        max-height: 30px;
        padding-left: 100px;
    }
    .post_upvote{
        min-height: 30px;
        max-width: 60px;
        margin: auto;
        padding: 10px;
    }
    .comment_button{
        max-height: 30px;
        padding-left: 50px;
    }
    
    h2{
        color:#5b767c;
        padding-top: 10px;
        padding-bottom: 10px;
        margin-right: 20px;
        margin-left: 20px;
    }
    /* width */
    ::-webkit-scrollbar {
        width: 6px;
    }
    
    
    /* Track */
    ::-webkit-scrollbar-track {
        background: #d9eee3; 
        border-radius: 10px;
    }
    
    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #a8d1ca; 
        border-radius: 10px;
    }
    
    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #b8dbd5; 
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

<!--BODY-->
<body>
    <!--NAVIGATION BAR-->
    <?php
        require_once "include/navbar.php";
    ?>
    
    <?php
        echo "<div class=\"posts\">";
        echo "<h2>".$_GET["knot_name"]."</h2>";

        // display follow button or block user from admin
        $loggedin = isset($_SESSION["loggedin"]) and $_SESSION["loggedin"];
        if ($loggedin){
            $sql = "SELECT user_id FROM BannedFromKnot where user_id = ?";
        
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "i", $param_userid);
                
                // Set parameters
                $param_userid = $_SESSION["user_id"];
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    /* store result */
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        // the user is banned from the knot
                        header("page_not_found.php");
                    } else {
                        $sql = "SELECT k.knot_id, user_id
                                FROM Knot AS k, FollowingKnot as fk
                                WHERE k.knot_id = fk.knot_id
                                    AND knot_name = ?
                                    AND user_id = ?";
        
                        if($stmt = mysqli_prepare($link, $sql)){
                            // Bind variables to the prepared statement as parameters
                            mysqli_stmt_bind_param($stmt, "is", $param_userid, $param_knotname);
                            
                            // Set parameters
                            $param_userid = $_SESSION["user_id"];
                            $param_knotname = $_GET["knot_name"];
                            
                            // Attempt to execute the prepared statement
                            if(mysqli_stmt_execute($stmt)){
                                /* store result */
                                mysqli_stmt_bind_result($stmt, $knot_id, $user_id);

                                if(mysqli_stmt_num_rows($stmt) == 1){
                                    // if the user is following the knot, display the unfollow button
                                    echo "<p><a class=\"rebbit_link\" href=\"unfollow_knot.php?knot_id=".$knot_id."&user_id=".$user_id."\">Unfollow</a></p>";
                                }else{
                                    echo "<p><a class=\"rebbit_link\" href=\"follow_knot.php?knot_id=".$knot_id."&user_id=".$user_id."\">Follow</a></p>";
                                }
                            }

                            // Close statement
                            mysqli_stmt_close($stmt);
                        }
                    }
                }
            }
        }

        echo "<div>";

        $sql = "SELECT post_id, user_id, post_title, post_body, post_title, image_location, p.create_date as pdate
                FROM Knot AS k, Post AS p
                WHERE k.knot_id = p.knot_id
                    AND k.knot_name = ?
                LIMIT 30
                ";

        echo '<div class="flex_post">';
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "is", $param_userid, $param_knotname);
            $param_knotname = $_GET["knot_name"];
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "i", $param_userid);
                $param_userid = $_SESSION["user_id"];
  
                if(mysqli_stmt_execute($stmt)){
                  mysqli_stmt_bind_result($stmt, $post_id, $user_id, $post_title, $image_location, $post_body, $pdate);
                  echo '<div class="flex_post">';
                  while (mysqli_stmt_fetch()){
                    //  Post styling 
                    echo '<a href="post.php?post_id='.$post_id.'">';
                    echo '<div class="post">';
                    echo '<img src="../images/test_images/frog_mug2.jpeg" alt="..." class="img-thumbnail post_img" >';
                    echo '<div class="post_info">';
                    echo '<p class="post_title">'.$post_title.'</p>';
                    echo '<img src="../images/assets/UpvoteDownvote.png" alt="..." class="post_upvote" >';
                    echo '<p class="post_desc">'.$post_body.'</p>';
                    echo '<p class="post_date">'.$pdate.'</p>';
                    echo '<img src="./../images/assets/chat-icon.png" class="comment_button">';
                    echo '</div>';
                    echo '</div>';
                    echo '</a>';
                  }
                echo '</div>';

            }else{
                header("page_not_found.php");
            }
        }
    }else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    ?>
            
            
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="../bootstrap/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
        
</html>