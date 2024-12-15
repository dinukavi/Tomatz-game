<?php
$server_name = "localhost";
$user_name = "root";
$password = "";
$database = "game2";

$conn = new mysqli($server_name, $user_name, $password, $database);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Check if form data is set and not empty
if(isset($_POST['userName'], $_POST['email'], $_POST['password'])) {
    $userName = $_POST['userName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute SQL statement to insert data into the database
    $sql = "INSERT INTO users (user_name, email, password) VALUES ('$userName', '$email', '$password')";

    //alert for the successfully recorded user
    if ($conn->query($sql) === TRUE) 
    {
        echo '<script type="text/javascript">
        window.onload=function()
        {
            alert("New record created successfully");
        }
        </script>';

        // Redirect to login page after successful signup
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} 

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../STYLING/cascading.css">
</head>
<body>
    <div class="container">
        <form class="row g-3" method="post">
            <h1>Sign Up</h1>
            <div class="col-5">
                <label for="userName" class="form-label">User Name</label>
                <input type="text" class="form-control" id="userName" name="userName" required>
            </div>
            <br>
            <div class="col-5">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" required>
            </div>
            <br>
            <div class="col-5">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <br>
            <div class="col-5">
                <a href="../GUI/login.php">
                    <button type="submit" class="btn btn-primary">Sign up</button>
                </a>
                <a href="../GUI/home.php">
                    <button type="button">Cancel</button>
                </a>
            </div>
        </form>
        <br>
    </div>
</body>
</html>
