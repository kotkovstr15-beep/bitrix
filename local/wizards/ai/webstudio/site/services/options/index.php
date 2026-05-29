<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\SiteTable;

$siteId = (string)$wizard->GetVar('siteID');
$siteName = trim((string)$wizard->GetVar('siteName')) ?: 'Веб-студия Bitrix Expert';
$siteEmail = trim((string)$wizard->GetVar('siteEmail')) ?: 'hello@example.com';

if (class_exists(SiteTable::class)) {
    SiteTable::update($siteId, [
        'NAME' => $siteName,
        'EMAIL' => $siteEmail,
        'TEMPLATE' => [[
            'CONDITION' => '',
            'SORT' => 1,
            'TEMPLATE' => 'webstudio',
        ]],
    ]);
}

COption::SetOptionString('main', 'site_name', $siteName, false, $siteId);
COption::SetOptionString('main', 'email_from', $siteEmail, false, $siteId);
