document.addEventListener('DOMContentLoaded', function () {
    if (!window.IntersectionObserver) return;

    var counters = document.querySelectorAll('[data-si-counter]');
    if (!counters.length) return;

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            observer.unobserve(entry.target);

            var el      = entry.target;
            var target  = parseFloat(el.dataset.siCounter);
            var dur     = 2000;
            var start   = null;

            function step(ts) {
                if (!start) start = ts;
                var p   = Math.min((ts - start) / dur, 1);
                var val = target * (1 - Math.pow(1 - p, 3));
                el.textContent = Number.isInteger(target)
                    ? Math.round(val)
                    : val.toFixed(1);
                if (p < 1) requestAnimationFrame(step);
                else el.textContent = target;
            }
            requestAnimationFrame(step);
        });
    }, { threshold: 0.5 });

    counters.forEach(function (el) { observer.observe(el); });
});
