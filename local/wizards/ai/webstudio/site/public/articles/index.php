<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
$config = include $_SERVER['DOCUMENT_ROOT'] . '/.webstudio_iblocks.php';
$APPLICATION->IncludeComponent('bitrix:news', 'articles', [
    'IBLOCK_TYPE' => $config['IBLOCK_TYPE'], 'IBLOCK_ID' => $config['ARTICLES_IBLOCK_ID'],
    'SEF_MODE' => 'Y', 'SEF_FOLDER' => '/articles/', 'SEF_URL_TEMPLATES' => ['news' => '', 'section' => '', 'detail' => '#ELEMENT_CODE#/'],
    'NEWS_COUNT' => 9, 'SORT_BY1' => 'DATE_ACTIVE_FROM', 'SORT_ORDER1' => 'DESC', 'CACHE_TYPE' => 'A', 'CACHE_TIME' => 36000000,
    'PROPERTY_CODE' => ['TAGS', 'RELATED'], 'DETAIL_PROPERTY_CODE' => ['TAGS', 'RELATED'], 'SET_TITLE' => 'Y', 'ADD_SECTIONS_CHAIN' => 'N',
    'USE_SEARCH' => 'N', 'USE_RSS' => 'N', 'USE_RATING' => 'N', 'USE_CATEGORIES' => 'N', 'USE_REVIEW' => 'N', 'USE_FILTER' => 'N',
], false);
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
