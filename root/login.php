<?php
// TODO: Implement login form handling
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Set up viewport and encoding -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Page title -->
    <title>UCLan Shop - Log In</title>

    <!-- Import stylesheet -->
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
    <!-- Navigation Bar -->
    <?php include 'components/navbar.inc.php' ?>

    <div class="row login-section">
        <h1>Welcome!</h1>
        <h3>Please log in using the form below</h3>

        <!--
        We POST the login data to the server so it isn't stored in search history.
        MDN Docs: https://developer.mozilla.org/en-US/docs/Learn/Forms/Sending_and_retrieving_form_data
        -->
        <form action="./login.php" method="POST">
            <label for="email" class="form-label">Email</label><br>
            <input type="email" id="email" name="email" placeholder="Enter Email" class="text-field" required><br>

            <label for="password" class="form-label">Password</label><br>
            <input type="password" id="password" name="password" placeholder="Enter Password" class="text-field" required><br>

            <input type="submit" value="Log In" class="form-submit">
        </form>

        <p>Or if you don't have an account yet,<br><a href="register.php">sign up</a> for one today!</p>
    </div>

    <!-- Site footer -->
    <?php include 'components/footer.inc.php' ?>
</body>
</html>