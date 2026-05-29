<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$siteId = (string)$wizard->GetVar('siteID');
$rewrite = (string)$wizard->GetVar('rewritePublic') === 'Y';
$wizardPath = rtrim($wizard->GetPath(), '/');
$sitePath = rtrim((string)WIZARD_SITE_PATH, '/');
$documentRoot = rtrim((string)$_SERVER['DOCUMENT_ROOT'], '/');

CopyDirFiles($wizardPath . '/site/templates/webstudio', $documentRoot . '/local/templates/webstudio', true, true);
CopyDirFiles($wizardPath . '/site/files/local/components', $documentRoot . '/local/components', true, true);

$copyPublic = static function (string $from, string $to) use ($rewrite): void {
    if (!$rewrite && file_exists($to)) {
        return;
    }
    CopyDirFiles($from, $to, $rewrite, true);
};

$copyPublic($wizardPath . '/site/public', $sitePath);

$menuTop = <<<'PHP_MENU'
<?php
$aMenuLinks = [
    ['Главная', '/', [], [], ''],
    ['О компании', '/about/', [], [], ''],
    ['Услуги', '/services/', [], [], ''],
    ['Статьи', '/articles/', [], [], ''],
    ['Контакты', '/contacts/', [], [], ''],
];
PHP_MENU;
$menuBottom = <<<'PHP_MENU'
<?php
$aMenuLinks = [
    ['Услуги', '/services/', [], [], ''],
    ['Статьи', '/articles/', [], [], ''],
    ['Контакты', '/contacts/', [], [], ''],
    ['Политика конфиденциальности', '/privacy/', [], [], ''],
];
PHP_MENU;
file_put_contents($sitePath . '/.top.menu.php', $menuTop);
file_put_contents($sitePath . '/.bottom.menu.php', $menuBottom);

$robots = "User-agent: *\nDisallow: /bitrix/\nDisallow: /local/\nAllow: /local/templates/webstudio/assets/\nSitemap: /sitemap.xml\n";
file_put_contents($sitePath . '/robots.txt', $robots);

$sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL
    . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL
    . '  <url><loc>/</loc><priority>1.0</priority></url>' . PHP_EOL
    . '  <url><loc>/about/</loc><priority>0.8</priority></url>' . PHP_EOL
    . '  <url><loc>/services/</loc><priority>0.8</priority></url>' . PHP_EOL
    . '  <url><loc>/articles/</loc><priority>0.8</priority></url>' . PHP_EOL
    . '  <url><loc>/contacts/</loc><priority>0.8</priority></url>' . PHP_EOL
    . '</urlset>' . PHP_EOL;
file_put_contents($sitePath . '/sitemap.xml', $sitemap);

CWizardUtil::ReplaceMacros($sitePath . '/index.php', ['SITE_ID' => $siteId]);
CWizardUtil::ReplaceMacros($sitePath . '/about/index.php', ['SITE_ID' => $siteId]);
CWizardUtil::ReplaceMacros($sitePath . '/services/index.php', ['SITE_ID' => $siteId]);
CWizardUtil::ReplaceMacros($sitePath . '/articles/index.php', ['SITE_ID' => $siteId]);
CWizardUtil::ReplaceMacros($sitePath . '/contacts/index.php', ['SITE_ID' => $siteId]);

$rule = [
    'CONDITION' => '#^/articles/([A-Za-z0-9_-]+)/?#',
    'RULE' => 'ELEMENT_CODE=$1',
    'ID' => 'bitrix:news',
    'PATH' => '/articles/index.php',
    'SORT' => 100,
];
CUrlRewriter::Add($rule);
