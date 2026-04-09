( function () {
    'use strict';

    if ( window.siScrollReady ) { return; }
    window.siScrollReady = true;

    // ── Scroll progress bar ──────────────────────────────────
    var bar = document.createElement( 'div' );
    bar.className = 'si-scroll-progress';
    bar.setAttribute( 'aria-hidden', 'true' );
    document.body.appendChild( bar );

    // ── State ────────────────────────────────────────────────
    var scrollY  = 0;
    var ticking  = false;

    var heroBg    = document.querySelector( '.si-home-hero__bg' );
    var heroInner = document.querySelector( '.si-home-hero__inner' );
    var heroSplit = document.querySelector( '.si-home-hero__split' );
    var heroH     = heroInner ? heroInner.parentElement.offsetHeight : 0;

    // Promote parallax elements for GPU compositing
    if ( heroBg )    { heroBg.style.willChange    = 'transform'; }
    if ( heroInner ) { heroInner.style.willChange = 'transform, opacity'; }
    if ( heroSplit ) { heroSplit.style.willChange = 'transform'; }

    function tick() {
        ticking = false;

        // Progress bar
        var docH  = document.documentElement.scrollHeight - window.innerHeight;
        var pct   = docH > 0 ? scrollY / docH : 0;
        bar.style.transform = 'scaleX(' + Math.min( pct, 1 ) + ')';

        // Hero parallax — only while hero is in view
        if ( heroBg && scrollY < heroH * 1.2 ) {
            // Background drifts up at half scroll speed (depth illusion)
            heroBg.style.transform = 'translateY(' + ( scrollY * 0.5 ) + 'px)';
        }

        if ( heroInner && scrollY < heroH ) {
            // Content drifts up slightly and fades out
            var fade = Math.max( 0, 1 - scrollY / ( window.innerHeight * 0.65 ) );
            heroInner.style.transform = 'translateY(' + ( scrollY * 0.12 ) + 'px)';
            heroInner.style.opacity   = fade;
        }

        if ( heroSplit && scrollY < heroH ) {
            heroSplit.style.transform = 'translateY(' + ( scrollY * 0.08 ) + 'px)';
        }
    }

    window.addEventListener( 'scroll', function () {
        scrollY = window.pageYOffset;
        if ( ! ticking ) {
            requestAnimationFrame( tick );
            ticking = true;
        }
    }, { passive: true } );

    // ── Scroll reveal (.si-reveal) ───────────────────────────
    var revealEls = document.querySelectorAll( '.si-reveal' );
    if ( ! revealEls.length ) { return; }

    if ( ! window.IntersectionObserver ) {
        revealEls.forEach( function ( el ) { el.classList.add( 'is-visible' ); } );
        return;
    }

    // Auto-stagger: items inside known list containers get staggered delays
    var staggerRoots = document.querySelectorAll(
        '.si-reveal-group, .si-dual-showcase__inner, .si-tools-grid__list, ' +
        '.si-approach-cards__grid, .si-benefits-list__list, .si-ld-hero__stats'
    );
    staggerRoots.forEach( function ( root ) {
        root.querySelectorAll( '.si-reveal' ).forEach( function ( el, i ) {
            if ( ! el.dataset.delay ) {
                el.dataset.delay = i * 110;
            }
        } );
    } );

    var observer = new IntersectionObserver( function ( entries ) {
        entries.forEach( function ( entry ) {
            if ( ! entry.isIntersecting ) { return; }
            var el    = entry.target;
            var delay = parseInt( el.dataset.delay, 10 ) || 0;
            setTimeout( function () {
                el.classList.add( 'is-visible' );
            }, delay );
            observer.unobserve( el );
        } );
    }, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' } );

    revealEls.forEach( function ( el ) { observer.observe( el ); } );
} )();
