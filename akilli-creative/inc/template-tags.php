<?php
/**
 * Template tags.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;

/**
 * Site logo (custom logo → bundled brand logo → text).
 */
function akilli_logo() {
	if ( has_custom_logo() ) {
		echo '<div class="ak-logo">' . get_custom_logo() . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		return;
	}
	$name = get_bloginfo( 'name' );
	echo '<a class="ak-logo" href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
	if ( file_exists( AKILLI_THEME_DIR . '/assets/img/logo.png' ) ) {
		echo '<img src="' . esc_url( AKILLI_THEME_URI . '/assets/img/logo.png' ) . '" width="640" height="234" alt="' . esc_attr( $name ) . ' ana sayfa">';
	} else {
		echo '<span class="ak-logo__text">' . esc_html( $name ) . '</span>';
	}
	echo '</a>';
}

/**
 * Breadcrumbs (visual; JSON-LD is produced by the plugin when no SEO plugin is active).
 */
function akilli_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}
	if ( function_exists( 'yoast_breadcrumb' ) && current_theme_supports( 'yoast-seo-breadcrumbs' ) ) {
		yoast_breadcrumb( '<nav class="ak-crumbs" aria-label="Sayfa konumu">', '</nav>' );
		return;
	}
	$trail = akilli_breadcrumb_trail();
	if ( count( $trail ) < 2 ) {
		return;
	}
	echo '<nav class="ak-crumbs" aria-label="Sayfa konumu"><ol>';
	$last = count( $trail ) - 1;
	foreach ( $trail as $i => $c ) {
		if ( $i === $last || ! $c['url'] ) {
			echo '<li><span' . ( $i === $last ? ' aria-current="page"' : '' ) . '>' . esc_html( wp_html_excerpt( $c['name'], 60, '…' ) ) . '</span></li>';
		} else {
			echo '<li><a href="' . esc_url( $c['url'] ) . '">' . esc_html( $c['name'] ) . '</a></li>';
		}
	}
	echo '</ol></nav>';
}

/**
 * Generic page header for templates without a hero block.
 *
 * @param string $title   Title (plain text).
 * @param string $text    Intro.
 * @param string $eyebrow Eyebrow.
 */
function akilli_page_header( $title, $text = '', $eyebrow = '' ) {
	echo '<header class="ak-pagehead"><div class="ak-wrap">';
	akilli_breadcrumbs();
	if ( $eyebrow ) {
		echo '<p class="ak-eyebrow">' . esc_html( $eyebrow ) . '</p>';
	}
	echo '<h1 class="ak-pagehead__title">' . esc_html( $title ) . '</h1>';
	if ( $text ) {
		echo '<div class="ak-pagehead__text">' . wp_kses_post( wpautop( $text ) ) . '</div>';
	}
	echo '</div></header>';
}

/**
 * Post meta line.
 *
 * @param int|WP_Post $post Post.
 */
function akilli_post_meta( $post = null ) {
	$post      = get_post( $post );
	$published = get_the_date( '', $post );
	$modified  = get_the_modified_date( '', $post );
	echo '<span><time datetime="' . esc_attr( get_the_date( 'c', $post ) ) . '">' . esc_html( $published ) . '</time></span>';
	if ( get_the_modified_date( 'Ymd', $post ) > get_the_date( 'Ymd', $post ) ) {
		echo '<span>Güncellendi: <time datetime="' . esc_attr( get_the_modified_date( 'c', $post ) ) . '">' . esc_html( $modified ) . '</time></span>';
	}
	if ( akilli_mod( 'akilli_reading_time' ) ) {
		echo '<span>' . esc_html( akilli_reading_time( $post ) ) . ' dk okuma</span>';
	}
}

/**
 * Pagination.
 */
function akilli_pagination() {
	the_posts_pagination(
		array(
			'class'              => 'ak-pagination',
			'mid_size'           => 1,
			'prev_text'          => '<span aria-hidden="true">←</span><span class="screen-reader-text">Önceki sayfa</span>',
			'next_text'          => '<span aria-hidden="true">→</span><span class="screen-reader-text">Sonraki sayfa</span>',
			'before_page_number' => '<span class="screen-reader-text">Sayfa </span>',
			'aria_label'         => 'Sayfalar',
		)
	);
}

/**
 * Blog category chips.
 */
function akilli_category_nav() {
	$cats = get_categories(
		array(
			'hide_empty' => true,
			'orderby'    => 'count',
			'order'      => 'DESC',
		)
	);
	if ( ! $cats ) {
		return;
	}
	$blog    = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );
	$current = is_category() ? get_queried_object_id() : 0;
	echo '<nav class="ak-catnav" aria-label="Blog kategorileri">';
	echo '<a class="ak-chip" href="' . esc_url( $blog ) . '"' . ( is_home() ? ' aria-current="page"' : '' ) . '>Tümü</a>';
	foreach ( $cats as $c ) {
		echo '<a class="ak-chip" href="' . esc_url( get_category_link( $c ) ) . '"' . ( $current === $c->term_id ? ' aria-current="page"' : '' ) . '>' . esc_html( $c->name ) . '</a>';
	}
	echo '</nav>';
}

/**
 * Copyright text.
 *
 * @return string
 */
function akilli_copyright() {
	return str_replace( '{yil}', wp_date( 'Y' ), (string) akilli_mod( 'akilli_copyright' ) );
}

/**
 * Section anchors from Akıllı blocks in post content (for the service sub-nav).
 *
 * @param WP_Post $post Post.
 * @return array id => label
 */
function akilli_content_anchors( $post ) {
	$out = array();
	foreach ( parse_blocks( $post->post_content ) as $b ) {
		if ( 0 !== strpos( (string) $b['blockName'], 'akilli/' ) || ! empty( $b['attrs']['hidden'] ) ) {
			continue;
		}
		$a = $b['attrs'];
		if ( empty( $a['title'] ) && empty( $a['anchor'] ) ) {
			continue;
		}
		$id = function_exists( 'akilli_block_anchor' ) ? akilli_block_anchor( $a ) : sanitize_title( $a['title'] );
		if ( $id ) {
			$out[ $id ] = ! empty( $a['eyebrow'] ) ? $a['eyebrow'] : wp_strip_all_tags( $a['title'] );
		}
	}
	return $out;
}
