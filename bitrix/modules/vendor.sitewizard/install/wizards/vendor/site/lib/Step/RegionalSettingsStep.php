<?php

namespace Vendor\SiteWizard\Step;

class RegionalSettingsStep extends \CWizardStep
{
    public function InitStep(): void
    {
        $this->SetStepID('regional_settings_step');
        $this->SetTitle('Региональность и домены');
        $this->SetPrevStep('structure_choice_step');
        $this->SetNextStep('infrastructure_build_step');
    }

    public function ShowStep(): void
    {
        $wizard = $this->GetWizard();

        $domains = (array) $wizard->GetVar('DOMAINS', ['site.ru', 'spb.site.ru', 'msk.site.ru']);
        $language = (string) $wizard->GetVar('LANGUAGE_ID', 'ru');
        $currency = (string) $wizard->GetVar('CURRENCY', 'RUB');

        for ($i = 0; $i < 3; $i++) {
            $value = isset($domains[$i]) ? (string) $domains[$i] : '';
            echo 'Домен ' . ($i + 1) . ': <input type="text" name="DOMAINS[]" value="' . htmlspecialcharsbx($value) . '"><br>';
        }

        echo '<br>Язык: <select name="LANGUAGE_ID">';
        echo '<option value="ru"' . ($language === 'ru' ? ' selected' : '') . '>ru</option>';
        echo '<option value="en"' . ($language === 'en' ? ' selected' : '') . '>en</option>';
        echo '</select><br><br>';

        echo 'Валюта: <select name="CURRENCY">';
        foreach (['RUB', 'USD', 'EUR'] as $code) {
            echo '<option value="' . $code . '"' . ($currency === $code ? ' selected' : '') . '>' . $code . '</option>';
        }
        echo '</select>';
    }
}
