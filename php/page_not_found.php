<!DOCTYPE html>
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
.form_rebbit{
    background-color: #4f676c;
    padding: 20px;
    overflow: auto;
    color: #e9f5ef;
    border-radius: 25px;
    max-width: 600px;
}
.rebbit_link{
    color: darkseagreen;
}
.rebbit_link:hover{
    color: #86e4aa;
}

</style>

<body style="margin: 0.25em; background-color: #f1f0f0;">    <!-- NAVIGATION BAR-->
    <?php
        require_once "include/navbar.php";
    ?>

<div style="padding: 10px; padding-top: 2em;">
    <!-- Login Form -->
    <div class="wrapper form_rebbit">
        <h2>Error 404 - Page not found</h2>
        <p>We're sorry, but the page you requested does not exist.</p>
        <?php
            $httpReferer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
            echo "<p style=\"font-size:small\">Want to return to your previous browsing?";
            echo "<a class=\"rebbit_link\" href=\"".$httpReferer."\">".$httpReferer."</a></p>";
        ?>
    </div>  
</div>
    
      
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="../bootstrap/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
</body>
</html>