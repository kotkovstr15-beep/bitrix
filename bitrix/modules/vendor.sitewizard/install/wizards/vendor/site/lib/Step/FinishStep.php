<?php

namespace Vendor\SiteWizard\Step;

class FinishStep extends \CWizardStep
{
    public function InitStep(): void
    {
        $this->SetStepID('finish_step');
        $this->SetTitle('Установка завершена');
    }

    public function ShowStep(): void
    {
        echo '<p>Мастер успешно завершил разворачивание структуры сайта.</p>';
        echo '<p>Проверьте публичные разделы: /catalog/, /blog/, /news/, /personal/cart/, /personal/order/make/, /about/, /contacts/.</p>';
    }
}
