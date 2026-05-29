<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;

function ai_webstudio_apply_seo(): void
{
    global $APPLICATION;

    $configPath = $_SERVER['DOCUMENT_ROOT'] . '/.webstudio_iblocks.php';
    if (!is_file($configPath) || !Loader::includeModule('iblock')) {
        return;
    }

    $config = include $configPath;
    $page = strtok((string)$APPLICATION->GetCurPage(), '?') ?: '/';
    $element = CIBlockElement::GetList(
        [],
        ['IBLOCK_ID' => (int)$config['SEO_IBLOCK_ID'], 'ACTIVE' => 'Y', '=PROPERTY_URL' => $page],
        false,
        ['nTopCount' => 1],
        ['ID', 'NAME', 'PROPERTY_TITLE', 'PROPERTY_DESCRIPTION']
    )->Fetch();

    if (!$element) {
        return;
    }

    if ((string)$element['PROPERTY_TITLE_VALUE'] !== '') {
        $APPLICATION->SetPageProperty('title', (string)$element['PROPERTY_TITLE_VALUE']);
        $APPLICATION->SetTitle((string)$element['PROPERTY_TITLE_VALUE']);
        $APPLICATION->AddHeadString('<meta property="og:title" content="' . htmlspecialcharsbx((string)$element['PROPERTY_TITLE_VALUE']) . '">', true);
    }
    if ((string)$element['PROPERTY_DESCRIPTION_VALUE'] !== '') {
        $description = (string)$element['PROPERTY_DESCRIPTION_VALUE'];
        $APPLICATION->SetPageProperty('description', $description);
        $APPLICATION->AddHeadString('<meta property="og:description" content="' . htmlspecialcharsbx($description) . '">', true);
    }
    $APPLICATION->AddHeadString('<meta property="og:url" content="' . htmlspecialcharsbx($page) . '">', true);
}
