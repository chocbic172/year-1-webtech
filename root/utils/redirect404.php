<?php

namespace Utils\Redirect404;

function redirect404() {
    // Redirect the user to a 404 page, as we cannot find a non-existent product
    // Redirect is done using the `redirect` header in the HTTP standard.
    // I don't massively like the fact that this is hardcoded, but it seems unavoidable.
    // Stack Overflow: https://stackoverflow.com/questions/768431/how-do-i-make-a-redirect-in-php
    header('Location: https://'.$_SERVER["HTTP_HOST"].'/~ehoward4/webtech1/404.php');
}