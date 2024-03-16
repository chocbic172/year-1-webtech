<?php

namespace Utils\Show404;

/**
 * Displays a 404 not found error.
 * Must be called before HTML code begins.
 */
function show404() {
    // We render the contents of the 404 page then `exit()`
    // to stop the rest of the page rendering.
    include('404.php');
    exit();
}