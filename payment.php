<?php
# temporary only, assumption is that the previous page has a form that passes these information
$_POST['product_id'] = 1;
$_POST['receiver_name'] = "Milo Receiver";
$_POST['receiver_email'] = "miloreceiver@gmail.com";
$_POST['receiver_phone'] = "1234567";
$_POST['delivery_addr'] = "1244 Jln Seksyen 1/3";
$_POST['order_desc'] = "Put at front door";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
</head>

<body>
    <?php
    require("database.php");
    $product_id = $_POST['product_id'];
    $query = "SELECT `product_name`, `price`, `quantity` FROM `product`
    WHERE `product_id` = " . $product_id . ";";
    $product = mysqli_fetch_assoc(mysqli_query($con, $query));
    $product_name = $product['product_name'];
    $price = number_format((float)$product['price'], 2);
    $receiver_name = $_POST['receiver_name'];
    $receiver_email = $_POST['receiver_email'];
    $receiver_phone = $_POST['receiver_phone'];
    $delivery_addr = $_POST['delivery_addr'];
    $order_desc = $_POST['order_desc'];

    $query = "SELECT `method_name` FROM `payment_method` ORDER BY `method_name`";
    $payment_methods = mysqli_query($con, $query);

    ?>
    <div>
        <table>
            <thead>
                <th colspan="3">Please confirm your order details</th>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="2">PREVIEW IMAGE</td>
                    <td>Product:</td>
                    <td><?php echo $product_name ?></td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>RM <?php echo $price ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <div>
        <table>
            <thead>
                <th colspan="3">Receiver details</th>
            </thead>
            <tbody>
                <tr>
                    <td>Name:</td>
                    <td colspan="2"><?php echo $receiver_name ?></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td colspan="2"><?php echo $receiver_email ?></td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td colspan="2"><?php echo $receiver_phone ?></td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td colspan="2"><?php echo $delivery_addr ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <?php
    require("database.php");
    if (!isset($_POST['method_name'])) {
    ?>
        <div>
            <form id="payment_form" method="POST" action="">
                <table>
                    <tr>
                        <td>Pay via:</td>
                        <td>
                            <select id="method_name" name="method_name" required>
                                <option value="">---Please choose a payment method---</option>
                                <?php
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
                            <button type="submit" value="submit">Confirm Payment</button>
                            <button type="reset" value="cancel">Cancel Payment</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    <?php
    } else {
        $method_name = $_POST['method_name'];
        $query = "SELECT `method_id` FROM `payment_method`
        WHERE `method_name` = '" . $method_name . "';";
        # ADD TABLE HERE TO INPUT PAYMENT INFO (credit card info, e-wallet info, etc.)
        # do not store these info into database for privacy & safety reasons
        # btw, is a table needed? what about redirect them to the provider's payment page?
        $result = mysqli_fetch_assoc(mysqli_query($con, $query));
        $method_id = $result['method_id'];
        $query = "INSERT INTO `order`(
            `order_id`,
            `receiver_name`,
            `receiver_email`,
            `receiver_phone`,
            `delivery_addr`,
            `order_desc`,
            `order_time`,
            `payment_method`,
            `product_id`
        )
        VALUES(
            NULL,"
            . "'" . $receiver_name . "',"
            . "'" . $receiver_email . "',"
            . "'" . $receiver_phone . "',"
            . "'" . $delivery_addr . "',"
            . "'" . $order_desc . "',"
            . "now(),"
            . "'" . $method_id . "',"
            . "'" . $product_id . "'"
            . ");";
        if (mysqli_query($con, $query)) {
            $query = "UPDATE `product`
            SET `quantity` = `quantity` - 1
            WHERE `product_id` = " . $product_id . ";";
            mysqli_query($con, $query);
            header("Location: thank_you.php");
        };
    };
    ?>
</body>

</html>