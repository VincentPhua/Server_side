<?php
// Need DB file connection
require('database.php');
// Get product id
$id=$_GET['id'];
// Delete record from DB
$query = "DELETE FROM product WHERE product_id=$id"; 
$result = mysqli_query($con,$query) or die ( mysqli_error($con));
// Redirect to view page after delete
header("Location: view_products.php"); 
exit();
?>
