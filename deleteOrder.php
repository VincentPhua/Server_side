<?php
// Need DB file connection
require ('database.php');

// Get order id
$id = $_GET['id'];

// Retrieve order details including products and quantities
$orderDetailsQuery = "SELECT product_id, quantity FROM order_items WHERE order_id = $id";
$orderDetailsResult = mysqli_query($con, $orderDetailsQuery);

// Loop through order details to update product quantities
while ($row = mysqli_fetch_assoc($orderDetailsResult)) {
    $productId = $row['product_id'];
    $quantity = $row['quantity'];

    // Update product quantity in the products table
    $updateQuantityQuery = "UPDATE products SET quantity = quantity + $quantity WHERE product_id = $productId";
    mysqli_query($con, $updateQuantityQuery);
}

// Delete record from orders table
$query = "DELETE FROM orders WHERE order_id = $id";
$result = mysqli_query($con, $query) or die (mysqli_error($con));

// Redirect to view orders page
header("Location: view_orders.php");
mysqli_close($con);
exit;
?>
