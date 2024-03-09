<?php
// TODO: Implement register form handling
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Set up viewport and encoding -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Page title -->
    <title>UCLan Shop - Register</title>

    <!-- Import stylesheet -->
    <link rel="stylesheet" href="styles/authentication.css">
</head>
<body>
    <!-- Navigation Bar -->
    <?php include 'components/navbar.inc.php' ?>

    <div class="row login-section">
        <h1>Welcome!</h1>
        <h3>Please register for an account using the form below</h3>

        <!--
        We POST the login data to the server so it isn't stored in search history.
        MDN Docs: https://developer.mozilla.org/en-US/docs/Learn/Forms/Sending_and_retrieving_form_data
        -->
        <form action="./register.php" method="POST">
            <label for="name" class="form-label">Full Name</label><br>
            <input type="text" id="name" name="name" placeholder="Enter Full Name" class="text-field" required><br>

            <label for="email" class="form-label">Email</label><br>
            <input type="email" id="email" name="email" placeholder="Enter Email" class="text-field" required><br>

            <label for="password" class="form-label">Password</label><br>
            <input type="password" id="password" name="password" placeholder="Enter Password" class="text-field" required><br>
            
            <label for="repeat-password" class="form-label">Repeat Password</label><br>
            <input type="password" id="repeat-password" name="repeat-password" placeholder="Repeat Password" class="text-field" required><br>

            <input type="submit" value="Register" class="form-submit">
        </form>

        <p>Or if you already have an account,<br><a href="./login.php">log in</a> here!</p>
    </div>

    <!-- Site footer -->
    <?php include 'components/footer.inc.php' ?>
</body>
</html>