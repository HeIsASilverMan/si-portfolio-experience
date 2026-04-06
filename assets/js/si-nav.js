document.addEventListener('DOMContentLoaded', function () {
    var toggle = document.querySelector('.si-nav-toggle');
    var nav    = document.querySelector('.si-nav');
    if (!toggle || !nav) return;

    toggle.addEventListener('click', function () {
        var open = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', !open);
        nav.classList.toggle('is-open', !open);
        document.body.style.overflow = open ? '' : 'hidden';
    });

    // Close on link click
    nav.querySelectorAll('.si-nav__link').forEach(function (link) {
        link.addEventListener('click', function () {
            toggle.setAttribute('aria-expanded', 'false');
            nav.classList.remove('is-open');
            document.body.style.overflow = '';
        });
    });

    // Close on Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && nav.classList.contains('is-open')) {
            toggle.setAttribute('aria-expanded', 'false');
            nav.classList.remove('is-open');
            document.body.style.overflow = '';
            toggle.focus();
        }
    });
});
