<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('Корзина');
?>
<?php
$APPLICATION->IncludeComponent(
    'bitrix:sale.basket.basket',
    '',
    [
        'ACTION_VARIABLE' => 'basketAction',
        'AUTO_CALCULATION' => 'Y',
    ],
    false
);
?>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>
