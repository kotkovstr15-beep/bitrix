<?php

namespace Vendor\SiteWizard\Service;

use Bitrix\Main\Error;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Result;

class InfrastructureBuilder
{
    /** @var object */
    private $wizard;

    /**
     * @param object $wizard Экземпляр CWizard/CWizardBase
     */
    public function __construct($wizard)
    {
        $this->wizard = $wizard;
    }

    public function build(): Result
    {
        $result = new Result();

        try {
            $this->copyPublicFiles();
            $this->createIblockTypes();
            $iblocks = $this->createIblocks();
            $this->createDemoData($iblocks);
            $this->createMenu();
            $this->configureSites();
            $this->configureUrlRewrite();
            $this->configureRegionalOrderProperty();
        } catch (\Throwable $exception) {
            $result->addError(new Error($exception->getMessage()));
        }

        return $result;
    }

    private function copyPublicFiles(): void
    {
        $source = __DIR__ . '/../../install/files/public';
        $target = rtrim($_SERVER['DOCUMENT_ROOT'], '/');

        CopyDirFiles($source, $target, true, true);
    }

    private function createIblockTypes(): void
    {
        if (!\Bitrix\Main\Loader::includeModule('iblock')) {
            throw new \RuntimeException('Не установлен модуль iblock.');
        }

        $types = [
            'catalog' => 'Каталог',
            'content' => 'Контент',
        ];

        foreach ($types as $id => $name) {
            $existing = \CIBlockType::GetByID($id);
            if ($existing instanceof \CDBResult && $existing->Fetch()) {
                continue;
            }

            $iblockType = new \CIBlockType();
            $iblockType->Add([
                'ID' => $id,
                'SECTIONS' => 'Y',
                'IN_RSS' => 'Y',
                'LANG' => [
                    'ru' => [
                        'NAME' => $name,
                    ],
                    'en' => [
                        'NAME' => $name,
                    ],
                ],
            ]);
        }
    }

    /**
     * @return array<string, int>
     */
    private function createIblocks(): array
    {
        $siteId = (string) $this->wizard->GetVar('SITE_CODE', 's1');
        $iblockMap = [
            'catalog' => ['TYPE' => 'catalog', 'NAME' => 'Каталог товаров', 'SECTIONS' => 'Y'],
            'blog' => ['TYPE' => 'content', 'NAME' => 'Блог', 'SECTIONS' => 'N'],
            'news' => ['TYPE' => 'content', 'NAME' => 'Новости', 'SECTIONS' => 'N'],
        ];

        $created = [];

        foreach ($iblockMap as $code => $meta) {
            $existing = \CIBlock::GetList([], ['CODE' => $code, 'TYPE' => $meta['TYPE']])->Fetch();
            if ($existing) {
                $created[$code] = (int) $existing['ID'];
                continue;
            }

            $iblock = new \CIBlock();
            $id = $iblock->Add([
                'LID' => [$siteId],
                'CODE' => $code,
                'API_CODE' => $code,
                'NAME' => $meta['NAME'],
                'IBLOCK_TYPE_ID' => $meta['TYPE'],
                'VERSION' => 2,
                'ACTIVE' => 'Y',
                'SECTION_PAGE_URL' => '/' . $code . '/#SECTION_CODE#/',
                'DETAIL_PAGE_URL' => '/' . $code . '/#SECTION_CODE#/#ELEMENT_CODE#/',
                'INDEX_ELEMENT' => 'Y',
                'INDEX_SECTION' => 'Y',
                'RIGHTS_MODE' => 'S',
                'SECTIONS_NAME' => $meta['SECTIONS'] === 'Y' ? 'Разделы' : '',
            ]);

            if (!$id) {
                throw new \RuntimeException('Ошибка создания инфоблока ' . $code . ': ' . $iblock->LAST_ERROR);
            }

            $created[$code] = (int) $id;
            $this->createIblockProperties((int) $id, $code);
        }

        return $created;
    }

