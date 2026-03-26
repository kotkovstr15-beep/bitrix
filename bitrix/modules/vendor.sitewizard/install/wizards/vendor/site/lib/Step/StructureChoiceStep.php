<?php

namespace Vendor\SiteWizard\Step;

class StructureChoiceStep extends \CWizardStep
{
    public function InitStep(): void
    {
        $this->SetStepID('structure_choice_step');
        $this->SetTitle('Выбор структуры');
        $this->SetPrevStep('environment_check_step');
        $this->SetNextStep('regional_settings_step');
    }

    public function ShowStep(): void
    {
        $wizard = $this->GetWizard();
        $type = (string) $wizard->GetVar('SITE_TYPE', 'shop');
        $siteCode = (string) $wizard->GetVar('SITE_CODE', 's1');

        echo '<label><input type="radio" name="SITE_TYPE" value="shop" ' . ($type === 'shop' ? 'checked' : '') . '> Сайт с каталогом и корзиной</label><br>';
        echo '<label><input type="radio" name="SITE_TYPE" value="content" ' . ($type === 'content' ? 'checked' : '') . '> Сайт с блогом и новостями</label><br><br>';
        echo 'Символьный код сайта: <input type="text" name="SITE_CODE" value="' . htmlspecialcharsbx($siteCode) . '">';
    }

    public function OnPostForm(): bool
    {
        $wizard = $this->GetWizard();
        $siteCode = trim((string) $wizard->GetVar('SITE_CODE'));

        if ($siteCode === '' || !preg_match('/^[a-z][a-z0-9_]{1,8}$/i', $siteCode)) {
            $this->SetError('Код сайта должен начинаться с буквы и содержать только буквы/цифры/подчеркивание.');
            return false;
        }

        return parent::OnPostForm();
    }
}
