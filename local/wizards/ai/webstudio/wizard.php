<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

require_once __DIR__ . '/step.php';

final class AiWebStudioWizard extends CWizard
{
    public function __construct()
    {
        parent::__construct();

        $this->wizardName = 'AI WebStudio';
        $this->wizardDescription = 'Автоматическая установка сайта веб-студии на стандартной архитектуре мастеров 1С-Битрикс.';
        $this->wizardVersion = '1.0.0';
        $this->SetDefaultVars([
            'siteID' => defined('SITE_ID') ? SITE_ID : 's1',
            'siteName' => 'Веб-студия Bitrix Expert',
            'siteEmail' => 'hello@example.com',
            'sitePhone' => '+7 (999) 123-45-67',
            'installDemoData' => 'Y',
            'rewritePublic' => 'Y',
        ]);

        $this->IncludeServiceLang('step.php');
        $this->AddStep(new AiWebStudioSelectSiteStep());
        $this->AddStep(new AiWebStudioInstallStep());
        $this->AddStep(new AiWebStudioFinishStep());
    }
}
