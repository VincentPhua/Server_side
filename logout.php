<?php
// Start or resume a session
session_start();

// User logout, session destroy
if(session_destroy())
{
// Redirect to login page
header("Location: login.php");
exit();
}
?>
