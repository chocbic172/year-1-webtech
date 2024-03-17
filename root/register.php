<?php
session_start();

require("utils/database.php");

use Utils\Database\DBConnection as Database;

$db = new Database();

// Initialise persistent form data variables
$formSubmitted = false;
$name = $email = "";

// The form is submitted using the `POST` method. We detect + handle
// that with by checking the `$_SERVER` superglobal. PHP Docs Ref:
// https://www.php.net/manual/en/reserved.variables.server.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $formSubmitted = true;
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $repeatPassword = $_POST["repeat-password"];
}

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
        MDN Docs:
        https://developer.mozilla.org/en-US/docs/Learn/Forms/Sending_and_retrieving_form_data

        We use the `$_SERVER["PHP_SELF"]` superglobal to ensure the form is always submitted to this page.
        However, to avoid XSS exploits we wrap this in `htmlspecialcars()`, which automatically "escapes"
        all html characters. See W3 Schools for reference implementation:
        https://www.w3schools.com/php/php_form_validation.asp
        -->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">


            <!-- Full Name form field + validation -->
            <label for="name" class="form-label">Full Name</label><br>
            <?php
                if ($formSubmitted) {
                    if ($name == "") {
                        echo "<span>Please enter your full name!</span>";
                    }
                }
            ?>
            <input type="text" id="name" name="name" placeholder="Enter Full Name" class="text-field" value="<?php echo $name ?>"><br>


            <!-- Email form field + validation -->
            <label for="email" class="form-label">Email</label><br>
            <?php
                if ($formSubmitted) {
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo "<span>Please enter a valid email!</span>";
                    }

                    if ($db->emailIsRegistered($email)) {
                        echo "<span>There is already an account with this email. Please choose another.</span>";
                    }
                }
            ?>
            <input type="text" id="email" name="email" placeholder="Enter Email" class="text-field" value="<?php echo $email ?>"><br>


            <!-- Password form field + validation -->
            <label for="password" class="form-label">Password</label><br>
            <?php
                if ($formSubmitted) {
                    if (strlen($password) < 8) {
                        echo "<span>Please choose another password with at least 8 characters</span><br/>";
                    }
                    
                    if (!preg_match('~[0-9]+~', $password)) {
                        echo "<span>Please choose another password with  at least 1 number</span><br/>";
                    }
                    
                    if (!(preg_match('~[A-Z]+~', $password) && preg_match('~[a-z]+~', $password))) {
                        echo "<span>Please choose another password with both uppercase and lowercase letters</span><br/>";
                    }
                }
                ?>
            <input type="password" id="password" name="password" placeholder="Enter Password" class="text-field"><br>
            
            <!-- Repeated password form field + validation -->
            <label for="repeat-password" class="form-label">Repeat Password</label><br>
            <?php
                if ($formSubmitted) {
                    if ($password != $repeatPassword) {
                        echo "<span>Passwords do not match! Please try again.</span>";
                    }
                }
                ?>
            <input type="password" id="repeat-password" name="repeat-password" placeholder="Repeat Password" class="text-field"><br>
            
            <!-- Form submit button -->
            <input type="submit" value="Register" class="form-submit">
            
        </form>
        
        <p>Or if you already have an account,<br><a href="./login.php">log in</a> here!</p>
    </div>
    
    <!-- Site footer -->
    <?php include 'components/footer.inc.php' ?>
</body>
</html>