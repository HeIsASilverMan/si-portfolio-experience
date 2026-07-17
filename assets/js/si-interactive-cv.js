/**
 * SI Interactive CV
 *
 * Powers the [si_interactive_cv] module:
 *   - expandable experience roles (accordion)
 *   - toolkit tabs (click + arrow-key navigation)
 *   - knowledge-check quiz (every answer is "correct")
 *   - fixed course-player HUD: scroll progress, lesson markers,
 *     show/hide as the module enters and leaves the viewport
 *
 * Vanilla JS, no dependencies. Respects prefers-reduced-motion.
 */
( function () {
    'use strict';

    if ( window.siInteractiveCvReady ) { return; }
    window.siInteractiveCvReady = true;

    var reduceMotion = window.matchMedia
        && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

    function init() {
        var root = document.getElementById( 'si-cv' );
        if ( ! root ) { return; }

        initJobs( root );
        initToolkit( root );
        initQuiz( root );
        initHud( root );
    }

    /* -- Experience accordion --------------------------------- */
    function initJobs( root ) {
        var heads = root.querySelectorAll( '.si-cv-job__head' );
        heads.forEach( function ( head ) {
            head.addEventListener( 'click', function () {
                var job = head.closest( '.si-cv-job' );
                if ( ! job ) { return; }
                var open = job.classList.toggle( 'is-open' );
                head.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
            } );
        } );
    }

    /* -- Toolkit tabs ----------------------------------------- */
    function initToolkit( root ) {
        var tabs = Array.prototype.slice.call(
            root.querySelectorAll( '.si-cv-toolkit__tab' )
        );
        if ( ! tabs.length ) { return; }

        function select( tab ) {
            tabs.forEach( function ( t ) {
                var active = t === tab;
                t.classList.toggle( 'is-active', active );
                t.setAttribute( 'aria-selected', active ? 'true' : 'false' );
                t.setAttribute( 'tabindex', active ? '0' : '-1' );

                var panel = document.getElementById(
                    t.getAttribute( 'aria-controls' )
                );
                if ( panel ) {
                    panel.classList.toggle( 'is-active', active );
                    if ( active ) {
                        panel.removeAttribute( 'hidden' );
                    } else {
                        panel.setAttribute( 'hidden', '' );
                    }
                }
            } );
        }

        tabs.forEach( function ( tab, i ) {
            tab.addEventListener( 'click', function () { select( tab ); } );
            tab.addEventListener( 'keydown', function ( e ) {
                var next = null;
                if ( e.key === 'ArrowRight' || e.key === 'ArrowDown' ) {
                    next = tabs[ ( i + 1 ) % tabs.length ];
                } else if ( e.key === 'ArrowLeft' || e.key === 'ArrowUp' ) {
                    next = tabs[ ( i - 1 + tabs.length ) % tabs.length ];
                } else if ( e.key === 'Home' ) {
                    next = tabs[ 0 ];
                } else if ( e.key === 'End' ) {
                    next = tabs[ tabs.length - 1 ];
                }
                if ( next ) {
                    e.preventDefault();
                    select( next );
                    next.focus();
                }
            } );
        } );
    }

    /* -- Knowledge check -------------------------------------- */
    function initQuiz( root ) {
        var opts   = root.querySelectorAll( '.si-cv-quiz__opt' );
        var result = document.getElementById( 'si-cv-quiz-result' );
        if ( ! opts.length || ! result ) { return; }

        opts.forEach( function ( opt ) {
            opt.addEventListener( 'click', function () {
                opts.forEach( function ( o ) { o.classList.remove( 'is-correct' ); } );
                opt.classList.add( 'is-correct' );
                result.hidden = false;
                // Mark the module as complete on the HUD.
                document.dispatchEvent( new CustomEvent( 'si-cv:complete' ) );
            } );
        } );
    }

    /* -- Fixed course-player HUD ------------------------------ */
    function initHud( root ) {
        var hud = document.getElementById( 'si-cv-hud' );
        if ( ! hud ) { return; }
        hud.hidden = false;

        var fill    = document.getElementById( 'si-cv-hud-fill' );
        var pct     = document.getElementById( 'si-cv-hud-pct' );
        var markers = Array.prototype.slice.call(
            hud.querySelectorAll( '.si-cv-hud__marker' )
        );
        var lessons = Array.prototype.slice.call(
            root.querySelectorAll( '.si-cv-lesson' )
        );

        var completed = false;
        var ticking   = false;

        // Smooth-scroll for marker + in-module anchor clicks.
        function anchorHandler( e ) {
            var href = this.getAttribute( 'href' ) || '';
            if ( href.charAt( 0 ) !== '#' ) { return; }
            var el = document.getElementById( href.slice( 1 ) );
            if ( ! el ) { return; }
            e.preventDefault();
            el.scrollIntoView( {
                behavior: reduceMotion ? 'auto' : 'smooth',
                block: 'start'
            } );
        }
        markers.forEach( function ( m ) {
            m.addEventListener( 'click', anchorHandler );
        } );
        root.querySelectorAll( '.si-cv__start' ).forEach( function ( a ) {
            a.addEventListener( 'click', anchorHandler );
        } );

        function tick() {
            ticking = false;

            var rect     = root.getBoundingClientRect();
            var vh       = window.innerHeight || document.documentElement.clientHeight;

            // Show the HUD while any part of the module is on screen.
            var inView = rect.top < vh * 0.6 && rect.bottom > vh * 0.4;
            hud.classList.toggle( 'is-visible', inView );

            // Progress: how far the module top has travelled past the
            // viewport middle, clamped to the module's scrollable range.
            var range = rect.height - vh;
            var p     = range > 0 ? ( -rect.top ) / range : ( rect.top < 0 ? 1 : 0 );
            p = Math.max( 0, Math.min( 1, p ) );

            var shown = completed ? 100 : Math.round( p * 100 );
            if ( fill ) { fill.style.width = shown + '%'; }
            if ( pct )  { pct.textContent = shown + '%'; }

            // Update lesson markers (reached + current).
            var mid     = vh * 0.5;
            var current = -1;
            lessons.forEach( function ( lesson, i ) {
                var lr = lesson.getBoundingClientRect();
                if ( lr.top <= mid ) { current = i; }
            } );
            markers.forEach( function ( m, i ) {
                m.classList.toggle( 'is-reached', completed || i <= current );
                m.classList.toggle( 'is-current', ! completed && i === current );
            } );
        }

        function requestTick() {
            if ( ! ticking ) {
                window.requestAnimationFrame( tick );
                ticking = true;
            }
        }

        document.addEventListener( 'si-cv:complete', function () {
            completed = true;
            hud.classList.add( 'is-complete' );
            markers.forEach( function ( m ) {
                m.classList.add( 'is-reached' );
                m.classList.remove( 'is-current' );
            } );
            if ( fill ) { fill.style.width = '100%'; }
            if ( pct )  { pct.textContent = '100%'; }
        } );

        window.addEventListener( 'scroll', requestTick, { passive: true } );
        window.addEventListener( 'resize', requestTick );
        tick();
    }

    if ( document.readyState === 'loading' ) {
        document.addEventListener( 'DOMContentLoaded', init );
    } else {
        init();
    }
} )();
