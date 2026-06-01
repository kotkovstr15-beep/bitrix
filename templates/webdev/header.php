<?php
/**
 * Header template for WEBDEV site template.
 * Подключает метаданные, ассеты, панель Битрикс, логотип и главное меню.
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

Loc::loadMessages(__FILE__);

$asset = Asset::getInstance();
$asset->addCss(SITE_TEMPLATE_PATH . '/styles.css');
$asset->addCss(SITE_TEMPLATE_PATH . '/assets/css/main.css');
$asset->addJs(SITE_TEMPLATE_PATH . '/script.js');
$asset->addJs(SITE_TEMPLATE_PATH . '/assets/js/main.js');
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $APPLICATION->ShowHead(); ?>
    <title><?php $APPLICATION->ShowTitle(); ?></title>
</head>
<body>
<?php $APPLICATION->ShowPanel(); ?>
<div class="site" id="top">
    <header class="site-header">
        <div class="container site-header__inner">
            <!-- Текстовый логотип сайта -->
            <a class="logo" href="/" aria-label="WEBDEV — <?= Loc::getMessage('WEBDEV_MENU_HOME') ?>">WEBDEV</a>

            <!-- Бургер-меню для мобильных устройств -->
            <button class="burger" type="button" aria-label="Открыть меню" aria-controls="main-menu" aria-expanded="false">
                <span class="burger__line"></span>
                <span class="burger__line"></span>
                <span class="burger__line"></span>
            </button>

            <!-- Главное меню: сначала пробуем кастомный ShowMenu, затем штатный компонент bitrix:menu -->
            <nav class="main-nav" id="main-menu" aria-label="Главное меню">
                <?php
                if (method_exists($APPLICATION, 'ShowMenu')) {
                    $APPLICATION->ShowMenu('top', [
                        'containerClass' => 'main-nav__list',
                        'itemClass' => 'main-nav__item',
                        'linkClass' => 'main-nav__link',
                    ]);
                } else {
                    $APPLICATION->IncludeComponent(
                        'bitrix:menu',
                        '',
                        [
                            'ROOT_MENU_TYPE' => 'top',
                            'MAX_LEVEL' => '1',
                            'CHILD_MENU_TYPE' => 'left',
                            'USE_EXT' => 'N',
                            'DELAY' => 'N',
                            'ALLOW_MULTI_SELECT' => 'N',
                            'MENU_CACHE_TYPE' => 'A',
                            'MENU_CACHE_TIME' => '3600',
                            'MENU_CACHE_USE_GROUPS' => 'Y',
                            'MENU_CACHE_GET_VARS' => [],
                        ],
                        false,
                        ['HIDE_ICONS' => 'Y']
                    );
                }
                ?>
            </nav>
        </div>
    </header>

    <main class="site-main">
        <section class="page-hero">
            <div class="container">
                <h1 class="page-title"><?php $APPLICATION->ShowTitle(false); ?></h1>
            </div>
        </section>
