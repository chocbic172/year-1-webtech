<?php

/**
 * Generates HTML elements for the navigation bar page link
 *
 * @return string
 */
function _generateNavbarLinks() {
    $pages = [
        "index.php" => "Home",
        "products.php" => "Products",
        "cart.php" => "Basket",
    ];
    $generatedLinks = "";

    // The php inbuilt `explode` and `end` functions are used
    // to extrapolate which script is requesting the navbar.
    // See php docs:
    // https://www.php.net/manual/en/function.explode.php
    // https://www.php.net/manual/en/function.end.php
    // https://www.php.net/manual/en/reserved.variables.server.php

    $currentPageFullPath = explode("/", $_SERVER['SCRIPT_NAME']);
    $currentPageScriptPath = end($currentPageFullPath);

    foreach ($pages as $pagePath => $pageName) {
        if ($currentPageScriptPath == $pagePath) {
            $generatedLinks .= '<a href="#" class="nav-link selected">'.$pageName.'</a>';
        } else {
            $generatedLinks .= '<a href="./'.$pagePath.'" class="nav-link">'.$pageName.'</a>';
        }
    }

    return $generatedLinks;
}

/**
 * Generates HTML elements for the navigation bar login link
 * 
 * Dynamically changed depending on the session login state.
 *
 * @return string
 */
function _generateNavbarLogin() {
    if (isset($_SESSION['user'])) {
        return '
        <a href="./signout.php">Sign Out</a>
        ';
    }

    return '
        <a href="./login.php">Login</a>
    ';
}

/**
 * Navbar HTML Definitions
 */
echo '
<div class="navbar-clearfix"></div>

<div class="navbar">
    <!-- Navigation logo -->
    <div class="navbar-col hidden-sm">
        <p class="nav-logo"><a href="./index.php">UCLan Student Shop</a></p>
    </div>

    <!-- Main navigation section, with links -->
    <div class="navbar-col nav-section-main">
        <div class="navigation-list">
            '._generateNavbarLinks().'
        </div>
    </div>

    <!-- Spacer -->
    <div class="navbar-col hidden-sm">
        <div class="nav-login">
            '._generateNavbarLogin().'
        </div>
    </div>
</div>
';
