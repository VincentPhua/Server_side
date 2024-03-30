<?php
// Check authentication for user
// Need DB file connection
include("auth.php");
require('database.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">


    <title>View Order Records</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <div class="container">
        <div id="sidenav" class="sidenav">
            <div class="admin-image-container">
                <img src="imgs/staff/Admin.jpg" alt="Admin" class="admin-image">
            </div>
            <h2>Staff Page</h2>
            <div class="view-product-staff-info">
                Staff Name:
                <?php echo $_SESSION['staff_name']; ?>
            </div>
            <hr>
            <a href="staff.php" class="view-product-dashboard">Dashboard</a>
            <a href="view_products.php" class="view-product">Products</a>
            <form action="logout.php" method="post">
                <button type="submit" class="view-product-logout-button">Logout</button>
            </form>
        </div>

        <div class="main">
            <div class="main-header">
                <h2>View Order Records</h2>
            </div>
            <table class="view-order-table">
                <thead>
                    <tr>
                        <th><strong>Order ID</strong></th>
                        <th><strong>Receiver Name</strong></th>
                        <th><strong>Receiver Email</strong></th>
                        <th><strong>Receiver Phone Number</strong></th>
                        <th><strong>Delivery Address</strong></th>
                        <th><strong>Subtotal</strong></th>
                        <th><strong>Order Time</strong></th>
                        <th><strong>Payment Method</strong></th>
                        <th><strong>Action</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //read all row from database table
                    $sql = "SELECT * FROM orders";
                    $result = $con->query($sql);

                    if (!$result) {
                        die("Invalid query: " . $con->error);
                    }
                    $count = 1; // Initialize count variable outside the loop
                    //read data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>$row[order_id]</td>
                            <td>$row[receiver_name]</td> 
                            <td>$row[receiver_email]</td> 
                            <td>$row[receiver_phone]</td> 
                            <td>$row[delivery_addr]</td>
                            <td>RM$row[subtotal]</td>
                            <td>$row[order_time]</td>
                            <td>$row[payment_method]</td>
                            <td>
                                <a class='btn btn-primary btn-sm' href='updateOrder.php?id=$row[order_id]'>Update</a>
                                <a class='btn btn-danger btn-sm' href='deleteOrder.php?id=$row[order_id]'>Delete</a>
                            </td>

                        </tr>";

                        $count++;
                    }

                    ?>


                </tbody>

            </table>
        </div>
    </div>
</body>
<?php mysqli_close($con); ?>
</html>