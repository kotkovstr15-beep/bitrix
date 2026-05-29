<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); } ?>
<div class="container cards-grid">
<?php foreach ($arResult['ITEMS'] as $item): ?>
    <article class="article-card">
        <p class="meta"><?= htmlspecialcharsbx($item['DISPLAY_ACTIVE_FROM'] ?: $item['DATE_ACTIVE_FROM']) ?></p>
        <h3><?= htmlspecialcharsbx($item['NAME']) ?></h3>
        <p><?= htmlspecialcharsbx($item['PREVIEW_TEXT']) ?></p>
        <a class="btn" href="<?= htmlspecialcharsbx($item['DETAIL_PAGE_URL']) ?>">Подробнее</a>
    </article>
<?php endforeach; ?>
</div>
