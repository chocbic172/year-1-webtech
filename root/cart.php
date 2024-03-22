<?php
session_start();

require("utils/database.php");

use Utils\Database\DBConnection as Database;

$db = new Database();

$totalPrice = 0.0;

$userLoggedIn = isset($_SESSION['user']);

$serverMessages = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!$userLoggedIn) {
        $serverMessages .= "<p>Please log in (use the link in the navbar) to checkout your cart.</p>";
    }
    
    if ((!isset($_SESSION['cart'])) || (count($_SESSION['cart']) < 1)) {
        $serverMessages .= "<p>Please add some orders to the basket to start checking out your product.</p>";
        $orderSuccess = false;
    } else {
        $orderSuccess = $db->saveOrder($_SESSION['cart']);
    }

    if ($orderSuccess) {
        $serverMessages .= "<p>Order successfully submitted! Thank you for shopping!</p>";
        unset($_SESSION['cart']);
    } else {
        $serverMessages .= "<p>Order could not be submitted :( Please refresh and try again.</p>";
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
    <title>UCLan Shop - Basket</title>

    <!-- Import stylesheet -->
    <link rel="stylesheet" href="styles/cart.css">
</head>
<body>
    <!-- Navigation Bar -->
    <?php include 'components/navbar.inc.php' ?>

    <div class="cart-container">
        <h2>Cart</h2>
        <div class="server-messages">
            <?php echo $serverMessages ?>
        </div>
        <hr>
        <ul id="cart-list">
            <?php
            // PHP Docs: https://www.php.net/manual/en/control-structures.foreach.php
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as &$product) {
                    $productInfo = $db->getProductInfo($product)->fetch_assoc();
                    $totalPrice += floatval($productInfo['product_price']);
                    echo '
                    <li><div class="cart-item">
                        <p class="cart-item-name"><a href="item.php?id='.$product.'">'.$productInfo['product_title'].'</a></p>
                        <p class="cart-item-price">£'.$productInfo['product_price'].'</p>
                    </div></li>';
                }
                unset($product);
            } else {
                echo "<p>No items currently in cart. Add some from the products page!</p>";
            }
            ?>
        </ul>
        <hr>
        <p id="total-price"><b>Total Cost:</b> £<?php echo $totalPrice ?></p>
    </div>

    <div class="flex-content-center cart-bottom">
        <?php echo $userLoggedIn ? "" : "<h3>Please <a href='./login.php'>log in</a> to checkout your basket!</h3>" ?>

        <!--
        We use the `$_SERVER["PHP_SELF"]` superglobal to ensure the form is always submitted to this page.
        However, to avoid XSS exploits we wrap this in `htmlspecialcars()`, which automatically "escapes"
        all html characters. See W3 Schools for reference implementation:
        https://www.w3schools.com/php/php_form_validation.asp
        -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            <?php echo $userLoggedIn ? '<input type="submit" class="checkout-button" value="Checkout">' : "" ?>
        </form>

        <p>
            Forgotten something?
            <a href="./products.php">Press here to continue shopping</a>
        </p>
    </div>

    <!-- Site footer -->
    <?php include 'components/footer.inc.php' ?>
</body>
</html>