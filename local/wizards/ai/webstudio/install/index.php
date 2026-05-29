<?php
/**
 * Optional package installer for copying this wizard into /local/wizards/ai/webstudio.
 * In regular Bitrix usage place the whole directory there and run it from Marketplace > Solutions Wizard.
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_before.php';
}

if (!$USER->IsAdmin()) {
    $APPLICATION->AuthForm('Требуются права администратора.');
}

$source = dirname(__DIR__);
$target = $_SERVER['DOCUMENT_ROOT'] . '/local/wizards/ai/webstudio';
CopyDirFiles($source, $target, true, true);
LocalRedirect('/bitrix/admin/wizard_list.php?lang=' . LANGUAGE_ID);
