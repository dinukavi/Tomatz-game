<?php
session_start(); // Ensure session is started

// Database connection parameters
$server_name = "localhost";
$user_name = "root";
$password = "";
$database = "game2";

// Establish connection to the database
$conn = new mysqli($server_name, $user_name, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure that both session username and posted highest score are set
if (!isset($_SESSION['username'])) {
    die('User not logged in.');
}

if (!isset($_POST['highestscore'])) {
    die('Highest score not provided.');
}

$highest_score = $_POST['highestscore'];
$username = $_SESSION['username']; // Retrieve username from session

// Update the highest score in the database
$sql_update_score = "UPDATE users SET highest_score = ? WHERE user_name = ?";
$stmt_update = $conn->prepare($sql_update_score);

// Check if prepared statement creation failed
if (!$stmt_update) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters to the prepared statement
if (!$stmt_update->bind_param("is", $highest_score, $username)) {
    die("Binding parameters failed: " . $stmt_update->error);
}

// Execute the prepared statement
if (!$stmt_update->execute()) {
    die("Execute failed: " . $stmt_update->error);
}

// Check if any rows were affected by the update operation
if ($stmt_update->affected_rows === 0) {
    echo "No rows updated, check if the user exists and the score is a new high.";
} else {
    echo "Highest Score Updated: " . $highest_score;
}

// Close the prepared statement and the database connection
$stmt_update->close();
$conn->close();
