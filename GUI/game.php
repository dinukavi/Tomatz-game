<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // User is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Game Page</title>

    <!-- Template Main CSS File -->
    <link rel="stylesheet" href="../STYLING/cascading.css">
   
</head>

    <body>
        <h1 style="text-align: right; color:green; -webkit-text-stroke: 0.3px blue; -webkit-text-fill-color:yellow;"; >Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <div class="container" >
        <form class="row g-3" action="../CODE/connect.php" method="post">

            <h1 style="font-size:50px" >Tomats</h1>
            
            <a href="tomats.php">
                <button style="font-size: 30px; background-color: black; border-radius: 25px;" type="button" class="btn-dark "><b>New Game</b></button>
            </a>
            <br><br>
            <a href="leaderboard.php">
                <button style="font-size: 30px; background-color: black; border-radius: 25px;"  type="button" class="btn-dark "><b>Leaderboard</b></button>
            </a>
            <br><br>
            <a href="../CODE/logout.php">
                <button style="font-size: 30px; background-color: black; border-radius: 25px;" type="button" class="btn btn-primary"><b>Logout</b></button>
            </a>
            <br>
            <img src="../images/OIP-removebg-preview.png" height="170px" width="170px">
            
            <br>
        </div>
    </body>
</html>