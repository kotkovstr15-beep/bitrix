<?php

namespace Vendor\SiteWizard\Step;

use Vendor\SiteWizard\Service\EnvironmentChecker;

class EnvironmentCheckStep extends \CWizardStep
{
    public function InitStep(): void
    {
        $this->SetStepID('environment_check_step');
        $this->SetTitle('Проверка окружения');
        $this->SetPrevStep('welcome_step');
        $this->SetNextStep('structure_choice_step');
    }

    public function ShowStep(): void
    {
        WizardUi::printStyles();

        $checker = new EnvironmentChecker();
        $report = $checker->check();

        echo '<div class="vsw-card"><h2 class="vsw-title">Проверка окружения</h2><ul class="vsw-checklist">';
        foreach ($report as $item) {
            $statusClass = $item['ok'] ? 'vsw-ok' : 'vsw-bad';
            $statusText = $item['ok'] ? 'OK' : 'ERROR';
            echo sprintf('<li><span class="%s">[%s]</span> %s</li>', $statusClass, $statusText, htmlspecialcharsbx($item['message']));
        }
        echo '</ul></div>';
    }

    public function OnPostForm(): bool
    {
        $checker = new EnvironmentChecker();
        if (!$checker->isValid()) {
            $this->SetError('Проверка окружения не пройдена. Исправьте ошибки и повторите попытку.');
            return false;
        }

        parent::OnPostForm();
        return true;
    }
}
