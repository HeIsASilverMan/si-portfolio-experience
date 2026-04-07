/**
 * SI Multi-Step Forms
 * Handles step transitions, keyboard navigation, data collection, review
 * population, and AJAX submission for [si_form_composition] and
 * [si_form_learning_design].
 *
 * No jQuery. No build tools.
 */
( function () {
    'use strict';

    // Guard against double-init
    if ( window.siFormsInit ) return;
    window.siFormsInit = true;

    document.querySelectorAll( '.si-form' ).forEach( initForm );

    function initForm( form ) {
        var steps      = Array.from( form.querySelectorAll( '.si-form__step' ) );
        var progFill   = form.querySelector( '.si-form__progress-fill' );
        var stepCurEl  = form.querySelector( '.si-form__step-current' );
        var stepTotEl  = form.querySelector( '.si-form__step-total' );
        var backBtn    = form.querySelector( '.si-form__back-btn' );
        var successEl  = form.querySelector( '.si-form__success' );
        var formType   = form.dataset.formType || 'composition';

        var current   = 0;
        var totalReal = steps.length;  // includes review step
        var data      = {};            // collected field values keyed by data-field

        if ( stepTotEl ) stepTotEl.textContent = totalReal;

        // ── Activate first step ───────────────────────────────
        activateStep( 0, 'none' );

        // ── Back button ───────────────────────────────────────
        if ( backBtn ) {
            backBtn.addEventListener( 'click', function () {
                if ( current > 0 ) navigate( current - 1, 'back' );
            } );
        }

        // ── Navigate to a step ────────────────────────────────
        function navigate( index, dir ) {
            if ( index < 0 || index >= steps.length ) return;

            var leaving = steps[ current ];
            var arriving = steps[ index ];

            // Mark current as exiting
            leaving.classList.remove( 'is-active' );
            leaving.classList.add( 'is-exiting' );

            // Remove exiting class after transition ends
            var onEnd = function () {
                leaving.classList.remove( 'is-exiting' );
                leaving.removeEventListener( 'transitionend', onEnd );
            };
            leaving.addEventListener( 'transitionend', onEnd );

            // Animate arriving from correct side
            if ( dir === 'back' ) {
                arriving.style.transform = 'translateX(-60px)';
                arriving.style.opacity   = '0';
            } else {
                arriving.style.transform = 'translateX(60px)';
                arriving.style.opacity   = '0';
            }

            current = index;
            activateStep( index, dir );
        }

        function activateStep( index, dir ) {
            var step = steps[ index ];

            // If it's the review step, populate it first
            if ( step.classList.contains( 'si-form__step--review' ) ) {
                populateReview( step );
            }

            // Force reflow so the initial transform is applied before transition
            step.getBoundingClientRect();

            step.classList.add( 'is-active' );
            step.style.transform = '';
            step.style.opacity   = '';

            // Update progress bar
            var pct = Math.round( ( ( index + 1 ) / steps.length ) * 100 );
            if ( progFill ) progFill.style.width = pct + '%';

            // Update step counter
            if ( stepCurEl ) stepCurEl.textContent = index + 1;

            // Back button visibility
            if ( backBtn ) {
                if ( index === 0 ) {
                    backBtn.hidden = true;
                } else {
                    backBtn.hidden = false;
                }
            }

            // Focus first interactive element
            requestAnimationFrame( function () {
                var first = step.querySelector( 'button:not(.si-form__review-edit), textarea, input, [tabindex="0"]' );
                if ( first ) first.focus( { preventScroll: true } );
            } );
        }

        // ── Collect value from current step ───────────────────
        function collectCurrentStep() {
            var step  = steps[ current ];
            var field = step.dataset.field;
            if ( ! field ) return true; // review or no-field steps

            var selected = step.querySelectorAll( '.si-form__option.is-selected' );

            if ( selected.length ) {
                var vals = Array.from( selected ).map( function ( el ) {
                    return el.dataset.value || el.textContent.trim();
                } );
                data[ field ] = vals.join( ', ' );
                return true;
            }

            var ta = step.querySelector( '.si-form__textarea' );
            if ( ta ) {
                data[ field ] = ta.value.trim();
                return true; // textarea can be empty (some steps are optional)
            }

            var inputs = step.querySelectorAll( '.si-form__input' );
            if ( inputs.length ) {
                var valid = true;
                inputs.forEach( function ( inp ) {
                    var val = inp.value.trim();
                    if ( inp.required && ! val ) {
                        valid = false;
                        inp.focus();
                    }
                    data[ inp.name ] = val;
                } );
                return valid;
            }

            return true;
        }

        // ── Validate + advance ────────────────────────────────
        function advance() {
            var step  = steps[ current ];
            var field = step.dataset.field;
            var errEl = step.querySelector( '.si-form__error' );

            // For required card/radio steps, check something is selected
            if ( field && step.querySelector( '.si-form__option' ) ) {
                var isOptional = step.dataset.optional === 'true';
                var hasSelection = !!step.querySelector( '.si-form__option.is-selected' );
                if ( ! isOptional && ! hasSelection ) {
                    if ( errEl ) {
                        errEl.textContent = 'Please make a selection to continue.';
                    }
                    return;
                }
            }

            // For required textarea steps
            if ( field && step.querySelector( '.si-form__textarea' ) ) {
                var isOpt = step.dataset.optional === 'true';
                var ta    = step.querySelector( '.si-form__textarea' );
                if ( ! isOpt && ! ta.value.trim() ) {
                    if ( errEl ) errEl.textContent = 'Please add a few words to continue.';
                    ta.focus();
                    return;
                }
            }

            if ( errEl ) errEl.textContent = '';
            collectCurrentStep();

            if ( current < steps.length - 1 ) {
                navigate( current + 1, 'forward' );
            }
        }

        function skip() {
            var step  = steps[ current ];
            var field = step.dataset.field;
            if ( field ) data[ field ] = '';
            if ( current < steps.length - 1 ) navigate( current + 1, 'forward' );
        }

        // ── Card-select / radio: click handler ────────────────
        form.addEventListener( 'click', function ( e ) {
            var opt = e.target.closest( '.si-form__option' );
            if ( ! opt ) return;

            var step     = opt.closest( '.si-form__step' );
            var isMulti  = step && step.dataset.multi === 'true';

            if ( isMulti ) {
                // Toggle selection
                opt.classList.toggle( 'is-selected' );
                opt.setAttribute( 'aria-checked', opt.classList.contains( 'is-selected' ) );
            } else {
                // Single select: deselect others, select this, auto-advance
                var siblings = step ? step.querySelectorAll( '.si-form__option' ) : [];
                siblings.forEach( function ( s ) {
                    s.classList.remove( 'is-selected' );
                    s.setAttribute( 'aria-checked', 'false' );
                } );
                opt.classList.add( 'is-selected' );
                opt.setAttribute( 'aria-checked', 'true' );

                // Auto-advance after short delay so selection is visible
                setTimeout( advance, 220 );
            }
        } );

        // ── Continue buttons ──────────────────────────────────
        form.addEventListener( 'click', function ( e ) {
            if ( e.target.closest( '.si-form__continue-btn' ) ) advance();
            if ( e.target.closest( '.si-form__skip-btn' ) )     skip();
        } );

        // ── Review: edit buttons ──────────────────────────────
        form.addEventListener( 'click', function ( e ) {
            var editBtn = e.target.closest( '.si-form__review-edit' );
            if ( ! editBtn ) return;
            var target = parseInt( editBtn.dataset.targetStep, 10 );
            if ( ! isNaN( target ) ) navigate( target, 'back' );
        } );

        // ── Keyboard navigation ───────────────────────────────
        form.addEventListener( 'keydown', function ( e ) {
            var step    = steps[ current ];
            var hasTa   = !! step.querySelector( '.si-form__textarea' );
            var inInput = document.activeElement &&
                          ( document.activeElement.tagName === 'INPUT' ||
                            document.activeElement.tagName === 'TEXTAREA' );

            // Enter key to advance (not inside textarea — use Shift+Enter there)
            if ( e.key === 'Enter' ) {
                if ( hasTa ) {
                    if ( e.shiftKey ) {
                        e.preventDefault();
                        advance();
                    }
                    // plain Enter in textarea = newline (default behaviour)
                } else if ( ! inInput || e.target.tagName !== 'TEXTAREA' ) {
                    if ( ! e.target.closest( '.si-form__review-edit' ) &&
                         ! e.target.closest( '.si-form__continue-btn' ) &&
                         ! e.target.closest( '.si-form__submit-btn' ) ) {
                        e.preventDefault();
                        advance();
                    }
                }
            }

            // Escape / Backspace at start of field to go back
            if ( e.key === 'Escape' ) {
                if ( current > 0 ) navigate( current - 1, 'back' );
            }
        } );

        // ── Submit ────────────────────────────────────────────
        var submitBtn = form.querySelector( '.si-form__submit-btn' );
        if ( submitBtn ) {
            submitBtn.addEventListener( 'click', function () {
                submitForm();
            } );
        }

        function submitForm() {
            if ( ! window.siFormsConfig ) {
                showError( 'Configuration error. Please reload the page.' );
                return;
            }

            // Honeypot check (client-side: if filled, silently succeed)
            var hpField = form.querySelector( '[name="si_honeypot"]' );
            if ( hpField && hpField.value ) {
                showSuccess();
                return;
            }

            form.classList.add( 'si-form--submitting' );
            if ( submitBtn ) submitBtn.disabled = true;

            var payload = new FormData();
            payload.append( 'action',       'si_submit_enquiry' );
            payload.append( 'nonce',        siFormsConfig.nonce );
            payload.append( 'form_type',    formType );
            payload.append( 'form_data',    JSON.stringify( data ) );

            // Add individual contact fields for email
            if ( data.contact_name )  payload.append( 'contact_name',  data.contact_name );
            if ( data.contact_email ) payload.append( 'contact_email', data.contact_email );
            if ( data.contact_phone ) payload.append( 'contact_phone', data.contact_phone );
            if ( data.contact_company ) payload.append( 'contact_company', data.contact_company );
            if ( data.contact_role )    payload.append( 'contact_role',    data.contact_role );

            fetch( siFormsConfig.ajaxUrl, {
                method:      'POST',
                credentials: 'same-origin',
                body:        payload,
            } )
            .then( function ( res ) { return res.json(); } )
            .then( function ( json ) {
                if ( json.success ) {
                    showSuccess();
                } else {
                    form.classList.remove( 'si-form--submitting' );
                    if ( submitBtn ) submitBtn.disabled = false;
                    showError( json.data || 'Something went wrong. Please try again.' );
                }
            } )
            .catch( function () {
                form.classList.remove( 'si-form--submitting' );
                if ( submitBtn ) submitBtn.disabled = false;
                showError( 'Network error. Please check your connection and try again.' );
            } );
        }

        function showSuccess() {
            if ( successEl ) {
                successEl.classList.add( 'is-visible' );
                successEl.removeAttribute( 'aria-hidden' );
                var heading = successEl.querySelector( '.si-form__success-heading' );
                if ( heading ) heading.focus();
            }
        }

        function showError( msg ) {
            var step  = steps[ current ];
            var errEl = step.querySelector( '.si-form__error' );
            if ( errEl ) {
                errEl.textContent = msg;
            } else {
                // Fallback: show at bottom of submit step
                var reviewErr = form.querySelector( '.si-form__step--review .si-form__error' );
                if ( reviewErr ) reviewErr.textContent = msg;
            }
        }

        // ── Populate review step ──────────────────────────────
        function populateReview( reviewStep ) {
            var list = reviewStep.querySelector( '.si-form__review-list' );
            if ( ! list ) return;

            list.innerHTML = '';

            steps.forEach( function ( step, i ) {
                if ( step.classList.contains( 'si-form__step--review' ) ) return;

                var field   = step.dataset.field;
                var label   = step.dataset.reviewLabel || step.querySelector( '.si-form__question' ).textContent.trim();
                var value   = '';

                if ( field ) {
                    if ( field === 'contact' ) {
                        var parts = [];
                        if ( data.contact_name )    parts.push( data.contact_name );
                        if ( data.contact_email )   parts.push( data.contact_email );
                        if ( data.contact_phone )   parts.push( data.contact_phone );
                        if ( data.contact_company ) parts.push( data.contact_company );
                        if ( data.contact_role )    parts.push( data.contact_role );
                        value = parts.join( '  \u00B7  ' );
                    } else {
                        value = data[ field ] || '';
                    }
                }

                if ( ! value ) value = '\u2014'; // em dash for empty

                var item = document.createElement( 'div' );
                item.className = 'si-form__review-item';
                item.innerHTML =
                    '<span class="si-form__review-label">' + escHtml( label ) + '</span>' +
                    '<span class="si-form__review-value">'  + escHtml( value ) + '</span>' +
                    '<button class="si-form__review-edit" data-target-step="' + i + '" aria-label="Edit ' + escHtml( label ) + '">Edit</button>';

                list.appendChild( item );
            } );
        }

        // ── Helpers ───────────────────────────────────────────
        function escHtml( str ) {
            return String( str )
                .replace( /&/g,  '&amp;' )
                .replace( /</g,  '&lt;' )
                .replace( />/g,  '&gt;' )
                .replace( /"/g,  '&quot;' );
        }
    } // end initForm

} )();
