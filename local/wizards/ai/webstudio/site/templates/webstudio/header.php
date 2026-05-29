<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
use Bitrix\Main\Page\Asset;
$asset = Asset::getInstance();
$asset->addCss(SITE_TEMPLATE_PATH . '/assets/css/style.css');
$asset->addJs(SITE_TEMPLATE_PATH . '/assets/js/app.js');
if (function_exists('ai_webstudio_apply_seo')) {
    ai_webstudio_apply_seo();
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="<?= LANG_CHARSET ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $APPLICATION->ShowHead(); ?>
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= htmlspecialcharsbx(COption::GetOptionString('main', 'site_name')) ?>">
    <title><?php $APPLICATION->ShowTitle(); ?></title>
</head>
<body>
<div id="panel"><?php $APPLICATION->ShowPanel(); ?></div>
<header class="site-header">
    <div class="container header-grid">
        <a class="logo" href="/" aria-label="На главную"><span>BX</span>Studio</a>
        <nav class="main-nav" aria-label="Главное меню"><?php $APPLICATION->IncludeComponent('bitrix:menu', 'top', ['ROOT_MENU_TYPE' => 'top', 'MAX_LEVEL' => '1', 'CHILD_MENU_TYPE' => 'left', 'USE_EXT' => 'N', 'MENU_CACHE_TYPE' => 'A', 'MENU_CACHE_TIME' => '36000000'], false); ?></nav>
        <button class="theme-toggle" type="button" data-theme-toggle aria-label="Переключить тему">◐</button>
    </div>
</header>
<main>
