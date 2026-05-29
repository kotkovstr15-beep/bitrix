<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
</main>
<footer class="site-footer">
    <div class="container footer-grid">
        <div><a class="logo" href="/"><span>BX</span>Studio</a><p>Разработка сайтов, магазинов и порталов на 1С-Битрикс.</p></div>
        <nav aria-label="Нижнее меню"><?php $APPLICATION->IncludeComponent('bitrix:menu', 'bottom', ['ROOT_MENU_TYPE' => 'bottom', 'MAX_LEVEL' => '1', 'CHILD_MENU_TYPE' => 'left', 'USE_EXT' => 'N', 'MENU_CACHE_TYPE' => 'A', 'MENU_CACHE_TIME' => '36000000'], false); ?></nav>
    </div>
</footer>
</body>
</html>
