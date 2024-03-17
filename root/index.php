<?php
session_start();

require("utils/database.php");

use Utils\Database\DBConnection as Database;

$db = new Database();

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
    <link rel="stylesheet" href="styles/index.css">
</head>
<body>
    <!-- Navigation Bar -->
    <?php include 'components/navbar.inc.php' ?>

    <!-- Introduction (landing) Section -->
    <div class="intro-section row">
        <div class="col-40 flex-content-center">
            <div class="intro-card">
                <h2>
                    Welcome to the UCLan Student Shop
                    <?php
                    if (isset($_SESSION['user'])) {
                        echo $db->getUserFullName($_SESSION['user']);
                    }
                    ?>
                </h2>
                <p>To buy some clothes or simply browse the selection, press the button below.</p>
                <button onclick="location.href = './products.php';">See Products</button>
            </div>
        </div>

        <div class="col-60 flex-content-center">
            <video class="intro-video" src="./assets/video/video.mp4" muted autoplay loop></video>
        </div>
    </div>

    <!-- Extra information section -->
    <div class="info-section">
        <h2>Welcome to the UCLan Student Union Shop!</h2>
        <h3>Have a look at the video below for information about UCLan, or go to our <br> <a href="./products.php">products page</a> and see the entire product selection!</h3>
        <div>
            <iframe src="https://www.youtube.com/embed/iTBQHj7L2-8"></iframe>
        </div>
    </div>

    <!-- Site footer -->
    <?php include 'components/footer.inc.php' ?>
</body>
</html>