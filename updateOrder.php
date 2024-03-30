<?php
// Check authentication for user
include("auth.php");
// Need DB file connection
require ('database.php');

//update info
$status = '';
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve order info from form
    $order_id = $_POST['order_id'];
    $receiver_name = $_POST['receiver_name'];
    $receiver_email = $_POST['receiver_email'];
    $receiver_phone = $_POST['receiver_phone'];
    $delivery_addr = $_POST['delivery_addr'];
    $subtotal = $_POST['subtotal'];
    $order_time =  date("Y-m-d H:i:s");
    $payment_method = $_POST['payment_method'];



    

    // Update order data in database
    $update_query = "UPDATE orders SET receiver_name='$receiver_name', receiver_email='$receiver_email', receiver_phone='$receiver_phone', delivery_addr='$delivery_addr', subtotal='$subtotal', payment_method='$payment_method' WHERE order_id=$order_id";
    mysqli_query($con, $update_query) or die(mysqli_error($con));

    // Status message
    $status = "Order updated successfully. Go back to <a href='view_orders.php'>View Order List</a> ?";
}

// Retrieve product information based on product ID
$order_id = $_GET['id'];
$select_query = "SELECT * FROM orders WHERE order_id=$order_id";
$result = mysqli_query($con, $select_query);
$row = mysqli_fetch_assoc($result);

// Close database connection
mysqli_close($con);
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="300">
    <title>Update Order</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <a href="view_orders.php" class="back-button">&lt; Back to View Order</a>
    <div class="create-order-container">
        <h2 class="create-order-title">Update Order</h2>
        <form class="create-order-form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">

            <label for="receiver_name">Receiver Name:</label>
            <input type="text" name="receiver_name" id="receiver_name" value="<?php echo $row['receiver_name']; ?>" placeholder="Receiver Name" required>

            <label for="receiver_email">Receiver Email:</label>
            <input type="text" name="receiver_email" id="receiver_email" value="<?php echo $row['receiver_email']; ?>" placeholder="Receiver Email" required>

            <label for="receiver_phone">Receiver Phone Number:</label>
            <input type="text" name="receiver_phone" id="receiver_phone" value="<?php echo $row['receiver_phone']; ?>" placeholder="Receiver Phone Number" required>

            <label for="delivery_addr">Delivery Address:</label>
            <input type="text" name="delivery_addr" id="delivery_addr" value="<?php echo $row['delivery_addr']; ?>" placeholder="Delivery Address" required>

            <label for="subtotal">Subtotal:</label>
            <input type="number" name="subtotal" step="0.01" min="0" id="subtotal" value="<?php echo $row['subtotal']; ?>" placeholder="Subtotal" required>

            <label for="payment_method">Payment Method:</label>
            <input type="text" name="payment_method" id="payment_method" value="<?php echo $row['payment_method']; ?>" placeholder="Payment Method" required>

            <input type="submit" value="Update">
            <p class="create-order-status">
                <?php echo $status; ?>
            </p>
        </form>
    </div>
</body>

</html>