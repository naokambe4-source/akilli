/* Akıllı Creative – admin helpers: project gallery, drag & drop ordering. */
( function ( $ ) {
	'use strict';

	// Project gallery picker.
	$( '[data-ak-gallery]' ).each( function () {
		var $box = $( this );
		var $list = $box.find( '.ak-gallery__list' );
		var $input = $box.find( 'input[name="ak_gallery"]' );
		var frame;

		function sync() {
			var ids = $list.children().map( function () {
				return $( this ).data( 'id' );
			} ).get();
			$input.val( ids.join( ',' ) );
		}

		$list.sortable( { update: sync } );

		$box.on( 'click', '.ak-gallery__remove', function () {
			$( this ).closest( 'li' ).remove();
			sync();
		} );

		$box.on( 'click', '[data-ak-gallery-add]', function ( e ) {
			e.preventDefault();
			if ( ! frame ) {
				frame = wp.media( {
					title: 'Galeri görselleri seçin',
					button: { text: 'Galeriye ekle' },
					library: { type: 'image' },
					multiple: true
				} );
				frame.on( 'select', function () {
					frame.state().get( 'selection' ).each( function ( att ) {
						var a = att.toJSON();
						var src = a.sizes && a.sizes.thumbnail ? a.sizes.thumbnail.url : a.url;
						var $li = $( '<li/>' ).attr( 'data-id', a.id ).data( 'id', a.id );
						$( '<img/>' ).attr( { src: src, alt: '' } ).appendTo( $li );
						$( '<button type="button" class="ak-gallery__remove" aria-label="Görseli kaldır">×</button>' ).appendTo( $li );
						$list.append( $li );
					} );
					sync();
				} );
			}
			frame.open();
		} );
	} );

	// Ordering screen.
	$( '[data-ak-order]' ).each( function () {
		var $list = $( this );
		var $status = $( '.ak-order__status' );
		$list.sortable( { handle: '.ak-order__handle', axis: 'y' } );

		$list.on( 'click', '[data-move]', function () {
			var $li = $( this ).closest( 'li' );
			if ( $( this ).data( 'move' ) === 'up' ) {
				$li.prev().before( $li );
			} else {
				$li.next().after( $li );
			}
			$( this ).trigger( 'focus' );
		} );

		$( '[data-ak-order-save]' ).on( 'click', function () {
			var ids = $list.children().map( function () {
				return $( this ).data( 'id' );
			} ).get();
			$status.text( 'Kaydediliyor…' );
			$.post( window.ajaxurl, {
				action: 'akilli_save_order',
				type: $list.data( 'type' ),
				nonce: $list.data( 'nonce' ),
				ids: ids
			} ).done( function ( r ) {
				$status.text( r && r.success ? r.data : 'Kaydedilemedi.' );
			} ).fail( function () {
				$status.text( 'Kaydedilemedi. Sayfayı yenileyip tekrar deneyin.' );
			} );
		} );
	} );
}( jQuery ) );
