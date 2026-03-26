<?php

namespace Vendor\SiteWizard\Step;

class WelcomeStep extends \CWizardStep
{
    public function InitStep(): void
    {
        $this->SetStepID('welcome_step');
        $this->SetTitle('Добро пожаловать в мастер установки');
        $this->SetNextStep('environment_check_step');
    }

    public function ShowStep(): void
    {
        echo '<p>Мастер создаст структуру сайта, инфоблоки, демо-данные, страницы каталога и региональные настройки.</p>';
    }
}
