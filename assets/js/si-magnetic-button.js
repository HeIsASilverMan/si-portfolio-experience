document.addEventListener('DOMContentLoaded', function () {
    var btns = document.querySelectorAll('.si-btn--magnetic');

    btns.forEach(function (btn) {
        btn.addEventListener('mousemove', function (e) {
            var rect = btn.getBoundingClientRect();
            var x    = e.clientX - rect.left - rect.width  / 2;
            var y    = e.clientY - rect.top  - rect.height / 2;
            btn.style.transform = 'translate(' + (x * 0.3) + 'px, ' + (y * 0.3) + 'px)';
        });

        btn.addEventListener('mouseleave', function () {
            btn.style.transform = 'translate(0, 0)';
        });
    });
});
