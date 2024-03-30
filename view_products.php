<?php
// Check authentication for user
// Need DB file connection
include ("auth.php");
require ('database.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="300">
    <title>View Product Records</title>
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
            <a href="view_orders.php" class="view-product-orders">Orders</a>
            <form action="logout.php" method="post">
                <button type="submit" class="view-product-logout-button">Logout</button>
            </form>
        </div>

        <div class="main">
            <div class="main-header">
                <h2>View Product Records</h2>
                <a href="create_product.php" class="create-product-link">
                    <button class="create-product-btn">Create Product</button>
                </a>
            </div>
            <table class="view-product-table">
                <thead>
                    <tr>
                        <th><strong>No.</strong></th>
                        <th><strong>Product Image</strong></th>
                        <th><strong>Product Name</strong></th>
                        <th><strong>Description</strong></th>
                        <th><strong>Price</strong></th>
                        <th><strong>RRP</strong></th>
                        <th><strong>Quantity</strong></th>                   
                        <th><strong>Date and Time Recorded</strong></th>
                        <th><strong>Edit</strong></th>
                        <th><strong>Delete</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Setup count variable
                    $count = 1;
                    // Select and execute query
                    $sel_query = "SELECT * FROM products ORDER BY product_id;";
                    $result = mysqli_query($con, $sel_query);
                    // For price
                    $currencySymbol = "RM";
                    // loop for product record
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <!-- Display data in table row -->
                        <tr>
                            <td align="center">
                                <?php echo $count; ?>
                            </td>
                            <td align="center">
                                <?php echo "<img src='imgs/" . $row["image_name"] . "' alt='Product Image' class='product-image'>"; ?> 
                            </td>
                            <td align="center">
                                <?php echo $row["product_name"]; ?>
                            </td>
                            <td align="center">
                                <?php echo $row["description"]; ?>
                            </td>
                            <td align="center">
                                <?php echo $currencySymbol . $row["price"]; ?>
                            </td>
                            <td align="center">
                                <?php echo $currencySymbol . $row["rrp"]; ?>
                            </td>
                            <td align="center">
                                <?php echo $row["quantity"]; ?>
                            </td>
                            <td align="center">
                                <?php echo $row["date_created"]; ?>
                            </td>
                            <td align="center">
                                <a href="update_product.php?id=<?php echo $row["product_id"]; ?>"
                                    class="view-product-update-link">Update</a>
                            </td>
                            <td align="center">
                                <!-- Delete link with confirmation -->
                                <a href="delete_product.php?id=<?php echo $row["product_id"]; ?>"
                                    onclick="return confirm('Are you sure you want to delete this product record?')"
                                    class="view-product-delete-link">Delete</a>
                            </td>
                        </tr>
                        <!-- Increment -->
                        <?php $count++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<?php mysqli_close($con) ?>
</html>
