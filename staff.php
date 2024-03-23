<?php
include ("auth.php");

// Get the staff name from the session
$staffName = $_SESSION['staff_name'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Staff Landing Page</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<head>
    <title>Staff Landing Page</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="container">
        <h1 class="staff-page">Welcome,
            <?php echo $staffName; ?>! Staff ID:
            <?php echo $_SESSION['staff_id']; ?>
        </h1>

        <div class="card-container">
            <div class="card">
                <h2>View Products</h2>
                <p>Click here to view the products.</p>
                <a href="view_products.php">Go to View Products</a>
            </div>

            <div class="card">
                <h2>View Orders</h2>
                <p>Click here to view the orders.</p>
                <a href="view_orders.php">Go to View Orders</a>
            </div>
        </div>
        <div class="logout-link">
            <form action="logout.php" method="post">
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</body>
<footer>
    <p>&copy; 2024 PhoneAccessories. All rights reserved.</p>
</footer>

</html>