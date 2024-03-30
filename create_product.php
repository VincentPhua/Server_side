<?php
// Check authentication for user
// Need DB file connection
include ("auth.php");
require ('database.php');
// Set the default timezone to your desired timezone
date_default_timezone_set('Asia/Singapore');

$status = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve product info from form
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $date_record = date("Y-m-d H:i:s");
    $submittedby = $_SESSION["staff_name"];

    // Image upload
    $targetDir = "imgs/";
    $uploadedFileName = $_FILES['image']['name'];
    $targetFile = $targetDir . $uploadedFileName;
    $imageFileType = strtolower(pathinfo($uploadedFileName, PATHINFO_EXTENSION));

    // Check if image file is a valid format
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $status = "Sorry, only JPG and PNG files are allowed.";
    } else {
        // Move uploaded file to destination directory only if it doesn't exist
        if (!file_exists($targetFile)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {

                // Insert product data into database
                $ins_query = "INSERT INTO products (`product_name`, `description`, `image_name`, `price`, `quantity`, `date_created`, `submittedby`) 
                          VALUES ('$product_name','$description', '$uploadedFileName', '$price', '$quantity', '$date_record', '$submittedby')";
                mysqli_query($con, $ins_query) or die (mysqli_error($con));

                // Status message
                $status = "New product inserted successfully. Go back to <a href='view_products.php'>View Product List</a> ?";
            } else {
                $status = "Sorry, there was an error uploading your file.";
            }
        } else {
            $status = "File already exists. Please choose a different file.";
        }
    }
}
mysqli_close($con);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="300">
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
            <label for="description">Description:</label>
            <input type="text" name="description" id="description" placeholder="Description" required>
            <label for="image">Image:</label>
            <input type="file" name="image" id="image" accept="image/jpeg, image/png" required>
            <label for="price">Price:</label>
            <input type="number" name="price" step="0.01" min="0" id="price" placeholder="Price" required>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" placeholder="Quantity" required>
            <input type="submit" value="Submit">
            <p class="create-product-status">
                <?php echo $status; ?>
            </p>
        </form>
    </div>
</body>

</html>
