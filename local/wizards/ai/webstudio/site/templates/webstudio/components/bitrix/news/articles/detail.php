<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); } ?>
<section class="section">
<div class="container article-detail">
<?php $APPLICATION->IncludeComponent('bitrix:news.detail', '', [
    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'], 'IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
    'CHECK_DATES' => 'Y', 'CACHE_TYPE' => $arParams['CACHE_TYPE'], 'CACHE_TIME' => $arParams['CACHE_TIME'], 'PROPERTY_CODE' => $arParams['DETAIL_PROPERTY_CODE'],
    'SET_TITLE' => 'Y', 'SET_BROWSER_TITLE' => 'Y', 'SET_META_DESCRIPTION' => 'Y', 'SET_CANONICAL_URL' => 'Y',
], $component); ?>
</div>
</section>
<section class="section"><div class="container"><h2>Похожие статьи</h2></div>
<?php $APPLICATION->IncludeComponent('bitrix:news.list', 'home_articles', [
    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'], 'IBLOCK_ID' => $arParams['IBLOCK_ID'], 'NEWS_COUNT' => 3,
    'SORT_BY1' => 'RAND', 'SORT_ORDER1' => 'ASC', 'CACHE_TYPE' => $arParams['CACHE_TYPE'], 'CACHE_TIME' => $arParams['CACHE_TIME'],
    'PROPERTY_CODE' => ['TAGS'], 'DETAIL_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['detail'], 'SET_TITLE' => 'N',
], $component); ?>
</section>
