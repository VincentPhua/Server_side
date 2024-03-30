<?php
require("database.php");
ob_start();
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = $_SESSION['to_pay'];
$subtotal = $_SESSION['subtotal'];
?>

<?= template_header('Payment') ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
</head>

<body>
    <div class="cart content-wrapper">
        <h1>Please confirm your order details</h1>
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
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td class="img">
                            <a href="index.php?page=product&id=<?= $product['product_id'] ?>">
                                <img src="imgs/<?=$product['image_name']?>" width="70" height="70" alt="<?=$product['product_name']?>">
                            </a>
                        </td>
                        <td>
                            <a href="index.php?page=product&id=<?= $product['product_id'] ?>"><?= $product['product_name'] ?></a>
                        </td>
                        <td class="price">&dollar;<?= $product['price'] ?></td>
                        <td class="quantity">
                            <p><?php echo $products_in_cart[$product['product_id']] ?></p>
                        </td>
                        <td class="price">&dollar;<?= $product['price'] * $products_in_cart[$product['product_id']] ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="subtotal">
                            <span class="text">Subtotal</span>
                            <span class="price">&dollar;<?= $subtotal ?></span>
                        </div>
                    </td>
            </tbody>
        </table>
    </div>
    <?php if (!isset($_POST['receiver_name']) && !isset($_POST['receiver_phone']) && !isset($_POST['delivery_addr'])) { ?>
        <div class="cart content-wrapper">
            <form method="POST" action="">
                <table>
                    <thead>
                        <th colspan="2">Receiver details (please fill in)</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Name:</td>
                            <td><input id="receiver_name" name="receiver_name" type="text" placeholder="Muhammad Ali" style="width: 100%" required ></td>
                        </tr>
                        <tr>
                            <td>Email (Optional):</td>
                            <td><input id="receiver_email" name="receiver_email" type="email" placeholder="muhammadali@gmail.com" style="width: 100%"></td>
                        </tr>
                        <tr>
                            <td>Phone:</td>
                            <td><input id="receiver_phone" name="receiver_phone" type="text" placeholder="012-3456789" style="width: 100%" required></td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td><textarea id="delivery_addr" name="delivery_addr" rows="4" style="width: 100%; resize: none;" required></textarea></td>
                        </tr>
                        <tr>
                            <td>Pay via:</td>
                            <td>
                                <select id="method_name" name="method_name" required>
                                    <option value="">---Please choose a payment method---</option>
                                    <?php
                                    $query = "SELECT `method_name` FROM `payment_method` ORDER BY `method_name`";
                                    $payment_methods = mysqli_query($con, $query);
                                    while ($row = mysqli_fetch_assoc($payment_methods)) {
                                        echo "<option value=\"" . $row['method_name'] . "\">" . $row['method_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button class="payment-button" type="submit" value="submit">Confirm Payment</button>
                                <a href="index.php?page=cart" class="cancel-button" type="reset" value="cancel">Back to Cart</button>
                            </td>
                    </tbody>
                </table>
            </form>
        </div>
    <?php } else { ?>
    <?php
        $receiver_name = $_POST['receiver_name'];
        $receiver_email = $_POST['receiver_email'];
        $receiver_phone = $_POST['receiver_phone'];
        $delivery_addr = $_POST['delivery_addr'];
        $method_name = $_POST['method_name'];
        $query = "SELECT `method_id` FROM `payment_method`
        WHERE `method_name` = '" . $method_name . "';";
        # ADD TABLE HERE TO INPUT PAYMENT INFO (credit card info, e-wallet info, etc.)
        # do not store these info into database for privacy & safety reasons
        # btw, is a table needed? what about redirect them to the provider's payment page?
        $result = mysqli_fetch_assoc(mysqli_query($con, $query));
        $method_id = $result['method_id'];
        $query = "INSERT INTO `orders`(
            `order_id`,
            `receiver_name`,
            `receiver_email`,
            `receiver_phone`,
            `delivery_addr`,
            `subtotal`,
            `order_time`,
            `payment_method`
        )
        VALUES(
            NULL,"
            . "'" . $receiver_name . "',"
            . "'" . $receiver_email . "',"
            . "'" . $receiver_phone . "',"
            . "'" . $delivery_addr . "',"
            . $subtotal . ","
            . "now(),"
            . "'" . $method_id . "'"
            . ");";
        if (mysqli_query($con, $query)) {
            $order_id = mysqli_insert_id($con);
            foreach ($products as $product) {
                $query = "UPDATE `products`
                SET `quantity` = `quantity` - " . $products_in_cart[$product['product_id']]
                    . " WHERE `product_id` = " . $product['product_id'] . ";";
                mysqli_query($con, $query);

                $query = "INSERT INTO `order_items` (
                    order_id,
                    product_id,
                    quantity
                    ) VALUES ("
                    . "'" . $order_id . "',"
                    . "'" . $product['product_id'] . "',"
                    . "'" . $products_in_cart[$product['product_id']] . "'"
                    . ");";
                mysqli_query($con, $query);
            };
            mysqli_close($con);
            header("Location: index.php?page=payment_success");
        }
    }; ?>
</body>

<?= template_footer() ?>

</html>