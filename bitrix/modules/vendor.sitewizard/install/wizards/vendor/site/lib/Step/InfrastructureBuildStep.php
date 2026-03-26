<?php

namespace Vendor\SiteWizard\Step;

use Vendor\SiteWizard\Service\InfrastructureBuilder;

class InfrastructureBuildStep extends \CWizardStep
{
    public function InitStep(): void
    {
        $this->SetStepID('infrastructure_build_step');
        $this->SetTitle('Создание инфраструктуры');
        $this->SetPrevStep('regional_settings_step');
        $this->SetNextStep('finish_step');
    }

    public function ShowStep(): void
    {
        echo '<p>На этом шаге будут созданы сайты/домены, инфоблоки, страницы, меню, демо-данные и настройки ЧПУ.</p>';
    }

    public function OnPostForm(): bool
    {
        $wizard = $this->GetWizard();
        $builder = new InfrastructureBuilder($wizard);

        $result = $builder->build();
        if (!$result->isSuccess()) {
            $this->SetError(implode('<br>', $result->getErrorMessages()));
            return false;
        }

        return parent::OnPostForm();
    }
}
