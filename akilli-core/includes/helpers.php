<?php
/**
 * Shared helper functions.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/icons.php';
require_once __DIR__ . '/template-functions.php';

/**
 * Default settings. Brand contact data is pre-filled; every value is editable
 * under "Akıllı Creative → Ayarlar".
 *
 * @return array
 */
if ( ! function_exists( 'akilli_settings_defaults' ) ) :
function akilli_settings_defaults() {
	return array(
		// Contact.
		'company_name'    => 'Akıllı Creative',
		'email'           => 'info@akillicreative.com',
		'phone'           => '+90 530 611 82 80',
		'whatsapp'        => '+90 530 611 82 80',
		'whatsapp_text'   => 'Merhaba, web sitenizden ulaşıyorum. Bir proje hakkında bilgi almak istiyorum.',
		'address'         => 'Kızılsaray Mah. Ofisbudur Plaza No:26/101 Kat 1, Muratpaşa / Antalya',
		'address_street'  => 'Kızılsaray Mah. Ofisbudur Plaza No:26/101 Kat 1',
		'address_city'    => 'Antalya',
		'address_region'  => 'Muratpaşa',
		'address_postal'  => '',
		'map_url'         => 'https://www.google.com/maps/search/?api=1&query=Ofisbudur+Plaza+Muratpa%C5%9Fa+Antalya',
		'working_hours'   => 'Hafta içi 09:00 – 18:30',
		'instagram'       => 'https://www.instagram.com/akillicreative/',
		'linkedin'        => '',
		'facebook'        => '',
		'youtube'         => '',
		'x'               => '',
		// Notifications.
		'notify_emails'   => '',
		'mail_subject'    => '[Akıllı Creative] Yeni {tur}: {ad}',
		// Quote form.
		'q_req_company'   => 0,
		'q_req_phone'     => 1,
		'q_show_budget'   => 1,
		'q_req_budget'    => 0,
		'q_budgets'       => "15.000 ₺ altı\n15.000 – 40.000 ₺\n40.000 – 100.000 ₺\n100.000 ₺ üzeri\nHenüz net değil",
		'q_intro'         => 'Projenizi birkaç cümleyle anlatın; ihtiyacınızı inceleyip en geç bir iş günü içinde size dönüş yapalım. Bütçe alanı isteğe bağlıdır ve yalnızca doğru kapsamı önermemize yardımcı olur.',
		'q_success'       => 'Teşekkürler! Talebiniz bize ulaştı. Ekibimiz ihtiyacınızı inceleyip en kısa sürede sizinle iletişime geçecek.',
		'consent_text'    => 'Kişisel verilerimin, talebime yanıt verilmesi amacıyla {kvkk} kapsamında işlenmesini kabul ediyorum.',
		'privacy_page'    => 0,
		// Contact form.
		'c_success'       => 'Mesajınız için teşekkürler! En kısa sürede size dönüş yapacağız.',
		// AI / answer engines.
		'llms_enabled'      => 1,
		'llms_summary'      => 'Akıllı Creative, Antalya merkezli bir dijital ajanstır. Türkiye genelindeki işletmeler için web tasarım, e-ticaret yazılımı, kurumsal kimlik ve grafik tasarım, SEO, AEO/GEO (yapay zekâ arama görünürlüğü), dijital reklam ve sosyal medya hizmetleri sunar.',
		'llms_facts'        => '',
		'ai_block_training' => 0,
		// Spam.
		'min_seconds'     => 3,
		'rate_limit'      => 5,
	);
}
endif;

/**
 * Get one plugin setting.
 *
 * @param string $key Setting key.
 * @return mixed
 */
if ( ! function_exists( 'akilli_get_setting' ) ) :
function akilli_get_setting( $key ) {
	static $cache = null;
	if ( null === $cache || doing_action( 'update_option_akilli_core_settings' ) ) {
		$cache = wp_parse_args( (array) get_option( 'akilli_core_settings', array() ), akilli_settings_defaults() );
	}
	return isset( $cache[ $key ] ) ? $cache[ $key ] : null;
}
endif;

