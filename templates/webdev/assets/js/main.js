// WEBDEV main interactions: burger menu, smooth anchors and reveal animations.
window.WebdevTemplate.onReady(function () {
    'use strict';

    var burger = document.querySelector('.burger');
    var nav = document.querySelector('.main-nav');

    if (burger && nav) {
        burger.addEventListener('click', function () {
            var isOpen = nav.classList.toggle('is-open');
            burger.classList.toggle('is-active', isOpen);
            burger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        nav.addEventListener('click', function (event) {
            if (event.target.closest('a')) {
                nav.classList.remove('is-open');
                burger.classList.remove('is-active');
                burger.setAttribute('aria-expanded', 'false');
            }
        });
    }

    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
        link.addEventListener('click', function (event) {
            var targetId = link.getAttribute('href');
            var target = targetId.length > 1 ? document.querySelector(targetId) : null;

            if (!target) {
                return;
            }

            event.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    var animatedItems = document.querySelectorAll('[data-animate]');

    if ('IntersectionObserver' in window && animatedItems.length > 0) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.16 });

        animatedItems.forEach(function (item) {
            observer.observe(item);
        });
    } else {
        animatedItems.forEach(function (item) {
            item.classList.add('is-visible');
        });
    }
});
