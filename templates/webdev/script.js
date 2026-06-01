// WEBDEV base script: safe global helpers without external dependencies.
(function () {
    'use strict';

    window.WebdevTemplate = window.WebdevTemplate || {};

    window.WebdevTemplate.onReady = function (callback) {
        if (typeof callback !== 'function') {
            return;
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', callback, { once: true });
        } else {
            callback();
        }
    };
}());
