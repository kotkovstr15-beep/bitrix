<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); } ?>
<?php foreach ($arResult['ITEMS'] as $item): $bg = $item['PROPERTIES']['BACKGROUND']['VALUE'] ?: 'linear-gradient(135deg,#0f172a,#2563eb)'; ?>
<div class="hero" style="background: <?= htmlspecialcharsbx($bg) ?>">
    <div class="hero__inner">
        <p class="eyebrow">Bitrix development</p>
        <h1><?= htmlspecialcharsbx($item['NAME']) ?></h1>
        <p><?= htmlspecialcharsbx($item['PREVIEW_TEXT']) ?></p>
        <?php if ($item['PROPERTIES']['SUBTITLE']['~VALUE']['TEXT']): ?><p><?= htmlspecialcharsbx($item['PROPERTIES']['SUBTITLE']['~VALUE']['TEXT']) ?></p><?php endif; ?>
        <a class="btn" href="<?= htmlspecialcharsbx($item['PROPERTIES']['BUTTON_LINK']['VALUE'] ?: '/contacts/') ?>"><?= htmlspecialcharsbx($item['PROPERTIES']['BUTTON_TEXT']['VALUE'] ?: 'Связаться') ?> →</a>
    </div>
</div>
<?php endforeach; ?>
