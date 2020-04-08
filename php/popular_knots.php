<?php
// Configuration file 
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
  h1, h2, h3{
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  } 
  p{
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
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

<!-- BODY -->
<body>
  <!-- NAVIGATION BAR-->
  <?php
    session_start();
    require_once "include/navbar.php";
  ?>
  
  <!-- 2 column layout -->
  <div class="container-fluid">
    <!-- Get username -->
    <p style="color:#4f676c;"><i>Hello<?php if (isset($_SESSION["user_name"])){ echo ", ".$_SESSION["user_name"];}?></i></p>
    <h1 style="padding-top: 1em; color:#4f676c;">Recent Activity</h1>
    <p class="top_desc">Hop to it partner. Browse through the most popular knots.</p>
    <div class="row">
      <div class="col-sm-12 overflow-auto your_knots overflow-auto" style="background-color: #b7d6c6; padding: 1em; border-radius: 25px;" >
        <!-- Your Knots -->
        <h3 style="padding-bottom:.25em; color:#50504e;">Your knots</h3>
        <!-- Flex -->
        <?php

            // LIMIT 25: keeps from being too much information
            // theoretically have scroll/multiple pages via javascript

            $sql = "SELECT k.knot_id as knot_id, knot_name, description, count(fk.user_id) AS n_followers
                    FROM Knot AS k, FollowingKnot AS fk
                    WHERE k.knot_id = fk.knot_id
                    GROUP BY knot_id
                    ORDER BY n_followers
                    LIMIT 25";

            $query = mysqli_query($link, $sql) or die(mysqli_error($link));

            echo '<div class="flex_post">';
            while ($result = mysqli_fetch_array($query)){
                echo "<div class=\"post\">";
                echo '<p class="post_title">'.$result["knot_name"].'</p>';
                echo '<p class="post_desc">'.$result["description"]."</p>";
                echo '<p class="post_date">Number of Followers: '.$result["n_followers"]."</p>";
                // <img src="../images/assets/chat-icon.png" class="comment_button">
                echo "</div>";
            }
            echo "</div>";
        ?>
          
      </div>
      
    </div>
  </div>

  <?php
      // Close connection
      mysqli_close($link);
  ?>
  
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="../bootstrap/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>