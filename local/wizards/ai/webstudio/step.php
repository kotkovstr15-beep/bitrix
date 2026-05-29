<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SiteTable;

final class AiWebStudioSelectSiteStep extends CWizardStep
{
    public function initStep(): void
    {
        $this->SetStepID('select_site');
        $this->SetTitle('Параметры сайта');
        $this->SetNextStep('install');
        $this->SetCancelStep('cancel');
        $this->SetNextCaption('Установить');
    }

    public function showStep(): void
    {
        $wizard = $this->GetWizard();
        $sites = [];

        if (class_exists(SiteTable::class)) {
            $result = SiteTable::getList([
                'select' => ['LID', 'NAME'],
                'order' => ['DEF' => 'DESC', 'SORT' => 'ASC'],
            ]);
            while ($site = $result->fetch()) {
                $sites[$site['LID']] = '[' . $site['LID'] . '] ' . $site['NAME'];
            }
        }

        if ($sites === []) {
            $defaultSiteId = defined('SITE_ID') ? SITE_ID : 's1';
            $sites = [$defaultSiteId => $defaultSiteId];
        }

        $this->content .= '<p>Мастер создаст инфоблоки, демо-данные, публичные разделы, меню, шаблон сайта и компонент формы обратной связи.</p>';
        $this->content .= '<table class="wizard-data-table">';
        $this->content .= '<tr><th align="right">Сайт</th><td>' . $this->ShowSelectField('siteID', $sites) . '</td></tr>';
        $this->content .= '<tr><th align="right">Название</th><td>' . $this->ShowInputField('text', 'siteName', ['size' => 45]) . '</td></tr>';
        $this->content .= '<tr><th align="right">Email</th><td>' . $this->ShowInputField('text', 'siteEmail', ['size' => 45]) . '</td></tr>';
        $this->content .= '<tr><th align="right">Телефон</th><td>' . $this->ShowInputField('text', 'sitePhone', ['size' => 45]) . '</td></tr>';
        $this->content .= '<tr><th align="right">Демо-данные</th><td>' . $this->ShowCheckboxField('installDemoData', 'Y', ['id' => 'installDemoData']) . ' <label for="installDemoData">создать</label></td></tr>';
        $this->content .= '<tr><th align="right">Публичные файлы</th><td>' . $this->ShowCheckboxField('rewritePublic', 'Y', ['id' => 'rewritePublic']) . ' <label for="rewritePublic">перезаписывать существующие файлы</label></td></tr>';
        $this->content .= '</table>';
    }
}

final class AiWebStudioInstallStep extends CWizardStep
{
    public function initStep(): void
    {
        $this->SetStepID('install');
        $this->SetTitle('Установка решения');
        $this->SetNextStep('finish');
        $this->SetCancelStep('cancel');
        $this->SetNextCaption('Готово');
    }

    public function showStep(): void
    {
        $wizard = $this->GetWizard();
        $wizard->InstallServices();
        $this->content .= '<p><b>Сайт установлен.</b></p><p>Инфоблоки, демо-данные, шаблон, меню и публичные страницы созданы.</p>';
    }
}

final class AiWebStudioFinishStep extends CWizardStep
{
    public function initStep(): void
    {
        $this->SetStepID('finish');
        $this->SetTitle('Установка завершена');
        $this->SetCancelStep('finish');
        $this->SetCancelCaption('Закрыть');
    }

    public function showStep(): void
    {
        $siteId = htmlspecialcharsbx((string)$this->GetWizard()->GetVar('siteID'));
        $this->content .= '<p>Готово. Откройте публичную часть сайта и проверьте разделы:</p>';
        $this->content .= '<ul><li>/</li><li>/about/</li><li>/services/</li><li>/articles/</li><li>/contacts/</li></ul>';
        $this->content .= '<p>Контент управляется через инфоблоки типа <b>ai_webstudio_' . $siteId . '</b>.</p>';
    }
}
