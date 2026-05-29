<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); } ?>
<section class="section page-hero"><div class="container"><p class="eyebrow">Блог</p><h1>Статьи о разработке на Битрикс</h1><p>Практические материалы, чек-листы и рекомендации.</p></div></section>
<section class="section">
<?php $APPLICATION->IncludeComponent('bitrix:news.list', 'home_articles', [
    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'], 'IBLOCK_ID' => $arParams['IBLOCK_ID'], 'NEWS_COUNT' => $arParams['NEWS_COUNT'],
    'SORT_BY1' => $arParams['SORT_BY1'], 'SORT_ORDER1' => $arParams['SORT_ORDER1'], 'CACHE_TYPE' => $arParams['CACHE_TYPE'], 'CACHE_TIME' => $arParams['CACHE_TIME'],
    'PROPERTY_CODE' => $arParams['PROPERTY_CODE'], 'DETAIL_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['detail'], 'SET_TITLE' => 'N',
], $component); ?>
</section>
