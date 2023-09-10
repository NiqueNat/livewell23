<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

parse_str(file_get_contents("php://input"),$_POST);
require_once "./includes/db_includes.php";

// Check if the required data is set in the POST request
if (isset($_POST['full_name']) && isset($_POST['email']) && isset($_POST['meal_plan'])) {
    // Insert the data into the database
    $query = "INSERT INTO livewell_db (name, email, meal_plan) VALUES (?, ?, ?)";

    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, 'sss', $_POST['full_name'], $_POST['email'], $_POST['meal_plan']);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // If the query was successful, you can return a success message or the newly inserted data
            $insertedRows = mysqli_stmt_affected_rows($stmt);
            $response = [
                "success" => true,
                "message" => "Data inserted successfully",
                "insertedRows" => $insertedRows,
            ];
        } else {
            // Handle the case where the query did not execute successfully
            $errorDetails = mysqli_error($link);
            $response = [
                "success" => false,
                "error" => "Failed to insert data: " . $errorDetails,
            ];

            // Log the error for debugging purposes
            error_log("Error in insert.php: " . mysqli_error($link));
        }

        mysqli_stmt_close($stmt);
    } else {
        // Handle the case where the prepared statement failed
        $response = [
            "success" => false,
            "error" => "Prepared statement did not insert records",
        ];
    }
} else {
    // Handle the case where required data is missing in the POST request
    $response = [
        "success" => false,
        "error" => "Required data missing (full_name, email, meal_plan)",
    ];
}

// Close the database connection
mysqli_close($link);

// Echo the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
