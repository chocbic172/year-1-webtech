<?php
require("utils/database.php");

use Utils\Database\DBConnection;

$db = new DBConnection();

function getProductsOfType(string $productType, DBConnection $db) {
    $result = $db->getProductsOfType($productType);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<a href="./item.php?id='.$row["product_id"].'"><div class="col-33">'.
            '<div class="product">'.
                '<img src="assets/'.$row["product_image"].'" alt="'.$row["product_title"].'">'.
                '<p><b>'.$row["product_title"].'</b></p>'.
                '<p><i>£'.$row["product_price"].'</i></p>'.
            '</div>'.
        '</div></a>';
        }
    } else {
        echo "<h3>No products of this category could be found!</h3>";
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
    <title>UCLan Shop - Products</title>

    <!-- Import stylesheet -->
    <link rel="stylesheet" href="styles/products.css">
</head>
<body>
    <!-- Navigation Bar -->
    <?php include 'components/navbar.inc.php' ?>

    <!-- Breadcrumbs -->
    <p class="breadcrumbs">
        <span><a href="./index.php">Home</a></span>
        <span>></span>
        <span><a href="#">Products</a></span>
    </p>

    <!-- Quick Navigation to Sections -->
    <!-- TODO: Make background slightly darker to increase text contrast -->
    <div class="row quick-navigation-section">
        <a href="#hoodies"><div class="col-33 hoodie-bg">
            <h2>Hoodies</h2>
        </div></a>
        <a href="#jumpers"><div class="col-33 jumper-bg">
            <h2>Jumpers</h2>
        </div></a>
        <a href="#tshirts"><div class="col-33 tshirt-bg">
            <h2>TShirts</h2>
        </div></a>
    </div>

    <!-- Hoodies section -->
    <!--
    The `id` attribute here is used to allows anchor links to be used. This
    is also used in the other sections. See W3 Reference:
    https://www.w3docs.com/snippets/html/how-to-create-an-anchor-link-to-jump-to-a-specific-part-of-a-page.html
    -->
    <div class="product-section" id="hoodies">
        <h2>Hoodies</h2>
        <a href="#"><p>Jump to Top</p></a>
        <div class="row product-row" id="hoodies-container">
            <?php getProductsOfType('UCLan Hoodie', $db); ?>
        </div>
    </div>

    <!-- Jumpers section -->
    <div class="product-section" id="jumpers">
        <h2>Jumpers</h2>
        <a href="#"><p>Jump to Top</p></a>
        <div class="row product-row" id="jumpers-container">
            <?php getProductsOfType('UCLan Logo Jumper', $db); ?>
        </div>
    </div>
    
    <!-- Jumpers section -->
    <div class="product-section" id="tshirts">
        <h2>TShirts</h2>
        <a href="#"><p>Jump to Top</p></a>
        <div class="row product-row" id="tshirts-container">
            <?php getProductsOfType('UCLan Logo Tshirt', $db); ?>
        </div>
    </div>

    <!-- Site footer -->
    <?php include 'components/footer.inc.php' ?>
</body>
</html>