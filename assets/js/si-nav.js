( function () {
    // Guard against double execution (e.g. script enqueued twice)
    if ( window.siNavReady ) { return; }
    window.siNavReady = true;

    // ── Nav open / close ────────────────────────────────────────
    function initNav() {
        var toggle = document.querySelector( '.si-nav-toggle' );
        var nav    = document.querySelector( '.si-nav' );
        if ( !toggle || !nav ) { return; }

        var navLinks = nav.querySelectorAll( '.si-nav__link' );
        var navFocusable = [];

        function updateNavFocusable() {
            navFocusable = Array.prototype.slice.call(
                nav.querySelectorAll( 'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])' )
            );
            navFocusable.push( toggle );
        }

        function openNav() {
            toggle.setAttribute( 'aria-expanded', 'true' );
            toggle.setAttribute( 'aria-label', 'Close navigation' );
            nav.classList.add( 'is-open' );
            document.body.classList.add( 'si-nav-open' );
            document.body.style.overflow = 'hidden';
            updateNavFocusable();
            // Focus first nav link after animation settles
            setTimeout( function () {
                if ( navLinks.length ) { navLinks[0].focus(); }
            }, 200 );
        }

        function closeNav() {
            toggle.setAttribute( 'aria-expanded', 'false' );
            toggle.setAttribute( 'aria-label', 'Open navigation' );
            nav.classList.remove( 'is-open' );
            document.body.classList.remove( 'si-nav-open' );
            document.body.style.overflow = '';
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

        // Keyboard: Escape to close + focus trap
        document.addEventListener( 'keydown', function ( e ) {
            if ( !nav.classList.contains( 'is-open' ) ) { return; }

            if ( e.key === 'Escape' ) {
                closeNav();
                toggle.focus();
                return;
            }

            // Focus trap: keep Tab within nav + toggle
            if ( e.key === 'Tab' && navFocusable.length ) {
                var first = navFocusable[0];
                var last  = navFocusable[ navFocusable.length - 1 ];
                if ( e.shiftKey ) {
                    if ( document.activeElement === first ) {
                        e.preventDefault();
                        last.focus();
                    }
                } else {
                    if ( document.activeElement === last ) {
                        e.preventDefault();
                        first.focus();
                    }
                }
            }
        } );
    }

    if ( document.readyState === 'loading' ) {
        document.addEventListener( 'DOMContentLoaded', initNav );
    } else {
        initNav();
    }
} )();
