/**
 * SI Thread — game-music landing page widgets.
 * Handles the standalone Thread Finder questionnaire ([si_thread_finder])
 * and the lead-magnet email capture widget ([si_lead_magnet]). The
 * landing page's "get in touch" CTAs link to the existing composition
 * enquiry form ([si_form_composition], handled by si-forms.js) rather than
 * a separate contact form.
 *
 * Deliberately separate from si-forms.js: that engine assumes one field per
 * step, and the Thread Finder needs several textareas per step plus
 * localStorage autosave, so it gets its own small init here instead of
 * being forced into the existing single-field step engine. Same backend
 * (si_submit_enquiry / si_lead_magnet_signup over admin-ajax.php), same
 * nonce config object, same honeypot + loading-state conventions.
 *
 * No jQuery. No build tools.
 */
( function () {
    'use strict';

    if ( window.siThreadInit ) return;
    window.siThreadInit = true;

    var DRAFT_KEY = 'si_thread_finder_draft';

    function debounce( fn, wait ) {
        var t;
        return function () {
            var args = arguments, ctx = this;
            clearTimeout( t );
            t = setTimeout( function () { fn.apply( ctx, args ); }, wait );
        };
    }

    function isValidEmail( val ) {
        // Same-ish check the browser does for type="email" — good enough as a
        // client-side gate; the server re-validates with is_email() regardless.
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test( val );
    }

    function honeypotFilled( root ) {
        var hp = root.querySelector( '[name="si_honeypot"]' );
        return !! ( hp && hp.value );
    }

    // ==========================================================
    // Thread Finder ([si_thread_finder])
    // ==========================================================

    document.querySelectorAll( '.si-tf' ).forEach( initThreadFinder );

    function initThreadFinder( root ) {
        var introEl    = root.querySelector( '.si-tf__intro' );
        var beginBtn   = root.querySelector( '.si-tf__begin-btn' );
        var steps      = Array.from( root.querySelectorAll( '.si-tf__step' ) );
        var progFill   = root.querySelector( '.si-form__progress-fill' );
        var stepCurEl  = root.querySelector( '.si-form__step-current' );
        var backBtn    = root.querySelector( '.si-form__back-btn' );
        var successEl  = root.querySelector( '.si-form__success' );
        var current    = 0;

        // ── Restore any saved draft ────────────────────────────
        var draft = loadDraft();
        if ( draft && draft.answers ) {
            Object.keys( draft.answers ).forEach( function ( key ) {
                var field = root.querySelector( '[name="' + key + '"]' );
                if ( field ) field.value = draft.answers[ key ];
            } );
        }

        // ── Autosave (debounced) ───────────────────────────────
        var saveDraft = debounce( function () {
            var answers = {};
            root.querySelectorAll( 'textarea[name], input[name]' ).forEach( function ( field ) {
                if ( field.name && field.name !== 'si_honeypot' ) {
                    answers[ field.name ] = field.value;
                }
            } );
            try {
                localStorage.setItem( DRAFT_KEY, JSON.stringify( { answers: answers } ) );
            } catch ( e ) { /* storage unavailable — autosave just won't persist */ }
        }, 500 );

        root.addEventListener( 'input', function ( e ) {
            if ( e.target.matches( 'textarea, input' ) ) saveDraft();
        } );

        function loadDraft() {
            try {
                var raw = localStorage.getItem( DRAFT_KEY );
                return raw ? JSON.parse( raw ) : null;
            } catch ( e ) {
                return null;
            }
        }

        function clearDraft() {
            try { localStorage.removeItem( DRAFT_KEY ); } catch ( e ) {}
        }

        // ── Begin ───────────────────────────────────────────────
        if ( beginBtn ) {
            beginBtn.addEventListener( 'click', function () {
                root.setAttribute( 'data-started', 'true' );
                if ( introEl ) introEl.hidden = true;
                activateStep( 0 );
            } );
        }

        function activateStep( index ) {
            steps.forEach( function ( step, i ) {
                step.classList.toggle( 'is-active', i === index );
                step.classList.remove( 'is-exiting' );
            } );
            current = index;

            var pct = Math.round( ( ( index + 1 ) / steps.length ) * 100 );
            if ( progFill ) progFill.style.width = pct + '%';
            if ( stepCurEl ) stepCurEl.textContent = index + 1;
            if ( backBtn ) backBtn.hidden = ( index === 0 );

            requestAnimationFrame( function () {
                var first = steps[ index ].querySelector( 'textarea, input' );
                if ( first ) first.focus( { preventScroll: true } );
            } );
        }

        if ( backBtn ) {
            backBtn.addEventListener( 'click', function () {
                if ( current > 0 ) activateStep( current - 1 );
            } );
        }

        root.querySelectorAll( '.si-tf__continue-btn' ).forEach( function ( btn ) {
            btn.addEventListener( 'click', function () {
                if ( current < steps.length - 1 ) activateStep( current + 1 );
            } );
        } );

        // ── Submit (final step) ─────────────────────────────────
        var submitBtn = root.querySelector( '.si-tf__submit-btn' );
        var formError = root.querySelector( '.si-tf__form-error' );
        if ( submitBtn ) {
            submitBtn.addEventListener( 'click', function () {
                [ 'si-tf-name-error', 'si-tf-email-error', 'si-tf-company-error' ].forEach( function ( id ) {
                    var el = root.querySelector( '#' + id );
                    if ( el ) el.textContent = '';
                } );
                if ( formError ) formError.textContent = '';

                var name    = root.querySelector( '#si-tf-name' );
                var email   = root.querySelector( '#si-tf-email' );
                var company = root.querySelector( '#si-tf-company' );

                var valid = true;
                if ( ! name.value.trim() ) {
                    setError( 'si-tf-name-error', 'Please enter your name.' );
                    valid = false;
                }
                if ( ! email.value.trim() || ! isValidEmail( email.value.trim() ) ) {
                    setError( 'si-tf-email-error', 'Please enter a valid email address.' );
                    valid = false;
                }
                if ( ! company.value.trim() ) {
                    setError( 'si-tf-company-error', 'Please let me know your game or studio name.' );
                    valid = false;
                }
                if ( ! valid ) return;

                if ( honeypotFilled( root ) ) {
                    showSuccess();
                    return;
                }

                if ( ! window.siFormsConfig ) {
                    if ( formError ) formError.textContent = 'Configuration error. Please reload the page.';
                    return;
                }

                root.classList.add( 'si-form--submitting' );
                submitBtn.disabled = true;

                var answers = {};
                steps.forEach( function ( step ) {
                    step.querySelectorAll( 'textarea[name]' ).forEach( function ( ta ) {
                        answers[ ta.name ] = ta.value.trim();
                    } );
                } );

                var payload = new FormData();
                payload.append( 'action', 'si_submit_enquiry' );
                payload.append( 'nonce', siFormsConfig.nonce );
                payload.append( 'form_type', 'thread_finder' );
                payload.append( 'contact_name', name.value.trim() );
                payload.append( 'contact_email', email.value.trim() );
                payload.append( 'contact_company', company.value.trim() );
                payload.append( 'form_data', JSON.stringify( answers ) );

                fetch( siFormsConfig.ajaxUrl, { method: 'POST', credentials: 'same-origin', body: payload } )
                    .then( function ( res ) { return res.json(); } )
                    .then( function ( json ) {
                        if ( json.success ) {
                            showSuccess();
                        } else {
                            root.classList.remove( 'si-form--submitting' );
                            submitBtn.disabled = false;
                            if ( formError ) formError.textContent = json.data || 'Something went wrong. Please try again.';
                        }
                    } )
                    .catch( function () {
                        root.classList.remove( 'si-form--submitting' );
                        submitBtn.disabled = false;
                        if ( formError ) formError.textContent = 'Network error. Please check your connection and try again.';
                    } );

                function setError( id, msg ) {
                    var el = root.querySelector( '#' + id );
                    if ( el ) el.textContent = msg;
                }

                function showSuccess() {
                    // Successful submit only — an abandoned session keeps its draft.
                    clearDraft();
                    root.classList.remove( 'si-form--submitting' );
                    if ( successEl ) {
                        successEl.classList.add( 'is-visible' );
                        successEl.removeAttribute( 'aria-hidden' );
                        var heading = successEl.querySelector( '.si-form__success-heading' );
                        if ( heading ) heading.focus();
                    }
                }
            } );
        }
    }

    // ==========================================================
    // Lead magnet ([si_lead_magnet])
    // ==========================================================

    document.querySelectorAll( '.si-lead-magnet' ).forEach( initLeadMagnet );

    function initLeadMagnet( root ) {
        var submitBtn = root.querySelector( '.si-lead-magnet__submit-btn' );
        var errorEl   = root.querySelector( '.si-lead-magnet__error' );
        var emailEl   = root.querySelector( 'input[name="email"]' );
        var nameEl    = root.querySelector( 'input[name="name"]' );
        if ( ! submitBtn || ! emailEl ) return;

        submitBtn.addEventListener( 'click', function () {
            if ( root.classList.contains( 'is-submitted' ) ) return;
            if ( errorEl ) errorEl.textContent = '';

            var email = emailEl.value.trim();
            if ( ! email || ! isValidEmail( email ) ) {
                if ( errorEl ) errorEl.textContent = 'Please enter a valid email address.';
                return;
            }

            if ( honeypotFilled( root ) ) {
                root.classList.add( 'is-submitted' );
                return;
            }

            if ( ! window.siFormsConfig ) {
                if ( errorEl ) errorEl.textContent = 'Configuration error. Please reload the page.';
                return;
            }

            root.classList.add( 'si-form--submitting' );
            submitBtn.disabled = true;

            var payload = new FormData();
            payload.append( 'action', 'si_lead_magnet_signup' );
            payload.append( 'nonce', siFormsConfig.nonce );
            payload.append( 'email', email );
            payload.append( 'magnet', root.dataset.magnet || 'default' );
            if ( nameEl && nameEl.value.trim() ) payload.append( 'name', nameEl.value.trim() );

            fetch( siFormsConfig.ajaxUrl, { method: 'POST', credentials: 'same-origin', body: payload } )
                .then( function ( res ) { return res.json(); } )
                .then( function ( json ) {
                    root.classList.remove( 'si-form--submitting' );
                    if ( json.success ) {
                        root.classList.add( 'is-submitted' );
                    } else {
                        submitBtn.disabled = false;
                        if ( errorEl ) errorEl.textContent = json.data || 'Something went wrong. Please try again.';
                    }
                } )
                .catch( function () {
                    root.classList.remove( 'si-form--submitting' );
                    submitBtn.disabled = false;
                    if ( errorEl ) errorEl.textContent = 'Network error. Please check your connection and try again.';
                } );
        } );
    }

} )();