    private function createIblockProperties(int $iblockId, string $code): void
    {
        $props = [
            'catalog' => [
                ['CODE' => 'PRICE', 'NAME' => 'Цена', 'TYPE' => 'N'],
                ['CODE' => 'CURRENCY', 'NAME' => 'Валюта', 'TYPE' => 'S', 'DEFAULT' => 'RUB'],
                ['CODE' => 'ARTNUMBER', 'NAME' => 'Артикул', 'TYPE' => 'S'],
                ['CODE' => 'IMAGE', 'NAME' => 'Картинка товара', 'TYPE' => 'F'],
                ['CODE' => 'REGION', 'NAME' => 'Регион', 'TYPE' => 'S'],
            ],
            'blog' => [
                ['CODE' => 'AUTHOR', 'NAME' => 'Автор', 'TYPE' => 'S'],
                ['CODE' => 'TAGS', 'NAME' => 'Теги', 'TYPE' => 'S'],
                ['CODE' => 'IMAGE_PREVIEW', 'NAME' => 'Изображение', 'TYPE' => 'F'],
            ],
            'news' => [
                ['CODE' => 'SOURCE', 'NAME' => 'Источник', 'TYPE' => 'S'],
                ['CODE' => 'DATE', 'NAME' => 'Дата события', 'TYPE' => 'S', 'USER_TYPE' => 'DateTime'],
            ],
        ];

        foreach ($props[$code] ?? [] as $property) {
            $exists = \CIBlockProperty::GetList([], ['IBLOCK_ID' => $iblockId, 'CODE' => $property['CODE']])->Fetch();
            if ($exists) {
                continue;
            }

            $ibp = new \CIBlockProperty();
            $fields = [
                'IBLOCK_ID' => $iblockId,
                'NAME' => $property['NAME'],
                'CODE' => $property['CODE'],
                'PROPERTY_TYPE' => $property['TYPE'],
                'ACTIVE' => 'Y',
                'DEFAULT_VALUE' => $property['DEFAULT'] ?? '',
                'USER_TYPE' => $property['USER_TYPE'] ?? '',
            ];

            if (!$ibp->Add($fields)) {
                throw new \RuntimeException('Ошибка создания свойства ' . $property['CODE'] . ': ' . $ibp->LAST_ERROR);
            }
        }
    }

    /**
     * @param array<string, int> $iblocks
     */
    private function createDemoData(array $iblocks): void
    {
        if (isset($iblocks['catalog'])) {
            $this->fillCatalog($iblocks['catalog']);
        }
        if (isset($iblocks['blog'])) {
            $this->fillSimpleIblock($iblocks['blog'], 'blog');
        }
        if (isset($iblocks['news'])) {
            $this->fillSimpleIblock($iblocks['news'], 'news');
        }
    }

    private function fillCatalog(int $iblockId): void
    {
        $sections = [
            'elektronika' => 'Электроника',
            'odezhda' => 'Одежда',
            'knigi' => 'Книги',
        ];

        $sectionIds = [];
        foreach ($sections as $code => $name) {
            $existing = \CIBlockSection::GetList([], ['IBLOCK_ID' => $iblockId, '=CODE' => $code])->Fetch();
            if ($existing) {
                $sectionIds[$code] = (int) $existing['ID'];
                continue;
            }

            $bs = new \CIBlockSection();
            $sectionId = $bs->Add([
                'IBLOCK_ID' => $iblockId,
                'NAME' => $name,
                'CODE' => $code,
                'ACTIVE' => 'Y',
            ]);
            if (!$sectionId) {
                throw new \RuntimeException('Ошибка создания раздела каталога: ' . $bs->LAST_ERROR);
            }

            $sectionIds[$code] = (int) $sectionId;
        }

        $element = new \CIBlockElement();
        foreach ($sectionIds as $code => $sectionId) {
            for ($i = 1; $i <= 2; $i++) {
                $article = strtoupper($code) . '-' . $i;
                $exists = \CIBlockElement::GetList([], ['IBLOCK_ID' => $iblockId, '=CODE' => strtolower($article)])->Fetch();
                if ($exists) {
                    continue;
                }

                $price = random_int(500, 50000);
                $ok = $element->Add([
                    'IBLOCK_ID' => $iblockId,
                    'IBLOCK_SECTION_ID' => $sectionId,
                    'NAME' => 'Товар ' . $article,
                    'CODE' => strtolower($article),
                    'ACTIVE' => 'Y',
                    'PREVIEW_TEXT' => 'Демо-описание товара',
                    'PROPERTY_VALUES' => [
                        'PRICE' => $price,
                        'CURRENCY' => (string) $this->wizard->GetVar('CURRENCY', 'RUB'),
                        'ARTNUMBER' => $article,
                        'REGION' => 'default',
                    ],
                ]);

                if (!$ok) {
                    throw new \RuntimeException('Ошибка создания товара: ' . $element->LAST_ERROR);
                }
            }
        }
    }

