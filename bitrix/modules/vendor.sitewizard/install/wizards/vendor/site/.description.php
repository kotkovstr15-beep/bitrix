<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arWizardDescription = [
    'NAME' => 'Мастер разворачивания сайта (Vendor)',
    'DESCRIPTION' => 'Автоматическое создание структуры сайта, инфоблоков, демо-данных и мультирегиональности.',
    'VERSION' => '1.0.0',
    'START_TYPE' => 'WINDOW',
    'TEMPLATES' => [
        '.default' => [
            'SCRIPT' => '',
            'CLASS' => '',
            'COLOR' => '',
            'NAME' => 'Базовый шаблон',
            'DESCRIPTION' => 'Стандартный шаблон мастера',
        ],
    ],
];
