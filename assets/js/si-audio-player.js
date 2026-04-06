( function () {
    if ( window.siAudioReady ) { return; }
    window.siAudioReady = true;

    var currentPlayer = null;

    function formatTime( secs ) {
        if ( isNaN( secs ) ) { return '--:--'; }
        var m = Math.floor( secs / 60 );
        var s = Math.floor( secs % 60 );
        return m + ':' + ( s < 10 ? '0' : '' ) + s;
    }

    function stopCurrent() {
        if ( !currentPlayer ) { return; }
        var card = currentPlayer;
        var audio = card.querySelector( '.si-audio-card__audio' );
        if ( audio ) { audio.pause(); }
        card.classList.remove( 'is-playing' );
        currentPlayer = null;
    }

    function initCard( card ) {
        var audio    = card.querySelector( '.si-audio-card__audio' );
        var btn      = card.querySelector( '.si-audio-card__play-btn' );
        var bar      = card.querySelector( '.si-audio-card__progress-bar' );
        var bgEl     = card.querySelector( '.si-audio-card__progress-bg' );
        var current  = card.querySelector( '.si-audio-card__current' );
        var duration = card.querySelector( '.si-audio-card__duration' );

        if ( !audio || !btn ) { return; }

        audio.addEventListener( 'loadedmetadata', function () {
            duration.textContent = formatTime( audio.duration );
        } );

        audio.addEventListener( 'timeupdate', function () {
            var pct = audio.duration ? ( audio.currentTime / audio.duration ) * 100 : 0;
            bar.style.width = pct + '%';
            current.textContent = formatTime( audio.currentTime );
        } );

        audio.addEventListener( 'ended', function () {
            card.classList.remove( 'is-playing' );
            currentPlayer = null;
            bar.style.width = '0%';
            current.textContent = '0:00';
        } );

        btn.addEventListener( 'click', function () {
            if ( card.classList.contains( 'is-playing' ) ) {
                audio.pause();
                card.classList.remove( 'is-playing' );
                currentPlayer = null;
            } else {
                stopCurrent();
                audio.play();
                card.classList.add( 'is-playing' );
                currentPlayer = card;
            }
        } );

        /* Scrubber */
        if ( bgEl ) {
            bgEl.addEventListener( 'click', function ( e ) {
                if ( !audio.duration ) { return; }
                var rect = bgEl.getBoundingClientRect();
                var pct  = ( e.clientX - rect.left ) / rect.width;
                audio.currentTime = pct * audio.duration;
            } );
        }
    }

    function init() {
        document.querySelectorAll( '.si-audio-card' ).forEach( initCard );
    }

    if ( document.readyState === 'loading' ) {
        document.addEventListener( 'DOMContentLoaded', init );
    } else {
        init();
    }
} )();
