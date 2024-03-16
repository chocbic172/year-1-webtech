<?php
// For conformity to the HTTP spec, we'll change the status code
// to indicate to the browser that the page could not be found.
// PHP Docs: https://www.php.net/manual/en/function.http-response-code.php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Set up viewport and encoding -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Page title -->
    <title>UCLan Shop - Page not found</title>

    <!-- Import stylesheet -->
    <link rel="stylesheet" href="styles/index.css">
</head>
<body>
    <!-- Navigation Bar -->
    <?php include 'components/navbar.inc.php' ?>

    <!-- Error information section -->
    <div class="info-section">
        <h2>We can't find this page!</h2>
        <h3>Please look in our <a href="./products.php">products page</a> or use the navbar<br>to navigate back to the home page.</h3>
    </div>

    <!-- Site footer -->
    <?php include 'components/footer.inc.php' ?>
</body>
</html>