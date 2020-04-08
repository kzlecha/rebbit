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

<!-- TODO: Add functional navigation bar -->

<!--BODY-->
<body>
    <!--NAVIGATION BAR-->
    <?php
        require_once "include/navbar.php";
    ?>
  
<div class="container-fluid post">
  <p style="color:#4f676c;"><i>Hello, @froglover97</i></p>
  <h2 class="post_title">Anoures</h2>
  <h3 class="post_knot">r/scientificFrogIllustrations</h3>
    <div class="container-fluid flex_post">
      <div class="col post_img">
        <img src="../images/test_images/Anoures.jpg" alt="..." class="img-thumbnail main_image post_knot">
      </div>
      <div class="col post_info">
        <p class="post_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
          incididunt ut labore et dolore magna aliqua. 
          Fermentum dui faucibus in ornare quam viverra. 
          Cursus mattis molestie a iaculis at erat pellentesque. 
          Aliquet nibh praesent tristique magna sit 
          amet purus gravida quis.</p>
        <p class="post_date">03-12-2020</p>
      </div>
  </div>
</div>

<!-- TODO: Add comment section -->
<!-- TODO: Add footer -->

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="../bootstrap/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>