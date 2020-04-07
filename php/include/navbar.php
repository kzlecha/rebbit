<nav style="background-color: #f1f0f0" class="navbar navbar-expand-lg navbar-light " >
        <a class="navbar-brand" href="index.html">
            <img src="images/graphics/rebbit.png" width="115" height="30" alt="rebbit">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php
                // display username if the user is loggedin and login otherwise
                $loggedin = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"];
                if($loggedin){
                    echo "<li class=\"nav-item active\">";
                    echo "<a class=\"nav-link\" href=\"profile.php?user_name=".$_SESSION["user_name"]."\">".$_SESSION["user_name"]."<span class=\"sr-only\">(current)</span></a>";
                    echo "</li>";
                }else{
                    echo "<li class=\"nav-item\">";
                    echo "<a class=\"nav-link\" href=\"login.php\">login</a>";
                    echo "</li>";
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="../html/about.html">about rebbit</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        explore
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                            if(isset($_SESSION["loggedin"])){
                                if($_SESSION["loggedin"]){
                                    echo "<a class=\"dropdown-item\" href=\"following_knots.php\">your knots</a>";
                                }
                            }
                        ?>
                        <a class="dropdown-item" href="popular_knots.php">popular knots</a>
                    </div>
                </li>
            </ul>
            <!-- Search bar-->
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="hop on" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">search</button>
            </form>
        </div>
    </nav>