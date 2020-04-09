<?php
    session_start();

    require_once "include/config.php";
    require_once "include/authorize.php";
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
    h1{
        font-weight: 600;
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }
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
    }
    .flex_post{
        display: flex;
        justify-content: space-evenly;
        flex-wrap: wrap;
    }
    .lillypad{
        max-height: 80px;
        margin: auto;
    }

    .cite_stats{
        margin: 0% 2.5%;
        max-width: 95%;
        min-width: 25%;
        text-align: center;
    }

    h1, h2, h3{
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    } 
    p{
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }  
    .form_rebbit{
        background-color: #4f676c;
        padding: 20px;
        overflow: auto;
        color: #e9f5ef;
        border-radius: 25px;
        max-width: 600px;
    }
    .submit_btn{
        background-color: darkseagreen;
        border-color: #9eb9ab;
    }
    .submit_btn:hover{
        background-color: #9eb9ab;
        border-color: darkseagreen;
    }
    .rebbit_link{
        color: darkseagreen;
    }
    .rebbit_link:hover{
        color: #86e4aa;
    }

  
</style>

<!-- BODY -->
<body>
    <!-- redirect user if not admin -->
    <?php
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
            header("index.php");
        }

        $admin = is_admin($_SESSION["user_id"]);
        if(!$admin){
            header("index.php");
        }
    ?>

    <!-- NAVIGATION BAR-->
    <?php
        require_once "include/navbar.php";

    ?>

  <!-- 2 column layout -->
  <div class="container-fluid">
    <!-- Get username -->
    <p style="color:#4f676c;"><i>Hello, Admin <?php echo $_SESSION["user_name"];?></i></p>
    <h1 style="padding-top: 1em; color:#4f676c;">Admin Portal</h1>
    <p class="top_desc">Hop to it partner. Search for posts and users or view website statistics.</p>
    <div class="row">
        <!-- Search -->
        <div class="col-sm-4 overflow-auto your_knots" style="background-color: #b7d6c6; padding: 1em; border-radius: 25px;" >
            <?php
                
                $keyword = $_POST["keyword"];
                $type = $_POST["type"];

                if(empty($keyword)){
                    header("admin.php");
                }
                if(empty($type)){
                    // by default set the keyword to the username
                    $type = "username";
                }



            ?>

        </div>
        
    </div>
  </div>
  
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="../bootstrap/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>