<?php

namespace Utils\Redirect404;

/**
 * Redirect the user to a 404 page.
 * Must be called before HTML code begins.
 */
function redirect404() {
    // Redirection is acheived using the HTTP `redirect` header.
    // Stack Overflow: https://stackoverflow.com/questions/768431/how-do-i-make-a-redirect-in-php

    // TODO: remove hardcoded `https://` and `~ehoward4...` string sections
    header('Location: https://'.$_SERVER["HTTP_HOST"].'/~ehoward4/webtech1/404.php');
}