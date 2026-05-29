<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); }

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Mail\Event;
use Bitrix\Main\Web\Json;

final class AiWebstudioFeedbackComponent extends CBitrixComponent
{
    public function executeComponent(): void
    {
        $this->arResult = ['ERRORS' => [], 'SUCCESS' => false, 'VALUES' => []];
        $request = Application::getInstance()->getContext()->getRequest();

        if ($request->isPost() && (string)$request->getPost('WEBSTUDIO_FEEDBACK') === 'Y') {
            $this->handleRequest($request);
        }

        $this->includeComponentTemplate();
    }

    private function handleRequest(\Bitrix\Main\HttpRequest $request): void
    {
        if (!check_bitrix_sessid()) {
            $this->arResult['ERRORS'][] = 'Сессия истекла. Обновите страницу и повторите отправку.';
            return;
        }

        if (trim((string)$request->getPost('company_site')) !== '') {
            $this->arResult['SUCCESS'] = true;
            return;
        }

        $values = [
            'name' => trim((string)$request->getPost('name')),
            'phone' => trim((string)$request->getPost('phone')),
            'email' => trim((string)$request->getPost('email')),
            'message' => trim((string)$request->getPost('message')),
        ];
        $this->arResult['VALUES'] = $values;

        if ($values['name'] === '') { $this->arResult['ERRORS'][] = 'Укажите имя.'; }
        if ($values['phone'] === '' && $values['email'] === '') { $this->arResult['ERRORS'][] = 'Укажите телефон или email.'; }
        if ($values['email'] !== '' && !check_email($values['email'])) { $this->arResult['ERRORS'][] = 'Email указан некорректно.'; }
        if (mb_strlen($values['message']) < 10) { $this->arResult['ERRORS'][] = 'Сообщение должно быть не короче 10 символов.'; }
        if ($this->arResult['ERRORS'] !== []) { return; }

        if (!Loader::includeModule('iblock')) {
            $this->arResult['ERRORS'][] = 'Модуль iblock недоступен.';
            return;
        }

        $element = new CIBlockElement();
        $id = (int)$element->Add([
            'IBLOCK_ID' => (int)$this->arParams['IBLOCK_ID'],
            'ACTIVE' => 'N',
            'NAME' => 'Заявка от ' . $values['name'] . ' ' . date('d.m.Y H:i'),
            'PREVIEW_TEXT' => $values['message'],
            'PROPERTY_VALUES' => [
                'NAME_VALUE' => $values['name'],
                'PHONE' => $values['phone'],
                'EMAIL' => $values['email'],
                'MESSAGE' => ['VALUE' => ['TEXT' => $values['message'], 'TYPE' => 'text']],
                'IP' => (string)Application::getInstance()->getContext()->getServer()->get('REMOTE_ADDR'),
                'USER_AGENT' => mb_substr((string)Application::getInstance()->getContext()->getServer()->get('HTTP_USER_AGENT'), 0, 250),
            ],
        ]);

        if ($id <= 0) {
            $this->arResult['ERRORS'][] = 'Не удалось сохранить заявку. Попробуйте позже.';
            return;
        }

        Event::send([
            'EVENT_NAME' => 'FEEDBACK_FORM',
            'LID' => SITE_ID,
            'C_FIELDS' => [
                'AUTHOR' => $values['name'],
                'AUTHOR_EMAIL' => $values['email'],
                'PHONE' => $values['phone'],
                'TEXT' => $values['message'],
                'EMAIL_TO' => (string)$this->arParams['EMAIL_TO'],
            ],
        ]);

        $this->arResult['SUCCESS'] = true;
        $this->arResult['VALUES'] = [];
    }
}
