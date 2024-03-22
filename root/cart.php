<?php
session_start();

require("utils/database.php");

use Utils\Database\DBConnection as Database;

$db = new Database();

$totalPrice = 0.0;

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
                        <button class="cart-item-remove">Remove</button>
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
        <button class="checkout-button">Checkout</button>
        <p>
            Forgotten something?
            <a href="./products.php">Press here to continue shopping</a>
        </p>
    </div>

    <!-- Site footer -->
    <?php include 'components/footer.inc.php' ?>
</body>
</html>