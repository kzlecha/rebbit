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

<!-- Rebbit specific styling-->
<style>
  body{
    background-color: #f1f0f0;
    margin: 0.25em;
  }
  .top_desc{
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
  }
  .post_info{
    margin-top: 0.4em;
    padding: 10px;
  }
  .post_desc{
    color: #50504e;
    font-size: small;
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    max-height: 150px;
    overflow: auto;
  }
  .post_title{
    padding-top: 1em; 
    color:#4f676c;
    font-weight: 200;
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
  }
  .post_knot{
    font-weight: 600;
    color: #50504e;
    font-family: 'Courier New', Courier, monospace;
    margin-top: 2px;
    font-size: 0.8em;
  }
  .post_date{
    font-family: 'Courier New', Courier, monospace;
    font-size: small;
    color: #5b767c ;
  }
  .post_img{
    max-width: 400px;
    min-width: 200px;
  }
  .flex_post{
    display: flex;
    justify-content: space-evenly;
    flex-wrap: wrap;
    padding: 20px;
    background-color: rgb(79, 103, 108, 0.05);
  }

</style>

<body>
    <!--NAVIGATION BAR-->
    <?php
        require_once "include/navbar.php";
    ?>

    // TODO: ADD PREPARED STATEMENTS 
    <!-- USER POST + COMMENTS -->
    <?php 
        echo "<div class=\"container-fluid post\"";
        if(isset($_SESSION['user_name'])){
          echo("<p style=\"color:#4f676c\"><i>Hello, ".$_SESSION['user_name']." </i></p>");
        }

        $sql = "SELECT k.knot_id AS knot_id, user_id, user_name, post_id, post_title, image_location, post_body, p.create_date AS pdate 
                      FROM Posts as p, Knot AS k, User as u
                      WHERE p.user_id = k.user_id
                      AND k.user_id = u.user_id";

        $query = mysqli_query($link, $sql) or die(mysqli_error($link));

        


        // POST
        echo "<h2 class=\"post_title\">".$_GET["post_title"]."</h2>";
        echo "<h3 class=\"post_knot\">".$_GET["knot_name"]."</h3>"; //Knot id
        echo "<h3 class=\"post_knot\">".$_GET["user_name"]."</h3>"; //User id
        echo "<div class=\"container-fluid flex_post\"";
          echo "<div class=\"col post_img\"";
          echo "<img src=".$GET["img_location"]."alt=\"post image\" class=\"img-thumbnail main_image post_knot\">";
          echo "</div>";
          echo "<div class=\"col post_info\">";
            echo "<p class=\"post_desc\">" .$_GET["post_body"];
            echo "</p>";
            echo "<p class=\"post_date\">".$_GET["create_date"]."</p>";
          echo "</div>";
        echo "</div>";

        // COMMENTS
        echo "<button type=\"button\" class=\"collapsible\">Comments</button>";
          echo "<div class=\"content\">";
          echo "<p class=\"post_desc\">" .$_GET["comment_body"]. "</p>";
          echo "<p class=".$_GET["create_date"].">03-12-2020</p>";
        echo "</div>";

      // IF LOGGED IN ADD COMMENT
      if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
       
          $sql = "SELECT k.knot_id AS knot_id, user_id, user_name, post_id, post_title, image_location, post_body, p.create_date AS pdate 
                      FROM Posts as p, Knot AS k, User as u
                      WHERE p.user_id = k.user_id
                      AND k.user_id = u.user_id";
          
          $query = mysqli_query($link, $sql) or die(mysqli_error($link));


      }

      echo "</div>"; 
    ?>
  
<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
</script>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="../bootstrap/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>