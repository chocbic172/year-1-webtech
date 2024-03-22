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
        $product = $_POST["product-id"];
        $title = $_POST["review-title"];
        $description = $_POST["review-description"];
    
        // Convert the rating to an `integer` so we can check that it's valid
        // PHP Docs: https://www.php.net/manual/en/function.intval.php
        $rating = intval($_POST["stars"]);
    
        $db->createReview($product, $title, $description, $rating);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST['action'] == "cart") {
            addProductToCart($_POST['productId']);
            echo $_SESSION['cart'];

            // Do not render any HTML for a javascript post request
            exit();
        }

        if ($_POST['action'] == "review") {
            createReview($db);
        }
    }

    // Check if the required url parameters exist with `isset()`.
    // PHP Docs: https://www.php.net/manual/en/function.isset.php
    if (!isset($_GET['id'])) { show404(); }

    $productId = $_GET['id'];

    $result = $db->getProductInfo($productId);
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
                echo '<p id="item-rating">'.str_repeat('⭐', 4).'</p>';
                echo '<p id="item-price">£'.$item['product_price'].'</p>';
                echo '<p id="item-desc">'.$item['product_desc'].'</p>';
            ?>
            <button id="item-cart-button" onclick="addToCart()">Add To Cart</button>
            </div>
        </div>
    </div>

    <div id="item-content">
        <div class="row item-content-container">
            <div class="col-40">
                <?php if(!isset($_SESSION['user'])) { echo "<h3>Please <a href='login.php'>sign in</a> to leave a review!</h3>"; } ?>
                <div class="<?php if (!isset($_SESSION['user'])) { echo "blurred"; } ?>">
                    <h3>Write a Review</h3>
                    <!--
                    We use the `$_SERVER["PHP_SELF"]` superglobal to ensure the form is always submitted to this page.
                    However, to avoid XSS exploits we wrap this in `htmlspecialcars()`, which automatically "escapes"
                    all html characters. See W3 Schools for reference implementation:
                    https://www.w3schools.com/php/php_form_validation.asp
                    -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'?id='.$productId ?>" method="post">
                        <input type="hidden" name="action" value="review">
                        <input type="hidden" name="product-id" value="<?php echo $productId ?>">
    
                        <label for="review-title" class="form-label">Review Title</label><br>
                        <input type="text" name="review-title" id="review-title" class="text-field"><br>
    
                        <label for="review-description" class="form-label">Review Description</label><br>
                        <textarea name="review-description" id="review-description" rows="5" class="text-field"></textarea><br>
    
                        <p class="form-label">Choose a rating</p>
                        <label for="stars">⭐</label>
                        <input type="radio" name="stars" id="1-star" value="1"><br>
                        <label for="stars">⭐⭐</label>
                        <input type="radio" name="stars" id="2-star" value="2"><br>
                        <label for="stars">⭐⭐⭐</label>
                        <input type="radio" name="stars" id="3-star" value="3"><br>
                        <label for="stars">⭐⭐⭐⭐</label>
                        <input type="radio" name="stars" id="4-star" value="4"><br>
                        <label for="stars">⭐⭐⭐⭐⭐</label>
                        <input type="radio" name="stars" id="5-star" value="5"><br>
    
                        <br>
    
                        <input type="submit" value="Post Review" class="form-submit">
                    </form>
                </div>
            </div>
            <div class="col-60">
                <h2>Product Reviews</h2>
                <hr>
                <?php
                $reviews = $db->getReviewsForProduct($productId);

                if ($reviews->num_rows > 0) {
                    while($review = $reviews->fetch_assoc()) {
                        echo '
                        <div>
                            <h4>'.$review['review_title'].'</h4>
                            <p>
                                <span>'.str_repeat('⭐', intval($review['review_rating'])).'</span> 
                                - Posted by '.$db->getUserFullName($review['user_id']).'
                            </p>
                            <p>'.$review['review_desc'].'</p>
                        </div>
                        <hr>
                        ';
                    }
                } else {
                    echo '<p>No reviews found for this product. Why don\'t you leave one using the form to the left?</p>';
                }
                ?>
            </div>
        </div>
    </div>

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