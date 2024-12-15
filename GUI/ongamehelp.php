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
    <title>Login Page</title>

    <!-- Template Main CSS File -->
    <link rel="stylesheet" href="../STYLING/cascading.css">

</head>

    <body>


        <div class="container">
            <h1 class="tomatz">Help</h1>
           
            <p class="tomatz">Some equations will appiered on the screen with some tomatoes for a unrecognise numbers. You have to select that number according to the given equation clarifications. You can enter the value of a tomato on the belove given area.</p>
            <a href="../GUI/tomats.php">
                <button type="button" class="btn btn-primary"><b>OK</b></button>
            </a>
            <br>
            <img src="../images/OIP-removebg-preview.png" height="170px" width="170px">
        <br>
        </div>
    </body>
</html>