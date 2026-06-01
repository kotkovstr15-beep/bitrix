<?php
/**
 * Landing page template: full-width page without side columns.
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<section class="landing-hero" id="home">
    <div class="container">
        <p class="section__lead">WEBDEV — разработка сайтов на 1С-Битрикс</p>
        <h1 class="landing-hero__title">Запускаем быстрые, удобные и масштабируемые веб-проекты</h1>
        <p class="section__lead">От лендингов до корпоративных порталов: проектируем UX, внедряем интеграции и сопровождаем развитие продукта.</p>
        <a class="btn" href="#contacts">Обсудить проект</a>
    </div>
</section>

<section class="section" id="services">
    <div class="container">
        <div class="section__header" data-animate>
            <h2 class="section__title">Услуги</h2>
            <p class="section__lead">Готовые направления для роста вашего digital-продукта.</p>
        </div>
        <?php
        $APPLICATION->IncludeComponent(
            'bitrix:news.list',
            'services_template',
            [
                'IBLOCK_TYPE' => 'content',
                'IBLOCK_ID' => '',
                'NEWS_COUNT' => '6',
                'SORT_BY1' => 'SORT',
                'SORT_ORDER1' => 'ASC',
                'SORT_BY2' => 'ID',
                'SORT_ORDER2' => 'DESC',
                'FIELD_CODE' => ['NAME', 'PREVIEW_TEXT', 'DETAIL_PAGE_URL'],
                'PROPERTY_CODE' => ['ICON'],
                'CHECK_DATES' => 'Y',
                'DETAIL_URL' => '',
                'CACHE_TYPE' => 'A',
                'CACHE_TIME' => '36000000',
                'CACHE_FILTER' => 'N',
                'CACHE_GROUPS' => 'Y',
                'PREVIEW_TRUNCATE_LEN' => '',
                'ACTIVE_DATE_FORMAT' => 'd.m.Y',
                'SET_TITLE' => 'N',
                'SET_BROWSER_TITLE' => 'N',
                'SET_META_KEYWORDS' => 'N',
                'SET_META_DESCRIPTION' => 'N',
                'SET_LAST_MODIFIED' => 'N',
                'INCLUDE_IBLOCK_INTO_CHAIN' => 'N',
                'ADD_SECTIONS_CHAIN' => 'N',
                'HIDE_LINK_WHEN_NO_DETAIL' => 'N',
                'PARENT_SECTION' => '',
                'PARENT_SECTION_CODE' => '',
                'INCLUDE_SUBSECTIONS' => 'Y',
                'STRICT_SECTION_CHECK' => 'N',
                'DISPLAY_DATE' => 'N',
                'DISPLAY_NAME' => 'Y',
                'DISPLAY_PICTURE' => 'N',
                'DISPLAY_PREVIEW_TEXT' => 'Y',
                'PAGER_TEMPLATE' => '.default',
                'DISPLAY_TOP_PAGER' => 'N',
                'DISPLAY_BOTTOM_PAGER' => 'N',
            ],
            false,
            ['HIDE_ICONS' => 'Y']
        );
        ?>
    </div>
</section>

<section class="section" id="why">
    <div class="container">
        <div class="section__header" data-animate>
            <h2 class="section__title">Почему мы</h2>
            <p class="section__lead">Делаем разработку прозрачной и предсказуемой для бизнеса.</p>
        </div>
        <div class="why-grid">
            <article class="why-card" data-animate>
                <h3>Сильная экспертиза Bitrix D7</h3>
                <p>Используем новое ядро, ORM, события и управляемые кеши для надежной архитектуры.</p>
            </article>
            <article class="why-card" data-animate>
                <h3>Фокус на скорости</h3>
                <p>Оптимизируем интерфейсы, изображения, кеширование и сценарии загрузки страниц.</p>
            </article>
            <article class="why-card" data-animate>
                <h3>Поддержка после запуска</h3>
                <p>Развиваем проект итерациями, анализируем метрики и быстро внедряем улучшения.</p>
            </article>
        </div>
    </div>
</section>

<section class="section" id="contacts">
    <div class="container contacts-grid">
        <div class="section__header" data-animate>
            <h2 class="section__title">Контакты</h2>
            <p class="section__lead">Расскажите о задаче — предложим оптимальный формат запуска.</p>
        </div>
        <div class="contact-card" data-animate>
            <?php $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . '/include/contacts_block.php', [], ['MODE' => 'html']); ?>
        </div>
        <div class="contact-card" data-animate>
            <h3>Быстрый старт</h3>
            <p>Подготовим оценку, карту работ и рекомендации по структуре будущего сайта.</p>
            <a class="btn" href="mailto:hello@example.ru">Написать нам</a>
        </div>
    </div>
</section>
