<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
$APPLICATION->SetTitle('Услуги');
$config = include $_SERVER['DOCUMENT_ROOT'] . '/.webstudio_iblocks.php';
?>
<section class="section page-hero"><div class="container"><p class="eyebrow">Услуги</p><h1>Разработка, поддержка и развитие сайтов</h1><p>Все услуги управляются через инфоблок «Услуги».</p></div></section>
<section class="section"><?php $APPLICATION->IncludeComponent('bitrix:news.list', 'home_services', ['IBLOCK_TYPE' => $config['IBLOCK_TYPE'], 'IBLOCK_ID' => $config['SERVICES_IBLOCK_ID'], 'NEWS_COUNT' => 50, 'SORT_BY1' => 'SORT', 'SORT_ORDER1' => 'ASC', 'CACHE_TYPE' => 'A', 'CACHE_TIME' => 36000000, 'PROPERTY_CODE' => ['ICON', 'PRICE', 'TERM'], 'SET_TITLE' => 'N'], false); ?></section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'; ?>
