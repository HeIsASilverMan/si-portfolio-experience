( function () {
    'use strict';

    if ( window.siAudioReady ) { return; }
    window.siAudioReady = true;

    var currentCard  = null;
    var miniPlayer   = null;

    // ── Helpers ────────────────────────────────────────────────
    function formatTime( secs ) {
        if ( isNaN( secs ) || secs < 0 ) { return '0:00'; }
        var m = Math.floor( secs / 60 );
        var s = Math.floor( secs % 60 );
        return m + ':' + ( s < 10 ? '0' : '' ) + s;
    }

    // ── Mini-player ────────────────────────────────────────────
    function buildMiniPlayer() {
        var mp = document.createElement( 'div' );
        mp.className  = 'si-mini-player';
        mp.id         = 'si-mini-player';
        mp.setAttribute( 'aria-label', 'Now playing' );
        mp.innerHTML  =
            '<div class="si-mini-player__waveform" aria-hidden="true">' +
                '<span></span><span></span><span></span><span></span><span></span>' +
                '<span></span><span></span><span></span><span></span><span></span>' +
            '</div>' +
            '<div class="si-mini-player__info">' +
                '<span class="si-mini-player__title"></span>' +
                '<div class="si-mini-player__scrub" aria-hidden="true">' +
                    '<div class="si-mini-player__fill"></div>' +
                '</div>' +
            '</div>' +
            '<span class="si-mini-player__time">0:00</span>' +
            '<button class="si-mini-player__btn" aria-label="Pause">' +
                '<svg class="si-play-icon" viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M8 5.14v14l11-7-11-7z"/></svg>' +
                '<svg class="si-pause-icon" viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>' +
            '</button>';
        document.body.appendChild( mp );

        var btn   = mp.querySelector( '.si-mini-player__btn' );
        var scrub = mp.querySelector( '.si-mini-player__scrub' );

        btn.addEventListener( 'click', function () {
            if ( ! currentCard ) { return; }
            var audio = currentCard.querySelector( '.si-audio-card__audio' );
            if ( ! audio ) { return; }
            if ( audio.paused ) {
                audio.play();
                currentCard.classList.add( 'is-playing' );
                mp.classList.add( 'is-playing' );
                btn.setAttribute( 'aria-label', 'Pause' );
            } else {
                audio.pause();
                currentCard.classList.remove( 'is-playing' );
                mp.classList.remove( 'is-playing' );
                btn.setAttribute( 'aria-label', 'Play' );
            }
        } );

        scrub.addEventListener( 'click', function ( e ) {
            if ( ! currentCard ) { return; }
            var audio = currentCard.querySelector( '.si-audio-card__audio' );
            if ( ! audio || ! audio.duration ) { return; }
            var rect = scrub.getBoundingClientRect();
            audio.currentTime = ( ( e.clientX - rect.left ) / rect.width ) * audio.duration;
        } );

        return mp;
    }

    function showMiniPlayer( title ) {
        if ( ! miniPlayer ) { miniPlayer = buildMiniPlayer(); }
        miniPlayer.querySelector( '.si-mini-player__title' ).textContent = title;
        miniPlayer.classList.add( 'is-playing' );
        miniPlayer.classList.add( 'is-visible' );
        miniPlayer.querySelector( '.si-mini-player__btn' ).setAttribute( 'aria-label', 'Pause' );
    }

    function hideMiniPlayer() {
        if ( ! miniPlayer ) { return; }
        miniPlayer.classList.remove( 'is-visible', 'is-playing' );
    }

    function updateMiniPlayer( audio ) {
        if ( ! miniPlayer ) { return; }
        var pct  = audio.duration ? ( audio.currentTime / audio.duration ) * 100 : 0;
        miniPlayer.querySelector( '.si-mini-player__fill' ).style.width = pct + '%';
        miniPlayer.querySelector( '.si-mini-player__time' ).textContent  = formatTime( audio.currentTime );
    }

    function stopCurrent() {
        if ( ! currentCard ) { return; }
        var audio = currentCard.querySelector( '.si-audio-card__audio' );
        if ( audio ) { audio.pause(); }
        currentCard.classList.remove( 'is-playing' );
        currentCard = null;
        hideMiniPlayer();
    }

    // ── Per-card init ──────────────────────────────────────────
    function initCard( card ) {
        var audio    = card.querySelector( '.si-audio-card__audio' );
        var btn      = card.querySelector( '.si-audio-card__play-btn' );
        var bar      = card.querySelector( '.si-audio-card__progress-bar' );
        var bgEl     = card.querySelector( '.si-audio-card__progress-bg' );
        var current  = card.querySelector( '.si-audio-card__current' );
        var duration = card.querySelector( '.si-audio-card__duration' );
        var titleEl  = card.querySelector( '.si-audio-card__title' );

        if ( ! btn ) { return; }
        if ( ! audio ) { return; }

        audio.addEventListener( 'loadedmetadata', function () {
            if ( duration ) { duration.textContent = formatTime( audio.duration ); }
        } );

        audio.addEventListener( 'timeupdate', function () {
            var pct = audio.duration ? ( audio.currentTime / audio.duration ) * 100 : 0;
            if ( bar ) { bar.style.width = pct + '%'; }
            if ( current ) { current.textContent = formatTime( audio.currentTime ); }
            if ( currentCard === card ) { updateMiniPlayer( audio ); }
        } );

        audio.addEventListener( 'ended', function () {
            card.classList.remove( 'is-playing' );
            if ( bar ) { bar.style.width = '0%'; }
            if ( current ) { current.textContent = '0:00'; }
            currentCard = null;
            hideMiniPlayer();
        } );

        btn.addEventListener( 'click', function () {
            if ( card.classList.contains( 'is-playing' ) ) {
                audio.pause();
                card.classList.remove( 'is-playing' );
                currentCard = null;
                hideMiniPlayer();
            } else {
                stopCurrent();
                audio.play();
                card.classList.add( 'is-playing' );
                currentCard = card;
                showMiniPlayer( titleEl ? titleEl.textContent : '' );
            }
        } );

        if ( bgEl ) {
            bgEl.addEventListener( 'click', function ( e ) {
                if ( ! audio.duration ) { return; }
                var rect = bgEl.getBoundingClientRect();
                audio.currentTime = ( ( e.clientX - rect.left ) / rect.width ) * audio.duration;
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
