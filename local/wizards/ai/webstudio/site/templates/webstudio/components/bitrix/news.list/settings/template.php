<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); } ?>
<div class="settings-list">
<?php foreach ($arResult['ITEMS'] as $item): ?>
    <div class="settings-card"><h3><?= htmlspecialcharsbx($item['NAME']) ?></h3><p><?= nl2br(htmlspecialcharsbx($item['PROPERTIES']['VALUE']['~VALUE']['TEXT'] ?: $item['PREVIEW_TEXT'])) ?></p></div>
<?php endforeach; ?>
</div>
