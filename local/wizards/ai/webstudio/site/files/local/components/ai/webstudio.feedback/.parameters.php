<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); }
$arComponentParameters = [
    'PARAMETERS' => [
        'IBLOCK_ID' => ['PARENT' => 'BASE', 'NAME' => 'Инфоблок заявок', 'TYPE' => 'STRING'],
        'EMAIL_TO' => ['PARENT' => 'BASE', 'NAME' => 'Email получателя', 'TYPE' => 'STRING'],
        'CACHE_TIME' => ['DEFAULT' => 0],
    ],
];
