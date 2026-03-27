<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('Блог');
?>
<?php
$APPLICATION->IncludeComponent(
    'bitrix:news',
    '',
    [
        'IBLOCK_TYPE' => 'content',
        'IBLOCK_ID' => '#BLOG_IBLOCK_ID#',
        'SEF_MODE' => 'Y',
        'SEF_FOLDER' => '/blog/',
        'SEF_URL_TEMPLATES' => [
            'news' => '',
            'section' => '',
            'detail' => '#ELEMENT_CODE#/',
        ],
    ],
    false
);
?>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>
