<?php
/**
 * Footer template for WEBDEV site template.
 * Выводит подвальное меню, контакты, форму обратной связи, копирайт и заглушки счетчиков.
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
    </main>

    <footer class="site-footer" id="contacts">
        <div class="container site-footer__grid">
            <div class="site-footer__brand">
                <a class="logo logo--footer" href="/">WEBDEV</a>
                <p>Проектируем, разрабатываем и поддерживаем современные веб-проекты на 1С-Битрикс.</p>
                <?php $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . '/include/contacts_block.php', [], ['MODE' => 'html']); ?>
            </div>

            <div class="site-footer__menu">
                <h2 class="site-footer__title">Навигация</h2>
                <?php
                if (method_exists($APPLICATION, 'ShowMenu')) {
                    $APPLICATION->ShowMenu('bottom', [
                        'containerClass' => 'footer-menu',
                        'itemClass' => 'footer-menu__item',
                        'linkClass' => 'footer-menu__link',
                    ]);
                } else {
                    $APPLICATION->IncludeComponent(
                        'bitrix:menu',
                        '',
                        [
                            'ROOT_MENU_TYPE' => 'bottom',
                            'MAX_LEVEL' => '1',
                            'CHILD_MENU_TYPE' => 'left',
                            'USE_EXT' => 'N',
                            'DELAY' => 'N',
                            'ALLOW_MULTI_SELECT' => 'N',
                            'MENU_CACHE_TYPE' => 'A',
                            'MENU_CACHE_TIME' => '3600',
                            'MENU_CACHE_USE_GROUPS' => 'Y',
                            'MENU_CACHE_GET_VARS' => [],
                        ],
                        false,
                        ['HIDE_ICONS' => 'Y']
                    );
                }
                ?>
            </div>

            <div class="site-footer__form">
                <h2 class="site-footer__title">Быстрая связь</h2>
                <p>Оставьте контакты — мы вернемся с идеями для вашего проекта.</p>
                <?php
                $APPLICATION->IncludeComponent(
                    'bitrix:main.feedback',
                    '',
                    [
                        'USE_CAPTCHA' => 'N',
                        'OK_TEXT' => 'Спасибо, ваше сообщение принято.',
                        'EMAIL_TO' => 'hello@example.ru',
                        'REQUIRED_FIELDS' => ['NAME', 'EMAIL', 'MESSAGE'],
                        'EVENT_MESSAGE_ID' => [],
                    ],
                    false,
                    ['HIDE_ICONS' => 'Y']
                );
                ?>
            </div>
        </div>

        <div class="container site-footer__bottom">
            <p>&copy; <?= date('Y') ?> WEBDEV. Все права защищены.</p>
            <!-- Заглушки счетчиков веб-аналитики: Яндекс.Метрика, Google Analytics и другие -->
            <div class="metrics-placeholder" aria-hidden="true">metrics-placeholder</div>
        </div>
    </footer>
</div>
</body>
</html>
