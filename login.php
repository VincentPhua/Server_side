<?php
ob_start();
// Check if session is active
if (session_status() == PHP_SESSION_ACTIVE) {
    // Session is active, destroy it
    session_destroy();
}
session_start();
$_SESSION['last_timestamp'] = time();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Include Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- Include custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <?php
    //Need db file
    require ('database.php');

    // Check if login form submitted
    if (isset($_POST['username'])) {
        // Sanitize user input
        $username = stripslashes($_REQUEST['username']);
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);

        // Retrieve users from DB 
        $query = "SELECT * 
              FROM `staff` 
              WHERE staff_name='$username'
              AND password='" . md5($password) . "'"
        ;
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $rows = mysqli_num_rows($result);
        // If user found, set session and redirect to index.php
        if ($rows == 1) {
            $userData = mysqli_fetch_assoc($result);
            $_SESSION['staff_name'] = $userData['staff_name'];
            $_SESSION['staff_id'] = $userData['staff_id'];


            header("Location: staff.php");
            exit();
        } else {
            echo "<div class='form'>
				<h3>Username/password is incorrect.</h3>
				<br/>Click here to <a href='login.php'>Login</a></div>";
        }
        mysqli_close($con);
    } else {
        if (isset($_GET['session_expired']) && $_GET['session_expired'] == 1) {
            echo "<script>alert('Your session has expired. Please log in again.');</script>";
            session_destroy();
        }
        ?>
        <section class="custom-container">
            <div class="custom-image-section">
                <div class="custom-image-wrapper">
                    <img src="imgs/staff/I1.jpg" alt="">
                </div>

                <div class="custom-content-container">
                    <h1 class="custom-section-heading"> Empowering Experience Through
                        <span>Phone Accessories.</span>
                    </h1>
                    <p class="custom-section-paragraph"> Every step forward is a step
                        towards luxury. Embrace the journey
                    </p>
                </div>
            </div>

            <div class="custom-form-section">
                <div class="custom-form-wrapper">
                    <div class="custom-logo-container">
                        <!-- Logo image goes here -->
                    </div>
                    <h2>Staff Log In</h2>
                    <form action="" method="post" name="login"> <!-- Added form element -->
                        <div class="custom-input-container">
                            <div class="custom-form-group">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" required />
                            </div>
                            <div class="custom-form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" required />
                            </div>
                        </div>
                        <input name="submit" type="submit" value="Login" class="btn-login" />
                    </form> <!-- Closing form element -->
                    <p></p>
                    <p></p>
                    <p>Go Back to Main Page? <a href='index.php'>Main Page</a></p>
                </div>
            </div>
        </section>

        <!-- End of form handling -->
    <?php } ?>
</body>

<footer>
    <p>&copy; 2024 PhoneAccessories. All rights reserved.</p>
</footer>

</html>