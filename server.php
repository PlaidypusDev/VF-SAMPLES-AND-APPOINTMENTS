<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// If the URL is /public/... redirect to the same path without /public
if (preg_match('#^/public/(.*)$#', $uri, $m)) {
    header('Location: /' . $m[1], true, 301);
    exit;
}

// If a real static file exists under public/, let the built-in server serve it
$publicPath = __DIR__ . '/public' . $uri;
if (is_file($publicPath)) {
    return false; // tells PHP's dev server to serve the static file from docroot
}

// Otherwise, bootstrap Laravel
require __DIR__ . '/public/index.php';
