<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('Оформление заказа');
?>
<?php
$APPLICATION->IncludeComponent(
    'bitrix:sale.order.ajax',
    '',
    [
        'PATH_TO_BASKET' => '/personal/cart/',
        'PATH_TO_PAYMENT' => '/personal/order/payment/',
        'PATH_TO_PERSONAL' => '/personal/',
        'SET_TITLE' => 'Y',
    ],
    false
);
?>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>
