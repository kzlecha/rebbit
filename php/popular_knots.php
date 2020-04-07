<?php
    
    session_start();

   // Include config file
    require_once "include/config.php";


    // LIMIT 25: keeps from being too much information
    // theoretically have scroll/multiple pages

    $sql = "SELECT Knot.knot_id, knot_name, description, count(FollowingKnot.user_id) AS n_followers
            FROM Knot, FollowingKnot
            WHERE Knot.knot_id = FollowingKnot.knot_id
            GROUP BY knot_id
            ORDER BY n_followers
            LIMIT 25";

    $query = mysqli_query($link, $sql) or die(mysqli_error($link));

    echo '<table>';
    while ($result = mysqli_fetch_array($query)){
        echo "<tr>";
        echo "<td>".$result["knot_name"]."</td>";
        echo "<td>".$result["description"]."</td>";
        echo "<td>".$result["n_followers"]."</td>";
        echo "</tr>";
    }
    echo "</table>";
?>