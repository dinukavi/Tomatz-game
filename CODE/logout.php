<?php
session_start(); // Start session

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page after logout
header("Location: ../GUI/home.php");
exit();

