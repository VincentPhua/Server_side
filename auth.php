<?php
// Start new session
session_start();
$timeout = 300; // Set timeout minutes

// If username is not set will redirect to login page
if(!isset($_SESSION["staff_name"]) || (time() - $_SESSION['last_timestamp']) >= $timeout) {
    echo $_SESSION['last_timestamp'];
    echo $timeout;
    session_unset();
    session_destroy();
    header("Location: login.php?session_expired=1");
    exit(); 
}else{
    session_regenerate_id(true);
    $_SESSION['last_timestamp'] = time();
}
?>
