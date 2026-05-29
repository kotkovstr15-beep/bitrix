<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Main\Web\Uri;

if (!Loader::includeModule('iblock')) {
    throw new RuntimeException('Модуль iblock не установлен.');
}

$siteId = (string)$wizard->GetVar('siteID');
$typeId = 'ai_webstudio_' . strtolower($siteId);
$siteName = trim((string)$wizard->GetVar('siteName')) ?: 'Веб-студия Bitrix Expert';
$siteEmail = trim((string)$wizard->GetVar('siteEmail')) ?: 'hello@example.com';
$sitePhone = trim((string)$wizard->GetVar('sitePhone')) ?: '+7 (999) 123-45-67';
$installDemoData = (string)$wizard->GetVar('installDemoData') === 'Y';

if (!CIBlockType::GetByID($typeId)->Fetch()) {
    $iblockType = new CIBlockType();
    $result = $iblockType->Add([
        'ID' => $typeId,
        'SECTIONS' => 'Y',
        'IN_RSS' => 'N',
        'SORT' => 100,
        'LANG' => [
            'ru' => ['NAME' => 'AI WebStudio', 'SECTION_NAME' => 'Разделы', 'ELEMENT_NAME' => 'Элементы'],
            'en' => ['NAME' => 'AI WebStudio', 'SECTION_NAME' => 'Sections', 'ELEMENT_NAME' => 'Elements'],
        ],
    ]);
    if (!$result) {
        throw new RuntimeException('Не удалось создать тип инфоблока: ' . $iblockType->LAST_ERROR);
    }
}

$property = static function (int $iblockId, array $fields): void {
    $exists = CIBlockProperty::GetList([], ['IBLOCK_ID' => $iblockId, 'CODE' => $fields['CODE']])->Fetch();
    if ($exists) {
        return;
    }
    $prop = new CIBlockProperty();
    if (!$prop->Add(array_merge(['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y', 'SORT' => 500], $fields))) {
        throw new RuntimeException('Не удалось создать свойство ' . $fields['CODE'] . ': ' . $prop->LAST_ERROR);
    }
};

$createIblock = static function (string $code, string $name, bool $sections = false) use ($typeId, $siteId): int {
    $found = CIBlock::GetList([], ['TYPE' => $typeId, 'CODE' => $code, 'SITE_ID' => $siteId])->Fetch();
    if ($found) {
        return (int)$found['ID'];
    }

    $iblock = new CIBlock();
    $id = (int)$iblock->Add([
        'ACTIVE' => 'Y',
        'NAME' => $name,
        'CODE' => $code,
        'IBLOCK_TYPE_ID' => $typeId,
        'SITE_ID' => [$siteId],
        'SORT' => 100,
        'GROUP_ID' => ['2' => 'R'],
        'VERSION' => 2,
        'SECTION_PAGE_URL' => '#SITE_DIR#' . $code . '/',
        'DETAIL_PAGE_URL' => '#SITE_DIR#' . $code . '/#ELEMENT_CODE#/',
        'LIST_PAGE_URL' => '#SITE_DIR#' . $code . '/',
        'INDEX_ELEMENT' => 'Y',
        'INDEX_SECTION' => 'Y',
        'WORKFLOW' => 'N',
        'BIZPROC' => 'N',
        'RIGHTS_MODE' => 'S',
        'SECTION_PROPERTY' => $sections ? 'Y' : 'N',
    ]);
    if ($id <= 0) {
        throw new RuntimeException('Не удалось создать инфоблок ' . $name . ': ' . $iblock->LAST_ERROR);
    }
    return $id;
};

$iblocks = [
    'banners' => $createIblock('banners', 'Баннеры'),
    'services' => $createIblock('services', 'Услуги'),
    'articles' => $createIblock('articles', 'Статьи', true),
    'certificates' => $createIblock('certificates', 'Сертификаты Битрикс'),
    'socials' => $createIblock('socials', 'Социальные сети'),
    'contacts' => $createIblock('contacts', 'Контактная информация'),
    'site_settings' => $createIblock('site_settings', 'Настройки сайта'),
    'seo_settings' => $createIblock('seo_settings', 'SEO настройки'),
    'feedback' => $createIblock('feedback', 'Заявки обратной связи'),
];

