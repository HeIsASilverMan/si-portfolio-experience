/**
 * SI Portfolio Filter
 *
 * Handles filter pill clicks and shows/hides project cards
 * based on their data-cats attribute.
 *
 * Cards use class `is-hidden` when filtered out.
 */
( function () {
    'use strict';

    function init() {
        var filter = document.querySelector( '.si-portfolio-filter' );
        if ( ! filter ) return;

        var pills = filter.querySelectorAll( '.si-portfolio-filter__pill' );
        var cards = document.querySelectorAll( '#si-portfolio-grid-cards .si-project-card' );

        if ( ! pills.length || ! cards.length ) return;

        pills.forEach( function ( pill ) {
            pill.addEventListener( 'click', function () {
                var chosen = this.dataset.filter;

                // Update active pill state and aria-pressed
                pills.forEach( function ( p ) {
                    var isActive = p === pill;
                    p.classList.toggle( 'si-portfolio-filter__pill--active', isActive );
                    p.setAttribute( 'aria-pressed', isActive ? 'true' : 'false' );
                } );

                // Show/hide cards
                cards.forEach( function ( card ) {
                    if ( chosen === 'all' ) {
                        card.classList.remove( 'is-hidden' );
                    } else {
                        var cardCats = card.dataset.cats ? card.dataset.cats.split( ' ' ) : [];
                        var matches  = cardCats.indexOf( chosen ) !== -1;
                        card.classList.toggle( 'is-hidden', ! matches );
                    }
                } );
            } );
        } );
    }

    if ( document.readyState === 'loading' ) {
        document.addEventListener( 'DOMContentLoaded', init );
    } else {
        init();
    }
}() );