/**
 * Digits-only phone for tel: links, e.g. +905306118280.
 *
 * @param string $key Setting key holding the number.
 * @return string
 */
if ( ! function_exists( 'akilli_phone_href' ) ) :
function akilli_phone_href( $key = 'phone' ) {
	$raw    = (string) akilli_get_setting( $key );
	$digits = preg_replace( '/[^0-9+]/', '', $raw );
	return $digits ? 'tel:' . $digits : '';
}
endif;

/**
 * WhatsApp click-to-chat URL.
 *
 * @param string $text Optional prefilled message.
 * @return string
 */
if ( ! function_exists( 'akilli_whatsapp_url' ) ) :
function akilli_whatsapp_url( $text = '' ) {
	$digits = preg_replace( '/[^0-9]/', '', (string) akilli_get_setting( 'whatsapp' ) );
	if ( ! $digits ) {
		return '';
	}
	$text = $text ? $text : (string) akilli_get_setting( 'whatsapp_text' );
	return 'https://wa.me/' . $digits . ( $text ? '?text=' . rawurlencode( $text ) : '' );
}
endif;

/**
 * Social profile list (only filled ones).
 *
 * @return array network => url
 */
if ( ! function_exists( 'akilli_social_links' ) ) :
function akilli_social_links() {
	$out = array();
	foreach ( array( 'instagram', 'linkedin', 'facebook', 'youtube', 'x' ) as $net ) {
		$url = akilli_get_setting( $net );
		if ( $url ) {
			$out[ $net ] = $url;
		}
	}
	return $out;
}
endif;

/**
 * Whether Yoast SEO or Rank Math is active. When true, the plugin outputs no
 * meta description, canonical, Open Graph or JSON-LD of its own.
 *
 * @return bool
 */
if ( ! function_exists( 'akilli_seo_plugin_active' ) ) :
function akilli_seo_plugin_active() {
	$active = defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) || defined( 'RANK_MATH_VERSION' );
	return (bool) apply_filters( 'akilli_seo_plugin_active', $active );
}
endif;

/**
 * Locate a block template; themes may override at
 * {theme}/akilli-core/blocks/{name}.php.
 *
 * @param string $name Template name.
 * @return string
 */
if ( ! function_exists( 'akilli_locate_block_template' ) ) :
function akilli_locate_block_template( $name ) {
	$theme = locate_template( 'akilli-core/blocks/' . $name . '.php' );
	return $theme ? $theme : AKILLI_CORE_DIR . 'blocks/' . $name . '.php';
}
endif;

/**
 * Service tree: top-level categories with ordered children.
 *
 * @return array[] Each: [ 'post' => WP_Post, 'children' => WP_Post[] ]
 */
if ( ! function_exists( 'akilli_get_service_tree' ) ) :
function akilli_get_service_tree() {
	static $tree = null;
	if ( null !== $tree ) {
		return $tree;
	}
	$tree = array();
	$all  = get_posts(
		array(
			'post_type'        => 'ak_hizmet',
			'post_status'      => 'publish',
			'numberposts'      => 200,
			'orderby'          => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
			'suppress_filters' => false,
		)
	);
	foreach ( $all as $p ) {
		if ( ! $p->post_parent ) {
			$tree[ $p->ID ] = array(
				'post'     => $p,
				'children' => array(),
			);
		}
	}
	foreach ( $all as $p ) {
		if ( $p->post_parent && isset( $tree[ $p->post_parent ] ) ) {
			$tree[ $p->post_parent ]['children'][] = $p;
		}
	}
	return $tree;
}
endif;

/**
 * Allowed inline HTML for short editable texts (titles, intros).
 *
 * @return array
 */
if ( ! function_exists( 'akilli_inline_kses' ) ) :
function akilli_inline_kses() {
	return array(
		'em'     => array(),
		'strong' => array(),
		'br'     => array(),
		'mark'   => array(),
		'span'   => array( 'class' => true ),
		'a'      => array(
			'href'   => true,
			'target' => true,
			'rel'    => true,
		),
	);
}
endif;

