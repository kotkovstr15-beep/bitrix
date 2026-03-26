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
        WizardUi::printStyles();
        echo '<div class="vsw-card">';
        echo '<h2 class="vsw-title">Vendor Site Wizard</h2>';
        echo '<p class="vsw-muted">Мастер создаст базовую структуру сайта, инфоблоки, демо-данные и региональные настройки.</p>';
        echo '</div>';
    }
}
