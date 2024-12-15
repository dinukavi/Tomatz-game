<?php
session_start(); // Start session

// Database connection details
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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from form
    $userName = $_POST['userName'];
    $password = $_POST['password'];

    // Prepare SQL statement to fetch user from database
    $sql = "SELECT * FROM users WHERE user_name='$userName' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists, set session variables and redirect to game.php
        $_SESSION['username'] = $userName;
        header("Location: game.php");
        exit();
    } else {
        // User not found, show error message
        echo '<script type="text/javascript">
        window.onload=function()
        {
            alert("Invalid username or password");
        }
        </script>';
    }
}

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>

    <!-- Template Main CSS File -->
    <link rel="stylesheet" href="../STYLING/cascading.css">
  
</head>

<body>

  <div class="container">
    <form class="row g-3" method="post">

        <h1>Login</h1>
        <br>
        <div class="col-5">
          <label for="userName"><b>Username</b></label>
          <input type="text" placeholder="Enter Username" name="userName" required>
        </div>
        <br>
        <div class="col-5">
          <label for="password"><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="password" required>
        </div>
        <br>
        <div class="col-5">
          <label>
            <input type="checkbox" checked="checked" name="remember"> Remember me
          </label>
          <br>
          <br>
          <div class="col-6">
              <button type="submit">Login</button>
              <a href="../GUI/home.php">
                  <button type="button">Cancel</button>
              </a>
          </div>
        </div>
        <br>
        <span class="signup"><b>No account? <a href="../GUI/signup.php">signup</a></b></span>
       
      </div>
        
    </form>
  </div>  


</body>
</html>
