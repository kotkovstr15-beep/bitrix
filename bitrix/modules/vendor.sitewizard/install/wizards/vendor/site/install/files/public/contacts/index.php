<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('Контакты');
?>
<h1>Контакты</h1>
<p>Телефон: +7 (800) 000-00-00</p>
<p>Email: info@example.ru</p>
<?php
$APPLICATION->IncludeComponent(
    'bitrix:map.yandex.view',
    '.default',
    [
        'API_KEY' => '',
        'CONTROLS' => ['ZOOM', 'SMALLZOOM', 'TYPECONTROL'],
        'INIT_MAP_TYPE' => 'MAP',
        'MAP_DATA' => serialize([
            'yandex_lat' => '55.76',
            'yandex_lon' => '37.64',
            'yandex_scale' => 10,
            'PLACEMARKS' => [
                ['LON' => '37.64', 'LAT' => '55.76', 'TEXT' => 'Наш офис'],
            ],
        ]),
        'MAP_HEIGHT' => '400',
        'MAP_WIDTH' => '100%',
        'OPTIONS' => ['ENABLE_SCROLL_ZOOM', 'ENABLE_DBLCLICK_ZOOM', 'ENABLE_DRAGGING'],
    ],
    false
);
?>
<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>
