
<?php
$server_name = "localhost";
$user_name = "root";
$password = "";
$database = "game2";

// Create connection
$conn = new mysqli($server_name, $user_name, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

// Close connection
$conn->close();
?>
    
