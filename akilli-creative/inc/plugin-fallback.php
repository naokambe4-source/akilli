<?php
/**
 * Minimal fallbacks so the theme keeps working (header, footer, blog, pages)
 * when the "Akıllı Creative Çekirdek" plugin is not active.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/icons.php';

/**
 * Whether the companion plugin is active.
 *
 * @return bool
 */
function akilli_core_active() {
	return defined( 'AKILLI_CORE_VERSION' );
}

if ( ! function_exists( 'akilli_get_setting' ) ) {
	/**
	 * Fallback contact settings.
	 *
	 * @param string $key Key.
	 * @return string
	 */
	function akilli_get_setting( $key ) {
		$defaults = array(
			'company_name'  => get_bloginfo( 'name' ),
			'email'         => get_option( 'admin_email' ),
			'phone'         => '',
			'whatsapp'      => '',
			'whatsapp_text' => '',
			'address'       => '',
			'map_url'       => '',
			'working_hours' => '',
		);
		return isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	}
}

if ( ! function_exists( 'akilli_phone_href' ) ) {
	/**
	 * Fallback tel: link.
	 *
	 * @return string
	 */
	function akilli_phone_href() {
		$d = preg_replace( '/[^0-9+]/', '', (string) akilli_get_setting( 'phone' ) );
		return $d ? 'tel:' . $d : '';
	}
}

if ( ! function_exists( 'akilli_whatsapp_url' ) ) {
	/**
	 * Fallback WhatsApp link.
	 *
	 * @return string
	 */
	function akilli_whatsapp_url() {
		$d = preg_replace( '/[^0-9]/', '', (string) akilli_get_setting( 'whatsapp' ) );
		return $d ? 'https://wa.me/' . $d : '';
	}
}

if ( ! function_exists( 'akilli_social_links' ) ) {
	/**
	 * Fallback socials.
	 *
	 * @return array
	 */
	function akilli_social_links() {
		return array();
	}
}

if ( ! function_exists( 'akilli_inline' ) ) {
	/**
	 * Fallback inline kses echo.
	 *
	 * @param string $html HTML.
	 */
	function akilli_inline( $html ) {
		echo wp_kses( (string) $html, array( 'em' => array(), 'strong' => array(), 'br' => array(), 'a' => array( 'href' => true ) ) );
	}
}

if ( ! function_exists( 'akilli_reading_time' ) ) {
	/**
	 * Fallback reading time.
	 *
	 * @param int|WP_Post $post Post.
	 * @return int
	 */
	function akilli_reading_time( $post = null ) {
		$post = get_post( $post );
		return $post ? max( 1, (int) ceil( count( preg_split( '/\s+/u', wp_strip_all_tags( $post->post_content ), -1, PREG_SPLIT_NO_EMPTY ) ) / 200 ) ) : 1;
	}
}

if ( ! function_exists( 'akilli_quote_url' ) ) {
	/**
	 * Fallback quote URL.
	 *
	 * @return string
	 */
	function akilli_quote_url() {
		return home_url( '/teklif-al/' );
	}
}

if ( ! function_exists( 'akilli_breadcrumb_trail' ) ) {
	/**
	 * Fallback breadcrumb trail.
	 *
	 * @return array
	 */
	function akilli_breadcrumb_trail() {
		$trail = array(
			array(
				'name' => 'Ana sayfa',
				'url'  => home_url( '/' ),
			),
		);
		if ( is_singular() ) {
			$trail[] = array(
				'name' => get_the_title(),
				'url'  => '',
			);
		}
		return $trail;
	}
}

if ( ! function_exists( 'akilli_contact_links' ) ) {
	/**
	 * Fallback contact links.
	 *
	 * @param string $class Class.
	 */
	function akilli_contact_links( $class = '' ) {
		$mail = akilli_get_setting( 'email' );
		if ( $mail ) {
			echo '<div class="ak-clinks ' . esc_attr( $class ) . '"><a class="ak-clink" href="' . esc_url( 'mailto:' . $mail ) . '">' . akilli_icon( 'mail' ) . '<span>' . esc_html( $mail ) . '</span></a></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}
