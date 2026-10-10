/**
 * Akıllı Creative — project detail: accessible lightbox (<dialog>),
 * click-to-load video (no third-party requests until asked) and gentle
 * gallery parallax (full motion, larger screens only).
 */
( function () {
	'use strict';
	var html = document.documentElement;

	/* Lightbox */
	var links = Array.prototype.slice.call( document.querySelectorAll( '[data-ak-lightbox]' ) );
	if ( links.length && typeof HTMLDialogElement === 'function' ) {
		var dlg = document.createElement( 'dialog' );
		dlg.className = 'ak-lightbox';
		dlg.setAttribute( 'aria-label', 'Görsel önizleme' );
		dlg.innerHTML = '<img alt=""><div class="ak-lightbox__bar"><button type="button" data-prev aria-label="Önceki görsel">←</button><button type="button" data-close aria-label="Kapat">✕</button><button type="button" data-next aria-label="Sonraki görsel">→</button></div>';
		document.body.appendChild( dlg );
		var img = dlg.querySelector( 'img' );
		var idx = 0;
		var opener = null;
		var show = function ( i ) {
			idx = ( i + links.length ) % links.length;
			img.src = links[ idx ].href;
			var thumb = links[ idx ].querySelector( 'img' );
			img.alt = thumb ? thumb.alt : '';
		};
		links.forEach( function ( a, i ) {
			a.addEventListener( 'click', function ( e ) {
				e.preventDefault();
				opener = a;
				show( i );
				dlg.showModal();
			} );
		} );
		dlg.querySelector( '[data-close]' ).addEventListener( 'click', function () {
			dlg.close();
		} );
		dlg.querySelector( '[data-prev]' ).addEventListener( 'click', function () {
			show( idx - 1 );
		} );
		dlg.querySelector( '[data-next]' ).addEventListener( 'click', function () {
			show( idx + 1 );
		} );
		dlg.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'ArrowRight' ) {
				show( idx + 1 );
			} else if ( e.key === 'ArrowLeft' ) {
				show( idx - 1 );
			}
		} );
		dlg.addEventListener( 'click', function ( e ) {
			if ( e.target === dlg ) {
				dlg.close();
			}
		} );
		dlg.addEventListener( 'close', function () {
			if ( opener ) {
				opener.focus();
			}
		} );
	}

	/* Click-to-load video */
	document.querySelectorAll( '[data-ak-video]' ).forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			var f = document.createElement( 'iframe' );
			f.src = btn.getAttribute( 'data-ak-video' );
			f.title = btn.getAttribute( 'data-title' ) || 'Video';
			f.allow = 'autoplay; encrypted-media; picture-in-picture; fullscreen';
			f.allowFullscreen = true;
			btn.replaceWith( f );
			f.focus();
		} );
	} );

	/* Gallery parallax */
	var items = Array.prototype.slice.call( document.querySelectorAll( '.ak-gallery__item[data-speed]' ) );
	if ( items.length && window.matchMedia( '(min-width: 900px)' ).matches ) {
		var queued = false;
		var run = function () {
			queued = false;
			var on = html.classList.contains( 'ak-motion-full' );
			var vh = window.innerHeight;
			items.forEach( function ( it ) {
				var speed = parseFloat( it.dataset.speed ) || 0;
				if ( ! on || ! speed ) {
					it.style.transform = '';
					return;
				}
				var r = it.getBoundingClientRect();
				var center = r.top + r.height / 2 - vh / 2;
				it.style.transform = 'translate3d(0,' + ( center * speed ).toFixed( 1 ) + 'px,0)';
			} );
		};
		window.addEventListener( 'scroll', function () {
			if ( ! queued ) {
				queued = true;
				requestAnimationFrame( run );
			}
		}, { passive: true } );
		run();
	}
}() );