$property($iblocks['banners'], ['NAME' => 'Подзаголовок', 'CODE' => 'SUBTITLE', 'PROPERTY_TYPE' => 'S', 'USER_TYPE' => 'HTML']);
$property($iblocks['banners'], ['NAME' => 'Текст кнопки', 'CODE' => 'BUTTON_TEXT', 'PROPERTY_TYPE' => 'S']);
$property($iblocks['banners'], ['NAME' => 'Ссылка кнопки', 'CODE' => 'BUTTON_LINK', 'PROPERTY_TYPE' => 'S']);
$property($iblocks['banners'], ['NAME' => 'Фоновый градиент', 'CODE' => 'BACKGROUND', 'PROPERTY_TYPE' => 'S']);
$property($iblocks['services'], ['NAME' => 'Иконка', 'CODE' => 'ICON', 'PROPERTY_TYPE' => 'S']);
$property($iblocks['services'], ['NAME' => 'Стоимость от', 'CODE' => 'PRICE', 'PROPERTY_TYPE' => 'S']);
$property($iblocks['services'], ['NAME' => 'Срок', 'CODE' => 'TERM', 'PROPERTY_TYPE' => 'S']);
$property($iblocks['articles'], ['NAME' => 'Теги', 'CODE' => 'TAGS', 'PROPERTY_TYPE' => 'S', 'MULTIPLE' => 'Y']);
$property($iblocks['articles'], ['NAME' => 'Похожие статьи', 'CODE' => 'RELATED', 'PROPERTY_TYPE' => 'E', 'LINK_IBLOCK_ID' => $iblocks['articles'], 'MULTIPLE' => 'Y']);
$property($iblocks['certificates'], ['NAME' => 'Номер сертификата', 'CODE' => 'NUMBER', 'PROPERTY_TYPE' => 'S']);
$property($iblocks['socials'], ['NAME' => 'URL', 'CODE' => 'URL', 'PROPERTY_TYPE' => 'S']);
$property($iblocks['socials'], ['NAME' => 'SVG/Emoji иконка', 'CODE' => 'ICON', 'PROPERTY_TYPE' => 'S']);
$property($iblocks['contacts'], ['NAME' => 'Тип', 'CODE' => 'TYPE', 'PROPERTY_TYPE' => 'L', 'VALUES' => [
    ['VALUE' => 'phone', 'XML_ID' => 'phone'], ['VALUE' => 'email', 'XML_ID' => 'email'], ['VALUE' => 'address', 'XML_ID' => 'address'], ['VALUE' => 'map', 'XML_ID' => 'map'], ['VALUE' => 'requisites', 'XML_ID' => 'requisites'],
]]);
$property($iblocks['site_settings'], ['NAME' => 'Ключ', 'CODE' => 'KEY', 'PROPERTY_TYPE' => 'S']);
$property($iblocks['site_settings'], ['NAME' => 'Значение', 'CODE' => 'VALUE', 'PROPERTY_TYPE' => 'S', 'USER_TYPE' => 'HTML']);
$property($iblocks['seo_settings'], ['NAME' => 'URL', 'CODE' => 'URL', 'PROPERTY_TYPE' => 'S']);
$property($iblocks['seo_settings'], ['NAME' => 'Meta title', 'CODE' => 'TITLE', 'PROPERTY_TYPE' => 'S']);
$property($iblocks['seo_settings'], ['NAME' => 'Meta description', 'CODE' => 'DESCRIPTION', 'PROPERTY_TYPE' => 'S']);
$property($iblocks['seo_settings'], ['NAME' => 'Open Graph image', 'CODE' => 'OG_IMAGE', 'PROPERTY_TYPE' => 'F']);
$property($iblocks['feedback'], ['NAME' => 'Имя', 'CODE' => 'NAME_VALUE', 'PROPERTY_TYPE' => 'S']);
$property($iblocks['feedback'], ['NAME' => 'Телефон', 'CODE' => 'PHONE', 'PROPERTY_TYPE' => 'S']);
$property($iblocks['feedback'], ['NAME' => 'Email', 'CODE' => 'EMAIL', 'PROPERTY_TYPE' => 'S']);
$property($iblocks['feedback'], ['NAME' => 'Сообщение', 'CODE' => 'MESSAGE', 'PROPERTY_TYPE' => 'S', 'USER_TYPE' => 'HTML']);
$property($iblocks['feedback'], ['NAME' => 'IP', 'CODE' => 'IP', 'PROPERTY_TYPE' => 'S']);
$property($iblocks['feedback'], ['NAME' => 'User agent', 'CODE' => 'USER_AGENT', 'PROPERTY_TYPE' => 'S']);


