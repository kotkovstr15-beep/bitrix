<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
$APPLICATION->SetTitle('О компании');
$config = include $_SERVER['DOCUMENT_ROOT'] . '/.webstudio_iblocks.php';
?>
<section class="section page-hero"><div class="container"><p class="eyebrow">Обо мне</p><h1>Экспертная разработка сайтов на Битрикс</h1><p>Помогаю компаниям запускать надежные цифровые продукты и развивать их после релиза.</p></div></section>
<section class="section"><div class="container content-card"><?php $APPLICATION->IncludeComponent('bitrix:news.list', 'settings', ['IBLOCK_TYPE' => $config['IBLOCK_TYPE'], 'IBLOCK_ID' => $config['SETTINGS_IBLOCK_ID'], 'NEWS_COUNT' => 20, 'CACHE_TYPE' => 'A', 'CACHE_TIME' => 36000000, 'PROPERTY_CODE' => ['KEY', 'VALUE'], 'SET_TITLE' => 'N'], false); ?></div></section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'; ?>
