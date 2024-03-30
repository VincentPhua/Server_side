<?php
include ("auth.php");
include ("database.php");

// Get the staff name from the session
$staffName = $_SESSION['staff_name'];
// Fetch sales data from the database
$salesQuery = "SELECT DATE(order_time) AS order_date, SUM(subtotal) AS total_sales 
               FROM orders 
               GROUP BY order_date";
$salesResult = mysqli_query($con, $salesQuery);

// Process the data into an array
$salesData = array();
while ($row = mysqli_fetch_assoc($salesResult)) {
    $salesData[] = array($row['order_date'], $row['total_sales']);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="refresh" content="300">
    <title>Staff Landing Page</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="staff-page">Welcome,
            <?php echo $staffName; ?>! Staff ID:
            <?php echo $_SESSION['staff_id']; ?>
        </h1>
        <div class="logout-link">
            <form action="logout.php" method="post">
                <button type="submit">Logout</button>
            </form>
        </div>
        <!-- Graph Section -->
        <div class="graph-container">
            <canvas id="salesChart"></canvas>
        </div>

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
    </div>
    <footer>
        <p>&copy; 2024 PhoneAccessories. All rights reserved.</p>
    </footer>
    <script>
        // JavaScript code to create the chart using Chart.js
        var salesData = <?php echo json_encode($salesData); ?>;

        var salesDates = salesData.map(function (item) {
            return item[0];
        });

        var salesAmounts = salesData.map(function (item) {
            return item[1];
        });

        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: salesDates,
                datasets: [{
                    label: 'Sales Per Day',
                    data: salesAmounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>

</html>