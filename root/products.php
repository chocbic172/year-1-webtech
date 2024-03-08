<?php
function getProductsOfType($productType) {
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

    $sql = "SELECT product_id, product_image, product_title, product_type, product_price FROM tbl_products WHERE product_type='$productType'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<a href="./item.php?item='.$row["product_id"].'"><div class="col-33">'.
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
                <a href="#" class="selected">Products</a>
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
            <?php getProductsOfType('UCLan Hoodie'); ?>
        </div>
    </div>

    <!-- Jumpers section -->
    <div class="product-section" id="jumpers">
        <h2>Jumpers</h2>
        <a href="#"><p>Jump to Top</p></a>
        <div class="row product-row" id="jumpers-container">
            <?php getProductsOfType('UCLan Logo Jumper'); ?>
        </div>
    </div>
    
    <!-- Jumpers section -->
    <div class="product-section" id="tshirts">
        <h2>TShirts</h2>
        <a href="#"><p>Jump to Top</p></a>
        <div class="row product-row" id="tshirts-container">
            <?php getProductsOfType('UCLan Logo Tshirt'); ?>
        </div>
    </div>

    <!-- Site footer -->
    <?php include 'components/footer.inc.php' ?>
</body>
</html>