    private function fillSimpleIblock(int $iblockId, string $type): void
    {
        $element = new \CIBlockElement();
        for ($i = 1; $i <= 3; $i++) {
            $code = $type . '-' . $i;
            $exists = \CIBlockElement::GetList([], ['IBLOCK_ID' => $iblockId, '=CODE' => $code])->Fetch();
            if ($exists) {
                continue;
            }

            $fields = [
                'IBLOCK_ID' => $iblockId,
                'NAME' => ucfirst($type) . ' ' . $i,
                'CODE' => $code,
                'ACTIVE' => 'Y',
                'PREVIEW_TEXT' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'DETAIL_TEXT' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero.',
            ];

            if ($type === 'blog') {
                $fields['PROPERTY_VALUES'] = [
                    'AUTHOR' => 'Автор ' . $i,
                    'TAGS' => 'demo,bitrix,post' . $i,
                ];
            }

            if ($type === 'news') {
                $fields['PROPERTY_VALUES'] = [
                    'SOURCE' => 'Информагентство',
                    'DATE' => ConvertTimeStamp(false, 'FULL'),
                ];
            }

            if (!$element->Add($fields)) {
                throw new \RuntimeException('Ошибка создания элемента ' . $code . ': ' . $element->LAST_ERROR);
            }
        }
    }

    private function createMenu(): void
    {
        $menuPath = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/.top.menu.php';
        if (is_file($menuPath)) {
            return;
        }

        $menu = <<<'PHP'
<?php
$aMenuLinks = [
    ['Каталог', '/catalog/', [], [], ''],
    ['Блог', '/blog/', [], [], ''],
    ['Новости', '/news/', [], [], ''],
    ['О нас', '/about/', [], [], ''],
    ['Контакты', '/contacts/', [], [], ''],
    ['Корзина', '/personal/cart/', [], [], ''],
];
PHP;
        file_put_contents($menuPath, $menu);
    }

    private function configureSites(): void
    {
        $domains = array_values(array_filter((array) $this->wizard->GetVar('DOMAINS', [])));
        if ($domains === []) {
            return;
        }

        foreach ($domains as $index => $domain) {
            $siteId = $index === 0 ? (string) $this->wizard->GetVar('SITE_CODE', 's1') : 's' . ($index + 1);
            $site = new \CSite();
            $exists = \CSite::GetByID($siteId)->Fetch();
            if ($exists) {
                continue;
            }

            $ok = $site->Add([
                'LID' => $siteId,
                'ACTIVE' => 'Y',
                'SORT' => 100,
                'DEF' => $index === 0 ? 'Y' : 'N',
                'NAME' => 'Регион ' . ($index + 1),
                'DIR' => '/',
                'LANGUAGE_ID' => (string) $this->wizard->GetVar('LANGUAGE_ID', 'ru'),
                'SERVER_NAME' => $domain,
                'DOC_ROOT' => '',
                'DOMAINS' => $domain,
            ]);

            if (!$ok) {
                throw new \RuntimeException('Ошибка создания сайта для домена ' . $domain . ': ' . $site->LAST_ERROR);
            }
        }
    }

    private function configureUrlRewrite(): void
    {
        $rules = [
            ['CONDITION' => '#^/catalog/#', 'RULE' => '', 'ID' => 'bitrix:catalog', 'PATH' => '/catalog/index.php'],
            ['CONDITION' => '#^/blog/#', 'RULE' => '', 'ID' => 'bitrix:news', 'PATH' => '/blog/index.php'],
            ['CONDITION' => '#^/news/#', 'RULE' => '', 'ID' => 'bitrix:news', 'PATH' => '/news/index.php'],
        ];

        foreach ($rules as $rule) {
            \CUrlRewriter::Add('', $rule);
        }
    }

    private function configureRegionalOrderProperty(): void
    {
        if (!\Bitrix\Main\Loader::includeModule('sale')) {
            return;
        }

        $propertyDb = \CSaleOrderProps::GetList([], ['CODE' => 'REGION']);
        if ($propertyDb->Fetch()) {
            return;
        }

        \CSaleOrderProps::Add([
            'PERSON_TYPE_ID' => 1,
            'NAME' => 'Регион',
            'TYPE' => 'STRING',
            'REQUIRED' => 'Y',
            'DEFAULT_VALUE' => 'default',
            'CODE' => 'REGION',
            'SORT' => 100,
            'USER_PROPS' => 'Y',
            'IS_LOCATION' => 'N',
            'PROPS_GROUP_ID' => 1,
        ]);
    }
}
