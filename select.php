<?php
require_once "./includes/db_includes.php";

// Used to store the results of the query
$results = [];

// Insert the data into the database
$query = "SELECT username, email, meal_plan, timestamp FROM livewell_db";
$result = mysqli_query($link, $query);

// If the query was successful, return the data
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
    }
    // Free the result set
    mysqli_free_result($result);
}

// Close the connection
mysqli_close($link);

// Echo the response as JSON
echo json_encode($results);
?>
