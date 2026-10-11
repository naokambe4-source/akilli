/**
 * Akıllı Creative — core interactions.
 * Progressive enhancement only: every feature degrades to plain HTML.
 */
( function () {
	'use strict';
	window.akilliReady = true;

	var doc = document;
	var html = doc.documentElement;
	var cfg = window.akilliTheme || {};
	var finePointer = window.matchMedia( '(hover: hover) and (pointer: fine)' );
	var reduceMQ = window.matchMedia( '(prefers-reduced-motion: reduce)' );

	function motion() {
		return html.classList.contains( 'ak-motion' );
	}
	function fullMotion() {
		return html.classList.contains( 'ak-motion-full' );
	}
	function $$( sel, ctx ) {
		return Array.prototype.slice.call( ( ctx || doc ).querySelectorAll( sel ) );
	}
	function rafThrottle( fn ) {
		var queued = false;
		return function () {
			if ( queued ) {
				return;
			}
			queued = true;
			requestAnimationFrame( function () {
				queued = false;
				fn();
			} );
		};
	}

	/* Header state ------------------------------------------------------- */
	var header = doc.querySelector( '[data-ak-header]' );
	var onScrollHeader = rafThrottle( function () {
		if ( header ) {
			header.classList.toggle( 'is-scrolled', window.scrollY > 8 );
		}
	} );
	window.addEventListener( 'scroll', onScrollHeader, { passive: true } );
	onScrollHeader();

	/* Mobile navigation -------------------------------------------------- */
	var nav = doc.querySelector( '[data-ak-nav]' );
	var toggle = doc.querySelector( '[data-ak-menu-toggle]' );
	var desktopMQ = window.matchMedia( '(min-width: 1100px)' );

	function setMenu( open ) {
		if ( ! header || ! toggle ) {
			return;
		}
		header.classList.toggle( 'is-open', open );
		toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		toggle.querySelector( '.ak-menu-toggle__label' ).textContent = open ? 'Kapat' : 'Menü';
		doc.body.style.overflow = open ? 'hidden' : '';
		if ( open ) {
			var first = nav.querySelector( 'a, button' );
			if ( first ) {
				first.focus();
			}
		}
	}
	if ( toggle && nav ) {
		toggle.setAttribute( 'role', 'button' );
		toggle.addEventListener( 'click', function ( e ) {
			e.preventDefault();
			setMenu( ! header.classList.contains( 'is-open' ) );
		} );
		toggle.addEventListener( 'keydown', function ( e ) {
			if ( e.key === ' ' ) {
				e.preventDefault();
				toggle.click();
			}
		} );
		// Focus trap while the sheet is open.
		doc.addEventListener( 'keydown', function ( e ) {
			if ( ! header.classList.contains( 'is-open' ) ) {
				return;
			}
			if ( e.key === 'Escape' ) {
				setMenu( false );
				toggle.focus();
				return;
			}
			if ( e.key !== 'Tab' ) {
				return;
			}
			var items = $$( 'a[href], button:not([disabled])', nav ).filter( function ( el ) {
				return el.offsetParent !== null;
			} );
			items.push( toggle );
			var first = items[ 0 ];
			var last = items[ items.length - 1 ];
			if ( e.shiftKey && doc.activeElement === first ) {
				e.preventDefault();
				last.focus();
			} else if ( ! e.shiftKey && doc.activeElement === last ) {
				e.preventDefault();
				first.focus();
			}
		} );
		desktopMQ.addEventListener( 'change', function () {
			if ( desktopMQ.matches ) {
				setMenu( false );
			}
		} );
		// Close the sheet when following an in-page link.
		nav.addEventListener( 'click', function ( e ) {
			var a = e.target.closest( 'a' );
			if ( a && a.hash && a.pathname === location.pathname && header.classList.contains( 'is-open' ) ) {
				setMenu( false );
			}
		} );
	}

	/* Sub menus / mega menu ---------------------------------------------- */
	function closeAllSubs( except ) {
		$$( '.ak-nav__list > li.is-open', nav ).forEach( function ( li ) {
			if ( li !== except ) {
				li.classList.remove( 'is-open' );
				var b = li.querySelector( ':scope > .ak-sub-toggle' );
				if ( b ) {
					b.setAttribute( 'aria-expanded', 'false' );
				}
			}
		} );
	}
	if ( nav ) {
		$$( '.ak-sub-toggle', nav ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var li = btn.parentElement;
				var open = ! li.classList.contains( 'is-open' );
				if ( desktopMQ.matches && li.parentElement.classList.contains( 'ak-nav__list' ) ) {
					closeAllSubs( li );
				}
				li.classList.toggle( 'is-open', open );
				li.classList.remove( 'is-closed' );
				btn.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			} );
		} );
		nav.addEventListener( 'keydown', function ( e ) {
			if ( e.key !== 'Escape' || ! desktopMQ.matches ) {
				return;
			}
			var li = e.target.closest( '.ak-nav__list > li' );
			if ( li ) {
				li.classList.remove( 'is-open' );
				li.classList.add( 'is-closed' );
				var b = li.querySelector( ':scope > .ak-sub-toggle' );
				if ( b ) {
					b.setAttribute( 'aria-expanded', 'false' );
					b.focus();
				}
			}
		} );
		$$( '.ak-nav__list > li', nav ).forEach( function ( li ) {
			li.addEventListener( 'mouseleave', function () {
				li.classList.remove( 'is-closed' );
				if ( desktopMQ.matches && li.classList.contains( 'is-open' ) ) {
					li.classList.remove( 'is-open' );
					var b = li.querySelector( ':scope > .ak-sub-toggle' );
					if ( b ) {
						b.setAttribute( 'aria-expanded', 'false' );
					}
				}
			} );
			li.addEventListener( 'focusout', function ( e ) {
				if ( ! li.contains( e.relatedTarget ) ) {
					li.classList.remove( 'is-closed' );
					if ( desktopMQ.matches ) {
						li.classList.remove( 'is-open' );
						var b = li.querySelector( ':scope > .ak-sub-toggle' );
						if ( b ) {
							b.setAttribute( 'aria-expanded', 'false' );
						}
					}
				}
			} );
		} );
		doc.addEventListener( 'click', function ( e ) {
			if ( desktopMQ.matches && ! nav.contains( e.target ) ) {
				closeAllSubs( null );
			}
		} );
		// Open the sub menu that contains the current page on mobile.
		$$( '.current-menu-ancestor, .current-menu-parent', nav ).forEach( function ( li ) {
			if ( ! desktopMQ.matches ) {
				li.classList.add( 'is-open' );
				var b = li.querySelector( ':scope > .ak-sub-toggle' );
				if ( b ) {
					b.setAttribute( 'aria-expanded', 'true' );
				}
			}
		} );
	}

	/* Reveal on scroll ---------------------------------------------------- */
	var revealIO = 'IntersectionObserver' in window ? new IntersectionObserver( function ( entries ) {
		entries.forEach( function ( en ) {
			if ( en.isIntersecting ) {
				en.target.classList.add( 'is-in' );
				revealIO.unobserve( en.target );
			}
		} );
	}, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 } ) : null;
	$$( '[data-reveal]' ).forEach( function ( el ) {
		if ( revealIO && motion() ) {
			revealIO.observe( el );
		} else {
			el.classList.add( 'is-in' );
		}
	} );

	/* Word splitting (hero title, statement) ------------------------------ */
	function splitWords( root, cls, skip ) {
		var count = 0;
		var walker = doc.createTreeWalker( root, NodeFilter.SHOW_TEXT, {
			acceptNode: function ( n ) {
				if ( ! n.nodeValue.trim() ) {
					return NodeFilter.FILTER_REJECT;
				}
				if ( skip && n.parentElement.closest( skip ) ) {
					return NodeFilter.FILTER_REJECT;
				}
				return NodeFilter.FILTER_ACCEPT;
			}
		} );
		var nodes = [];
		while ( walker.nextNode() ) {
			nodes.push( walker.currentNode );
		}
		nodes.forEach( function ( node ) {
			var frag = doc.createDocumentFragment();
			node.nodeValue.split( /(\s+)/ ).forEach( function ( part ) {
				if ( ! part ) {
					return;
				}
				if ( /^\s+$/.test( part ) ) {
					frag.appendChild( doc.createTextNode( part ) );
					return;
				}
				var s = doc.createElement( 'span' );
				s.className = cls;
				s.style.setProperty( '--w', count++ );
				s.textContent = part;
				frag.appendChild( s );
			} );
			node.parentNode.replaceChild( frag, node );
		} );
		return count;
	}

	var heroTitle = doc.querySelector( '[data-ak-split]' );
	if ( heroTitle && motion() ) {
		splitWords( heroTitle, 'ak-word', '.ak-rotator, .screen-reader-text' );
		var rot = heroTitle.querySelector( '.ak-rotator' );
		if ( rot ) {
			rot.classList.add( 'ak-word' );
			rot.style.setProperty( '--w', heroTitle.querySelectorAll( '.ak-word' ).length );
		}
	}

	/* Hero plate: opens from a framed inset to full bleed while scrolling ---- */
	var plate = doc.querySelector( '[data-ak-plate]' );
	if ( plate ) {
		var onPlate = rafThrottle( function () {
			if ( ! fullMotion() ) {
				plate.style.setProperty( '--p', 0 );
				return;
			}
			var r = plate.getBoundingClientRect();
			var vh = window.innerHeight;
			var head = header ? header.offsetHeight : 0;
			var p = 1 - ( r.top - head ) / ( vh * 0.55 );
			plate.style.setProperty( '--p', Math.max( 0, Math.min( 1, p ) ).toFixed( 3 ) );
		} );
		window.addEventListener( 'scroll', onPlate, { passive: true } );
		window.addEventListener( 'resize', onPlate );
		doc.addEventListener( 'akilli:motion', onPlate );
		onPlate();
	}

	/* Rotating words ------------------------------------------------------ */
	$$( '[data-ak-rotator]' ).forEach( function ( rot ) {
		var words;
		try {
			words = JSON.parse( rot.getAttribute( 'data-words' ) );
		} catch ( e ) {
			return;
		}
		if ( ! words || words.length < 2 ) {
			return;
		}
		var i = 0;
		var visible = true;
		var current = rot.querySelector( '.ak-rotator__word' );
		if ( 'IntersectionObserver' in window ) {
			new IntersectionObserver( function ( en ) {
				visible = en[ 0 ].isIntersecting;
			} ).observe( rot );
		}
		setInterval( function () {
			if ( ! motion() || ! visible || doc.hidden ) {
				return;
			}
			i = ( i + 1 ) % words.length;
			var next = doc.createElement( 'span' );
			next.className = 'ak-rotator__word is-in';
			next.textContent = words[ i ];
			current.classList.add( 'is-out' );
			rot.appendChild( next );
			var old = current;
			setTimeout( function () {
				old.remove();
			}, 520 );
			current = next;
		}, 2600 );
	} );

	/* Tabs: services explorer --------------------------------------------- */
	$$( '[data-ak-tabs]' ).forEach( function ( box ) {
		var list = box.querySelector( '[data-ak-tablist]' );
		var tabs = $$( '[data-ak-tab]', box );
		var panels = $$( '[data-ak-panel]', box );
		if ( ! tabs.length ) {
			return;
		}
		list.setAttribute( 'role', 'tablist' );
		list.setAttribute( 'aria-label', 'Hizmet kategorileri' );
		$$( 'li', list ).forEach( function ( li ) {
			li.setAttribute( 'role', 'presentation' );
		} );
		tabs.forEach( function ( tab, i ) {
			var id = tab.getAttribute( 'href' ).slice( 1 );
			tab.setAttribute( 'role', 'tab' );
			tab.setAttribute( 'aria-controls', id );
			panels[ i ].setAttribute( 'role', 'tabpanel' );
			panels[ i ].setAttribute( 'aria-labelledby', tab.id );
			panels[ i ].setAttribute( 'tabindex', '-1' );
		} );
		function select( idx, focus ) {
			tabs.forEach( function ( t, i ) {
				var on = i === idx;
				t.setAttribute( 'aria-selected', on ? 'true' : 'false' );
				t.setAttribute( 'tabindex', on ? '0' : '-1' );
				panels[ i ].hidden = ! on;
				if ( on && motion() ) {
					panels[ i ].classList.remove( 'is-entering' );
					void panels[ i ].offsetWidth;
					panels[ i ].classList.add( 'is-entering' );
				}
			} );
			if ( focus ) {
				tabs[ idx ].focus();
			}
			// Keep the active chip visible on mobile.
			if ( tabs[ idx ].scrollIntoView && ! desktopMQ.matches && focus ) {
				tabs[ idx ].scrollIntoView( { block: 'nearest', inline: 'center' } );
			}
		}
		var start = 0;
		tabs.forEach( function ( t, i ) {
			if ( location.hash && t.getAttribute( 'href' ) === location.hash ) {
				start = i;
			}
			t.addEventListener( 'click', function ( e ) {
				e.preventDefault();
				select( i, false );
				if ( ! desktopMQ.matches ) {
					t.scrollIntoView( { block: 'nearest', inline: 'center', behavior: motion() ? 'smooth' : 'auto' } );
				}
			} );
			t.addEventListener( 'keydown', function ( e ) {
				var n = null;
				if ( e.key === 'ArrowRight' || e.key === 'ArrowDown' ) {
					n = ( i + 1 ) % tabs.length;
				} else if ( e.key === 'ArrowLeft' || e.key === 'ArrowUp' ) {
					n = ( i - 1 + tabs.length ) % tabs.length;
				} else if ( e.key === 'Home' ) {
					n = 0;
				} else if ( e.key === 'End' ) {
					n = tabs.length - 1;
				} else if ( e.key === ' ' ) {
					e.preventDefault();
					select( i, false );
				}
				if ( n !== null ) {
					e.preventDefault();
					select( n, true );
				}
			} );
			// Desktop: preview on hover after a short intent delay.
			var timer;
			t.addEventListener( 'mouseenter', function () {
				if ( ! finePointer.matches || ! desktopMQ.matches ) {
					return;
				}
				timer = setTimeout( function () {
					select( i, false );
				}, 180 );
			} );
			t.addEventListener( 'mouseleave', function () {
				clearTimeout( timer );
			} );
		} );
		select( start, false );
	} );

	/* Statement: words light up with scroll -------------------------------- */
	var statements = $$( '[data-ak-words]' );
	if ( statements.length && motion() ) {
		var stItems = statements.map( function ( el ) {
			splitWords( el, 'ak-w' );
			return { el: el, words: $$( '.ak-w', el ) };
		} );
		var onStatement = rafThrottle( function () {
			var vh = window.innerHeight;
			stItems.forEach( function ( it ) {
				var r = it.el.getBoundingClientRect();
				if ( r.bottom < 0 || r.top > vh ) {
					return;
				}
				var p = ( vh * 0.85 - r.top ) / ( r.height + vh * 0.35 );
				p = Math.max( 0, Math.min( 1, p ) );
				var n = Math.round( p * it.words.length );
				it.words.forEach( function ( w, i ) {
					w.classList.toggle( 'is-on', i < n || ! motion() );
				} );
			} );
		} );
		window.addEventListener( 'scroll', onStatement, { passive: true } );
		window.addEventListener( 'resize', onStatement );
		onStatement();
	}

	/* Process: progress meter + active step ------------------------------- */
	$$( '[data-ak-process]' ).forEach( function ( sec ) {
		var meter = sec.querySelector( '.ak-process__meter span' );
		var steps = $$( '.ak-process__step', sec );
		var list = sec.querySelector( '.ak-process__steps' );
		var onProcess = rafThrottle( function () {
			var vh = window.innerHeight;
			var r = list.getBoundingClientRect();
			var p = ( vh * 0.6 - r.top ) / r.height;
			p = Math.max( 0, Math.min( 1, p ) );
			if ( meter ) {
				meter.style.setProperty( '--progress', motion() ? p.toFixed( 3 ) : 1 );
			}
			var active = -1;
			steps.forEach( function ( s, i ) {
				var sr = s.getBoundingClientRect();
				if ( sr.top < vh * 0.62 ) {
					active = i;
				}
			} );
			steps.forEach( function ( s, i ) {
				s.classList.toggle( 'is-active', i === active );
			} );
		} );
		window.addEventListener( 'scroll', onProcess, { passive: true } );
		window.addEventListener( 'resize', onProcess );
		onProcess();
	} );

	/* Marquee: subtle skew from scroll velocity (full motion only) --------- */
	var marquees = $$( '.ak-marquee' );
	if ( marquees.length ) {
		var lastY = window.scrollY;
		var skew = 0;
		var ticking = false;
		var decay = function () {
			skew *= 0.88;
			marquees.forEach( function ( m ) {
				m.style.setProperty( '--skew', skew.toFixed( 2 ) + 'deg' );
			} );
			if ( Math.abs( skew ) > 0.05 ) {
				requestAnimationFrame( decay );
			} else {
				ticking = false;
			}
		};
		window.addEventListener( 'scroll', function () {
			if ( ! fullMotion() ) {
				return;
			}
			var y = window.scrollY;
			skew = Math.max( -7, Math.min( 7, skew + ( y - lastY ) * 0.05 ) );
			lastY = y;
			if ( ! ticking ) {
				ticking = true;
				requestAnimationFrame( decay );
			}
		}, { passive: true } );
	}

	/* Pointer-reactive layers (CTA, 404) ---------------------------------- */
	$$( '[data-ak-pointer]' ).forEach( function ( el ) {
		el.addEventListener( 'pointermove', function ( e ) {
			if ( ! fullMotion() || ! finePointer.matches ) {
				return;
			}
			var r = el.getBoundingClientRect();
			el.style.setProperty( '--mx', ( ( e.clientX - r.left ) / r.width * 2 - 1 ).toFixed( 3 ) );
			el.style.setProperty( '--my', ( ( e.clientY - r.top ) / r.height * 2 - 1 ).toFixed( 3 ) );
		} );
		el.addEventListener( 'pointerleave', function () {
			el.style.setProperty( '--mx', 0 );
			el.style.setProperty( '--my', 0 );
		} );
	} );
	var p404 = doc.querySelector( '.ak-404' );
	if ( p404 ) {
		doc.addEventListener( 'pointermove', function ( e ) {
			if ( ! fullMotion() ) {
				return;
			}
			p404.style.setProperty( '--mx', ( e.clientX / window.innerWidth * 2 - 1 ).toFixed( 3 ) );
			p404.style.setProperty( '--my', ( e.clientY / window.innerHeight * 2 - 1 ).toFixed( 3 ) );
		} );
	}

	/* Cursor label on project cards (mouse only) --------------------------- */
	if ( cfg.cursor && finePointer.matches ) {
		var cursor = null;
		doc.addEventListener( 'pointerover', function ( e ) {
			var t = e.target.closest && e.target.closest( '[data-cursor]' );
			if ( ! t || ! motion() ) {
				return;
			}
			if ( ! cursor ) {
				cursor = doc.createElement( 'div' );
				cursor.className = 'ak-cursor';
				cursor.setAttribute( 'aria-hidden', 'true' );
				doc.body.appendChild( cursor );
			}
			cursor.textContent = t.getAttribute( 'data-cursor' );
			cursor.classList.add( 'is-on' );
		} );
		doc.addEventListener( 'pointerout', function ( e ) {
			var t = e.target.closest && e.target.closest( '[data-cursor]' );
			if ( cursor && t && ! t.contains( e.relatedTarget ) ) {
				cursor.classList.remove( 'is-on' );
			}
		} );
		doc.addEventListener( 'pointermove', function ( e ) {
			if ( cursor ) {
				cursor.style.setProperty( '--x', e.clientX + 'px' );
				cursor.style.setProperty( '--y', e.clientY + 'px' );
			}
		}, { passive: true } );
	}

	/* Service page sub-nav: highlight current section -------------------- */
	var subnav = doc.querySelector( '[data-ak-subnav]' );
	if ( subnav && 'IntersectionObserver' in window ) {
		var links = $$( 'a[href^="#"]', subnav );
		var map = {};
		links.forEach( function ( a ) {
			var t = doc.getElementById( a.getAttribute( 'href' ).slice( 1 ) );
			if ( t ) {
				map[ t.id ] = a;
			}
		} );
		var subIO = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( en ) {
				if ( en.isIntersecting && map[ en.target.id ] ) {
					links.forEach( function ( l ) {
						l.classList.remove( 'is-active' );
						l.removeAttribute( 'aria-current' );
					} );
					map[ en.target.id ].classList.add( 'is-active' );
					map[ en.target.id ].setAttribute( 'aria-current', 'location' );
					var ul = subnav.querySelector( 'ul' );
					var a = map[ en.target.id ];
					ul.scrollTo( { left: a.offsetLeft - 24, behavior: 'auto' } );
				}
			} );
		}, { rootMargin: '-40% 0px -55% 0px' } );
		Object.keys( map ).forEach( function ( id ) {
			subIO.observe( doc.getElementById( id ) );
		} );
	}

	/* Reading progress --------------------------------------------------- */
	var progress = doc.querySelector( '[data-ak-progress]' );
	if ( progress ) {
		var article = doc.querySelector( '.ak-article' );
		var onProgress = rafThrottle( function () {
			var r = article.getBoundingClientRect();
			var p = Math.max( 0, Math.min( 1, -r.top / ( r.height - window.innerHeight ) ) );
			progress.style.setProperty( '--p', p.toFixed( 3 ) );
		} );
		window.addEventListener( 'scroll', onProgress, { passive: true } );
		onProgress();
	}

	/* Mobile quick bar: step aside at the footer -------------------------- */
	var bar = doc.querySelector( '[data-ak-mobilebar]' );
	var footer = doc.querySelector( '.ak-footer__bottom' );
	if ( bar && footer && 'IntersectionObserver' in window ) {
		new IntersectionObserver( function ( en ) {
			bar.classList.toggle( 'is-hidden', en[ 0 ].isIntersecting );
		} ).observe( footer );
	}

	/* Motion preference toggle (visitor) ---------------------------------- */
	var motionBtn = doc.querySelector( '[data-ak-motion-toggle]' );
	function store( key, val ) {
		try {
			if ( val === null ) {
				localStorage.removeItem( key );
			} else {
				localStorage.setItem( key, val );
			}
		} catch ( e ) {}
	}
	function read( key ) {
		try {
			return localStorage.getItem( key );
		} catch ( e ) {
			return null;
		}
	}
	if ( motionBtn && ! reduceMQ.matches ) {
		motionBtn.hidden = false;
		var syncBtn = function () {
			var off = read( 'ak-motion' ) === 'off';
			motionBtn.setAttribute( 'aria-pressed', off ? 'true' : 'false' );
			motionBtn.textContent = off ? 'Hareket kapalı' : 'Hareketi azalt';
		};
		syncBtn();
		motionBtn.addEventListener( 'click', function () {
			var off = read( 'ak-motion' ) !== 'off';
			store( 'ak-motion', off ? 'off' : null );
			if ( off ) {
				html.classList.remove( 'ak-motion', 'ak-motion-full', 'ak-motion-lite' );
				html.setAttribute( 'data-motion', 'off' );
				$$( '[data-reveal]' ).forEach( function ( el ) {
					el.classList.add( 'is-in' );
				} );
				doc.dispatchEvent( new CustomEvent( 'akilli:motion', { detail: 'off' } ) );
			} else {
				var level = cfg.motion && cfg.motion !== 'off' ? cfg.motion : 'full';
				html.classList.add( 'ak-motion', 'ak-motion-' + level );
				html.setAttribute( 'data-motion', level );
				$$( '.ak-w' ).forEach( function ( w ) {
					w.classList.add( 'is-on' );
				} );
				doc.dispatchEvent( new CustomEvent( 'akilli:motion', { detail: level } ) );
			}
			syncBtn();
		} );
	}

	/* Cookie notice ------------------------------------------------------- */
	var cookie = doc.querySelector( '[data-ak-cookie]' );
	if ( cookie && read( 'ak-cookie-ok' ) !== '1' ) {
		cookie.hidden = false;
		cookie.querySelector( '[data-ak-cookie-ok]' ).addEventListener( 'click', function () {
			store( 'ak-cookie-ok', '1' );
			cookie.hidden = true;
		} );
	}
}() );
