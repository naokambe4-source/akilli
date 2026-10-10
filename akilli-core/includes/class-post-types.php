<?php
/**
 * Custom post types and taxonomies.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers content types: services, projects, references and leads.
 */
class Akilli_Post_Types {

	/**
	 * Hooks.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register' ) );
		add_filter( 'post_updated_messages', array( __CLASS__, 'messages' ) );
		add_action( 'pre_get_posts', array( __CLASS__, 'search_scope' ) );
	}

	/**
	 * Register all types.
	 */
	public static function register() {
		register_post_type(
			'ak_hizmet',
			array(
				'labels'          => self::labels( 'Hizmet', 'Hizmetler', 'Hizmet' ),
				'description'     => 'Hizmet kategorileri (üst hizmet) ve alt hizmet detay sayfaları.',
				'public'          => true,
				'hierarchical'    => true,
				'show_in_rest'    => true,
				'menu_icon'       => 'dashicons-lightbulb',
				'menu_position'   => 21,
				'has_archive'     => false,
				'rewrite'         => array(
					'slug'       => 'hizmetlerimiz',
					'with_front' => false,
				),
				'supports'        => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions', 'custom-fields' ),
				'template'        => array(
					array( 'core/paragraph', array( 'placeholder' => 'Hizmeti 2–3 cümleyle tanıtın…' ) ),
					array( 'akilli/features', array( 'title' => 'Hizmet kapsamı', 'style' => 'list' ) ),
					array( 'akilli/features', array( 'title' => 'Kimler için uygun?', 'style' => 'cards' ) ),
					array( 'akilli/checklist', array( 'title' => 'Teslim ettiklerimiz' ) ),
					array( 'akilli/process', array( 'title' => 'Çalışma süreci' ) ),
					array( 'akilli/faq', array( 'title' => 'Sık sorulan sorular' ) ),
				),
			)
		);

		register_post_type(
			'ak_proje',
			array(
				'labels'        => self::labels( 'Proje', 'Projeler', 'Proje' ),
				'description'   => 'Portföy çalışmaları.',
				'public'        => true,
				'show_in_rest'  => true,
				'menu_icon'     => 'dashicons-portfolio',
				'menu_position' => 22,
				'has_archive'   => false,
				'rewrite'       => array(
					'slug'       => 'calismalarimiz',
					'with_front' => false,
				),
				'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions', 'custom-fields' ),
			)
		);

		register_taxonomy(
			'ak_proje_kategori',
			array( 'ak_proje' ),
			array(
				'labels'            => array(
					'name'          => 'Proje Kategorileri',
					'singular_name' => 'Proje Kategorisi',
					'menu_name'     => 'Kategoriler',
					'all_items'     => 'Tüm kategoriler',
					'edit_item'     => 'Kategoriyi düzenle',
					'add_new_item'  => 'Yeni kategori ekle',
					'search_items'  => 'Kategori ara',
					'not_found'     => 'Kategori bulunamadı.',
				),
				'hierarchical'      => true,
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'rewrite'           => array(
					'slug'       => 'calisma-kategorisi',
					'with_front' => false,
				),
			)
		);

		register_post_type(
			'ak_referans',
			array(
				'labels'              => self::labels( 'Referans', 'Referanslar', 'Referans' ),
				'description'         => 'Referans logoları. Logo için "Öne çıkan görsel" alanını kullanın.',
				'public'              => false,
				'show_ui'             => true,
				'show_in_rest'        => true,
				'exclude_from_search' => true,
				'menu_icon'           => 'dashicons-awards',
				'menu_position'       => 23,
				'supports'            => array( 'title', 'thumbnail', 'page-attributes' ),
			)
		);

		register_post_type(
			'ak_talep',
			array(
				'labels'              => array(
					'name'               => 'Talepler',
					'singular_name'      => 'Talep',
					'menu_name'          => 'Talepler',
					'all_items'          => 'Tüm talepler',
					'edit_item'          => 'Talebi görüntüle',
					'view_item'          => 'Talebi görüntüle',
					'search_items'       => 'Talep ara',
					'not_found'          => 'Henüz talep yok.',
					'not_found_in_trash' => 'Çöp kutusunda talep yok.',
				),
				'public'              => false,
				'show_ui'             => true,
				'show_in_rest'        => false,
				'exclude_from_search' => true,
				'menu_icon'           => 'dashicons-email-alt',
				'menu_position'       => 24,
				'capability_type'     => array( 'ak_talep', 'ak_talepler' ),
				'map_meta_cap'        => true,
				'capabilities'        => array( 'create_posts' => 'do_not_allow' ),
				'supports'            => array( 'title' ),
			)
		);
	}

	/**
	 * Turkish label set.
	 *
	 * @param string $singular Singular.
	 * @param string $plural   Plural.
	 * @param string $acc      Accusative-ish form.
	 * @return array
	 */
	private static function labels( $singular, $plural, $acc ) {
		return array(
			'name'                  => $plural,
			'singular_name'         => $singular,
			'menu_name'             => $plural,
			'add_new'               => 'Yeni ekle',
			'add_new_item'          => 'Yeni ' . mb_strtolower( $singular ) . ' ekle',
			'edit_item'             => $acc . ' düzenle',
			'new_item'              => 'Yeni ' . mb_strtolower( $singular ),
			'view_item'             => $acc . ' görüntüle',
			'view_items'            => $plural . ' görüntüle',
			'search_items'          => $plural . ' içinde ara',
			'not_found'             => 'Kayıt bulunamadı.',
			'not_found_in_trash'    => 'Çöp kutusunda kayıt yok.',
			'all_items'             => 'Tüm ' . mb_strtolower( $plural ),
			'parent_item_colon'     => 'Üst ' . mb_strtolower( $singular ) . ':',
			'featured_image'        => 'Kapak görseli',
			'set_featured_image'    => 'Kapak görseli seç',
			'remove_featured_image' => 'Kapak görselini kaldır',
			'use_featured_image'    => 'Kapak görseli olarak kullan',
			'attributes'            => 'Sıralama ve üst öğe',
			'item_published'        => $singular . ' yayımlandı.',
			'item_updated'          => $singular . ' güncellendi.',
		);
	}

	/**
	 * Turkish update messages.
	 *
	 * @param array $messages Messages.
	 * @return array
	 */
	public static function messages( $messages ) {
		foreach ( array( 'ak_hizmet', 'ak_proje', 'ak_referans', 'ak_talep' ) as $type ) {
			$messages[ $type ] = array(
				1  => 'Kaydedildi.',
				4  => 'Kaydedildi.',
				6  => 'Yayımlandı.',
				7  => 'Kaydedildi.',
				10 => 'Taslak kaydedildi.',
			);
		}
		return $messages;
	}

	/**
	 * Front-end search covers pages, posts, services and projects.
	 *
	 * @param WP_Query $q Query.
	 */
	public static function search_scope( $q ) {
		if ( is_admin() || ! $q->is_main_query() || ! $q->is_search() ) {
			return;
		}
		if ( ! $q->get( 'post_type' ) ) {
			$q->set( 'post_type', array( 'ak_hizmet', 'ak_proje', 'post', 'page' ) );
		}
	}
}
