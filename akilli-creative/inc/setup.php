<?php
/**
 * Theme setup.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'after_setup_theme',
	function () {
		load_theme_textdomain( 'akilli-creative', AKILLI_THEME_DIR . '/languages' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
		add_theme_support(
			'custom-logo',
			array(
				'height'               => 120,
				'width'                => 360,
				'flex-height'          => true,
				'flex-width'           => true,
				'unlink-homepage-logo' => false,
			)
		);
		register_nav_menus(
			array(
				'primary'         => 'Ana menü (header)',
				'footer_services' => 'Footer — Hizmetler',
				'footer_company'  => 'Footer — Kurumsal',
				'legal'           => 'Yasal bağlantılar (footer altı)',
			)
		);
		add_image_size( 'ak-card', 960, 640, true );
		add_image_size( 'ak-wide', 1920, 1080, false );
		add_editor_style( 'assets/css/fonts.css' );
	}
);

$GLOBALS['content_width'] = 760;

/**
 * Body classes.
 */
add_filter(
	'body_class',
	function ( $classes ) {
		if ( is_singular() && akilli_has_hero() ) {
			$classes[] = 'has-block-hero';
		}
		if ( get_theme_mod( 'akilli_mobile_bar', true ) ) {
			$classes[] = 'has-mobile-bar';
		}
		return $classes;
	}
);

/**
 * Does the current page start with an Akıllı hero block (so templates skip their own title)?
 *
 * @param int|WP_Post|null $post Post.
 * @return bool
 */
function akilli_has_hero( $post = null ) {
	$post = get_post( $post );
	if ( ! $post || ! akilli_core_active() ) {
		return false;
	}
	return has_block( 'akilli/hero', $post ) || has_block( 'akilli/page-hero', $post );
}

/**
 * Admin notice when the companion plugin is missing.
 */
add_action(
	'admin_notices',
	function () {
		if ( akilli_core_active() || ! current_user_can( 'install_plugins' ) ) {
			return;
		}
		echo '<div class="notice notice-warning"><p><strong>Akıllı Creative teması:</strong> Hizmetler, projeler, referanslar, teklif formu ve özel bloklar için <strong>Akıllı Creative Çekirdek</strong> eklentisini yükleyip etkinleştirin (Eklentiler → Yeni Ekle → Eklenti yükle → <code>akilli-core.zip</code>). Tema eklenti olmadan da açılır; ancak bu bölümler görünmez.</p></div>';
	}
);

/**
 * Point to the setup screen right after activation.
 */
add_action(
	'after_switch_theme',
	function () {
		set_transient( 'akilli_theme_activated', 1, 60 );
	}
);
add_action(
	'admin_notices',
	function () {
		if ( ! get_transient( 'akilli_theme_activated' ) || ! current_user_can( 'manage_options' ) ) {
			return;
		}
		delete_transient( 'akilli_theme_activated' );
		if ( akilli_core_active() ) {
			echo '<div class="notice notice-success is-dismissible"><p><strong>Akıllı Creative etkin.</strong> Sayfaları, menüleri ve örnek içerikleri oluşturmak için <a href="' . esc_url( admin_url( 'admin.php?page=akilli-demo' ) ) . '">Akıllı Creative → Kurulum</a> ekranına gidin.</p></div>';
		}
	}
);

/**
 * Favicon fallback when no Site Icon is set.
 */
add_action(
	'wp_head',
	function () {
		if ( has_site_icon() ) {
			return;
		}
		echo '<link rel="icon" href="' . esc_url( AKILLI_THEME_URI . '/assets/img/favicon-32.png' ) . '" sizes="32x32">' . "\n";
		echo '<link rel="icon" href="' . esc_url( AKILLI_THEME_URI . '/assets/img/favicon-192.png' ) . '" sizes="192x192">' . "\n";
		echo '<link rel="apple-touch-icon" href="' . esc_url( AKILLI_THEME_URI . '/assets/img/apple-touch-icon.png' ) . '">' . "\n";
	},
	3
);

/**
 * Excerpt tweaks.
 */
add_filter(
	'excerpt_length',
	function () {
		return 26;
	}
);
add_filter(
	'excerpt_more',
	function () {
		return '…';
	}
);

/**
 * Archive titles without "Kategori:" prefixes.
 */
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

/**
 * Search: 12 per page.
 */
add_action(
	'pre_get_posts',
	function ( $q ) {
		if ( ! is_admin() && $q->is_main_query() && $q->is_search() ) {
			$q->set( 'posts_per_page', 12 );
		}
	}
);

/**
 * Remove emoji scripts (performance).
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
