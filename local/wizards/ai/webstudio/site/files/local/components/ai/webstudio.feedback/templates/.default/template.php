<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); } ?>
<form class="feedback-form" method="post" action="<?= POST_FORM_ACTION_URI ?>" novalidate>
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="WEBSTUDIO_FEEDBACK" value="Y">
    <div style="position:absolute;left:-9999px" aria-hidden="true"><label>Сайт компании <input type="text" name="company_site" tabindex="-1" autocomplete="off"></label></div>
    <h3>Оставить заявку</h3>
    <?php if ($arResult['SUCCESS']): ?><div class="form-message ok">Спасибо! Заявка отправлена.</div><?php endif; ?>
    <?php foreach ($arResult['ERRORS'] as $error): ?><div class="form-message error"><?= htmlspecialcharsbx($error) ?></div><?php endforeach; ?>
    <label>Имя<input required type="text" name="name" value="<?= htmlspecialcharsbx($arResult['VALUES']['name'] ?? '') ?>"></label>
    <label>Телефон<input type="tel" name="phone" value="<?= htmlspecialcharsbx($arResult['VALUES']['phone'] ?? '') ?>"></label>
    <label>Email<input type="email" name="email" value="<?= htmlspecialcharsbx($arResult['VALUES']['email'] ?? '') ?>"></label>
    <label>Сообщение<textarea required name="message"><?= htmlspecialcharsbx($arResult['VALUES']['message'] ?? '') ?></textarea></label>
    <button class="btn" type="submit">Отправить заявку</button>
</form>
