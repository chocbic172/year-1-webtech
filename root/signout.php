<?php
session_start();

// Remove logged in user session.
unset($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Set up viewport and encoding -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Page title -->
    <title>UCLan Shop - Sign Out</title>

    <!-- Import stylesheet -->
    <link rel="stylesheet" href="styles/authentication.css">
</head>
<body>
    <!-- Navigation Bar -->
    <?php include 'components/navbar.inc.php' ?>

    <div class="row login-section">
        <h1>You have successfully logged out.</h1>
        <h3>Feel free to keep browsing our products using the links above.</h3>
    </div>

    <!-- Site footer -->
    <?php include 'components/footer.inc.php' ?>
</body>
</html>