if (!CEventType::GetByID('FEEDBACK_FORM', 'ru')->Fetch()) {
    (new CEventType())->Add([
        'EVENT_NAME' => 'FEEDBACK_FORM',
        'LID' => 'ru',
        'NAME' => 'Заявка с формы обратной связи AI WebStudio',
        'DESCRIPTION' => "#AUTHOR# - имя
#AUTHOR_EMAIL# - email
#PHONE# - телефон
#TEXT# - сообщение
#EMAIL_TO# - получатель",
    ]);
}
if (!CEventMessage::GetList($by = 'id', $order = 'asc', ['TYPE_ID' => 'FEEDBACK_FORM', 'SITE_ID' => $siteId])->Fetch()) {
    (new CEventMessage())->Add([
        'ACTIVE' => 'Y',
        'EVENT_NAME' => 'FEEDBACK_FORM',
        'LID' => [$siteId],
        'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
        'EMAIL_TO' => '#EMAIL_TO#',
        'SUBJECT' => 'Новая заявка с сайта #SITE_NAME#',
        'BODY_TYPE' => 'text',
        'MESSAGE' => "Имя: #AUTHOR#
Email: #AUTHOR_EMAIL#
Телефон: #PHONE#

Сообщение:
#TEXT#",
    ]);
}

$configPath = rtrim((string)WIZARD_SITE_PATH, '/') . '/.webstudio_iblocks.php';
$config = '<?php' . PHP_EOL
    . 'return ' . var_export([
        'IBLOCK_TYPE' => $typeId,
        'BANNERS_IBLOCK_ID' => (int)$iblocks['banners'],
        'SERVICES_IBLOCK_ID' => (int)$iblocks['services'],
        'ARTICLES_IBLOCK_ID' => (int)$iblocks['articles'],
        'CERTIFICATES_IBLOCK_ID' => (int)$iblocks['certificates'],
        'SOCIALS_IBLOCK_ID' => (int)$iblocks['socials'],
        'CONTACTS_IBLOCK_ID' => (int)$iblocks['contacts'],
        'SETTINGS_IBLOCK_ID' => (int)$iblocks['site_settings'],
        'SEO_IBLOCK_ID' => (int)$iblocks['seo_settings'],
        'FEEDBACK_IBLOCK_ID' => (int)$iblocks['feedback'],
    ], true) . ';' . PHP_EOL;
file_put_contents($configPath, $config);

if (!$installDemoData) {
    return;
}

$addElement = static function (int $iblockId, array $fields, array $props = []): int {
    $existing = CIBlockElement::GetList([], ['IBLOCK_ID' => $iblockId, '=CODE' => $fields['CODE']], false, false, ['ID'])->Fetch();
    if ($existing) {
        return (int)$existing['ID'];
    }
    $element = new CIBlockElement();
    $id = (int)$element->Add(array_merge([
        'IBLOCK_ID' => $iblockId,
        'ACTIVE' => 'Y',
        'PROPERTY_VALUES' => $props,
    ], $fields));
    if ($id <= 0) {
        throw new RuntimeException('Не удалось добавить элемент ' . $fields['NAME'] . ': ' . $element->LAST_ERROR);
    }
    return $id;
};

$addElement($iblocks['banners'], ['NAME' => 'Разработка сайтов на 1С-Битрикс', 'CODE' => 'main-hero', 'PREVIEW_TEXT' => 'Проектирую, запускаю и развиваю быстрые сайты, интернет-магазины и корпоративные порталы.', 'SORT' => 10], ['SUBTITLE' => ['VALUE' => ['TEXT' => 'От аудита и прототипа до интеграций, SEO и технической поддержки.', 'TYPE' => 'text']], 'BUTTON_TEXT' => 'Обсудить проект', 'BUTTON_LINK' => '/contacts/', 'BACKGROUND' => 'linear-gradient(135deg,#0f172a 0%,#1d4ed8 55%,#14b8a6 100%)']);

$services = [
    ['bitrix-development', 'Разработка на Битрикс', 'Индивидуальная разработка компонентов, шаблонов, интеграций и личных кабинетов.', '⚙️', 'от 80 000 ₽', 'от 3 недель'],
    ['ecommerce', 'Интернет-магазины', 'Каталог, корзина, оплата, доставка, обмен с 1С и CRM.', '🛒', 'от 150 000 ₽', 'от 5 недель'],
    ['support', 'Поддержка и развитие', 'Регулярные обновления, мониторинг, исправления, SEO и A/B улучшения.', '🚀', 'от 25 000 ₽/мес', 'SLA 24/7'],
];
foreach ($services as $item) {
    $addElement($iblocks['services'], ['CODE' => $item[0], 'NAME' => $item[1], 'PREVIEW_TEXT' => $item[2], 'DETAIL_TEXT' => $item[2] . "\n\nРаботаю прозрачно: фиксирую задачи, сроки, риски и передаю документацию.", 'SORT' => 100], ['ICON' => $item[3], 'PRICE' => $item[4], 'TERM' => $item[5]]);
}

