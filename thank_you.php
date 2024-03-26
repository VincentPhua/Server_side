<?php
header("refresh:5; url=payment.php"); #temporary only, need to redirect back to index.php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You!</title>
</head>

<body>
    <h1>Thank you for your purchase!</h1>
    <p>You will be redirected back to main page in few seconds...</p>
    <p>If the page does not redirect, <a href="payment.php">Click here</a></p> <!-- temporary only, need redirect to index.php -->
</body>

</html>