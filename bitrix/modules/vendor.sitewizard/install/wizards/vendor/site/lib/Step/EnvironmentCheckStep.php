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
        $checker = new EnvironmentChecker();
        $report = $checker->check();

        echo '<ul>';
        foreach ($report as $item) {
            $status = $item['ok'] ? '✅' : '❌';
            echo sprintf('<li>%s %s</li>', $status, htmlspecialcharsbx($item['message']));
        }
        echo '</ul>';
    }

    public function OnPostForm(): bool
    {
        $checker = new EnvironmentChecker();
        if (!$checker->isValid()) {
            $this->SetError('Проверка окружения не пройдена. Исправьте ошибки и повторите попытку.');
            return false;
        }

        return parent::OnPostForm();
    }
}
