# AI WebStudio wizard для 1С-Битрикс

Разместите каталог `local/wizards/ai/webstudio` в корне сайта. В административной части откройте **Marketplace → Мастера установки** и запустите мастер **AI WebStudio**.

Мастер создаёт:

- структуру сайта: главная, о компании, услуги, статьи, контакты;
- тип инфоблоков `ai_webstudio_<SITE_ID>` и инфоблоки для баннеров, услуг, статей, сертификатов, соцсетей, контактов, настроек, SEO и заявок;
- демонстрационные элементы;
- меню `.top.menu.php` и `.bottom.menu.php`;
- шаблон `/local/templates/webstudio`;
- компонент `/local/components/ai/webstudio.feedback`;
- `robots.txt` и `sitemap.xml`.

Контент управляется через созданные инфоблоки. Форма обратной связи использует CSRF (`bitrix_sessid`), honeypot, серверную валидацию, email-событие `FEEDBACK_FORM` и сохраняет заявки в инфоблок.
