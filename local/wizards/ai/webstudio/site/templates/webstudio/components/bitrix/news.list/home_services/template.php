<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); } ?>
<div class="container cards-grid">
<?php foreach ($arResult['ITEMS'] as $item): ?>
    <article class="service-card">
        <div class="service-card__icon"><?= htmlspecialcharsbx($item['PROPERTIES']['ICON']['VALUE'] ?: '⚙️') ?></div>
        <h3><?= htmlspecialcharsbx($item['NAME']) ?></h3>
        <p><?= htmlspecialcharsbx($item['PREVIEW_TEXT']) ?></p>
        <p class="meta"><?= htmlspecialcharsbx($item['PROPERTIES']['PRICE']['VALUE']) ?> · <?= htmlspecialcharsbx($item['PROPERTIES']['TERM']['VALUE']) ?></p>
    </article>
<?php endforeach; ?>
</div>
