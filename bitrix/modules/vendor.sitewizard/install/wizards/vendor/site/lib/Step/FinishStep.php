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
        WizardUi::printStyles();
        echo '<div class="vsw-card">';
        echo '<h2 class="vsw-title">Готово</h2>';
        echo '<p class="vsw-muted">Мастер успешно завершил разворачивание структуры сайта.</p>';
        echo '<p>Проверьте разделы: <code>/catalog/</code>, <code>/blog/</code>, <code>/news/</code>, <code>/personal/cart/</code>, <code>/personal/order/make/</code>, <code>/about/</code>, <code>/contacts/</code>.</p>';
        echo '</div>';
    }
}
