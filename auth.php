<?php
// Start new session
session_start();

// If username is not set will redirect to login page
if(!isset($_SESSION["staff_name"])){
header("Location: login.php");
exit(); }
?>
