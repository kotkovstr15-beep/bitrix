<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);

if (class_exists('vendor_sitewizard')) {
    return;
}

class vendor_sitewizard extends CModule
{
    public $MODULE_ID = 'vendor.sitewizard';
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;

    public function __construct()
    {
        $versionFile = __DIR__ . '/version.php';
        if (is_file($versionFile)) {
            include $versionFile;
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = Loc::getMessage('VENDOR_SITEWIZARD_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('VENDOR_SITEWIZARD_MODULE_DESC');
        $this->PARTNER_NAME = 'Vendor';
        $this->PARTNER_URI = 'https://example.com';
    }

    public function DoInstall(): void
    {
        ModuleManager::registerModule($this->MODULE_ID);
        $this->InstallFiles();
    }

    public function DoUninstall(): void
    {
        $this->UnInstallFiles();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    public function InstallFiles(): bool
    {
        $wizardSource = __DIR__ . '/wizards';
        $wizardTarget = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/wizards';

        if (is_dir($wizardSource)) {
            CopyDirFiles($wizardSource, $wizardTarget, true, true);
        }

        return true;
    }

    public function UnInstallFiles(): bool
    {
        $wizardDir = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/wizards/vendor/site';
        if (is_dir($wizardDir)) {
            DeleteDirFilesEx('/bitrix/wizards/vendor/site');
        }

        return true;
    }
}
