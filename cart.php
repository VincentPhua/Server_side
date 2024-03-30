<?php
// If the user clicked the add to cart button on the product page we can check for the form data
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) 
{
    // Set the post variables so we easily identify them, also make sure they are integer
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    // Prepare the SQL statement, we basically are checking if the product exists in our databaser
    $stmt = $pdo->prepare('SELECT * FROM products WHERE product_id = ?');
    $stmt->execute([$_POST['product_id']]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if ($product && $quantity > 0) 
    {
        // Product exists in database, now we can create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) 
        {
            if (array_key_exists($product_id, $_SESSION['cart'])) 
            {
                // Product exists in cart so just update the quanity
                $_SESSION['cart'][$product_id] += $quantity;
            } else 
            {
                // Product is not in cart so add it
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else 
        {
            // There are no products in cart, this will add the first product to cart
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    // Prevent form resubmission...
    header('location: index.php?page=cart');
    exit;
}

// Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) 
{
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
}

// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if (isset($_POST['update']) && isset($_SESSION['cart'])) 
{
    // Loop through the post data so we can update the quantities for every product in cart
    foreach ($_POST as $k => $v) 
    {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) 
        {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            // Always do checks and validation
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) 
            {
                // Update new quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    // Prevent form resubmission...
    header('location: index.php?page=cart');
    exit;
}


// Send the user to the payment page if they click the Add button, also the cart should not be empty
if (isset($_POST['payment']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) 
{
    header('Location: index.php?page=payment');
    exit;
}


// Check the session variable for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
// If there are products in cart
if ($products_in_cart) 
{
    // There are products in the cart so we need to select those products from the database
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM products WHERE product_id IN (' . $array_to_question_marks . ')');
    // We only need the array keys, not the values, the keys are the id's of the products
    $stmt->execute(array_keys($products_in_cart));
    // Fetch the products from the database and return the result as an Array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Calculate the subtotal
    foreach ($products as $product) 
    {
        $subtotal += (float)$product['price'] * (int)$products_in_cart[$product['product_id']];
    }
}
// Set the products to pay
$_SESSION['to_pay'] = $products;
// Set the subtotal in session variable
$_SESSION['subtotal'] = $subtotal;
$pdo = NULL;
?>

<?=template_header('Cart')?>

<div class="cart content-wrapper">
    <h1><?php echo ((isset($_SESSION['cart']) && count($_SESSION['cart']) > 0)? "Shopping Cart" : "It seems like your cart is empty...") ?></h1>
    <p><i>Press the refresh button to refresh your prices!</i></p>
    <form action="index.php?page=cart" method="post">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have yet added products in your cart.</td>
                </tr>
                <?php else: ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td class="img">
                        <a href="index.php?page=product&id=<?=$product['product_id']?>">
                            <img src="imgs/<?=$product['image_name']?>" width="70" height="70" alt="<?=$product['product_name']?>">
                        </a>
                    </td>
                    <td>
                        <a href="index.php?page=product&id=<?=$product['product_id']?>"><?=$product['product_name']?></a>
                        <br>
                        <a href="index.php?page=cart&remove=<?=$product['product_id']?>" class="remove">Remove</a>
                    </td>
                    <td class="price">&dollar;<?=$product['price']?></td>
                    <td class="quantity">
                        <input type="number" onchange="" name="quantity-<?=$product['product_id']?>" value="<?=$products_in_cart[$product['product_id']]?>" min="1" max="<?=$product['quantity']?>" placeholder="Quantity" required>
                    </td>
                    <td class="price">&dollar;<?=$product['price'] * $products_in_cart[$product['product_id']]?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price">&dollar;<?=$subtotal?></span>
        </div>
        <div class="buttons">
            <input type="submit" value="Refresh" name="update">
            <?php 
            $href = "index.php?page=products";
            $text = "Click me to see products!";
            if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                $href = "index.php?page=payment_process";
                $text = "Payment";
             } ?>
            <a href=<?php echo $href ?> class="payment-button"><?php echo $text ?></a>

        </div>
    </form>
</div>

<?=template_footer()?>