<?php

$hostname = "localhost:3306";
$database = "myrna67_live_well";
$username = "myrna67_live_well";
$password = "#6823zOey";

$link = mysqli_connect($hostname, $username, $password, $database);

$database_response = [];

if (!$link) {
    $database_response['success'] = false;
    $database_response['error'] = mysqli_connect_error(); // Get the specific connection error
} else {
    $database_response['success'] = true;
}

?>
