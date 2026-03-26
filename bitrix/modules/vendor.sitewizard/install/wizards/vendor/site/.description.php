<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arWizardDescription = [
    'NAME' => 'Мастер разворачивания сайта (Vendor)',
    'DESCRIPTION' => 'Автоматическое создание структуры сайта, инфоблоков, демо-данных и мультирегиональности.',
    'VERSION' => '1.0.1',
    'START_TYPE' => 'WINDOW',
    'WIZARD_TYPE' => 'INSTALL',
    'STEPS' => [
        'Vendor\SiteWizard\Step\WelcomeStep',
        'Vendor\SiteWizard\Step\EnvironmentCheckStep',
        'Vendor\SiteWizard\Step\StructureChoiceStep',
        'Vendor\SiteWizard\Step\RegionalSettingsStep',
        'Vendor\SiteWizard\Step\InfrastructureBuildStep',
        'Vendor\SiteWizard\Step\FinishStep',
    ],
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
