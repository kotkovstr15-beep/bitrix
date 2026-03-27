<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

CModule::IncludeModule('main');
require_once __DIR__ . '/scripts/init.php';

// Совместимость с разными версиями ядра:
// - если доступно динамическое добавление шагов через AddStep, регистрируем шаги здесь;
// - если нет (мастеры сайта в некоторых сборках), шаги берутся из .description.php (ключ STEPS).
if (method_exists($this, 'AddStep')) {
    /** @var CWizardBase $wizard */
    $wizard = $this;

    $wizard->AddStep(new \Vendor\SiteWizard\Step\WelcomeStep());
    $wizard->AddStep(new \Vendor\SiteWizard\Step\EnvironmentCheckStep());
    $wizard->AddStep(new \Vendor\SiteWizard\Step\StructureChoiceStep());
    $wizard->AddStep(new \Vendor\SiteWizard\Step\RegionalSettingsStep());
    $wizard->AddStep(new \Vendor\SiteWizard\Step\InfrastructureBuildStep());
    $wizard->AddStep(new \Vendor\SiteWizard\Step\FinishStep());
}
