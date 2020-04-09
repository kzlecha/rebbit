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
<!-- Custom styling -->
<style>
  body{
    background-color: #f1f0f0;
    margin: 0.25em;
  }
  .top_desc{
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
  }
  .post{
    max-width: 200px;
    padding: 2px;
    margin-right: 10px;
  }
  .post_info{
    margin-top: 0.4em;
    padding: 10px;
    border-bottom: dashed 0.8px #4f676c;
  }
  .post_info:hover{
    background-color: darkseagreen;
    opacity: 0.8;
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
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    padding-right: 5px;
    display: inline;
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
    color: #5b767c ;
    display: inline;
  }
  .flex_post{
    display: flex;
    justify-content: space-evenly;
    flex-wrap: wrap;
  }
  .trending, .your_knots{
    max-height: 2000px;
  }
  .submit_btn{
    background-color: darkseagreen;
    border-color: #9eb9ab;
  }
  h1, h2, h3{
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  }
  h4{
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
  }
  
  /* width */
  ::-webkit-scrollbar {
    width: 6px;
  }
  
  /* Track */
  ::-webkit-scrollbar-track {
    background: #f1f0f0; 
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
  .submit_btn{
    background-color: darkseagreen;
    border-color: #9eb9ab;
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
  
</style>

<body style="margin: 0.25em; background-color: #f1f0f0;">    
<!-- NAVIGATION BAR-->
    <?php
        require_once "include/navbar.php";

        if(isset($_SESSION['user_name'])){
          echo("<div style=\"padding:15px\"><p style=\"color:#4f676c\"><i>Hello, ".$_SESSION['user_name']."</i></p></div>");
          echo("<div style=\"padding:15px\"><h3 style=\"color:#4f676c\"> ".$_SESSION['user_name']."'s Profile</h3></div>");
        } else {
            echo "<div style=\"padding:15px\">Sorry, you must be <a href=\"login.php\"> logged in </a> to view your profile.</div>";
        }
    ?>

    <?php
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        $userId = $_SESSION['user_name']; 
        $sql = "SELECT user_id, user_name, email, image_locatiom
                    FROM User
                    WHERE user_id = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_userid);
            $param_userid = $_SESSION['user_id'];
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt, $user_id, $user_name, $email, $image_locatiom);
                echo("<div style=\"padding:5px\"><h4 style=\"color:#4f676c\">Profile Information</h4></div>"); 
                while (mysqli_stmt_fetch($stmt)){
                    echo "<div style=\"padding:15px\">";
                    echo '<a href="profile.php?user_id='.$user_id.'">';
                    echo '<h4>'.$user_name.'</h4>';
                    echo '<h4>'.$email.'</h4>';
                    echo "</div>";
                }
        }else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }   
}
?>

<form style="padding:10px;" action = 'editCustomer.php'>
    <input class="submit_btn" type="submit" value="Edit Profile">
</form>

<?php
      // Close connection
      mysqli_close($link);
?>

<body>


<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="../bootstrap/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
        
</html>