$articleIds = [];
foreach ([
    ['checklist-zapuska', 'Чек-лист запуска сайта на Битрикс', 'Что проверить перед публикацией: производительность, SEO, формы, безопасность и аналитику.'],
    ['speed-optimization', 'Как ускорить сайт на 1С-Битрикс', 'Композит, кеширование, оптимизация изображений и правильная архитектура компонентов.'],
    ['crm-integration', 'Интеграция Битрикс-сайта с CRM', 'Какие данные передавать в CRM, как валидировать заявки и не терять лиды.'],
] as $article) {
    $articleIds[] = $addElement($iblocks['articles'], ['CODE' => $article[0], 'NAME' => $article[1], 'PREVIEW_TEXT' => $article[2], 'DETAIL_TEXT' => $article[2] . "\n\nПодробный материал с практическими рекомендациями и примерами внедрения.", 'DATE_ACTIVE_FROM' => ConvertTimeStamp(time(), 'FULL'), 'SORT' => 100], ['TAGS' => ['Битрикс', 'Разработка']]);
}
if (count($articleIds) > 1) {
    CIBlockElement::SetPropertyValuesEx($articleIds[0], $iblocks['articles'], ['RELATED' => array_slice($articleIds, 1)]);
}

foreach ([['bitrix-framework', 'Bitrix Framework Developer', 'BX-2026-001'], ['bitrix-admin', 'Bitrix Administrator', 'BX-2026-002']] as $certificate) {
    $addElement($iblocks['certificates'], ['CODE' => $certificate[0], 'NAME' => $certificate[1], 'PREVIEW_TEXT' => 'Подтвержденная компетенция по платформе 1С-Битрикс.', 'SORT' => 100], ['NUMBER' => $certificate[2]]);
}

foreach ([['telegram', 'Telegram', 'https://t.me/bitrix_expert', 'TG'], ['whatsapp', 'WhatsApp', 'https://wa.me/79991234567', 'WA'], ['vk', 'VK', 'https://vk.com/bitrix_expert', 'VK'], ['github', 'GitHub', 'https://github.com/bitrix-expert', 'GH']] as $social) {
    $addElement($iblocks['socials'], ['CODE' => $social[0], 'NAME' => $social[1], 'SORT' => 100], ['URL' => $social[2], 'ICON' => $social[3]]);
}

foreach ([['phone', 'Телефон', $sitePhone, 'phone'], ['email', 'Email', $siteEmail, 'email'], ['address', 'Адрес', 'Москва, удаленная работа по всему миру', 'address'], ['map', 'Карта', '55.751244,37.618423', 'map'], ['requisites', 'Реквизиты', 'ИП Иванов Иван Иванович, ИНН 000000000000', 'requisites']] as $contact) {
    $addElement($iblocks['contacts'], ['CODE' => $contact[0], 'NAME' => $contact[1], 'PREVIEW_TEXT' => $contact[2], 'SORT' => 100], ['TYPE' => $contact[3]]);
}

foreach ([['about_text', 'Обо мне', 'Разрабатываю сайты на 1С-Битрикс более 8 лет: от посадочных страниц до высоконагруженных интернет-магазинов.'], ['skills', 'Навыки', 'Bitrix Framework, D7, PHP 8.1+, интеграции, производительность, SEO, UX.'], ['experience', 'Опыт', '8+ лет, 120+ проектов, 35+ интеграций.']] as $setting) {
    $addElement($iblocks['site_settings'], ['CODE' => $setting[0], 'NAME' => $setting[1]], ['KEY' => $setting[0], 'VALUE' => ['VALUE' => ['TEXT' => $setting[2], 'TYPE' => 'text']]]);
}

foreach ([['home', '/', $siteName . ' — разработка сайтов на 1С-Битрикс', 'Разработка, поддержка и продвижение сайтов на 1С-Битрикс.'], ['articles', '/articles/', 'Статьи о разработке на Битрикс', 'Практические статьи по разработке, SEO и интеграциям на 1С-Битрикс.'], ['contacts', '/contacts/', 'Контакты веб-студии', 'Свяжитесь для оценки проекта на 1С-Битрикс.']] as $seo) {
    $addElement($iblocks['seo_settings'], ['CODE' => $seo[0], 'NAME' => $seo[2]], ['URL' => $seo[1], 'TITLE' => $seo[2], 'DESCRIPTION' => $seo[3]]);
}
