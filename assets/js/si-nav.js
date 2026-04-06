( function () {
    // Guard against double execution (e.g. script enqueued twice)
    if ( window.siNavReady ) { return; }
    window.siNavReady = true;

    function initNav() {
        var toggle = document.querySelector( '.si-nav-toggle' );
        var nav    = document.querySelector( '.si-nav' );
        if ( !toggle || !nav ) { return; }

        function openNav() {
            toggle.setAttribute( 'aria-expanded', 'true' );
            toggle.setAttribute( 'aria-label', 'Close navigation' );
            nav.classList.add( 'is-open' );
            document.body.style.overflow = 'hidden';
        }

        function closeNav() {
            toggle.setAttribute( 'aria-expanded', 'false' );
            toggle.setAttribute( 'aria-label', 'Open navigation' );
            nav.classList.remove( 'is-open' );
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
