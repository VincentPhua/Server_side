<?php
// Check authentication for user
// Need DB file connection
include ("auth.php");
require ('database.php');

$status = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve product info from form
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $date_record = date("Y-m-d H:i:s");
    $submittedby = $_SESSION["staff_name"];

    // Image upload
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a valid format
    if ($imageFileType != "jpg" && $imageFileType != "png") {
        $status = "Sorry, only JPG and PNG files are allowed.";
    } else {
        // Move uploaded file to destination directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image_name = $targetFile;

            // Insert product data into database
            $ins_query = "INSERT INTO product (product_name, image_name, price, quantity, date_created, submittedby) 
                          VALUES ('$product_name', '$image_name', '$price', '$quantity', '$date_record', '$submittedby')";
            mysqli_query($con, $ins_query) or die (mysqli_error($con));

            // Status message
            $status = "New product inserted successfully. Go back to <a href='view_products.php'>View Product List</a> ?";
        } else {
            $status = "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Create Product</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <a href="view_products.php" class="back-button">&lt; Back to View Products</a>
    <div class="create-product-container">
        <h2 class="create-product-title">Create Product</h2>
        <form class="create-product-form" method="post" enctype="multipart/form-data">
        <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" id="product_name" placeholder="Product Name" required>
            <label for="image">Image:</label>
            <input type="file" name="image" id="image" accept="image/jpeg, image/png" required>
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" placeholder="Price" required>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" placeholder="Quantity" required>
            <input type="submit" value="Submit">
            <p class="create-product-status"><?php echo $status; ?></p>
        </form>
    </div>
</body>

</html>