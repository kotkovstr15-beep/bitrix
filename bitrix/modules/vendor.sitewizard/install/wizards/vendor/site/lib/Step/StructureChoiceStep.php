<?php

namespace Vendor\SiteWizard\Step;

class StructureChoiceStep extends \CWizardStep
{
    public function InitStep(): void
    {
        $this->SetStepID('structure_choice_step');
        $this->SetTitle('Структура сайта');
        $this->SetPrevStep('environment_check_step');
        $this->SetNextStep('regional_settings_step');
    }

    public function ShowStep(): void
    {
        WizardUi::printStyles();

        $wizard = $this->GetWizard();
        $siteCode = (string) $wizard->GetVar('SITE_CODE', 's1');

        echo '<div class="vsw-card">';
        echo '<h2 class="vsw-title">Единый сценарий установки</h2>';
        echo '<p class="vsw-muted">Мастер развернет один сайт, в котором сразу будут: каталог, корзина, блог и новости.</p>';
        echo '<div class="vsw-grid">';
        echo '<label>Код сайта (латиница, цифры, нижнее подчеркивание)<br><input class="vsw-input" type="text" name="SITE_CODE" value="' . htmlspecialcharsbx($siteCode) . '"></label>';
        echo '</div></div>';
    }

    public function OnPostForm(): bool
    {
        $wizard = $this->GetWizard();

        $requestCode = isset($_REQUEST['SITE_CODE']) ? trim((string) $_REQUEST['SITE_CODE']) : '';
        $siteCode = $requestCode !== '' ? $requestCode : trim((string) $wizard->GetVar('SITE_CODE', 's1'));

        if (!preg_match('/^[a-z][a-z0-9_]{0,19}$/i', $siteCode)) {
            $this->SetError('Код сайта должен начинаться с латинской буквы и содержать только латиницу/цифры/подчеркивание (пример: s1, site2, demo_site).');
            return false;
        }

        $wizard->SetVar('SITE_CODE', $siteCode);
        $wizard->SetVar('SITE_TYPE', 'all_in_one');

        parent::OnPostForm();
        return true;
    }
}
