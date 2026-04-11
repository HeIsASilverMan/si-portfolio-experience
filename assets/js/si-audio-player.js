( function () {
    'use strict';

    if ( window.siAudioReady ) { return; }
    window.siAudioReady = true;

    // ── Helpers ────────────────────────────────────────────
    function formatTime( s ) {
        if ( isNaN( s ) || s < 0 ) { return '0:00'; }
        var m = Math.floor( s / 60 );
        var sec = Math.floor( s % 60 );
        return m + ':' + ( sec < 10 ? '0' : '' ) + sec;
    }

    /* Deterministic waveform heights — gives each track index a unique
       but consistent shape that looks genuinely musical. */
    function waveHeights( seed, count ) {
        var h = [];
        for ( var i = 0; i < count; i++ ) {
            var x   = i / count;
            var v   = 0.45 + 0.45 * Math.sin( x * Math.PI * ( 2 + seed % 5 ) )
                         + 0.25 * Math.sin( x * Math.PI * ( 5 + seed % 3 ) * 1.7 )
                         + 0.1  * Math.sin( x * Math.PI * ( 11 + seed % 7 ) );
            h.push( Math.max( 8, Math.min( 100, Math.round( v * 100 ) ) ) );
        }
        return h;
    }

    // ── State ──────────────────────────────────────────────
    var tracks       = [];
    var currentIdx   = -1;
    var isPlaying    = false;
    var currentAudio = null;

    // ── DOM refs ───────────────────────────────────────────
    var stage, stageBg, stageGenre, stageDesc;
    var stageWaveform, stagePlay, stageScrub, stageFill, stageThumb;
    var stageCurrent, stageDuration;
    var miniPlayer;

    // ── Mini-player ────────────────────────────────────────
    function buildMiniPlayer() {
        var mp = document.createElement( 'div' );
        mp.id        = 'si-mini-player';
        mp.className = 'si-mini-player';
        mp.setAttribute( 'aria-label', 'Now playing' );
        mp.innerHTML =
            '<div class="si-mini-player__waveform" aria-hidden="true">' +
                '<span></span><span></span><span></span>' +
                '<span></span><span></span>' +
            '</div>' +
            '<div class="si-mini-player__info">' +
                '<span class="si-mini-player__title"></span>' +
                '<div class="si-mini-player__scrub">' +
                    '<div class="si-mini-player__fill"></div>' +
                '</div>' +
            '</div>' +
            '<span class="si-mini-player__time">0:00</span>' +
            '<button class="si-mini-player__btn" aria-label="Pause">' +
                '<svg class="si-play-icon" viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M8 5.14v14l11-7-11-7z"/></svg>' +
                '<svg class="si-pause-icon" viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>' +
            '</button>';
        document.body.appendChild( mp );

        mp.querySelector( '.si-mini-player__btn' ).addEventListener( 'click', togglePlay );
        mp.querySelector( '.si-mini-player__scrub' ).addEventListener( 'click', function ( e ) {
            if ( ! currentAudio || ! currentAudio.duration ) { return; }
            var r = this.getBoundingClientRect();
            currentAudio.currentTime = ( ( e.clientX - r.left ) / r.width ) * currentAudio.duration;
        } );
        return mp;
    }

    function showMiniPlayer( title ) {
        if ( ! miniPlayer ) { miniPlayer = buildMiniPlayer(); }
        miniPlayer.querySelector( '.si-mini-player__title' ).textContent = title;
        miniPlayer.classList.add( 'is-visible', 'is-playing' );
        miniPlayer.querySelector( '.si-mini-player__btn' ).setAttribute( 'aria-label', 'Pause' );
    }

    function pauseMiniPlayer() {
        if ( ! miniPlayer ) { return; }
        miniPlayer.classList.remove( 'is-playing' );
        miniPlayer.querySelector( '.si-mini-player__btn' ).setAttribute( 'aria-label', 'Play' );
    }

    function hideMiniPlayer() {
        if ( ! miniPlayer ) { return; }
        miniPlayer.classList.remove( 'is-visible', 'is-playing' );
    }

    function updateMiniProgress( audio ) {
        if ( ! miniPlayer ) { return; }
        var pct = audio.duration ? ( audio.currentTime / audio.duration ) * 100 : 0;
        miniPlayer.querySelector( '.si-mini-player__fill' ).style.width = pct + '%';
        miniPlayer.querySelector( '.si-mini-player__time' ).textContent  = formatTime( audio.currentTime );
    }

    // ── Waveform render ────────────────────────────────────
    function renderWaveform( seed ) {
        if ( ! stageWaveform ) { return; }
        var heights = waveHeights( seed, 60 );
        stageWaveform.innerHTML = '';
        heights.forEach( function ( h ) {
            var s = document.createElement( 'span' );
            s.style.height = h + '%';
            stageWaveform.appendChild( s );
        } );
    }

    // ── Load a track into the stage ────────────────────────
    function loadTrack( idx, autoplay ) {
        if ( idx < 0 || idx >= tracks.length ) { return; }
        var track = tracks[ idx ];

        // Stop whatever is currently playing
        if ( currentAudio ) {
            currentAudio.pause();
            currentAudio.currentTime = 0;
        }
        isPlaying    = false;
        currentIdx   = idx;
        currentAudio = track.audio;

        // Stage background
        if ( stageBg ) {
            if ( track.thumb ) {
                stageBg.style.backgroundImage = 'url(' + track.thumb + ')';
                stageBg.style.opacity = '1';
            } else {
                stageBg.style.backgroundImage = 'none';
                stageBg.style.opacity = '0';
            }
        }

        // Stage text
        if ( stageGenre ) {
            stageGenre.textContent   = track.genre;
            stageGenre.style.display = track.genre ? '' : 'none';
        }
        if ( stageDesc ) {
            stageDesc.textContent = track.description;
        }

        // Waveform
        renderWaveform( idx );

        // Reset controls
        if ( stageFill     ) { stageFill.style.width       = '0%';    }
        if ( stageThumb    ) { stageThumb.style.left        = '0%';    }
        if ( stageCurrent  ) { stageCurrent.textContent     = '0:00'; }
        if ( stageDuration ) { stageDuration.textContent    = track.duration || '--:--'; }
        if ( stagePlay     ) { stagePlay.classList.remove( 'is-playing' ); }
        if ( stage         ) { stage.classList.remove( 'is-playing' ); }

        // Active track highlight
        tracks.forEach( function ( t, i ) {
            t.el.classList.toggle( 'is-active', i === idx );
            t.el.classList.remove( 'is-playing' );
        } );

        // Autoplay
        if ( autoplay && currentAudio ) {
            currentAudio.play().then( function () {
                isPlaying = true;
                if ( stagePlay ) { stagePlay.classList.add( 'is-playing' ); }
                if ( stage     ) { stage.classList.add( 'is-playing' ); }
                track.el.classList.add( 'is-playing' );
                showMiniPlayer( track.title );
            } ).catch( function () {} );
        }
    }

    // ── Play / pause ───────────────────────────────────────
    function togglePlay() {
        if ( currentIdx < 0 && tracks.length ) {
            loadTrack( 0, true );
            return;
        }
        if ( ! currentAudio ) { return; }

        if ( isPlaying ) {
            currentAudio.pause();
            isPlaying = false;
            if ( stagePlay ) { stagePlay.classList.remove( 'is-playing' ); }
            if ( stage     ) { stage.classList.remove( 'is-playing' ); }
            if ( tracks[ currentIdx ] ) { tracks[ currentIdx ].el.classList.remove( 'is-playing' ); }
            pauseMiniPlayer();
        } else {
            currentAudio.play().then( function () {
                isPlaying = true;
                if ( stagePlay ) { stagePlay.classList.add( 'is-playing' ); }
                if ( stage     ) { stage.classList.add( 'is-playing' ); }
                if ( tracks[ currentIdx ] ) { tracks[ currentIdx ].el.classList.add( 'is-playing' ); }
                showMiniPlayer( tracks[ currentIdx ].title );
            } ).catch( function () {} );
        }
    }

    // ── Init ───────────────────────────────────────────────
    function init() {
        stage        = document.getElementById( 'si-audio-stage'   );
        if ( ! stage ) { return; }

        stageBg       = document.getElementById( 'si-stage-bg'       );
        stageGenre    = document.getElementById( 'si-stage-genre'    );
        stageDesc     = document.getElementById( 'si-stage-desc'     );
        stageWaveform = document.getElementById( 'si-stage-waveform' );
        stagePlay     = document.getElementById( 'si-stage-play'     );
        stageScrub    = document.getElementById( 'si-stage-scrub'    );
        stageFill     = document.getElementById( 'si-stage-fill'     );
        stageThumb    = document.getElementById( 'si-stage-thumb'    );
        stageCurrent  = document.getElementById( 'si-stage-current'  );
        stageDuration = document.getElementById( 'si-stage-duration' );

        // Gather track items
        var trackList = document.getElementById( 'si-tracklist' );
        if ( ! trackList ) { return; }

        var items = trackList.querySelectorAll( '.si-track-item' );
        items.forEach( function ( el, i ) {
            var audio = el.querySelector( '.si-track-audio' );
            var t = {
                el:          el,
                audio:       audio || null,
                title:       el.dataset.title       || '',
                client:      el.dataset.client      || '',
                year:        el.dataset.year        || '',
                genre:       el.dataset.genre       || '',
                description: el.dataset.description || '',
                thumb:       el.dataset.thumb       || '',
                duration:    ''
            };
            tracks.push( t );

            // Load metadata to get duration
            if ( audio ) {
                audio.preload = 'metadata';
                audio.addEventListener( 'loadedmetadata', function () {
                    t.duration = formatTime( audio.duration );
                    var durEl  = el.querySelector( '.si-track-item__dur' );
                    if ( durEl ) { durEl.textContent = t.duration; }
                    if ( currentIdx === i && stageDuration ) {
                        stageDuration.textContent = t.duration;
                    }
                } );

                audio.addEventListener( 'timeupdate', function () {
                    if ( currentIdx !== i ) { return; }
                    var pct = audio.duration ? ( audio.currentTime / audio.duration ) * 100 : 0;
                    if ( stageFill    ) { stageFill.style.width   = pct + '%'; }
                    if ( stageThumb   ) { stageThumb.style.left   = Math.min( pct, 98 ) + '%'; }
                    if ( stageScrub   ) { stageScrub.setAttribute( 'aria-valuenow', Math.round( pct ) ); }
                    if ( stageCurrent ) { stageCurrent.textContent = formatTime( audio.currentTime ); }
                    updateMiniProgress( audio );
                } );

                audio.addEventListener( 'ended', function () {
                    if ( currentIdx !== i ) { return; }
                    isPlaying = false;
                    if ( stagePlay ) { stagePlay.classList.remove( 'is-playing' ); }
                    if ( stage     ) { stage.classList.remove( 'is-playing' ); }
                    el.classList.remove( 'is-playing' );
                    // Auto-advance to next track
                    if ( currentIdx < tracks.length - 1 ) {
                        loadTrack( currentIdx + 1, true );
                    } else {
                        hideMiniPlayer();
                    }
                } );
            }

            // Click track item to load + play
            el.addEventListener( 'click', function () {
                if ( currentIdx === i ) { togglePlay(); } else { loadTrack( i, true ); }
            } );
            el.addEventListener( 'keydown', function ( e ) {
                if ( e.key === 'Enter' || e.key === ' ' ) { e.preventDefault(); el.click(); }
            } );
        } );

        // Stage play button
        if ( stagePlay ) { stagePlay.addEventListener( 'click', togglePlay ); }

        // Scrubber click + keyboard
        if ( stageScrub ) {
            stageScrub.addEventListener( 'click', function ( e ) {
                if ( ! currentAudio || ! currentAudio.duration ) { return; }
                var r = stageScrub.getBoundingClientRect();
                currentAudio.currentTime = ( ( e.clientX - r.left ) / r.width ) * currentAudio.duration;
            } );
            stageScrub.addEventListener( 'keydown', function ( e ) {
                if ( ! currentAudio || ! currentAudio.duration ) { return; }
                var step = currentAudio.duration * 0.02;
                if ( e.key === 'ArrowRight' || e.key === 'ArrowUp'   ) { currentAudio.currentTime = Math.min( currentAudio.currentTime + step, currentAudio.duration ); }
                if ( e.key === 'ArrowLeft'  || e.key === 'ArrowDown' ) { currentAudio.currentTime = Math.max( currentAudio.currentTime - step, 0 ); }
            } );
        }

        // Keyboard: left/right arrows to switch tracks when stage is focused
        stage.addEventListener( 'keydown', function ( e ) {
            if ( e.target.closest( '#si-stage-scrub' ) ) { return; }
            if ( e.key === 'ArrowRight' ) { loadTrack( currentIdx + 1, isPlaying ); }
            if ( e.key === 'ArrowLeft'  ) { loadTrack( currentIdx - 1, isPlaying ); }
        } );

        // Load first track (no autoplay — let user initiate)
        if ( tracks.length ) { loadTrack( 0, false ); }
    }

    // ── Home page mini player ──────────────────────────────
    function initHomePlayer() {
        var player = document.getElementById( 'si-home-player' );
        if ( ! player ) { return; }

        var audio = document.getElementById( 'si-home-audio' );
        var btn   = document.getElementById( 'si-home-play'  );
        var fill  = document.getElementById( 'si-home-fill'  );
        var time  = document.getElementById( 'si-home-time'  );
        var bar   = player.querySelector( '.si-home-player__bar' );

        if ( ! audio || ! btn ) { return; }

        btn.addEventListener( 'click', function () {
            if ( audio.paused ) {
                audio.play().then( function () {
                    player.classList.add( 'is-playing' );
                    btn.setAttribute( 'aria-label', 'Pause' );
                } ).catch( function () {} );
            } else {
                audio.pause();
                player.classList.remove( 'is-playing' );
                btn.setAttribute( 'aria-label', 'Play' );
            }
        } );

        audio.addEventListener( 'timeupdate', function () {
            var pct = audio.duration ? ( audio.currentTime / audio.duration ) * 100 : 0;
            if ( fill ) { fill.style.width    = pct + '%'; }
            if ( time ) { time.textContent    = formatTime( audio.currentTime ); }
        } );

        audio.addEventListener( 'ended', function () {
            player.classList.remove( 'is-playing' );
            btn.setAttribute( 'aria-label', 'Play' );
            if ( fill ) { fill.style.width = '0%'; }
            if ( time ) { time.textContent = '0:00'; }
        } );

        if ( bar ) {
            bar.addEventListener( 'click', function ( e ) {
                if ( ! audio.duration ) { return; }
                var r = bar.getBoundingClientRect();
                audio.currentTime = ( ( e.clientX - r.left ) / r.width ) * audio.duration;
            } );
        }
    }

    if ( document.readyState === 'loading' ) {
        document.addEventListener( 'DOMContentLoaded', init );
        document.addEventListener( 'DOMContentLoaded', initHomePlayer );
    } else {
        init();
        initHomePlayer();
    }
} )();
