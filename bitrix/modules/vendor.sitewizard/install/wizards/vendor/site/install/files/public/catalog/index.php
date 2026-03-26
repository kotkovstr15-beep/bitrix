<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('Каталог');
?>
<?php
$APPLICATION->IncludeComponent(
    'bitrix:catalog',
    '',
    [
        'IBLOCK_TYPE' => 'catalog',
        'IBLOCK_ID' => '#CATALOG_IBLOCK_ID#',
        'SEF_MODE' => 'Y',
        'SEF_FOLDER' => '/catalog/',
        'SEF_URL_TEMPLATES' => [
            'sections' => '',
            'section' => '#SECTION_CODE#/',
            'element' => '#SECTION_CODE#/#ELEMENT_CODE#/',
        ],
        'PAGE_ELEMENT_COUNT' => 5,
        'PRICE_CODE' => ['BASE'],
    ],
    false
);
?>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>
