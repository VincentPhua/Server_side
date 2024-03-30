<?php
// Need DB file connection
require ('database.php');
// Get product id
$id = $_GET['id'];
// Retrieve image file name from the database
$query = "SELECT image_name FROM products WHERE product_id = $id";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$imageFileName = $row['image_name'];

// Delete record from DB
$query = "DELETE FROM products WHERE product_id = $id";
$result = mysqli_query($con, $query) or die (mysqli_error($con));

// Delete image file from the upload folder
if (!empty ($imageFileName)) {
    $filePath = "imgs/" . $imageFileName;
    if (file_exists($filePath)) {
        unlink($filePath); // Delete the file
    }
}
// Redirect to view page after delete
header("Location: view_products.php");
mysqli_close($con);
exit();
?>
