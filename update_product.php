<?php
// Check authentication for user
include("auth.php");
// Need DB file connection
require('database.php');

// Set the default timezone to your desired timezone
date_default_timezone_set('Asia/Singapore');

$status = '';
$imageUpdate = ''; // Initialize $imageUpdate variable

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve product info from form
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $date_record = date("Y-m-d H:i:s");
    $submittedby = $_SESSION["staff_name"];

    // Check if an image is uploaded
    if (!empty($_FILES['image']['name'])) {
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
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $imageUpdate = ", image_name='$uploadedFileName'";
            } else {
                $status = "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Update product data in database
    $update_query = "UPDATE products SET product_name='$product_name', description='$description', price='$price', quantity='$quantity', date_created='$date_record', submittedby='$submittedby' $imageUpdate WHERE product_id=$product_id";
    mysqli_query($con, $update_query) or die(mysqli_error($con));

    // Status message
    $status = "Product updated successfully. Go back to <a href='view_products.php'>View Product List</a> ?";
}

// Retrieve product information based on product ID
$product_id = $_GET['id'];
$select_query = "SELECT * FROM products WHERE product_id=$product_id";
$result = mysqli_query($con, $select_query);
$row = mysqli_fetch_assoc($result);

// Close database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Update Product</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <a href="view_products.php" class="back-button">&lt; Back to View Products</a>
    <div class="create-product-container">
        <h2 class="create-product-title">Update Product</h2>
        <form class="create-product-form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">

            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" id="product_name" value="<?php echo $row['product_name']; ?>" placeholder="Product Name" required>

            <label for="description">Description:</label>
            <input type="text" name="description" id="description" value="<?php echo $row['description']; ?>" placeholder="Description" required>

            <label for="image">Image:</label>
            <input type="file" name="image" id="image" accept="image/jpeg, image/png">

            <label for="price">Price:</label>
            <input type="number" name="price" step="0.01" min="0" id="price" value="<?php echo $row['price']; ?>" placeholder="Price" required>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" value="<?php echo $row['quantity']; ?>" placeholder="Quantity" required>

            <input type="submit" value="Update">
            <p class="create-product-status">
                <?php echo $status; ?>
            </p>
        </form>
    </div>
</body>

</html>
