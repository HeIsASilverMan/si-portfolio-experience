document.addEventListener('DOMContentLoaded', function () {
    var marquees = document.querySelectorAll('.si-marquee-track');
    marquees.forEach(function (track) {
        var clone = track.cloneNode(true);
        track.parentNode.appendChild(clone);
    });
});
