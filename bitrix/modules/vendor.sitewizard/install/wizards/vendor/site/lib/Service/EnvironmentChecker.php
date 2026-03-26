<?php

namespace Vendor\SiteWizard\Service;

class EnvironmentChecker
{
    private const MIN_VERSION = '21.0.0';

    /**
     * @return array<int, array{ok: bool, message: string}>
     */
    public function check(): array
    {
        $result = [];

        $version = defined('SM_VERSION') ? SM_VERSION : '0.0.0';
        $result[] = [
            'ok' => version_compare($version, self::MIN_VERSION, '>='),
            'message' => sprintf('Версия ядра: %s (минимум %s)', $version, self::MIN_VERSION),
        ];

        foreach (['main', 'iblock', 'catalog', 'sale'] as $moduleId) {
            $result[] = [
                'ok' => \Bitrix\Main\Loader::includeModule($moduleId),
                'message' => sprintf('Модуль %s %s', $moduleId, \Bitrix\Main\Loader::includeModule($moduleId) ? 'доступен' : 'не установлен'),
            ];
        }

        foreach (['/upload', BX_ROOT . '/cache'] as $relativePath) {
            $absolutePath = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . $relativePath;
            $result[] = [
                'ok' => is_dir($absolutePath) && is_writable($absolutePath),
                'message' => sprintf('Права записи: %s', $relativePath),
            ];
        }

        return $result;
    }

    public function isValid(): bool
    {
        foreach ($this->check() as $item) {
            if ($item['ok'] !== true) {
                return false;
            }
        }

        return true;
    }
}
