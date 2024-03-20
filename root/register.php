<?php
session_start();

require("utils/database.php");
use Utils\Database\DBConnection as Database;

require("utils/validate.php");
use function Utils\Validate\verifyEmail;
use function Utils\Validate\verifyName;
use function Utils\Validate\verifyPassword;
use function Utils\Validate\verifyRepeatPassword;

$db = new Database();

// Initialise persistent form data variables
$name = $email = "";

$nameErrors = $emailErrors = $passwordErrors = $repeatPasswordErrors = "";

// The form is submitted using the `POST` method. We detect + handle
// that with by checking the `$_SERVER` superglobal. PHP Docs Ref:
// https://www.php.net/manual/en/reserved.variables.server.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $nameErrors = verifyName($name);

    $email = $_POST["email"];
    $emailErrors = verifyEmail($email, $db);

    $password = $_POST["password"];
    $passwordErrors = verifyPassword($password);

    $repeatPassword = $_POST["repeat-password"];
    $repeatPasswordErrors = verifyRepeatPassword($password, $repeatPassword);

    // No error messages implicitly means the validation has passed
    if (strlen($nameErrors.$emailErrors.$passwordErrors.$repeatPasswordErrors) == 0) {
        $registerSuccess = $db->registerUser($email, $name, $password);

        if ($registerSuccess) {
            header('Location: https://vesta.uclan.ac.uk/~ehoward4/webtech1/index.php');
            exit();
        }

        $nameErrors .= "<span>Registration has failed. Please reload the page and try again.</span>";
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

            <!-- Full Name form field -->
            <label for="name" class="form-label">Full Name</label><br>
            <?php echo $nameErrors ?>
            <input type="text" id="name" name="name" placeholder="Enter Full Name" class="text-field" value="<?php echo $name ?>"><br>

            <!-- Email form field -->
            <label for="email" class="form-label">Email</label><br>
            <?php echo $emailErrors ?>
            <input type="text" id="email" name="email" placeholder="Enter Email" class="text-field" value="<?php echo $email ?>"><br>

            <!-- Password form field -->
            <label for="password" class="form-label">Password</label><br>
            <?php echo $passwordErrors ?>
            <input type="password" id="password" name="password" placeholder="Enter Password" class="text-field"><br>
            
            <!-- Repeated password form field -->
            <label for="repeat-password" class="form-label">Repeat Password</label><br>
            <?php echo $repeatPasswordErrors ?>
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