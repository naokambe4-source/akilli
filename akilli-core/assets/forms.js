/* Akıllı Creative – progressive form submission. Without JS the form posts normally. */
( function () {
	'use strict';

	var messages = {
		required: 'Bu alan zorunludur.',
		email: 'Geçerli bir e-posta adresi yazın (örn. ad@firma.com).',
		tel: 'Geçerli bir telefon numarası yazın (örn. 0530 000 00 00).',
		short: 'Lütfen biraz daha ayrıntı verin (en az 10 karakter).',
		consent: 'Devam etmek için onay kutusunu işaretleyin.',
		network: 'Bağlantı sorunu nedeniyle gönderilemedi. Lütfen tekrar deneyin veya bize telefonla ulaşın.'
	};

	function setError( form, name, text ) {
		var wrap = form.querySelector( '[data-field="' + name + '"]' );
		if ( ! wrap ) {
			return;
		}
		var input = wrap.querySelector( 'input,select,textarea' );
		var out = wrap.querySelector( '.ak-field__error' );
		wrap.classList.toggle( 'has-error', !! text );
		if ( input ) {
			if ( text ) {
				input.setAttribute( 'aria-invalid', 'true' );
			} else {
				input.removeAttribute( 'aria-invalid' );
			}
		}
		if ( out ) {
			out.textContent = text || '';
		}
	}

	function check( field ) {
		var v = ( field.value || '' ).trim();
		if ( field.type === 'checkbox' ) {
			return field.required && ! field.checked ? messages.consent : '';
		}
		if ( field.required && ! v ) {
			return messages.required;
		}
		if ( v && field.type === 'email' && ! /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test( v ) ) {
			return messages.email;
		}
		if ( v && field.type === 'tel' ) {
			var d = v.replace( /\D/g, '' );
			if ( d.length < 10 || d.length > 15 || /[^0-9\s+()\-.]/.test( v ) ) {
				return messages.tel;
			}
		}
		if ( v && field.tagName === 'TEXTAREA' && v.length < 10 ) {
			return messages.short;
		}
		return '';
	}

	function status( form, type, text ) {
		var box = form.querySelector( '.ak-form__status' );
		box.innerHTML = '';
		if ( ! text ) {
			return;
		}
		var div = document.createElement( 'div' );
		div.className = 'ak-form__notice ak-form__notice--' + type;
		var p = document.createElement( 'p' );
		p.textContent = text;
		div.appendChild( p );
		box.appendChild( div );
		box.focus( { preventScroll: true } );
		box.scrollIntoView( { block: 'center', behavior: window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ? 'auto' : 'smooth' } );
	}

	document.querySelectorAll( '[data-ak-form]' ).forEach( function ( form ) {
		form.setAttribute( 'novalidate', '' );
		var fields = form.querySelectorAll( '[data-field] input, [data-field] select, [data-field] textarea' );

		fields.forEach( function ( f ) {
			f.addEventListener( 'blur', function () {
				if ( f.value || f.closest( '.has-error' ) ) {
					setError( form, f.closest( '[data-field]' ).dataset.field, check( f ) );
				}
			} );
		} );

		form.addEventListener( 'submit', function ( e ) {
			e.preventDefault();
			var first = null;
			fields.forEach( function ( f ) {
				var msg = check( f );
				setError( form, f.closest( '[data-field]' ).dataset.field, msg );
				if ( msg && ! first ) {
					first = f;
				}
			} );
			if ( first ) {
				status( form, 'error', 'Lütfen işaretli alanları kontrol edin.' );
				first.focus();
				return;
			}

			var btn = form.querySelector( '[type="submit"]' );
			btn.disabled = true;
			btn.classList.add( 'is-loading' );
			form.setAttribute( 'aria-busy', 'true' );

			fetch( form.getAttribute( 'action' ), {
				method: 'POST',
				body: new FormData( form ),
				credentials: 'same-origin',
				headers: { 'X-Akilli-Ajax': '1', Accept: 'application/json' }
			} ).then( function ( r ) {
				return r.json();
			} ).then( function ( res ) {
				if ( res && res.success ) {
					form.reset();
					form.classList.add( 'is-sent' );
					status( form, 'success', res.data.message );
					return;
				}
				var data = ( res && res.data ) || {};
				var errs = data.errors || {};
				Object.keys( errs ).forEach( function ( k ) {
					if ( k !== '_form' ) {
						setError( form, k, errs[ k ] );
					}
				} );
				status( form, 'error', data.message || messages.network );
				var bad = form.querySelector( '[aria-invalid="true"]' );
				if ( bad ) {
					bad.focus();
				}
			} ).catch( function () {
				status( form, 'error', messages.network );
			} ).finally( function () {
				btn.disabled = false;
				btn.classList.remove( 'is-loading' );
				form.removeAttribute( 'aria-busy' );
			} );
		} );
	} );
}() );
