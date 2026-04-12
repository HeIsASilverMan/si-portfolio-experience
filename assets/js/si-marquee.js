( function () {
    if ( window.siMarqueeReady ) { return; }
    window.siMarqueeReady = true;

    function initMarquees() {
        var marquees = document.querySelectorAll( '.si-marquee' );
        marquees.forEach( function ( marquee ) {
            var track = marquee.querySelector( '.si-marquee-track' );
            if ( !track ) { return; }

            var inner = document.createElement( 'div' );
            inner.className = 'si-marquee-inner';
            marquee.appendChild( inner );
            inner.appendChild( track );
            var clone = track.cloneNode( true );
            clone.setAttribute( 'aria-hidden', 'true' );
            inner.appendChild( clone );
        } );
    }

    if ( document.readyState === 'loading' ) {
        document.addEventListener( 'DOMContentLoaded', initMarquees );
    } else {
        initMarquees();
    }
} )();
