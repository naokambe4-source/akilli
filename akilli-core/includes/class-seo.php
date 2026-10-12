<?php
/**
 * Lightweight SEO layer: per-page title/description, Open Graph and JSON-LD.
 *
 * Everything here switches itself off when Yoast SEO or Rank Math is active,
 * so there is never duplicated meta, canonical or structured data.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * SEO.
 */
class Akilli_SEO {

	/**
	 * FAQ items collected while rendering blocks.
	 *
	 * @var array
	 */
	private static $faq = array();

	/**
	 * Post types with the SEO box.
	 *
	 * @var string[]
	 */
	public static $types = array( 'page', 'post', 'ak_hizmet', 'ak_proje' );

	/**
	 * Hooks.
	 */
	public static function init() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'box' ) );
		add_action( 'save_post', array( __CLASS__, 'save' ), 10, 2 );
		add_action( 'admin_notices', array( __CLASS__, 'indexing_notice' ) );
		add_action( 'wp', array( __CLASS__, 'frontend' ) );
	}

	/**
	 * Front-end hooks (only when no SEO plugin).
	 */
	public static function frontend() {
		if ( akilli_seo_plugin_active() ) {
			return;
		}
		add_filter( 'pre_get_document_title', array( __CLASS__, 'title' ) );
		add_filter( 'document_title_separator', function () {
			return '|';
		} );
		add_action( 'wp_head', array( __CLASS__, 'head' ), 2 );
		add_action( 'wp_footer', array( __CLASS__, 'footer_schema' ), 99 );
	}

	/**
	 * Collect FAQ items from blocks.
	 *
	 * @param array $items Items (q, a).
	 */
	public static function add_faq( $items ) {
		foreach ( $items as $i ) {
			self::$faq[] = $i;
		}
	}

	/**
	 * Meta box.
	 */
	public static function box() {
		foreach ( self::$types as $type ) {
			add_meta_box( 'akilli_seo', 'Arama motoru görünümü', array( __CLASS__, 'render_box' ), $type, 'normal', 'low' );
		}
	}

	/**
	 * Render meta box.
	 *
	 * @param WP_Post $post Post.
	 */
	public static function render_box( $post ) {
		wp_nonce_field( 'akilli_seo_save', 'akilli_seo_nonce' );
		if ( akilli_seo_plugin_active() ) {
			echo '<p><strong>Yoast SEO / Rank Math etkin.</strong> Tema kendi meta etiketlerini ve yapılandırılmış verisini üretmiyor; başlık ve açıklamayı SEO eklentisinin alanından yönetin. Aşağıdaki taslaklar referans olarak saklanır.</p>';
		}
		$title = get_post_meta( $post->ID, '_ak_seo_title', true );
		$desc  = get_post_meta( $post->ID, '_ak_seo_desc', true );
		echo '<p><label for="ak_seo_title"><strong>Meta başlık</strong></label><input class="widefat" id="ak_seo_title" name="ak_seo_title" maxlength="70" value="' . esc_attr( $title ) . '"><span class="description">Önerilen 50–60 karakter. Boşsa sayfa başlığı kullanılır.</span></p>';
		echo '<p><label for="ak_seo_desc"><strong>Meta açıklama</strong></label><textarea class="widefat" id="ak_seo_desc" name="ak_seo_desc" rows="3" maxlength="170">' . esc_textarea( $desc ) . '</textarea><span class="description">Önerilen 140–160 karakter. Boşsa özet kullanılır.</span></p>';
	}

	/**
	 * Save.
	 *
	 * @param int     $post_id Post.
	 * @param WP_Post $post    Post object.
	 */
	public static function save( $post_id, $post ) {
		if ( ! in_array( $post->post_type, self::$types, true ) ) {
			return;
		}
		if ( ! isset( $_POST['akilli_seo_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['akilli_seo_nonce'] ) ), 'akilli_seo_save' ) ) {
			return;
		}
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		update_post_meta( $post_id, '_ak_seo_title', isset( $_POST['ak_seo_title'] ) ? sanitize_text_field( wp_unslash( $_POST['ak_seo_title'] ) ) : '' );
		update_post_meta( $post_id, '_ak_seo_desc', isset( $_POST['ak_seo_desc'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ak_seo_desc'] ) ) : '' );
	}

	/**
	 * Remind admins that indexing is off.
	 */
	public static function indexing_notice() {
		if ( '0' !== (string) get_option( 'blog_public' ) || ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$screen = get_current_screen();
		if ( $screen && in_array( $screen->id, array( 'dashboard', 'toplevel_page_akilli-creative', 'akilli-creative_page_akilli-demo' ), true ) ) {
			echo '<div class="notice notice-info"><p><strong>Site arama motorlarına kapalı (demo modu).</strong> Yayına geçerken <a href="' . esc_url( admin_url( 'options-reading.php' ) ) . '">Ayarlar → Okuma</a> ekranında "Arama motorlarının bu siteyi dizine eklemesini engelle" kutusunun işaretini kaldırın. Kontrol listesi kurulum rehberindedir.</p></div>';
		}
	}

	/**
	 * Current queried post's custom field.
	 *
	 * @param string $key Key.
	 * @return string
	 */
	private static function field( $key ) {
		$id = self::context_id();
		return $id ? (string) get_post_meta( $id, $key, true ) : '';
	}

	/**
	 * ID whose SEO fields apply (singular or static front / posts page).
	 *
	 * @return int
	 */
	private static function context_id() {
		if ( is_singular() ) {
			return (int) get_queried_object_id();
		}
		if ( is_home() && get_option( 'page_for_posts' ) ) {
			return (int) get_option( 'page_for_posts' );
		}
		return 0;
	}

	/**
	 * Document title.
	 *
	 * @param string $title Title.
	 * @return string
	 */
	public static function title( $title ) {
		$custom = self::field( '_ak_seo_title' );
		return $custom ? $custom : $title;
	}

	/**
	 * Meta description.
	 *
	 * @return string
	 */
	public static function description() {
		$desc = self::field( '_ak_seo_desc' );
		if ( ! $desc && is_singular() ) {
			$post = get_queried_object();
			$desc = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_trim_words( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ), 28, '…' );
		} elseif ( ! $desc && ( is_category() || is_tag() || is_tax() ) ) {
			$desc = wp_strip_all_tags( term_description() );
		} elseif ( ! $desc && is_front_page() ) {
			$desc = get_bloginfo( 'description' );
		}
		return trim( preg_replace( '/\s+/', ' ', (string) $desc ) );
	}

	/**
	 * Head output: description + Open Graph + JSON-LD.
	 */
	public static function head() {
		$desc = self::description();
		if ( $desc ) {
			echo '<meta name="description" content="' . esc_attr( wp_html_excerpt( $desc, 170, '…' ) ) . '">' . "\n";
		}
		$title = wp_get_document_title();
		$url   = is_singular() ? get_permalink() : home_url( add_query_arg( array() ) );
		$img   = '';
		if ( is_singular() && has_post_thumbnail() ) {
			$img = get_the_post_thumbnail_url( null, 'large' );
		} elseif ( function_exists( 'get_theme_mod' ) && get_theme_mod( 'akilli_og_image' ) ) {
			$img = wp_get_attachment_image_url( (int) get_theme_mod( 'akilli_og_image' ), 'large' );
		}
		$og = array(
			'og:locale'      => 'tr_TR',
			'og:type'        => is_singular( 'post' ) ? 'article' : 'website',
			'og:site_name'   => get_bloginfo( 'name' ),
			'og:title'       => $title,
			'og:description' => $desc,
			'og:url'         => $url,
			'og:image'       => $img,
		);
		foreach ( $og as $prop => $val ) {
			if ( $val ) {
				echo '<meta property="' . esc_attr( $prop ) . '" content="' . esc_attr( $val ) . '">' . "\n";
			}
		}
		echo '<meta name="twitter:card" content="' . ( $img ? 'summary_large_image' : 'summary' ) . '">' . "\n";

		$graph = self::graph();
		if ( $graph ) {
			echo '<script type="application/ld+json">' . wp_json_encode(
				array(
					'@context' => 'https://schema.org',
					'@graph'   => $graph,
				),
				JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
			) . '</script>' . "\n";
		}
	}

	/**
	 * Organization node.
	 *
	 * @return array
	 */
	public static function organization() {
		$org = array(
			'@type'     => 'ProfessionalService',
			'@id'       => home_url( '/#organization' ),
			'name'      => akilli_get_setting( 'company_name' ),
			'url'       => home_url( '/' ),
			'email'     => akilli_get_setting( 'email' ),
			'telephone' => preg_replace( '/[^0-9+]/', '', (string) akilli_get_setting( 'phone' ) ),
			'address'   => array_filter(
				array(
					'@type'           => 'PostalAddress',
					'streetAddress'   => akilli_get_setting( 'address_street' ),
					'addressLocality' => akilli_get_setting( 'address_region' ),
					'addressRegion'   => akilli_get_setting( 'address_city' ),
					'postalCode'      => akilli_get_setting( 'address_postal' ),
					'addressCountry'  => 'TR',
				)
			),
			'areaServed' => array(
				array(
					'@type' => 'City',
					'name'  => 'Antalya',
				),
				array(
					'@type' => 'Country',
					'name'  => 'Türkiye',
				),
			),
			'sameAs'    => array_values( akilli_social_links() ),
		);
		$logo_id = get_theme_mod( 'custom_logo' );
		if ( $logo_id ) {
			$org['logo']  = wp_get_attachment_image_url( $logo_id, 'full' );
			$org['image'] = $org['logo'];
		}
		return array_filter( $org );
	}

	/**
	 * Build the JSON-LD graph for the current view.
	 *
	 * @return array
	 */
	private static function graph() {
		$graph   = array();
		$graph[] = array(
			'@type'           => 'WebSite',
			'@id'             => home_url( '/#website' ),
			'url'             => home_url( '/' ),
			'name'            => get_bloginfo( 'name' ),
			'inLanguage'      => 'tr-TR',
			'publisher'       => array( '@id' => home_url( '/#organization' ) ),
			'potentialAction' => array(
				'@type'       => 'SearchAction',
				'target'      => home_url( '/?s={search_term_string}' ),
				'query-input' => 'required name=search_term_string',
			),
		);
		if ( is_front_page() || is_page( array( 'iletisim', 'hakkimizda' ) ) ) {
			$graph[] = self::organization();
		}

		$trail = akilli_breadcrumb_trail();
		if ( count( $trail ) > 1 ) {
			$items = array();
			foreach ( $trail as $i => $crumb ) {
				$items[] = array_filter(
					array(
						'@type'    => 'ListItem',
						'position' => $i + 1,
						'name'     => $crumb['name'],
						'item'     => $crumb['url'],
					)
				);
			}
			$graph[] = array(
				'@type'           => 'BreadcrumbList',
				'itemListElement' => $items,
			);
		}

		if ( is_singular( 'post' ) ) {
			$post    = get_queried_object();
			$graph[] = array_filter(
				array(
					'@type'            => 'BlogPosting',
					'headline'         => get_the_title( $post ),
					'description'      => self::description(),
					'datePublished'    => get_the_date( 'c', $post ),
					'dateModified'     => get_the_modified_date( 'c', $post ),
					'mainEntityOfPage' => get_permalink( $post ),
					'image'            => get_the_post_thumbnail_url( $post, 'large' ),
					'author'           => array(
						'@type' => 'Person',
						'name'  => get_the_author_meta( 'display_name', $post->post_author ),
						'url'   => get_author_posts_url( $post->post_author ),
					),
					'publisher'        => array( '@id' => home_url( '/#organization' ) ),
					'inLanguage'       => 'tr-TR',
				)
			);
			$graph[] = self::organization();
		} elseif ( is_singular( 'ak_hizmet' ) ) {
			$post    = get_queried_object();
			$graph[] = array(
				'@type'       => 'Service',
				'name'        => get_the_title( $post ),
				'description' => self::description(),
				'url'         => get_permalink( $post ),
				'serviceType' => $post->post_parent ? get_the_title( $post->post_parent ) : get_the_title( $post ),
				'provider'    => array( '@id' => home_url( '/#organization' ) ),
				'areaServed'  => array(
					'@type' => 'Country',
					'name'  => 'Türkiye',
				),
			);
			$graph[] = self::organization();
		} elseif ( is_singular( 'ak_proje' ) ) {
			$post    = get_queried_object();
			$graph[] = array_filter(
				array(
					'@type'       => 'CreativeWork',
					'name'        => get_the_title( $post ),
					'description' => self::description(),
					'url'         => get_permalink( $post ),
					'image'       => get_the_post_thumbnail_url( $post, 'large' ),
					'creator'     => array( '@id' => home_url( '/#organization' ) ),
					'dateCreated' => get_post_meta( $post->ID, '_ak_year', true ),
				)
			);
			$graph[] = self::organization();
		}
		return apply_filters( 'akilli_schema_graph', $graph );
	}

	/**
	 * FAQPage JSON-LD (collected during rendering).
	 */
	public static function footer_schema() {
		if ( ! self::$faq ) {
			return;
		}
		$main = array();
		foreach ( self::$faq as $item ) {
			$main[] = array(
				'@type'          => 'Question',
				'name'           => wp_strip_all_tags( $item['q'] ),
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => wp_strip_all_tags( $item['a'] ),
				),
			);
		}
		echo '<script type="application/ld+json">' . wp_json_encode(
			array(
				'@context'   => 'https://schema.org',
				'@type'      => 'FAQPage',
				'mainEntity' => $main,
			),
			JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
		) . '</script>' . "\n";
	}
}

/**
 * Breadcrumb trail for the current view.
 *
 * @return array[] Each [name, url].
 */
if ( ! function_exists( 'akilli_breadcrumb_trail' ) ) :
function akilli_breadcrumb_trail() {
	$trail = array(
		array(
			'name' => 'Ana sayfa',
			'url'  => home_url( '/' ),
		),
	);
	if ( is_front_page() ) {
		return $trail;
	}
	$page_link = function ( $option, $path, $fallback ) {
		$id = (int) get_option( $option );
		$p  = $id ? get_post( $id ) : get_page_by_path( $path );
		if ( $p && 'publish' === $p->post_status ) {
			return array(
				'name' => get_the_title( $p ),
				'url'  => get_permalink( $p ),
			);
		}
		return array(
			'name' => $fallback,
			'url'  => '',
		);
	};
	$blog = function () {
		$id = (int) get_option( 'page_for_posts' );
		return $id ? array(
			'name' => get_the_title( $id ),
			'url'  => get_permalink( $id ),
		) : null;
	};

	if ( is_singular( 'ak_hizmet' ) ) {
		$trail[] = $page_link( 'akilli_page_hizmetler', 'hizmetlerimiz', 'Hizmetlerimiz' );
		$post    = get_queried_object();
		foreach ( array_reverse( get_post_ancestors( $post ) ) as $anc ) {
			$trail[] = array(
				'name' => get_the_title( $anc ),
				'url'  => get_permalink( $anc ),
			);
		}
		$trail[] = array(
			'name' => get_the_title( $post ),
			'url'  => '',
		);
	} elseif ( is_singular( 'ak_proje' ) || is_tax( 'ak_proje_kategori' ) ) {
		$trail[] = $page_link( 'akilli_page_calismalar', 'calismalarimiz', 'Çalışmalarımız' );
		$trail[] = array(
			'name' => is_tax() ? single_term_title( '', false ) : get_the_title(),
			'url'  => '',
		);
	} elseif ( is_singular( 'post' ) ) {
		$b = $blog();
		if ( $b ) {
			$trail[] = $b;
		}
		$cats = get_the_category();
		if ( $cats ) {
			$trail[] = array(
				'name' => $cats[0]->name,
				'url'  => get_category_link( $cats[0] ),
			);
		}
		$trail[] = array(
			'name' => get_the_title(),
			'url'  => '',
		);
	} elseif ( is_page() ) {
		$post = get_queried_object();
		foreach ( array_reverse( get_post_ancestors( $post ) ) as $anc ) {
			$trail[] = array(
				'name' => get_the_title( $anc ),
				'url'  => get_permalink( $anc ),
			);
		}
		$trail[] = array(
			'name' => get_the_title( $post ),
			'url'  => '',
		);
	} elseif ( is_home() ) {
		$b = $blog();
		$trail[] = array(
			'name' => $b ? $b['name'] : 'Blog',
			'url'  => '',
		);
	} elseif ( is_category() || is_tag() || is_author() || is_date() ) {
		$b = $blog();
		if ( $b ) {
			$trail[] = $b;
		}
		$trail[] = array(
			'name' => is_author() ? get_the_author_meta( 'display_name', get_queried_object_id() ) : ( is_date() ? get_the_archive_title() : single_term_title( '', false ) ),
			'url'  => '',
		);
	} elseif ( is_search() ) {
		$trail[] = array(
			'name' => 'Arama: ' . get_search_query(),
			'url'  => '',
		);
	} elseif ( is_404() ) {
		$trail[] = array(
			'name' => 'Sayfa bulunamadı',
			'url'  => '',
		);
	}
	return $trail;
}
endif;
