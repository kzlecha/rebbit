<?php

    session_start();
    
    require_once "../include/authorize.php";
    require_once "../include/config.php";

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
        require_once "../include/navbar.php";
    ?>

    <p style="font-size: small;">Return to admin profile: <a class="rebbit_link" href="admin.php">admin page</a></p>

    <div class="container-fluid">
    <!-- Get username -->
    <p style="color:#4f676c;"><i>Hello, Admin <?php echo $_SESSION["user_name"];?></i></p>
    <h1 style="padding-top: 1em; color:#4f676c;">Cite statistics</h1>
    <?php
        $stats = "";
        if(isset($_POST["growth_by_day"]) && !empty($_POST["growth_by_day"])){
            $stats = "Growth by Day";
            if(isset($_POST["popular_knots"]) && !empty($_POST["popular_knots"])){
                $stats = $stats." and Popular Knots";
            }
        }elseif(isset($_POST["popular_knots"]) && !empty($_POST["popular_knots"])){
            $stats = "Popular Knots";
        }
        echo '<p class="top_desc">Hop to it partner. View Website Statistics in terms of '.$stats.'.</p>';
    ?>
    <div class="row">
    <?php
        if(isset($_POST["growth_by_day"]) && !empty($_POST["growth_by_day"])){
            // create a section for growth
            echo '<div class="growth">';
            echo '<h2>Growth by Day</h2>';
            
            // growth by num users
            $sql = "SELECT create_date, count(user_id) as n_users FROM User GROUP BY create_date ORDER BY create_date DESC";

            $query = mysqli_query($link, $sql) or die(mysqli_error($link));

            echo '<div class="flex_post">';
            echo '<h3>Number of Users</h3>';
            while ($result = mysqli_fetch_array($query)){
                echo "<div class=\"post post_info\">";
                echo '<p class="post_knot">'.$result["n_users"].'</p>';
                echo '<p class="post_title">'.$result["create_date"].'</p>';
                echo '</div>';
            }
            echo "</div>";

            // growth by number of knots
            $sql = "SELECT create_date, count(knot_id) as n_knots FROM Knot GROUP BY create_date ORDER BY create_date DESC";

            $query = mysqli_query($link, $sql) or die(mysqli_error($link));

            echo '<div class="flex_post">';
            echo '<h3>Number of Knots</h3>';
            while ($result = mysqli_fetch_array($query)){
                echo "<div class=\"post post_info\">";
                echo '<p class="post_knot">'.$result["n_knots"].'</p>';
                echo '<p class="post_title">'.$result["create_date"].'</p>';
                echo '</div>';
            }
            echo "</div>";

            // growth by number of posts
            $sql = "SELECT create_date, count(post_id) as n_knots FROM Knot GROUP BY create_date ORDER BY create_date DESC";

            $query = mysqli_query($link, $sql) or die(mysqli_error($link));

            echo '<div class="flex_post">';
            echo '<h3>Number of Posts</h3>';
            while ($result = mysqli_fetch_array($query)){
                echo "<div class=\"post post_info\">";
                echo '<p class="post_knot">'.$result["n_knots"].'</p>';
                echo '<p class="post_title">'.$result["create_date"].'</p>';
                echo '</div>';
            }
            echo "</div>";

            echo '</div>';
        }

        if(isset($_POST["popular_knots"]) && !empty($_POST["popular_knots"])){
            // create a section for growth
            echo '<div class="growth">';
            echo '<h2>Most Popular Knots</h2>';
            
            // growth by num users
            $sql = "SELECT k.knot_id, knot_name, count(user_id) as n_followers
                    FROM FollowingKnot as fk, Knot as k
                    WHERE fk.knot_id = k.knot_id
                    GROUP BY k.knot_id, k.knot_name
                    ORDER BY n_followers DESC";

            $query = mysqli_query($link, $sql) or die(mysqli_error($link));

            echo '<div class="flex_post">';
            echo '<h3>Most Popular - Number of Followers</h3>';
            while ($result = mysqli_fetch_array($query)){
                echo "<div class=\"post post_info\">";
                echo '<p class="post_knot">'.$result["knot_name"].'</p>';
                echo '<p class="post_title">'.$result["knot_id"].'</p>';
                echo '<p class="post_desc">'.$result["n_followers"].'</p>';
                echo '</div>';
            }
            echo "</div>";

            // growth by number of knots
            $sql = "SELECT k.knot_id, knot_name, count(post_id) as n_posts
                    FROM Post as p, Knot as k
                    WHERE p.knot_id = k.knot_id
                    GROUP BY k.knot_id, k.knot_name
                    ORDER BY n_posts DESC";

            $query = mysqli_query($link, $sql) or die(mysqli_error($link));

            echo '<div class="flex_post">';
            echo '<h3>Most Active - Number of Posts</h3>';
            while ($result = mysqli_fetch_array($query)){
                echo "<div class=\"post post_info\">";
                echo '<p class="post_knot">'.$result["knot_name"].'</p>';
                echo '<p class="post_title">'.$result["knot_id"].'</p>';
                echo '<p class="post_desc">'.$result["n_posts"].'</p>';
                echo '</div>';
            }
            echo "</div>";

            echo '</div>';
        }
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
