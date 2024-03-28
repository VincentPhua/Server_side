<?=template_header('Payment')?>

<div class="payment content-wrapper">
<?php
    // Retrieve the subtotal value from the URL parameter
    $subtotal = isset($_GET['subtotal']) ? $_GET['subtotal'] : 0.00;
?>
    <h1>Total $<?= $subtotal ?> of payment for your orders has been made. Thank you!</h1>
</div>

<?=template_footer()?>

<?php
unset($_SESSION['cart'])
?>