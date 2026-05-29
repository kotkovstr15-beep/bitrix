<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

IncludeModuleLangFile(__FILE__);
?>
<div class="ai-wizard">
    <div class="ai-wizard__header">
        <strong>AI WebStudio</strong>
        <span>готовый сайт веб-студии на 1С-Битрикс</span>
    </div>
    <div class="ai-wizard__content">
        <?= $content ?>
    </div>
</div>
<style>
.ai-wizard{font-family:Arial,sans-serif;max-width:920px}.ai-wizard__header{padding:18px 22px;background:#101828;color:#fff;border-radius:14px 14px 0 0}.ai-wizard__header strong{display:block;font-size:22px}.ai-wizard__header span{color:#cbd5e1}.ai-wizard__content{border:1px solid #e5e7eb;border-top:0;padding:24px;border-radius:0 0 14px 14px;background:#fff}
</style>
