<?php
    require("utils/database.php");
    require("utils/redirect404.php");

    use Utils\Database\DBConnection as Database;
    use function Utils\Redirect404\redirect404;

    $db = new Database();

    // Check if the required url parameters exist with `isset()`.
    // PHP Docs: https://www.php.net/manual/en/function.isset.php
    if (!isset($_GET['id'])) { redirect404(); }

    $result = $db->getProductInfo($_GET['id']);
    $item = $result->fetch_assoc();

    if (! $result->num_rows > 0) { redirect404(); }
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
    <?php include 'components/navbar.inc.php' ?>

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