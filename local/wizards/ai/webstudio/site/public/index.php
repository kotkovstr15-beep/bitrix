<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
$APPLICATION->SetTitle('Главная');
$config = include $_SERVER['DOCUMENT_ROOT'] . '/.webstudio_iblocks.php';
?>
<section class="section hero-section">
<?php $APPLICATION->IncludeComponent('bitrix:news.list', 'home_banners', [
    'IBLOCK_TYPE' => $config['IBLOCK_TYPE'], 'IBLOCK_ID' => $config['BANNERS_IBLOCK_ID'], 'NEWS_COUNT' => 1,
    'SORT_BY1' => 'SORT', 'SORT_ORDER1' => 'ASC', 'CACHE_TYPE' => 'A', 'CACHE_TIME' => 36000000,
    'PROPERTY_CODE' => ['SUBTITLE', 'BUTTON_TEXT', 'BUTTON_LINK', 'BACKGROUND'], 'SET_TITLE' => 'N',
], false); ?>
</section>
<section class="section about-preview" id="about">
    <div class="container about-preview__grid">
        <div class="about-preview__photo" aria-hidden="true"><span>BX</span></div>
        <div>
            <p class="eyebrow">Обо мне</p>
            <h2>Разработчик сайтов на 1С-Битрикс с фокусом на бизнес-результат</h2>
            <?php $APPLICATION->IncludeComponent('bitrix:news.list', 'settings', [
                'IBLOCK_TYPE' => $config['IBLOCK_TYPE'], 'IBLOCK_ID' => $config['SETTINGS_IBLOCK_ID'], 'NEWS_COUNT' => 3,
                'SORT_BY1' => 'SORT', 'SORT_ORDER1' => 'ASC', 'CACHE_TYPE' => 'A', 'CACHE_TIME' => 36000000,
                'PROPERTY_CODE' => ['KEY', 'VALUE'], 'SET_TITLE' => 'N',
            ], false); ?>
        </div>
    </div>
</section>
<section class="section" id="services">
    <div class="container section-head"><p class="eyebrow">Услуги</p><h2>Что можно заказать</h2></div>
    <?php $APPLICATION->IncludeComponent('bitrix:news.list', 'home_services', [
        'IBLOCK_TYPE' => $config['IBLOCK_TYPE'], 'IBLOCK_ID' => $config['SERVICES_IBLOCK_ID'], 'NEWS_COUNT' => 6,
        'SORT_BY1' => 'SORT', 'SORT_ORDER1' => 'ASC', 'CACHE_TYPE' => 'A', 'CACHE_TIME' => 36000000,
        'PROPERTY_CODE' => ['ICON', 'PRICE', 'TERM'], 'SET_TITLE' => 'N',
    ], false); ?>
</section>
<section class="section advantages">
    <div class="container"><p class="eyebrow">Преимущества</p><h2>Почему выбирают нас</h2><div class="stats-grid"><div><b>120+</b><span>проектов</span></div><div><b>8+</b><span>лет опыта</span></div><div><b>24/7</b><span>мониторинг</span></div><div><b>35+</b><span>интеграций</span></div></div></div>
</section>
<section class="section certificates">
    <div class="container section-head"><p class="eyebrow">Сертификаты</p><h2>Компетенции Битрикс</h2></div>
    <?php $APPLICATION->IncludeComponent('bitrix:news.list', 'certificates', [
        'IBLOCK_TYPE' => $config['IBLOCK_TYPE'], 'IBLOCK_ID' => $config['CERTIFICATES_IBLOCK_ID'], 'NEWS_COUNT' => 8,
        'SORT_BY1' => 'SORT', 'SORT_ORDER1' => 'ASC', 'CACHE_TYPE' => 'A', 'CACHE_TIME' => 36000000,
        'PROPERTY_CODE' => ['NUMBER'], 'SET_TITLE' => 'N',
    ], false); ?>
</section>
<section class="section articles-preview">
    <div class="container section-head"><p class="eyebrow">Статьи</p><h2>Последние материалы</h2></div>
    <?php $APPLICATION->IncludeComponent('bitrix:news.list', 'home_articles', [
        'IBLOCK_TYPE' => $config['IBLOCK_TYPE'], 'IBLOCK_ID' => $config['ARTICLES_IBLOCK_ID'], 'NEWS_COUNT' => 3,
        'SORT_BY1' => 'DATE_ACTIVE_FROM', 'SORT_ORDER1' => 'DESC', 'CACHE_TYPE' => 'A', 'CACHE_TIME' => 36000000,
        'PROPERTY_CODE' => ['TAGS'], 'SET_TITLE' => 'N', 'DETAIL_URL' => '/articles/#ELEMENT_CODE#/',
    ], false); ?>
</section>
<section class="section contacts-preview" id="contacts">
    <div class="container contacts-grid">
        <div><p class="eyebrow">Контакты</p><h2>Обсудим проект?</h2><?php $APPLICATION->IncludeComponent('bitrix:news.list', 'contacts', ['IBLOCK_TYPE' => $config['IBLOCK_TYPE'], 'IBLOCK_ID' => $config['CONTACTS_IBLOCK_ID'], 'NEWS_COUNT' => 10, 'CACHE_TYPE' => 'A', 'CACHE_TIME' => 36000000, 'PROPERTY_CODE' => ['TYPE'], 'SET_TITLE' => 'N'], false); ?></div>
        <?php $APPLICATION->IncludeComponent('ai:webstudio.feedback', '', ['IBLOCK_ID' => $config['FEEDBACK_IBLOCK_ID'], 'EMAIL_TO' => COption::GetOptionString('main', 'email_from')], false); ?>
    </div>
</section>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'; ?>
