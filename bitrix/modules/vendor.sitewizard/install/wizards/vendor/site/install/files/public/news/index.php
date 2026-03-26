<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('Новости');
?>
<?php
$APPLICATION->IncludeComponent(
    'bitrix:news',
    '',
    [
        'IBLOCK_TYPE' => 'content',
        'IBLOCK_ID' => '#NEWS_IBLOCK_ID#',
        'SEF_MODE' => 'Y',
        'SEF_FOLDER' => '/news/',
        'SEF_URL_TEMPLATES' => [
            'news' => '',
            'section' => '',
            'detail' => '#ELEMENT_CODE#/',
        ],
        'USE_RSS' => 'Y',
    ],
    false
);
?>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>
