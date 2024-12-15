<?php

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