<?php
/**
 * Service cards template for bitrix:news.list.
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$this->setFrameMode(true);
?>
<div class="services-grid">
    <?php foreach ($arResult['ITEMS'] as $item): ?>
        <?php
        $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item['IBLOCK_ID'], 'ELEMENT_EDIT'));
        $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item['IBLOCK_ID'], 'ELEMENT_DELETE'), ['CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')]);
        $detailUrl = $item['DETAIL_PAGE_URL'] ?: '#';
        ?>
        <article class="service-card" id="<?= $this->GetEditAreaId($item['ID']) ?>" data-animate>
            <div class="service-card__icon" aria-hidden="true"><?= htmlspecialcharsbx($item['ICON']) ?></div>
            <h3 class="service-card__title"><?= htmlspecialcharsbx($item['NAME']) ?></h3>
            <?php if (!empty($item['PREVIEW_TEXT'])): ?>
                <div class="service-card__text"><?= $item['PREVIEW_TEXT'] ?></div>
            <?php endif; ?>
            <a class="service-card__link" href="<?= htmlspecialcharsbx($detailUrl) ?>">Подробнее →</a>
        </article>
    <?php endforeach; ?>
</div>
