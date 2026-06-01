<?php
/**
 * Adds visual icons to service items before template rendering.
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$icons = ['💻', '🛒', '⚙️', '🚀', '🔒', '📈'];

foreach ($arResult['ITEMS'] as $index => &$item) {
    $propertyIcon = $item['PROPERTIES']['ICON']['VALUE'] ?? '';
    $item['ICON'] = $propertyIcon !== '' ? $propertyIcon : $icons[$index % count($icons)];
}
unset($item);
