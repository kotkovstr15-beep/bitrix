<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

spl_autoload_register(static function (string $className): void {
    $prefix = 'Vendor\\SiteWizard\\';
    if (mb_strpos($className, $prefix) !== 0) {
        return;
    }

    $relative = mb_substr($className, mb_strlen($prefix));
    $relativePath = str_replace('\\', '/', $relative) . '.php';
    $fullPath = __DIR__ . '/../lib/' . $relativePath;

    if (is_file($fullPath)) {
        require_once $fullPath;
    }
});
