<?php
// Setup DB connection (host, username, password, database name)
$con = mysqli_connect("localhost","root","","assignment_db");

// Check for connection errors
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>