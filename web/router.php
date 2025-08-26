<?php
// web/router.php — router for PHP built-in server
if (PHP_SAPI === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $path;
    if (is_file($file)) {
        return false; // serve static files directly
    }
}
// Symfony 3.4 front controller is app.php. If your project uses index.php, this falls back.
if (file_exists(__DIR__ . '/app.php')) {
    require __DIR__ . '/app.php';
} else {
    require __DIR__ . '/index.php';
}
