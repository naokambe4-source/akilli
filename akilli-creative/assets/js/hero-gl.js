/**
 * Akıllı Creative — "living light" hero field.
 * A tiny dependency-free WebGL fragment shader: brand colours drift like light
 * through layered glass and bend softly around the pointer.
 * Skipped on small screens (unless enabled), without WebGL, or when motion is off
 * (then a single still frame is drawn). The CSS orb layer stays as fallback.
 */
( function () {
	'use strict';
	var cfg = window.akilliTheme || {};
	var canvas = document.querySelector( '[data-ak-gl]' );
	if ( ! canvas || ! cfg.gl ) {
		return;
	}
	if ( ! cfg.glMobile && window.matchMedia( '(max-width: 899px)' ).matches ) {
		return;
	}
	var gl = canvas.getContext( 'webgl', { antialias: false, alpha: false, premultipliedAlpha: false, powerPreference: 'low-power' } );
	if ( ! gl ) {
		return;
	}
	var html = document.documentElement;
	var hero = canvas.closest( '.ak-hero' );

	var vs = 'attribute vec2 a;void main(){gl_Position=vec4(a,0.,1.);}';
	var fs = [
		'precision mediump float;',
		'uniform vec2 r;uniform float t;uniform vec2 m;uniform vec3 c1,c2,c3,bg;',
		'float h(vec2 p){return fract(sin(dot(p,vec2(127.1,311.7)))*43758.5453);}',
		'float n(vec2 p){vec2 i=floor(p),f=fract(p);f=f*f*(3.-2.*f);return mix(mix(h(i),h(i+vec2(1.,0.)),f.x),mix(h(i+vec2(0.,1.)),h(i+vec2(1.,1.)),f.x),f.y);}',
		'float fbm(vec2 p){float v=0.,a=.5;for(int i=0;i<5;i++){v+=a*n(p);p=p*2.03+vec2(1.7,9.2);a*=.5;}return v;}',
		'void main(){',
		' vec2 uv=gl_FragCoord.xy/r;float ar=r.x/r.y;vec2 p=vec2(uv.x*ar,uv.y);vec2 mm=vec2(m.x*ar,m.y);',
		' float d=distance(p,mm);',
		' vec2 q=vec2(fbm(p*1.5+t*.045),fbm(p*1.5+vec2(5.2,1.3)-t*.038));',
		' q+=(p-mm)*.35*exp(-d*2.6);',
		' vec2 s=vec2(fbm(p*1.3+2.*q+vec2(1.7,9.2)+t*.05),fbm(p*1.3+2.*q+vec2(8.3,2.8)-t*.042));',
		' float f=fbm(p*1.1+2.3*s);',
		' vec3 col=bg;',
		' col=mix(col,c1,smoothstep(.32,.86,f)*.80);',
		' col=mix(col,c3,smoothstep(.52,.98,s.x)*.42);',
		' col=mix(col,c2,smoothstep(.58,1.,s.y)*.50);',
		' col=mix(col,bg,(1.-uv.x)*.38+(1.-uv.y)*.12);',
		' col+=vec3(.07)*exp(-d*d*14.);',
		' float g=h(gl_FragCoord.xy+t)*.035-.0175;',
		' gl_FragColor=vec4(col+g,1.);',
		'}'
	].join( '\n' );

	function shader( type, src ) {
		var s = gl.createShader( type );
		gl.shaderSource( s, src );
		gl.compileShader( s );
		return gl.getShaderParameter( s, gl.COMPILE_STATUS ) ? s : null;
	}
	var v = shader( gl.VERTEX_SHADER, vs );
	var f = shader( gl.FRAGMENT_SHADER, fs );
	if ( ! v || ! f ) {
		return;
	}
	var prog = gl.createProgram();
	gl.attachShader( prog, v );
	gl.attachShader( prog, f );
	gl.linkProgram( prog );
	if ( ! gl.getProgramParameter( prog, gl.LINK_STATUS ) ) {
		return;
	}
	gl.useProgram( prog );
	var buf = gl.createBuffer();
	gl.bindBuffer( gl.ARRAY_BUFFER, buf );
	gl.bufferData( gl.ARRAY_BUFFER, new Float32Array( [ -1, -1, 1, -1, -1, 1, 1, 1 ] ), gl.STATIC_DRAW );
	var loc = gl.getAttribLocation( prog, 'a' );
	gl.enableVertexAttribArray( loc );
	gl.vertexAttribPointer( loc, 2, gl.FLOAT, false, 0, 0 );
	var u = {};
	[ 'r', 't', 'm', 'c1', 'c2', 'c3', 'bg' ].forEach( function ( k ) {
		u[ k ] = gl.getUniformLocation( prog, k );
	} );

	function color( name, fallback ) {
		var val = getComputedStyle( html ).getPropertyValue( name ).trim() || fallback;
		var hex = /^#([0-9a-f]{3}|[0-9a-f]{6})$/i.test( val ) ? val : fallback;
		if ( hex.length === 4 ) {
			hex = '#' + hex[ 1 ] + hex[ 1 ] + hex[ 2 ] + hex[ 2 ] + hex[ 3 ] + hex[ 3 ];
		}
		return [ 1, 3, 5 ].map( function ( i ) {
			return parseInt( hex.substr( i, 2 ), 16 ) / 255;
		} );
	}
	function lighten( c, k ) {
		return c.map( function ( x ) {
			return x + ( 1 - x ) * k;
		} );
	}
	gl.uniform3fv( u.c1, lighten( color( '--ak-tint', '#8698ff' ), 0.18 ) );
	gl.uniform3fv( u.c2, lighten( color( '--ak-accent', '#ff6b3d' ), 0.35 ) );
	gl.uniform3fv( u.c3, lighten( color( '--ak-primary', '#3b46f1' ), 0.3 ) );
	gl.uniform3fv( u.bg, color( '--ak-paper', '#f6f5f1' ) );

	var scale = 0.55;
	function resize() {
		var dpr = Math.min( window.devicePixelRatio || 1, 1.5 ) * scale;
		var w = Math.max( 1, Math.round( canvas.clientWidth * dpr ) );
		var h = Math.max( 1, Math.round( canvas.clientHeight * dpr ) );
		if ( canvas.width !== w || canvas.height !== h ) {
			canvas.width = w;
			canvas.height = h;
			gl.viewport( 0, 0, w, h );
		}
		gl.uniform2f( u.r, w, h );
	}

	var mouse = [ 0.72, 0.55 ];
	var target = [ 0.72, 0.55 ];
	var visible = true;
	var running = false;
	var start = performance.now();
	var still = 12.0;

	function draw( time ) {
		mouse[ 0 ] += ( target[ 0 ] - mouse[ 0 ] ) * 0.05;
		mouse[ 1 ] += ( target[ 1 ] - mouse[ 1 ] ) * 0.05;
		gl.uniform1f( u.t, time );
		gl.uniform2f( u.m, mouse[ 0 ], mouse[ 1 ] );
		gl.drawArrays( gl.TRIANGLE_STRIP, 0, 4 );
	}
	function frame( now ) {
		if ( ! running ) {
			return;
		}
		draw( still + ( now - start ) / 1000 );
		requestAnimationFrame( frame );
	}
	function motionOn() {
		return html.classList.contains( 'ak-motion' );
	}
	function update() {
		var should = visible && ! document.hidden && motionOn();
		if ( should && ! running ) {
			running = true;
			start = performance.now();
			requestAnimationFrame( frame );
		} else if ( ! should && running ) {
			running = false;
			still += ( performance.now() - start ) / 1000;
		}
		if ( ! should ) {
			draw( still );
		}
	}

	resize();
	draw( still );
	canvas.classList.add( 'is-ready' );
	if ( hero ) {
		hero.classList.add( 'has-gl' );
	}

	window.addEventListener( 'resize', function () {
		resize();
		draw( still );
	} );
	if ( 'IntersectionObserver' in window ) {
		new IntersectionObserver( function ( en ) {
			visible = en[ 0 ].isIntersecting;
			update();
		} ).observe( canvas );
	}
	document.addEventListener( 'visibilitychange', update );
	document.addEventListener( 'akilli:motion', update );
	if ( hero && window.matchMedia( '(hover: hover) and (pointer: fine)' ).matches ) {
		hero.addEventListener( 'pointermove', function ( e ) {
			var r = canvas.getBoundingClientRect();
			target[ 0 ] = ( e.clientX - r.left ) / r.width;
			target[ 1 ] = 1 - ( e.clientY - r.top ) / r.height;
		} );
	}
	update();
}() );
