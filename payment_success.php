<?php
header( "refresh:5;url=index.php" );
?>

<?= template_header('Payment') ?>

<div class="payment content-wrapper">
<?php
    // Retrieve the subtotal value from the URL parameter
    $subtotal = isset($_SESSION['subtotal']) ? $_SESSION['subtotal'] : 0.00;
?>
    <h1>Total $<?= $subtotal ?> of payment for your orders has been made. Thank you!</h1>
    <p>You will be redirected to main page in few seconds...</p>
    <p>If the page does not redirect, click <a href="index.php">here</a> to return to main page.</p>
</div>

<?= template_footer() ?>

<?php
unset($_SESSION['cart'])
?>