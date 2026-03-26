<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

CModule::IncludeModule('main');
require_once __DIR__ . '/scripts/init.php';

/** @var CWizard $wizard */
$wizard = $this;

$wizard->AddStep(new \Vendor\SiteWizard\Step\WelcomeStep());
$wizard->AddStep(new \Vendor\SiteWizard\Step\EnvironmentCheckStep());
$wizard->AddStep(new \Vendor\SiteWizard\Step\StructureChoiceStep());
$wizard->AddStep(new \Vendor\SiteWizard\Step\RegionalSettingsStep());
$wizard->AddStep(new \Vendor\SiteWizard\Step\InfrastructureBuildStep());
$wizard->AddStep(new \Vendor\SiteWizard\Step\FinishStep());
