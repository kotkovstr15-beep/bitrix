<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); } ?>
<div class="contacts-list">
<?php foreach ($arResult['ITEMS'] as $item): ?>
    <div class="contact-card"><strong><?= htmlspecialcharsbx($item['NAME']) ?></strong><p><?= nl2br(htmlspecialcharsbx($item['PREVIEW_TEXT'])) ?></p></div>
<?php endforeach; ?>
</div>
