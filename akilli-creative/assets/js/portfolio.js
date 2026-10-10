/**
 * Akıllı Creative — portfolio filters (category + service).
 * Server-side filtering works without JS via query links; this upgrades it to
 * instant filtering with URL sync and a live result count.
 */
( function () {
	'use strict';
	var cfg = window.akilliTheme || {};
	document.querySelectorAll( '[data-ak-filters]' ).forEach( function ( box ) {
		var section = box.closest( 'section' );
		var grid = section.querySelector( '[data-ak-pgrid]' );
		var empty = section.querySelector( '[data-ak-empty]' );
		var status = box.querySelector( '[data-ak-filter-status]' );
		var tpl = section.querySelector( 'template[data-ak-all-projects]' );
		var reduce = ! document.documentElement.classList.contains( 'ak-motion' );

		// When the page was server-filtered, restore the complete set for client filtering.
		if ( tpl ) {
			grid.innerHTML = '';
			grid.appendChild( tpl.content.cloneNode( true ) );
		}
		var cards = Array.prototype.slice.call( grid.querySelectorAll( '.ak-pcard' ) );
		var params = new URLSearchParams( location.search );
		var state = { kategori: params.get( 'kategori' ) || '', hizmet: params.get( 'hizmet' ) || '' };

		function apply( animate ) {
			var shown = 0;
			cards.forEach( function ( c, i ) {
				var okCat = ! state.kategori || ( ' ' + c.dataset.cats + ' ' ).indexOf( ' ' + state.kategori + ' ' ) > -1;
				var okSvc = ! state.hizmet || ( ' ' + c.dataset.services + ' ' ).indexOf( ' ' + state.hizmet + ' ' ) > -1;
				var show = okCat && okSvc;
				var was = ! c.hidden;
				c.hidden = ! show;
				if ( show ) {
					shown++;
					if ( animate && ! reduce && ! was ) {
						c.style.animationDelay = ( shown * 50 ) + 'ms';
						c.classList.remove( 'is-filtering-in' );
						void c.offsetWidth;
						c.classList.add( 'is-filtering-in' );
					}
				}
			} );
			box.querySelectorAll( '[data-filter]' ).forEach( function ( a ) {
				if ( state[ a.dataset.filter ] === a.dataset.value ) {
					a.setAttribute( 'aria-current', 'true' );
				} else {
					a.removeAttribute( 'aria-current' );
				}
			} );
			if ( empty ) {
				empty.hidden = shown > 0;
			}
			if ( status ) {
				status.textContent = ( cfg.i18n && cfg.i18n.showing ? cfg.i18n.showing : '%d proje gösteriliyor' ).replace( '%d', shown );
			}
		}

		box.addEventListener( 'click', function ( e ) {
			var a = e.target.closest( '[data-filter]' );
			if ( ! a ) {
				return;
			}
			e.preventDefault();
			state[ a.dataset.filter ] = a.dataset.value;
			var url = new URL( location.href );
			[ 'kategori', 'hizmet' ].forEach( function ( k ) {
				if ( state[ k ] ) {
					url.searchParams.set( k, state[ k ] );
				} else {
					url.searchParams.delete( k );
				}
			} );
			history.replaceState( null, '', url.toString() );
			apply( true );
		} );
		var reset = section.querySelector( '[data-ak-reset]' );
		if ( reset ) {
			reset.addEventListener( 'click', function ( e ) {
				e.preventDefault();
				state = { kategori: '', hizmet: '' };
				history.replaceState( null, '', location.pathname );
				apply( true );
			} );
		}
		apply( false );
	} );
}() );
