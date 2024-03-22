<?php
    session_start();

    require("utils/database.php");
    require("utils/show404.php");

    use Utils\Database\DBConnection;
    use function Utils\Show404\show404;

    $db = new DBConnection();

    function addProductToCart(string $productId) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array($productId);
        } else {
            array_push($_SESSION['cart'], $productId);
        }
    }

    function createReview(DBConnection $db) {
        $product = $_POST["productId"];
        $title = $_POST["reviewTitle"];
        $description = $_POST["reviewDescription"];
    
        // Convert the rating to an `integer` so we can check that it's valid
        // PHP Docs: https://www.php.net/manual/en/function.intval.php
        $rating = intval($_POST["reviewRating"]);
    
        $db->createReview($product, $title, $description, $rating);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST['action'] == "cart") {
            addProductToCart($_POST['productId']);
            echo $_SESSION['cart'];
        }

        if ($_POST['action'] == "review") {
            createReview($db);
        }

        // Do not render any HTML for a post request
        exit();
    }

    // Check if the required url parameters exist with `isset()`.
    // PHP Docs: https://www.php.net/manual/en/function.isset.php
    if (!isset($_GET['id'])) { show404(); }

    $result = $db->getProductInfo($_GET['id']);
    $item = $result->fetch_assoc();

    // Render the 404 page if we cannot find the
    // product in the database
    if (! $result->num_rows > 0) { show404(); }
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
            <button id="item-cart-button" onclick="addToCart()">Add To Cart</button>
            </div>
        </div>
    </div>

    <div class="item-content">
        <h2>Reviews</h2>
        <div>
            <h3>Review name</h3>
            <p>*****</p>
            <p>Review description Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dicta corporis hic veritatis quod sequi ullam velit. Hic adipisci mollitia expedita libero iusto ipsum, voluptate cupiditate et error delectus earum corporis.</p>
        </div>
    </div>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <!-- Site footer -->
    <?php include 'components/footer.inc.php' ?>
    
    <script>
        // Setup some JS constants using PHP
        const postUrl = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>";
        const productId = "<?php echo $_GET['id']?>";

        // Send a post request to the PHP backend to add the item to the basket
        async function addToCart() {
            const basketButton = document.getElementById("item-cart-button");

            // We emulate submitting a form using the `FormData` API. This ensures
            // PHP can natively interpret the data we send without any JSON parsing.
            let formData = new FormData();
            formData.append('action', 'cart');
            formData.append('productId', productId);

            const response = await fetch(postUrl, {
                method: "POST",
                body: formData
            })

            basketButton.innerHTML = "Added!";
            basketButton.className = "added";
        }
    </script>
</body>
</html>