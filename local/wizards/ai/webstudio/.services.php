<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arServices = [
    'options' => [
        'NAME' => 'Настройки сайта',
        'STAGES' => [
            'options' => 'index.php',
        ],
    ],
    'iblocks' => [
        'NAME' => 'Инфоблоки и демонстрационные данные',
        'STAGES' => [
            'iblocks' => 'index.php',
        ],
    ],
    'files' => [
        'NAME' => 'Шаблон, страницы, меню и компоненты',
        'STAGES' => [
            'files' => 'index.php',
        ],
    ],
];
