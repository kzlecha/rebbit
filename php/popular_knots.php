<?php
    
    session_start();

    // LIMIT 25: keeps from being too much information
    // theoretically have scroll/multiple pages

    $sql = "SELECT Knot.knot_id, knot_name, description, count(FollowingKnot.user_id) AS n_followers
            FROM Knot, FollowingKnot
            WHERE Knot.knot_id = FollowingKnot.knot_id
            GROUP BY knot_id
            ORDER BY n_followers
            LIMIT 25";

?>