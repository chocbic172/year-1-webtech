<?php
session_start();

require("utils/database.php");

use Utils\Database\DBConnection as Database;

$db = new Database();

$loginAttempted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginSuccess = $db->attemptLogin($_POST['email'], $_POST['password']);
    
    $loginAttempted = true;

    // Redirect to homepage on success
    if ($loginSuccess) {
        header('Location: https://vesta.uclan.ac.uk/~ehoward4/webtech1/index.php');
        exit();
    }
}

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
    <link rel="stylesheet" href="styles/authentication.css">
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
            <?php
            // If we reach this point in the code and a login has been attempted,
            // the login attempt has implicitly failed
            if ($loginAttempted) {
                echo "<span>Login attempt unsuccessful! Please try again.</span><br><br>";
            }
            ?>
            <label for="email" class="form-label">Email</label><br>
            <input type="email" id="email" name="email" placeholder="Enter Email" class="text-field"
                value="<?php if($loginAttempted) { echo $_POST['email']; } ?>">
            <br>

            <label for="password" class="form-label">Password</label><br>
            <input type="password" id="password" name="password" placeholder="Enter Password" class="text-field">
            <br>

            <input type="submit" value="Log In" class="form-submit">
        </form>

        <p>Or if you don't have an account yet,<br><a href="register.php">sign up</a> for one today!</p>
    </div>

    <!-- Site footer -->
    <?php include 'components/footer.inc.php' ?>
</body>
</html>