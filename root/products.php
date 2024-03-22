<?php
session_start();

require("utils/database.php");

use Utils\Database\DBConnection;

$db = new DBConnection();

/**
 * Generates a graphical view of the rating of the item `$productId`
 */
function generateRating(string $productId, DBConnection $db) {
    if (intval($db->getRatingForProduct($productId)) > 0) {
        return str_repeat('⭐', intval($db->getRatingForProduct($productId)));
    } else {
        return 'No ratings yet!';
    }
}

/**
 * Generates a collection of HTML products from a `mysqli_result` object
 */
function renderProductsFromSQL(mysqli_result $products, DBConnection $db) {
    $output = "";

    if ($products->num_rows > 0) {
        // output data of each row
        while($row = $products->fetch_assoc()) {
            $output .= '<a href="./item.php?id='.$row["product_id"].'"><div class="col-33">'.
            '<div class="product">'.
                '<img src="assets/'.$row["product_image"].'" alt="'.$row["product_title"].'">'.
                '<p><b>'.$row["product_title"].'</b></p>'.
                '<p>'.generateRating($row["product_id"], $db).'</p>'.
                '<p><i>£'.$row["product_price"].'</i></p>'.
            '</div>'.
        '</div></a>';
        }
    } else {
        $output .= "<h3>No products of this category could be found!</h3>";
    }

    return $output;
}

/**
 * Generates a "product section" page component
 */
function generateProductsSection(mysqli_result $products, string $sectionTitle, DBConnection $db) {
    return '
    <div class="product-section">
        <h2>'.$sectionTitle.'</h2>
        <div class="row product-row">
            '.renderProductsFromSQL($products, $db).'
        </div>
    </div>
    ';
}

/**
 * Get ALL products in the database, categorised by item type
 */
function getAllProducts(DBConnection $db) {
    $productSections = "";
    $productSections .= generateProductsSection($db->getProductsOfType('UCLan Hoodie'), 'Hoodie', $db);
    $productSections .= generateProductsSection($db->getProductsOfType('UCLan Logo Jumper'), 'Jumper', $db);
    $productSections .= generateProductsSection($db->getProductsOfType('UCLan Logo TShirt'), 'TShirt', $db);
    return $productSections;
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
        <span><a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">Products</a></span>
    </p>

    <!-- Quick Navigation to Sections -->
    <!-- TODO: Make background slightly darker to increase text contrast -->
    <div class="row quick-navigation-section">
        <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?type=hoodies" ?>">
            <div class="col-33 hoodie-bg">
                <h2>Hoodies</h2>
            </div>
        </a>
        <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?type=jumpers" ?>">
            <div class="col-33 jumper-bg">
                <h2>Jumper</h2>
            </div>
        </a>
        <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?type=tshirts" ?>">
            <div class="col-33 tshirt-bg">
                <h2>TShirts</h2>
            </div>
        </a>
    </div>

    <div class="search-section">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="get">
            <input type="text" name="q" id="search" class="search-bar"
             placeholder="Type Search Here..." value="<?php echo isset($_GET['q']) ? $_GET['q']: ''?>">

            <input type="submit" value="Search" class="search-submit">
        </form>
    </div>

    <!--
    We GET the filter data to the server so it can be navigated through using the browser search history.
    MDN Docs:
    https://developer.mozilla.org/en-US/docs/Learn/Forms/Sending_and_retrieving_form_data

    We use the `$_SERVER["PHP_SELF"]` superglobal to ensure the form is always submitted to this page.
    However, to avoid XSS exploits we wrap this in `htmlspecialcars()`, which automatically "escapes"
    all html characters. See W3 Schools for reference implementation:
    https://www.w3schools.com/php/php_form_validation.asp
    -->
    <!-- <div class="offers-section">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="get">
    
        </form>
    </div> -->

    <?php
    // Filter the products using the "type" parameter of a get request. This
    // is submitted via a URL naviation event, as opposed to through a form.
    // We show all products if a) there is no applied filter or b) the
    // requested type is invalid
    if (isset($_GET['q'])) {
        echo generateProductsSection($db->getProductsFromSearch($_GET['q']), 'Search Results', $db);
    } else if (isset($_GET['type'])) {
        if ($_GET['type'] == "hoodies") {
            echo generateProductsSection($db->getProductsOfType('UCLan Hoodie'), 'Hoodie', $db);
        } else if ($_GET['type'] == "jumpers") {
            echo generateProductsSection($db->getProductsOfType('UCLan Logo Jumper'), 'Jumper', $db);
        } else if ($_GET['type'] == "tshirts") {
            echo generateProductsSection($db->getProductsOfType('UCLan Logo Tshirt'), 'Tshirt', $db);
        } else {
            echo getAllProducts($db);
        }
    } else {
        echo getAllProducts($db);
    }
    ?>

    <!-- Site footer -->
    <?php include 'components/footer.inc.php' ?>
</body>
</html>