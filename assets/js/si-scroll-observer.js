document.addEventListener('DOMContentLoaded', function () {
    var els = document.querySelectorAll('.si-reveal');
    if (!els.length) return;

    if (!window.IntersectionObserver) {
        els.forEach(function (el) { el.classList.add('is-visible'); });
        return;
    }

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                var el = entry.target;
                var delay = el.dataset.delay || 0;
                setTimeout(function () {
                    el.classList.add('is-visible');
                }, delay);
                observer.unobserve(el);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

    els.forEach(function (el, i) {
        // Auto-stagger siblings
        if (!el.dataset.delay) {
            var parent = el.parentElement;
            var siblings = parent.querySelectorAll('.si-reveal');
            siblings.forEach(function (sib, j) {
                sib.dataset.delay = j * 80;
            });
        }
        observer.observe(el);
    });
});
