<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); } ?>
<ul class="menu">
<?php foreach ($arResult as $item): ?>
    <li class="<?= $item['SELECTED'] ? 'selected' : '' ?>"><a href="<?= htmlspecialcharsbx($item['LINK']) ?>"><?= htmlspecialcharsbx($item['TEXT']) ?></a></li>
<?php endforeach; ?>
</ul>
