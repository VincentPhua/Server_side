<<<<<<< Updated upstream:payment.php
<?=template_header('Payment')?>
=======
<?=template_header('Payment Success')?>
>>>>>>> Stashed changes:payment_success.php

<div class="payment content-wrapper">
<?php
    // Retrieve the subtotal value from the URL parameter
<<<<<<< Updated upstream:payment.php
    $subtotal = isset($_GET['subtotal']) ? $_GET['subtotal'] : 0.00;
=======
    $subtotal = isset($_SESSION['subtotal']) ? $_SESSION['subtotal'] : 0.00;
>>>>>>> Stashed changes:payment_success.php
?>
    <h1>Total $<?= $subtotal ?> of payment for your orders has been made. Thank you!</h1>
</div>

<?=template_footer()?>

<?php
unset($_SESSION['cart'])
?>