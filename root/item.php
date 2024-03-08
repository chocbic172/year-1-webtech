<?php
    require('utils/env.php');

    $servername = $env['SQL_DB_HOST'];
    $username = $env['SQL_DB_USER'];
    $password = $env['SQL_DB_PASS'];
    $dbname = $env['SQL_DB_NAME'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT product_image, product_title, product_type, product_price, product_desc FROM tbl_products WHERE product_id='".$_GET['item']."'";
    $result = $conn->query($sql);

    $item = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Set up viewport and encoding -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Page title -->
    <title>UCLan Shop</title>

    <!-- Import stylesheet -->
    <link rel="stylesheet" href="styles/item.css">
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
                <a href="./products.php" class="selected">Products</a>
                <a href="./cart.php">Basket</a>
            </div>
        </div>
        <!-- Spacer -->
        <div class="navbar-col hidden-sm"></div>
    </div>

    <!-- Breadcrumbs -->
    <p class="breadcrumbs">
        <span><a href="./index.php">Home</a></span>
        <span>></span>
        <span><a href="./products.php">Products</a></span>
        <span>></span>
        <span id="title-breadcrumb">
            <?php echo '<a href="#">'.$item['product_title'].'</a>' ?>
        </span>
    </p>

    <div id="item-content">
        <div class="row item-content-container">
            <div class="col-60">
                <?php echo '<img id="item-img" src="assets/'.$item['product_image'].'" alt="Product Image">' ?>
            </div>
            <div class="col-40">
            <?php
                echo '<h2 id="item-title">'.$item['product_title'].'</h2>';
                echo '<p id="item-price">£'.$item['product_price'].'</p>';
                echo '<p id="item-desc">'.$item['product_desc'].'</p>';
            ?>
            <button id="item-cart-button">Add To Cart</button>
            </div>
        </div>
    </div>

    <!-- Site footer -->
    <?php include 'components/footer.inc.php' ?>
</body>
</html>