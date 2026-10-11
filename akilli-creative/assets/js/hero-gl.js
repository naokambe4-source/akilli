/**
 * Akıllı Creative — "living light" hero field.
 * A tiny dependency-free WebGL fragment shader: slowly breathing satin folds
 * in the brand's champagne tone, lit by a light that follows the pointer.
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
	// Satin drapery: long folds along one direction, slowly breathing; the light follows the pointer.
	var fs = [
		'precision mediump float;',
		'uniform vec2 r;uniform float t;uniform vec2 m;uniform vec3 c1,c2,c3,bg;',
		'float H(vec2 p){',
		' float a=1.05;vec2 d=vec2(cos(a),sin(a));vec2 e=vec2(-d.y,d.x);',
		' float u=dot(p,d),v=dot(p,e);',
		' float w=.32*sin(v*2.3+t*.21)+.18*sin(v*4.1-t*.17+u*.6);',
		' float h=sin(u*3.1+w*3.+t*.12);',
		' h+=.55*sin(u*5.3-v*.9+w*2.2-t*.09+1.7);',
		' h+=.28*sin(u*9.1+v*1.7+w*1.4+t*.15+4.1);',
		' h+=.12*sin(u*15.+v*3.1-t*.2+2.3);',
		' return h;',
		'}',
		'void main(){',
		' vec2 uv=gl_FragCoord.xy/r;float ar=r.x/r.y;vec2 p=vec2(uv.x*ar,uv.y)*1.25;',
		' float e=.0025;float h=H(p);',
		' vec3 n=normalize(vec3(-(H(p+vec2(e,0.))-h)/e*.085,-(H(p+vec2(0.,e))-h)/e*.085,1.));',
		' vec3 L=normalize(vec3((m.x-.5)*1.4+.35,(m.y-.5)*1.2+.45,.85));',
		' float diff=clamp(dot(n,L),0.,1.);',
		' vec3 Hh=normalize(L+vec3(0.,0.,1.));',
		' float spec=pow(clamp(dot(n,Hh),0.,1.),22.);',
		' float sheen=pow(1.-clamp(n.z,0.,1.),2.)*.35;',
		' vec3 col=c1*(.6+.48*diff)+vec3(1.,.97,.92)*spec*.32+c2*sheen*.25;',
		' col=mix(col,bg,.08);',
		' float vg=1.-.22*length(uv-vec2(.5,.45));',
		' col*=vg;',
		' float g=fract(sin(dot(gl_FragCoord.xy+t,vec2(12.9898,78.233)))*43758.5453)*.022-.011;',
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
	gl.uniform3fv( u.c1, lighten( color( '--ak-tint', '#d8c6a6' ), 0.12 ) );
	gl.uniform3fv( u.c2, lighten( color( '--ak-accent', '#8c5a34' ), 0.2 ) );
	gl.uniform3fv( u.c3, color( '--ak-ink', '#15130f' ) );
	gl.uniform3fv( u.bg, color( '--ak-paper', '#f3efe7' ) );

	var scale = 0.75;
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

	var mouse = [ 0.62, 0.7 ];
	var target = [ 0.62, 0.7 ];
	var visible = true;
	var running = false;
	var start = performance.now();
	var still = 12.0;

	function draw( time ) {
		mouse[ 0 ] += ( target[ 0 ] - mouse[ 0 ] ) * 0.025;
		mouse[ 1 ] += ( target[ 1 ] - mouse[ 1 ] ) * 0.025;
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
		( hero.querySelector( '[data-ak-plate]' ) || hero ).addEventListener( 'pointermove', function ( e ) {
			var r = canvas.getBoundingClientRect();
			target[ 0 ] = ( e.clientX - r.left ) / r.width;
			target[ 1 ] = 1 - ( e.clientY - r.top ) / r.height;
		} );
	}
	update();
}() );
