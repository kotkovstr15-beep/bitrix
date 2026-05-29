<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); } ?>
<div class="contacts-list" style="margin-top:18px">
<?php foreach ($arResult['ITEMS'] as $item): ?>
    <a class="contact-card" target="_blank" rel="nofollow noopener" href="<?= htmlspecialcharsbx($item['PROPERTIES']['URL']['VALUE']) ?>"><strong><?= htmlspecialcharsbx($item['PROPERTIES']['ICON']['VALUE']) ?> <?= htmlspecialcharsbx($item['NAME']) ?></strong></a>
<?php endforeach; ?>
</div>
