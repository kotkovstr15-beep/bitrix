<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
$APPLICATION->SetTitle('Контакты');
$config = include $_SERVER['DOCUMENT_ROOT'] . '/.webstudio_iblocks.php';
?>
<section class="section page-hero"><div class="container"><p class="eyebrow">Контакты</p><h1>Связаться с разработчиком</h1><p>Контактные данные, карта, реквизиты и соцсети берутся из инфоблоков.</p></div></section>
<section class="section"><div class="container contacts-grid"><div><?php $APPLICATION->IncludeComponent('bitrix:news.list', 'contacts', ['IBLOCK_TYPE' => $config['IBLOCK_TYPE'], 'IBLOCK_ID' => $config['CONTACTS_IBLOCK_ID'], 'NEWS_COUNT' => 20, 'CACHE_TYPE' => 'A', 'CACHE_TIME' => 36000000, 'PROPERTY_CODE' => ['TYPE'], 'SET_TITLE' => 'N'], false); ?><?php $APPLICATION->IncludeComponent('bitrix:news.list', 'socials', ['IBLOCK_TYPE' => $config['IBLOCK_TYPE'], 'IBLOCK_ID' => $config['SOCIALS_IBLOCK_ID'], 'NEWS_COUNT' => 20, 'CACHE_TYPE' => 'A', 'CACHE_TIME' => 36000000, 'PROPERTY_CODE' => ['URL', 'ICON'], 'SET_TITLE' => 'N'], false); ?></div><?php $APPLICATION->IncludeComponent('ai:webstudio.feedback', '', ['IBLOCK_ID' => $config['FEEDBACK_IBLOCK_ID'], 'EMAIL_TO' => COption::GetOptionString('main', 'email_from')], false); ?></div></section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'; ?>
