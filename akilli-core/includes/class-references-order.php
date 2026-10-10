<?php
/**
 * Drag & drop ordering screen for references (and projects).
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sortable list saved to menu_order via admin-ajax with nonce + capability checks.
 */
class Akilli_References_Order {

	/**
	 * Hooks.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
		add_action( 'wp_ajax_akilli_save_order', array( __CLASS__, 'save' ) );
	}

	/**
	 * Types that can be ordered.
	 *
	 * @return array
	 */
	private static function types() {
		return array(
			'ak_referans' => 'Referans sıralaması',
			'ak_proje'    => 'Proje sıralaması',
		);
	}

	/**
	 * Submenu pages.
	 */
	public static function menu() {
		foreach ( self::types() as $type => $title ) {
			add_submenu_page(
				'edit.php?post_type=' . $type,
				$title,
				'Sıralama',
				'edit_others_posts',
				'akilli-order-' . $type,
				function () use ( $type, $title ) {
					self::render( $type, $title );
				}
			);
		}
	}

	/**
	 * Render page.
	 *
	 * @param string $type  Post type.
	 * @param string $title Title.
	 */
	private static function render( $type, $title ) {
		wp_enqueue_style( 'akilli-admin', AKILLI_CORE_URL . 'assets/admin.css', array(), AKILLI_CORE_VERSION );
		wp_enqueue_script( 'akilli-admin', AKILLI_CORE_URL . 'assets/admin.js', array( 'jquery', 'jquery-ui-sortable' ), AKILLI_CORE_VERSION, true );
		$items = get_posts(
			array(
				'post_type'   => $type,
				'post_status' => array( 'publish', 'draft', 'pending', 'private' ),
				'numberposts' => 300,
				'orderby'     => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
			)
		);
		echo '<div class="wrap"><h1>' . esc_html( $title ) . '</h1>';
		echo '<p>Öğeleri sürükleyip bırakarak sıralayın, ardından <strong>Sıralamayı kaydet</strong> düğmesine basın. Sitede bu sıra kullanılır.</p>';
		if ( ! $items ) {
			echo '<p><em>Henüz kayıt yok.</em></p></div>';
			return;
		}
		echo '<ul class="ak-order" data-ak-order data-type="' . esc_attr( $type ) . '" data-nonce="' . esc_attr( wp_create_nonce( 'akilli_order_' . $type ) ) . '">';
		foreach ( $items as $item ) {
			echo '<li class="ak-order__item" data-id="' . esc_attr( $item->ID ) . '" tabindex="0"><span class="ak-order__handle dashicons dashicons-menu" aria-hidden="true"></span>';
			echo get_the_post_thumbnail( $item->ID, array( 80, 40 ) );
			echo '<span class="ak-order__title">' . esc_html( get_the_title( $item ) ) . '</span>';
			if ( 'publish' !== $item->post_status ) {
				echo ' <em>(' . esc_html( get_post_status_object( $item->post_status )->label ) . ')</em>';
			}
			echo '<span class="ak-order__move"><button type="button" class="button-link" data-move="up" aria-label="Yukarı taşı">↑</button> <button type="button" class="button-link" data-move="down" aria-label="Aşağı taşı">↓</button></span></li>';
		}
		echo '</ul><p><button type="button" class="button button-primary" data-ak-order-save>Sıralamayı kaydet</button> <span class="ak-order__status" role="status" aria-live="polite"></span></p></div>';
	}

	/**
	 * AJAX save.
	 */
	public static function save() {
		$type = isset( $_POST['type'] ) ? sanitize_key( wp_unslash( $_POST['type'] ) ) : '';
		if ( ! array_key_exists( $type, self::types() ) ) {
			wp_send_json_error( 'Geçersiz tür.', 400 );
		}
		check_ajax_referer( 'akilli_order_' . $type, 'nonce' );
		if ( ! current_user_can( 'edit_others_posts' ) ) {
			wp_send_json_error( 'Yetkiniz yok.', 403 );
		}
		$ids = isset( $_POST['ids'] ) ? array_map( 'absint', (array) wp_unslash( $_POST['ids'] ) ) : array();
		foreach ( $ids as $i => $id ) {
			if ( get_post_type( $id ) === $type && current_user_can( 'edit_post', $id ) ) {
				wp_update_post(
					array(
						'ID'         => $id,
						'menu_order' => $i,
					)
				);
			}
		}
		wp_send_json_success( 'Sıralama kaydedildi.' );
	}
}
