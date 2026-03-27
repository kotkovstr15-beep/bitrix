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

        $rawValue = $_POST['SITE_CODE'] ?? $_REQUEST['SITE_CODE'] ?? $wizard->GetVar('SITE_CODE', 's1');
        if (is_array($rawValue)) {
            $rawValue = (string) reset($rawValue);
        }

        $siteCode = trim((string) $rawValue);
        $siteCode = preg_replace('/[^a-z0-9_]/i', '', $siteCode) ?: '';
        $siteCode = strtolower($siteCode);

        if ($siteCode === '') {
            $siteCode = 's1';
        }

        if (!preg_match('/^[a-z]/', $siteCode)) {
            $siteCode = 's' . $siteCode;
        }

        $siteCode = mb_substr($siteCode, 0, 20);

        $wizard->SetVar('SITE_CODE', $siteCode);
        $wizard->SetVar('SITE_TYPE', 'all_in_one');

        parent::OnPostForm();
        return true;
    }
}
