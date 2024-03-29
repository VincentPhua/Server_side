<?php
// Need DB file connection
require ('database.php');
// Get product id
$id = $_GET['id'];

$checkQuery = "SELECT order_id FROM orders";
$checkResult = mysqli_query($con, $checkQuery);


// Delete record from DB
$query = "DELETE FROM orders WHERE order_id = $id";
$result = mysqli_query($con, $query) or die (mysqli_error($con));

header("Location: view_orders.php");
exit;
?>
