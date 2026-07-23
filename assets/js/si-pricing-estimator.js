/**
 * SI Pricing Estimator — [si_pricing_estimator]
 * "Build Sheet" project estimator. Services and complexity tiers are supplied
 * by the server as JSON (from the Pricing Builder CPTs); this file renders
 * the interactive cards, complexity slider, and live estimate summary.
 *
 * No jQuery. No build tools.
 */
( function () {
    'use strict';

    if ( window.siPricingInit ) return;
    window.siPricingInit = true;

    var ICONS = {
        instructional: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19 7-7 3 3-7 7-3-3z"/><path d="m18 13-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/><path d="m2 2 7.586 7.586"/><circle cx="11" cy="11" r="2"/></svg>',
        build: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/><path d="m10 8 4 2.5L10 13V8z"/></svg>',
        consulting: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        multimedia: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 8-6 4 6 4V8z"/><rect x="2" y="6" width="20" height="12" rx="2"/></svg>',
        audit: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>',
        interactive: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="6" x2="10" y1="12" y2="12"/><line x1="8" x2="8" y1="10" y2="14"/><line x1="15" x2="15.01" y1="13" y2="13"/><line x1="18" x2="18.01" y1="11" y2="11"/><rect x="2" y="6" width="20" height="12" rx="6"/></svg>',
        general: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v18M3 12h18"/></svg>'
    };

    document.querySelectorAll( '.si-pricing' ).forEach( initEstimator );

    function initEstimator( root ) {
        var dataEl = document.getElementById( 'si-pricing-data' );
        if ( ! dataEl ) return;

        var config;
        try {
            config = JSON.parse( dataEl.textContent );
        } catch ( e ) {
            return;
        }

        var services = config.services || [];
        var tiers    = config.tiers || [];
        if ( ! services.length ) return;

        var servicesEl   = root.querySelector( '#si-pricing-services' );
        var linesEl      = root.querySelector( '#si-pricing-lines' );
        var subtotalEl   = root.querySelector( '#si-pricing-subtotal' );
        var discountRow  = root.querySelector( '#si-pricing-discount-row' );
        var discountEl   = root.querySelector( '#si-pricing-discount' );
        var totalEl      = root.querySelector( '#si-pricing-total' );
        var copyBtn      = root.querySelector( '#si-pricing-copy' );
        var emailBtn     = root.querySelector( '#si-pricing-email' );
        var slider       = root.querySelector( '#si-pricing-tier-slider' );
        var tierLabelEl  = root.querySelector( '#si-pricing-tier-label' );
        var tierDescEl   = root.querySelector( '#si-pricing-tier-desc' );

        var qty       = {};
        services.forEach( function ( s ) { qty[ s.id ] = 0; } );
        var retainer  = false;
        var tierIndex = 0;

        if ( slider && tiers.length ) {
            updateTierDisplay( tiers[ 0 ] );
        }

        // ── Complexity slider ──────────────────────────────────
        if ( slider && tiers.length ) {
            slider.addEventListener( 'input', function () {
                tierIndex = Math.max( 0, Math.min( tiers.length - 1, parseInt( slider.value, 10 ) || 0 ) );
                updateTierDisplay( tiers[ tierIndex ] );
                renderSummary();
            } );
        }

        function updateTierDisplay( tier ) {
            if ( ! tier ) return;
            if ( tierLabelEl ) tierLabelEl.textContent = tier.label;
            if ( tierDescEl )  tierDescEl.textContent  = tier.desc || '';
            if ( slider ) {
                slider.setAttribute( 'aria-valuetext', tier.label );
            }
        }

        // ── Rendering ───────────────────────────────────────────
        function fmt( n ) {
            return '£' + Math.round( n ).toLocaleString( 'en-GB' );
        }

        function renderServices() {
            servicesEl.innerHTML = '';

            services.forEach( function ( s ) {
                var active = qty[ s.id ] > 0;

                var card = document.createElement( 'div' );
                card.className = 'si-pricing__card' + ( active ? ' si-pricing__card--active' : '' );

                var icon = document.createElement( 'div' );
                icon.className = 'si-pricing__card-icon';
                icon.setAttribute( 'aria-hidden', 'true' );
                icon.innerHTML = ICONS[ s.icon ] || ICONS.general;
                card.appendChild( icon );

                var info = document.createElement( 'div' );
                info.className = 'si-pricing__card-info';
                info.innerHTML =
                    '<div class="si-pricing__card-name">' + escHtml( s.name ) + '</div>' +
                    '<div class="si-pricing__card-desc">' + escHtml( s.desc ) + '</div>' +
                    '<div class="si-pricing__card-rate">' + fmt( s.rate ) + ' / ' + escHtml( s.unit ) + '</div>';
                card.appendChild( info );

                if ( s.fixed ) {
                    var toggle = document.createElement( 'button' );
                    toggle.type = 'button';
                    toggle.className = 'si-pricing__include-btn' + ( active ? ' si-pricing__include-btn--on' : '' );
                    toggle.textContent = active ? 'Included' : 'Include';
                    toggle.setAttribute( 'aria-pressed', active ? 'true' : 'false' );
                    toggle.setAttribute( 'aria-label', ( active ? 'Remove ' : 'Include ' ) + s.name );
                    toggle.addEventListener( 'click', function () {
                        qty[ s.id ] = qty[ s.id ] > 0 ? 0 : 1;
                        renderAll();
                    } );
                    card.appendChild( toggle );
                } else {
                    var stepper = document.createElement( 'div' );
                    stepper.className = 'si-pricing__stepper';

                    var dec = document.createElement( 'button' );
                    dec.type = 'button';
                    dec.className = 'si-pricing__stepper-btn';
                    dec.textContent = '−';
                    dec.setAttribute( 'aria-label', 'Decrease ' + s.name + ' quantity' );
                    dec.addEventListener( 'click', function () { changeQty( s, -1 ); } );

                    var qtyEl = document.createElement( 'span' );
                    qtyEl.className = 'si-pricing__stepper-qty';
                    qtyEl.textContent = qty[ s.id ];

                    var inc = document.createElement( 'button' );
                    inc.type = 'button';
                    inc.className = 'si-pricing__stepper-btn';
                    inc.textContent = '+';
                    inc.setAttribute( 'aria-label', 'Increase ' + s.name + ' quantity' );
                    inc.addEventListener( 'click', function () { changeQty( s, 1 ); } );

                    stepper.appendChild( dec );
                    stepper.appendChild( qtyEl );
                    stepper.appendChild( inc );
                    card.appendChild( stepper );
                }

                servicesEl.appendChild( card );
            } );

            // ── Retainer toggle ───────────────────────────────
            var retainerBtn = document.createElement( 'button' );
            retainerBtn.type = 'button';
            retainerBtn.className = 'si-pricing__retainer' + ( retainer ? ' si-pricing__retainer--on' : '' );
            retainerBtn.setAttribute( 'aria-pressed', retainer ? 'true' : 'false' );

            var pct = config.retainerPercent || 0;
            var retainerDescText = ( config.retainerDesc || 'Ongoing engagement discount' ) + ' — ' + pct + '% off subtotal';

            retainerBtn.innerHTML =
                '<span>' +
                    '<span class="si-pricing__retainer-name">' + escHtml( config.retainerLabel || 'Retainer client' ) + '</span>' +
                    '<span class="si-pricing__retainer-desc">' + escHtml( retainerDescText ) + '</span>' +
                '</span>' +
                '<span class="si-pricing__switch' + ( retainer ? ' si-pricing__switch--on' : '' ) + '" aria-hidden="true"><span class="si-pricing__switch-knob"></span></span>';

            retainerBtn.addEventListener( 'click', function () {
                retainer = ! retainer;
                renderAll();
            } );

            servicesEl.appendChild( retainerBtn );
        }

        function changeQty( s, dir ) {
            var val = qty[ s.id ] + dir * s.step;
            val = Math.max( 0, Math.min( s.max, val ) );
            qty[ s.id ] = Math.round( val * 2 ) / 2;
            renderAll();
        }

        function currentLines() {
            var mult = tiers.length ? ( tiers[ tierIndex ].mult || 1 ) : 1;
            return services
                .map( function ( s ) {
                    var appliedRate = s.scale ? s.rate * mult : s.rate;
                    return {
                        id: s.id,
                        name: s.name,
                        unit: s.unit,
                        fixed: s.fixed,
                        qty: qty[ s.id ],
                        lineTotal: appliedRate * qty[ s.id ]
                    };
                } )
                .filter( function ( l ) { return l.lineTotal > 0; } );
        }

        function renderSummary() {
            var lines = currentLines();
            var subtotal = lines.reduce( function ( sum, l ) { return sum + l.lineTotal; }, 0 );
            var pct = config.retainerPercent || 0;
            var discount = retainer ? subtotal * ( pct / 100 ) : 0;
            var total = subtotal - discount;

            if ( ! lines.length ) {
                linesEl.innerHTML = '<div class="si-pricing__empty-lines">Select services to build an estimate</div>';
            } else {
                linesEl.innerHTML = lines.map( function ( l ) {
                    var qtyLabel = l.fixed ? '' : ' · ' + l.qty + ' ' + l.unit;
                    return '<div class="si-pricing__line-item">' +
                        '<span>' + escHtml( l.name ) + qtyLabel + '</span>' +
                        '<span>' + fmt( l.lineTotal ) + '</span>' +
                    '</div>';
                } ).join( '' );
            }

            subtotalEl.textContent = fmt( subtotal );
            totalEl.textContent = fmt( total );

            if ( retainer && subtotal > 0 ) {
                discountRow.hidden = false;
                discountEl.textContent = '−' + fmt( discount );
            } else {
                discountRow.hidden = true;
            }

            var hasLines = lines.length > 0;
            copyBtn.disabled = ! hasLines;

            if ( hasLines ) {
                emailBtn.classList.remove( 'is-disabled' );
                emailBtn.setAttribute( 'href', 'mailto:?subject=' + encodeURIComponent( config.emailSubject || 'Project estimate' ) + '&body=' + encodeURIComponent( summaryText( lines, subtotal, discount, total, pct ) ) );
            } else {
                emailBtn.classList.add( 'is-disabled' );
                emailBtn.removeAttribute( 'href' );
            }

            copyBtn.onclick = function () {
                if ( ! navigator.clipboard ) return;
                navigator.clipboard.writeText( summaryText( lines, subtotal, discount, total, pct ) ).then( function () {
                    var original = copyBtn.textContent;
                    copyBtn.textContent = 'Copied';
                    setTimeout( function () { copyBtn.textContent = original; }, 1800 );
                } ).catch( function () {} );
            };
        }

        function summaryText( lines, subtotal, discount, total, pct ) {
            var tierLine = tiers.length ? ( 'Complexity: ' + tiers[ tierIndex ].label + '\n' ) : '';
            var rows = lines.map( function ( l ) {
                var qtyPart = l.fixed ? '' : l.qty + ' ' + l.unit + ' × ';
                return l.name + ' — ' + qtyPart + fmt( l.lineTotal / ( l.fixed ? 1 : ( l.qty || 1 ) ) ) + ' = ' + fmt( l.lineTotal );
            } ).join( '\n' );

            var body = 'PROJECT ESTIMATE — ' + ( config.studioName || '' ) + '\n\n' + tierLine + '\n' + rows + '\n\nSubtotal: ' + fmt( subtotal );
            if ( discount > 0 ) {
                body += '\nRetainer discount (' + pct + '%): -' + fmt( discount );
            }
            body += '\nEstimated total: ' + fmt( total ) + '\n\nThis is an indicative estimate. Final quote confirmed after a discovery call.';
            return body;
        }

        function escHtml( str ) {
            return String( str == null ? '' : str )
                .replace( /&/g, '&amp;' )
                .replace( /</g, '&lt;' )
                .replace( />/g, '&gt;' )
                .replace( /"/g, '&quot;' );
        }

        function renderAll() {
            renderServices();
            renderSummary();
        }

        renderAll();
    }
} )();