/**
 * Echo sanitized inline HTML.
 *
 * @param string $html Input.
 */
if ( ! function_exists( 'akilli_inline' ) ) :
function akilli_inline( $html ) {
	echo wp_kses( (string) $html, akilli_inline_kses() );
}
endif;

/**
 * Split multi-line textarea values into a clean array.
 *
 * @param string $text Text.
 * @return string[]
 */
if ( ! function_exists( 'akilli_lines' ) ) :
function akilli_lines( $text ) {
	return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $text ) ), 'strlen' ) );
}
endif;

/**
 * Get services attached to a project.
 *
 * @param int $post_id Project ID.
 * @return int[]
 */
if ( ! function_exists( 'akilli_project_service_ids' ) ) :
function akilli_project_service_ids( $post_id ) {
	return array_map( 'absint', (array) get_post_meta( $post_id, '_ak_service', false ) );
}
endif;

/**
 * Projects related to a service (and its children when it is a category).
 *
 * @param int $service_id Service ID.
 * @param int $limit      Max results.
 * @return WP_Post[]
 */
if ( ! function_exists( 'akilli_projects_for_service' ) ) :
function akilli_projects_for_service( $service_id, $limit = 3 ) {
	$ids      = array( (int) $service_id );
	$children = get_children(
		array(
			'post_parent' => $service_id,
			'post_type'   => 'ak_hizmet',
			'post_status' => 'publish',
			'fields'      => 'ids',
		)
	);
	$ids      = array_merge( $ids, array_map( 'intval', (array) $children ) );
	return get_posts(
		array(
			'post_type'   => 'ak_proje',
			'numberposts' => $limit,
			'meta_query'  => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				array(
					'key'     => '_ak_service',
					'value'   => $ids,
					'compare' => 'IN',
				),
			),
		)
	);
}
endif;

/**
 * Blog posts related to a service via the "İlgili hizmetler" box.
 *
 * @param int $service_id Service ID.
 * @param int $limit      Max results.
 * @return WP_Post[]
 */
if ( ! function_exists( 'akilli_posts_for_service' ) ) :
function akilli_posts_for_service( $service_id, $limit = 3 ) {
	$ids = array( (int) $service_id );
	$p   = get_post( $service_id );
	if ( $p && $p->post_parent ) {
		$ids[] = (int) $p->post_parent;
	}
	return get_posts(
		array(
			'post_type'   => 'post',
			'numberposts' => $limit,
			'meta_query'  => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				array(
					'key'     => '_ak_service',
					'value'   => $ids,
					'compare' => 'IN',
				),
			),
		)
	);
}
endif;

/**
 * URL of the quote page, optionally with a preselected service.
 *
 * @param int|WP_Post|null $service Service.
 * @return string
 */
if ( ! function_exists( 'akilli_quote_url' ) ) :
function akilli_quote_url( $service = null ) {
	$page_id = (int) get_option( 'akilli_page_teklif' );
	$url     = $page_id && get_post_status( $page_id ) === 'publish' ? get_permalink( $page_id ) : home_url( '/teklif-al/' );
	if ( $service ) {
		$service = get_post( $service );
		if ( $service ) {
			$url = add_query_arg( 'hizmet', $service->post_name, $url );
		}
	}
	return $url . '#teklif-formu';
}
endif;

/**
 * Estimated reading time in minutes.
 *
 * @param int|WP_Post $post Post.
 * @return int
 */
if ( ! function_exists( 'akilli_reading_time' ) ) :
function akilli_reading_time( $post = null ) {
	$post  = get_post( $post );
	$words = $post ? count( preg_split( '/\s+/u', wp_strip_all_tags( $post->post_content ), -1, PREG_SPLIT_NO_EMPTY ) ) : 0;
	return max( 1, (int) ceil( $words / 200 ) );
}
endif;
