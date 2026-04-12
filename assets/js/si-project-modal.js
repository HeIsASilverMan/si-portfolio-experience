/**
 * SI Project Modal
 *
 * Opens a modal when a .si-project-card is clicked.
 * Content is copied from hidden .si-modal-data divs into
 * the modal body — no AJAX needed.
 *
 * Features:
 *  - Focus trap inside modal
 *  - ESC to close
 *  - Backdrop click to close
 *  - Prev/Next navigation
 *  - Restores focus to trigger on close
 *  - Respects prefers-reduced-motion
 */
( function () {
    'use strict';

    var modal        = document.getElementById( 'si-project-modal' );
    if ( ! modal ) return;

    var backdrop     = document.getElementById( 'si-modal-backdrop' );
    var closeBtn     = document.getElementById( 'si-modal-close' );
    var body         = document.getElementById( 'si-modal-body' );
    var prevBtn      = document.getElementById( 'si-modal-prev' );
    var nextBtn      = document.getElementById( 'si-modal-next' );

    var cards        = [];   // ordered list of .si-project-card elements (visible)
    var currentIndex = -1;
    var lastFocused  = null;

    var FOCUSABLE = 'a[href], button:not([disabled]), input, textarea, select, [tabindex]:not([tabindex="-1"])';

    // ── Helpers ────────────────────────────────────────────────

    function getVisibleCards() {
        return Array.prototype.slice.call(
            document.querySelectorAll( '#si-portfolio-grid-cards .si-project-card:not(.is-hidden)' )
        );
    }

    function getModalData( card ) {
        var targetId = card.dataset.modalTarget;
        if ( ! targetId ) return null;
        return document.getElementById( targetId );
    }

    function populateModal( card ) {
        var dataEl = getModalData( card );
        if ( ! dataEl ) return;

        // Clone the content of the hidden data div into the modal body.
        // The clone includes the image, title, sections, actions, etc.
        body.innerHTML = '';
        var clone = dataEl.cloneNode( true );
        clone.removeAttribute( 'id' );
        clone.removeAttribute( 'hidden' );
        clone.removeAttribute( 'aria-hidden' );
        body.appendChild( clone );

        // Update modal's accessible title from the cloned heading.
        var titleEl = body.querySelector( '.si-modal-data__title' );
        if ( titleEl ) {
            titleEl.id = 'si-modal-title';
        }
    }

    function updateNavButtons() {
        if ( prevBtn ) {
            prevBtn.disabled = ( currentIndex <= 0 );
        }
        if ( nextBtn ) {
            nextBtn.disabled = ( currentIndex >= cards.length - 1 );
        }
    }

    // ── Open / close ────────────────────────────────────────────

    function openModal( index ) {
        cards        = getVisibleCards();
        currentIndex = index;

        if ( currentIndex < 0 || currentIndex >= cards.length ) return;

        populateModal( cards[ currentIndex ] );
        updateNavButtons();

        modal.removeAttribute( 'hidden' );
        modal.setAttribute( 'aria-hidden', 'false' );
        document.body.style.overflow = 'hidden';

        // Focus first focusable element inside the box.
        var focusable = modal.querySelectorAll( FOCUSABLE );
        if ( focusable.length ) {
            focusable[ 0 ].focus();
        }
    }

    function closeModal() {
        modal.setAttribute( 'hidden', '' );
        modal.setAttribute( 'aria-hidden', 'true' );
        document.body.style.overflow = '';
        body.innerHTML = '';

        if ( lastFocused && typeof lastFocused.focus === 'function' ) {
            lastFocused.focus();
        }
    }

    function showProject( index ) {
        if ( index < 0 || index >= cards.length ) return;
        currentIndex = index;
        populateModal( cards[ currentIndex ] );
        updateNavButtons();

        // Scroll modal body back to top after navigation.
        var box = modal.querySelector( '.si-project-modal__box' );
        if ( box ) box.scrollTop = 0;
    }

    // ── Event listeners ─────────────────────────────────────────

    // Card clicks (and keyboard Enter/Space)
    document.addEventListener( 'click', function ( e ) {
        var card = e.target.closest( '.si-project-card' );
        if ( ! card ) return;

        lastFocused = card;
        cards       = getVisibleCards();
        var idx     = cards.indexOf( card );
        if ( idx === -1 ) return;
        openModal( idx );
    } );

    document.addEventListener( 'keydown', function ( e ) {
        var card = e.target.closest( '.si-project-card' );
        if ( card && ( e.key === 'Enter' || e.key === ' ' ) ) {
            e.preventDefault();
            lastFocused = card;
            cards       = getVisibleCards();
            var idx     = cards.indexOf( card );
            if ( idx !== -1 ) openModal( idx );
            return;
        }

        if ( modal.hasAttribute( 'hidden' ) ) return;

        if ( e.key === 'Escape' ) {
            closeModal();
            return;
        }

        if ( e.key === 'ArrowLeft' || e.key === 'ArrowUp' ) {
            e.preventDefault();
            showProject( currentIndex - 1 );
            return;
        }

        if ( e.key === 'ArrowRight' || e.key === 'ArrowDown' ) {
            e.preventDefault();
            showProject( currentIndex + 1 );
            return;
        }

        // Focus trap
        if ( e.key === 'Tab' ) {
            var focusable = Array.prototype.slice.call( modal.querySelectorAll( FOCUSABLE ) );
            if ( ! focusable.length ) return;

            var first = focusable[ 0 ];
            var last  = focusable[ focusable.length - 1 ];

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

    if ( closeBtn ) {
        closeBtn.addEventListener( 'click', closeModal );
    }

    if ( backdrop ) {
        backdrop.addEventListener( 'click', closeModal );
    }

    if ( prevBtn ) {
        prevBtn.addEventListener( 'click', function () {
            showProject( currentIndex - 1 );
        } );
    }

    if ( nextBtn ) {
        nextBtn.addEventListener( 'click', function () {
            showProject( currentIndex + 1 );
        } );
    }

} )();
