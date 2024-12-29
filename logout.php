<?php
session_start(); // Start the session

include 'connect.php';
// Unset all session variables
session_unset();
// Destroy the session
session_destroy();
header("location: index.php");
exit;
?>