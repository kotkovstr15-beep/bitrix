<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); } ?>
<div class="container cards-grid">
<?php foreach ($arResult['ITEMS'] as $item): $content = '<h3>' . htmlspecialcharsbx($item['NAME']) . '</h3><p>' . htmlspecialcharsbx($item['PREVIEW_TEXT']) . '</p><p>№ ' . htmlspecialcharsbx($item['PROPERTIES']['NUMBER']['VALUE']) . '</p>'; ?>
    <article class="certificate-card"><button type="button" data-certificate="<?= htmlspecialcharsbx($content) ?>"><p class="eyebrow">Сертификат</p><h3><?= htmlspecialcharsbx($item['NAME']) ?></h3><p class="meta">№ <?= htmlspecialcharsbx($item['PROPERTIES']['NUMBER']['VALUE']) ?></p></button></article>
<?php endforeach; ?>
</div><div class="modal"><div class="modal__box"></div></div>
