<?php

namespace Vendor\SiteWizard\Step;

final class WizardUi
{
    private static bool $stylesPrinted = false;

    public static function printStyles(): void
    {
        if (self::$stylesPrinted) {
            return;
        }

        self::$stylesPrinted = true;

        echo '<style>
            .vsw-card{max-width:820px;background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:20px;margin:12px 0;font:14px/1.5 -apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Arial,sans-serif;color:#111827}
            .vsw-title{margin:0 0 10px;font-size:18px;font-weight:600}
            .vsw-muted{color:#6b7280}
            .vsw-grid{display:grid;grid-template-columns:1fr;gap:10px}
            .vsw-input,.vsw-select{width:100%;max-width:420px;padding:8px 10px;border:1px solid #d1d5db;border-radius:8px;box-sizing:border-box}
            .vsw-checklist{padding-left:18px;margin:8px 0 0}
            .vsw-ok{color:#166534}
            .vsw-bad{color:#991b1b}
            .vsw-option{display:block;padding:10px;border:1px solid #e5e7eb;border-radius:8px;max-width:520px}
        </style>';
    }
}
