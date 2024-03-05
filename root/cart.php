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
    <div class="navbar-clearfix"></div>
    <div class="navbar">
        <!-- Navigation logo -->
        <div class="navbar-col hidden-sm">
            <p class="nav-logo">UCLan Student Shop</p>
        </div>
        <!-- Main navigation section, with links -->
        <div class="navbar-col nav-section-main">
            <div class="navigation-list">
                <a href="./index.php">Home</a>
                <a href="./products.php">Products</a>
                <a href="#" class="selected">Basket</a>
            </div>
        </div>
        <!-- Spacer -->
        <div class="navbar-col hidden-sm"></div>
    </div>

    <div class="cart-container">
        <h2>Cart</h2>
        <hr>
        <ul id="cart-list"></ul>
        <hr>
        <p id="total-price"><b>Total Cost:</b> £price</p>
    </div>

    <div class="flex-content-center cart-bottom">
        <button class="checkout-button">Checkout</button>
        <p>
            Forgotten something?
            <a href="./products.php">Press here to continue shopping</a>
        </p>
    </div>

    <!-- Site footer -->
    <footer>
        <img src="assets/images/logo.svg" alt="">
    </footer>

    <!-- Import after body has loaded to reduce time to render -->
    <script src="scripts/cart.js"></script>
</body>
</html>