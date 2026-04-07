( function () {
    // Guard against double execution (e.g. script enqueued twice)
    if ( window.siNavReady ) { return; }
    window.siNavReady = true;

    var logoOrigRect = null;

    // ── Logo animation ──────────────────────────────────────────
    function animateLogo( open ) {
        var logo = document.querySelector( '.si-site-header__logo' );
        if ( !logo ) { return; }

        var onHome = document.body.classList.contains( 'home' );

        if ( open ) {
            if ( onHome ) {
                // Home page: logo is hidden — conjure it at centre, grow in
                logo.style.cssText = [
                    'position:fixed',
                    'top:30%',
                    'left:50%',
                    'transform:translate(-50%,-50%) scale(0.5)',
                    'opacity:0',
                    'z-index:1000',
                    'transition:none',
                    'pointer-events:auto',
                    'margin:0'
                ].join( ';' );
                logo.offsetHeight; // reflow
                logo.style.transition = 'transform 0.65s cubic-bezier(0.16,1,0.3,1), opacity 0.4s ease';
                logo.style.transform  = 'translate(-50%,-50%) scale(2.5)';
                logo.style.opacity    = '1';
            } else {
                // Other pages: FLIP — snapshot position, then animate to centre
                logoOrigRect = logo.getBoundingClientRect();
                logo.style.cssText = [
                    'position:fixed',
                    'top:'    + logoOrigRect.top  + 'px',
                    'left:'   + logoOrigRect.left + 'px',
                    'width:'  + logoOrigRect.width + 'px',
                    'margin:0',
                    'z-index:1000',
                    'transition:none',
                    'opacity:1',
                    'pointer-events:auto'
                ].join( ';' );
                logo.offsetHeight; // reflow
                logo.style.transition = [
                    'top 0.6s cubic-bezier(0.16,1,0.3,1)',
                    'left 0.6s cubic-bezier(0.16,1,0.3,1)',
                    'transform 0.6s cubic-bezier(0.16,1,0.3,1)'
                ].join( ',' );
                logo.style.top       = '30%';
                logo.style.left      = '50%';
                logo.style.transform = 'translate(-50%,-50%) scale(2.5)';
            }
        } else {
            if ( onHome ) {
                // Home page: shrink + fade back out at centre
                logo.style.transition = 'transform 0.4s cubic-bezier(0.16,1,0.3,1), opacity 0.3s ease';
                logo.style.transform  = 'translate(-50%,-50%) scale(0.6)';
                logo.style.opacity    = '0';
                setTimeout( function () {
                    if ( !document.body.classList.contains( 'si-nav-open' ) ) {
                        logo.style.cssText = '';
                    }
                }, 420 );
            } else {
                // Other pages: animate back to header position
                if ( !logoOrigRect ) { logo.style.cssText = ''; return; }
                logo.style.transition = [
                    'top 0.45s cubic-bezier(0.16,1,0.3,1)',
                    'left 0.45s cubic-bezier(0.16,1,0.3,1)',
                    'transform 0.45s cubic-bezier(0.16,1,0.3,1)'
                ].join( ',' );
                logo.style.top       = logoOrigRect.top  + 'px';
                logo.style.left      = logoOrigRect.left + 'px';
                logo.style.transform = '';
                logoOrigRect = null;
                logo.addEventListener( 'transitionend', function onEnd( e ) {
                    if ( e.propertyName !== 'top' ) { return; }
                    logo.removeEventListener( 'transitionend', onEnd );
                    if ( !document.body.classList.contains( 'si-nav-open' ) ) {
                        logo.style.cssText = '';
                    }
                } );
            }
        }
    }

    // ── Nav open / close ────────────────────────────────────────
    function initNav() {
        var toggle = document.querySelector( '.si-nav-toggle' );
        var nav    = document.querySelector( '.si-nav' );
        if ( !toggle || !nav ) { return; }

        function openNav() {
            toggle.setAttribute( 'aria-expanded', 'true' );
            toggle.setAttribute( 'aria-label', 'Close navigation' );
            nav.classList.add( 'is-open' );
            document.body.classList.add( 'si-nav-open' );
            document.body.style.overflow = 'hidden';
            animateLogo( true );
        }

        function closeNav() {
            toggle.setAttribute( 'aria-expanded', 'false' );
            toggle.setAttribute( 'aria-label', 'Open navigation' );
            nav.classList.remove( 'is-open' );
            document.body.classList.remove( 'si-nav-open' );
            document.body.style.overflow = '';
            animateLogo( false );
        }

        toggle.addEventListener( 'click', function () {
            if ( toggle.getAttribute( 'aria-expanded' ) === 'true' ) {
                closeNav();
            } else {
                openNav();
            }
        } );

        // Close on any nav link click
        nav.querySelectorAll( '.si-nav__link' ).forEach( function ( link ) {
            link.addEventListener( 'click', closeNav );
        } );

        // Close on Escape
        document.addEventListener( 'keydown', function ( e ) {
            if ( e.key === 'Escape' && nav.classList.contains( 'is-open' ) ) {
                closeNav();
                toggle.focus();
            }
        } );
    }

    if ( document.readyState === 'loading' ) {
        document.addEventListener( 'DOMContentLoaded', initNav );
    } else {
        initNav();
    }
} )();
