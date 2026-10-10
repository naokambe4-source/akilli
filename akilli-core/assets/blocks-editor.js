/**
 * Akıllı Creative – schema-driven editor UI for server-rendered blocks.
 * No build step: plain wp.element.createElement.
 */
( function ( wp, data ) {
	'use strict';
	if ( ! wp || ! data ) {
		return;
	}
	var el = wp.element.createElement;
	var Fragment = wp.element.Fragment;
	var be = wp.blockEditor;
	var c = wp.components;
	var SSR = wp.serverSideRender;
	var useSelect = wp.data.useSelect;

	function ImageField( props ) {
		var media = useSelect( function ( select ) {
			return props.value ? select( 'core' ).getMedia( props.value ) : null;
		}, [ props.value ] );
		return el( 'div', { className: 'ak-ed-image' },
			el( 'p', { className: 'ak-ed-label' }, props.label ),
			media && media.source_url ? el( 'img', { src: media.media_details && media.media_details.sizes && media.media_details.sizes.medium ? media.media_details.sizes.medium.source_url : media.source_url, alt: '', style: { maxWidth: '100%', borderRadius: '6px', display: 'block', marginBottom: '8px' } } ) : null,
			el( be.MediaUploadCheck, null,
				el( be.MediaUpload, {
					onSelect: function ( m ) {
						props.onChange( m.id );
					},
					allowedTypes: [ 'image' ],
					value: props.value,
					render: function ( o ) {
						return el( c.Button, { variant: 'secondary', onClick: o.open }, props.value ? 'Görseli değiştir' : 'Görsel seç' );
					}
				} )
			),
			props.value ? el( c.Button, { variant: 'link', isDestructive: true, onClick: function () {
				props.onChange( 0 );
			}, style: { marginLeft: '8px' } }, 'Kaldır' ) : null
		);
	}

	function Field( props ) {
		var f = props.field;
		var v = props.value;
		var set = props.onChange;
		switch ( f.type ) {
			case 'textarea':
				return el( c.TextareaControl, { label: f.label, help: f.help, value: v || '', onChange: set, rows: 3, __nextHasNoMarginBottom: true } );
			case 'toggle':
				return el( c.ToggleControl, { label: f.label, help: f.help, checked: !! v, onChange: set, __nextHasNoMarginBottom: true } );
			case 'number':
				return el( c.TextControl, { type: 'number', label: f.label, help: f.help, value: v || 0, onChange: function ( x ) {
					set( parseInt( x, 10 ) || 0 );
				}, __nextHasNoMarginBottom: true } );
			case 'select':
				return el( c.SelectControl, { label: f.label, help: f.help, value: v || '', options: f.options || [], onChange: set, __nextHasNoMarginBottom: true } );
			case 'image':
				return el( ImageField, { label: f.label, value: v, onChange: set } );
			case 'repeater':
				return el( Repeater, { field: f, value: v || [], onChange: set } );
			default:
				return el( c.TextControl, { type: f.type === 'url' ? 'url' : 'text', label: f.label, help: f.help, value: v || '', onChange: set, __nextHasNoMarginBottom: true } );
		}
	}

	function Repeater( props ) {
		var items = props.value.slice();
		var f = props.field;
		function update( i, key, val ) {
			var next = items.slice();
			next[ i ] = Object.assign( {}, next[ i ] );
			next[ i ][ key ] = val;
			props.onChange( next );
		}
		function move( i, d ) {
			var j = i + d;
			if ( j < 0 || j >= items.length ) {
				return;
			}
			var next = items.slice();
			var t = next[ i ];
			next[ i ] = next[ j ];
			next[ j ] = t;
			props.onChange( next );
		}
		function remove( i ) {
			var next = items.slice();
			next.splice( i, 1 );
			props.onChange( next );
		}
		var keys = Object.keys( f.fields );
		return el( 'div', { className: 'ak-ed-repeater' },
			el( 'p', { className: 'ak-ed-label' }, f.label + ' (' + items.length + ')' ),
			items.map( function ( item, i ) {
				var first = item[ keys[ 0 ] ] || item[ keys[ 1 ] ] || ( 'Öğe ' + ( i + 1 ) );
				return el( c.PanelBody, { key: i, title: ( i + 1 ) + '. ' + String( first ).slice( 0, 40 ), initialOpen: false },
					keys.map( function ( k ) {
						return el( 'div', { key: k, style: { marginBottom: '12px' } }, el( Field, { field: f.fields[ k ], value: item[ k ], onChange: function ( val ) {
							update( i, k, val );
						} } ) );
					} ),
					el( 'div', { style: { display: 'flex', gap: '6px' } },
						el( c.Button, { variant: 'secondary', size: 'small', onClick: function () {
							move( i, -1 );
						}, disabled: i === 0, label: 'Yukarı taşı' }, '↑' ),
						el( c.Button, { variant: 'secondary', size: 'small', onClick: function () {
							move( i, 1 );
						}, disabled: i === items.length - 1, label: 'Aşağı taşı' }, '↓' ),
						el( c.Button, { variant: 'link', isDestructive: true, onClick: function () {
							remove( i );
						} }, 'Sil' )
					)
				);
			} ),
			el( c.Button, { variant: 'primary', style: { marginTop: '8px' }, onClick: function () {
				props.onChange( items.concat( [ {} ] ) );
			} }, '+ Öğe ekle' )
		);
	}

	Object.keys( data.blocks ).forEach( function ( name ) {
		var def = data.blocks[ name ];
		var full = 'akilli/' + name;

		var groups = {};
		Object.keys( def.fields ).forEach( function ( k ) {
			var g = def.fields[ k ].group || 'İçerik';
			( groups[ g ] = groups[ g ] || [] ).push( k );
		} );

		wp.blocks.registerBlockType( full, {
			apiVersion: 3,
			title: def.title,
			description: def.description,
			icon: def.icon,
			category: 'akilli',
			attributes: def.attributes,
			supports: { html: false },
			edit: function ( props ) {
				var blockProps = be.useBlockProps( { className: 'ak-ed-block' } );
				var panels = Object.keys( groups ).map( function ( g, gi ) {
					return el( c.PanelBody, { key: g, title: g, initialOpen: gi === 0 },
						groups[ g ].map( function ( k ) {
							return el( 'div', { key: k, style: { marginBottom: '16px' } }, el( Field, {
								field: def.fields[ k ],
								value: props.attributes[ k ],
								onChange: function ( val ) {
									var o = {};
									o[ k ] = val;
									props.setAttributes( o );
								}
							} ) );
						} )
					);
				} );
				return el( Fragment, null,
					el( be.InspectorControls, null, panels ),
					el( 'div', blockProps,
						el( 'div', { className: 'ak-ed-tag' }, def.title + ' — içeriği sağ paneldeki alanlardan düzenleyin' ),
						el( 'div', { className: 'ak-ed-preview', style: { pointerEvents: 'none' } }, el( SSR, { block: full, attributes: props.attributes, httpMethod: 'POST' } ) )
					)
				);
			},
			save: function () {
				return null;
			}
		} );
	} );
}( window.wp, window.akilliBlocks ) );
