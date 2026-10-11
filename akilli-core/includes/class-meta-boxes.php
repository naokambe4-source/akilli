<?php
/**
 * Meta boxes for services, projects, references and blog posts.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Structured fields edited in classic meta boxes (shown under the block editor).
 */
class Akilli_Meta_Boxes {

	const NONCE = 'akilli_meta_nonce';

	/**
	 * Hooks.
	 */
	public static function init() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'add' ) );
		add_action( 'save_post', array( __CLASS__, 'save' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'assets' ) );
		add_action( 'init', array( __CLASS__, 'register_meta' ) );
		add_filter( 'manage_ak_proje_posts_columns', array( __CLASS__, 'project_columns' ) );
		add_action( 'manage_ak_proje_posts_custom_column', array( __CLASS__, 'project_column' ), 10, 2 );
		add_filter( 'manage_ak_referans_posts_columns', array( __CLASS__, 'ref_columns' ) );
		add_action( 'manage_ak_referans_posts_custom_column', array( __CLASS__, 'ref_column' ), 10, 2 );
	}

	/**
	 * Icon choices for services.
	 *
	 * @return array
	 */
	public static function service_icons() {
		return array(
			'web'       => 'Web / tarayıcı',
			'cart'      => 'E-ticaret',
			'pen'       => 'Tasarım kalemi',
			'growth'    => 'Büyüme',
			'code'      => 'Kod',
			'spark'     => 'Yıldız / kreatif',
			'layers'    => 'Katmanlar',
			'shield'    => 'Güvenlik',
			'card'      => 'Ödeme / kart',
			'plug'      => 'Entegrasyon',
			'palette'   => 'Renk paleti',
			'megaphone' => 'Reklam',
			'users'     => 'Topluluk',
			'plane'     => 'Turizm',
			'figma'     => 'Arayüz tasarımı',
			'id'        => 'Kartvizit / kimlik',
			'image'     => 'Görsel',
			'wordpress' => 'WordPress',
			'tooth'     => 'Diş / sağlık',
			'scale'     => 'Hukuk',
			'heart'     => 'Dernek / sağlık',
			'search'    => 'Arama',
			'chat'      => 'Sosyal medya',
			'target'    => 'Hedef',
			'compass'   => 'Danışmanlık',
			'gear'      => 'Yazılım ayarı',
			'rocket'    => 'Lansman',
		);
	}

	/**
	 * Expose a few fields to REST (read-only use in editor previews).
	 */
	public static function register_meta() {
		$auth = function () {
			return current_user_can( 'edit_posts' );
		};
		register_post_meta(
			'ak_hizmet',
			'_ak_icon',
			array(
				'type'          => 'string',
				'single'        => true,
				'show_in_rest'  => true,
				'auth_callback' => $auth,
			)
		);
	}

	/**
	 * Register boxes.
	 */
	public static function add() {
		add_meta_box( 'akilli_service', 'Hizmet ayarları', array( __CLASS__, 'box_service' ), 'ak_hizmet', 'side' );
		add_meta_box( 'akilli_project', 'Proje bilgileri', array( __CLASS__, 'box_project' ), 'ak_proje', 'normal', 'high' );
		add_meta_box( 'akilli_project_gallery', 'Proje galerisi', array( __CLASS__, 'box_gallery' ), 'ak_proje', 'normal' );
		add_meta_box( 'akilli_project_services', 'Verilen hizmetler', array( __CLASS__, 'box_services_select' ), 'ak_proje', 'side' );
		add_meta_box( 'akilli_post_services', 'İlgili hizmetler', array( __CLASS__, 'box_services_select' ), 'post', 'side' );
		add_meta_box( 'akilli_reference', 'Referans bağlantısı', array( __CLASS__, 'box_reference' ), 'ak_referans', 'normal', 'high' );
	}

	/**
	 * Admin assets.
	 *
	 * @param string $hook Hook.
	 */
	public static function assets( $hook ) {
		if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
			return;
		}
		$screen = get_current_screen();
		if ( $screen && 'ak_proje' === $screen->post_type ) {
			wp_enqueue_media();
		}
		wp_enqueue_style( 'akilli-admin', AKILLI_CORE_URL . 'assets/admin.css', array(), AKILLI_CORE_VERSION );
		wp_enqueue_script( 'akilli-admin', AKILLI_CORE_URL . 'assets/admin.js', array( 'jquery', 'jquery-ui-sortable' ), AKILLI_CORE_VERSION, true );
	}

	/**
	 * Text field row.
	 *
	 * @param string $name  Field name.
	 * @param string $label Label.
	 * @param string $value Value.
	 * @param string $type  Input type.
	 * @param string $help  Help text.
	 */
	private static function field( $name, $label, $value, $type = 'text', $help = '' ) {
		echo '<p class="ak-field"><label for="' . esc_attr( $name ) . '"><strong>' . esc_html( $label ) . '</strong></label>';
		if ( 'textarea' === $type ) {
			echo '<textarea class="widefat" rows="4" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '">' . esc_textarea( $value ) . '</textarea>';
		} else {
			echo '<input class="widefat" type="' . esc_attr( $type ) . '" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '">';
		}
		if ( $help ) {
			echo '<span class="description">' . esc_html( $help ) . '</span>';
		}
		echo '</p>';
	}

	/**
	 * Service box.
	 *
	 * @param WP_Post $post Post.
	 */
	public static function box_service( $post ) {
		wp_nonce_field( 'akilli_save_meta', self::NONCE );
		$icon = get_post_meta( $post->ID, '_ak_icon', true );
		echo '<p><label for="ak_icon"><strong>İkon</strong></label><select class="widefat" id="ak_icon" name="ak_icon">';
		foreach ( self::service_icons() as $key => $label ) {
			echo '<option value="' . esc_attr( $key ) . '"' . selected( $icon, $key, false ) . '>' . esc_html( $label ) . '</option>';
		}
		echo '</select></p>';
		self::field( 'ak_menu_label', 'Kısa ad (menü ve kartlar)', get_post_meta( $post->ID, '_ak_menu_label', true ), 'text', 'Boş bırakılırsa başlık kullanılır.' );
		$hide = get_post_meta( $post->ID, '_ak_hide_in_form', true );
		echo '<p><label><input type="checkbox" name="ak_hide_in_form" value="1"' . checked( $hide, '1', false ) . '> Teklif formundaki hizmet listesinde gösterme</label></p>';
		echo '<p class="description">Üst öğesi olmayan hizmetler <strong>kategori sayfası</strong> olarak çalışır; alt hizmetleri otomatik listelenir. Hizmetin kısa açıklaması için "Özet" alanını kullanın.</p>';
	}

	/**
	 * Project main box.
	 *
	 * @param WP_Post $post Post.
	 */
	public static function box_project( $post ) {
		wp_nonce_field( 'akilli_save_meta', self::NONCE );
		$m = function ( $k ) use ( $post ) {
			return get_post_meta( $post->ID, '_ak_' . $k, true );
		};
		echo '<div class="ak-grid">';
		self::field( 'ak_client', 'Müşteri adı', $m( 'client' ) );
		self::field( 'ak_sector', 'Sektör', $m( 'sector' ) );
		self::field( 'ak_year', 'Yıl', $m( 'year' ) );
		self::field( 'ak_url', 'Proje bağlantısı', $m( 'url' ), 'url', 'Canlı site adresi (isteğe bağlı).' );
		echo '</div>';
		echo '<p><label><input type="checkbox" name="ak_is_demo" value="1"' . checked( $m( 'is_demo' ), '1', false ) . '> <strong>Örnek / demo proje</strong> — sitede "Örnek çalışma" etiketiyle gösterilir.</label></p>';
		self::field( 'ak_need', 'İhtiyaç ve hedef', $m( 'need' ), 'textarea', 'Müşterinin sorunu, hedefi ve başlangıç durumu.' );
		self::field( 'ak_solution', 'Sunulan çözüm', $m( 'solution' ), 'textarea', 'Ne yaptınız, hangi kararları neden aldınız?' );
		self::field( 'ak_stack', 'Kullanılan altyapı', $m( 'stack' ), 'text', 'Virgülle ayırın: WordPress, WooCommerce, Figma…' );
		self::field( 'ak_video', 'Video (isteğe bağlı)', $m( 'video' ), 'url', 'YouTube, Vimeo veya .mp4 adresi.' );
		self::field( 'ak_results', 'Doğrulanmış sonuçlar', $m( 'results' ), 'textarea', 'Her satıra bir sonuç. Yalnızca müşteriyle doğrulanmış verileri yazın.' );
		echo '<p><label><input type="checkbox" name="ak_results_verified" value="1"' . checked( $m( 'results_verified' ), '1', false ) . '> Sonuçlar doğrulandı, sitede gösterilsin</label></p>';
		$accent = $m( 'accent' );
		echo '<p class="ak-field"><label for="ak_accent"><strong>Proje vurgu rengi</strong></label><input type="color" id="ak_accent" name="ak_accent" value="' . esc_attr( $accent ? $accent : '#8c5a34' ) . '"> <span class="description">Detay sayfasındaki ışık katmanının tonu.</span></p>';
	}

	/**
	 * Gallery box.
	 *
	 * @param WP_Post $post Post.
	 */
	public static function box_gallery( $post ) {
		$ids = array_filter( array_map( 'absint', explode( ',', (string) get_post_meta( $post->ID, '_ak_gallery', true ) ) ) );
		echo '<div class="ak-gallery" data-ak-gallery>';
		echo '<ul class="ak-gallery__list">';
		foreach ( $ids as $id ) {
			echo '<li data-id="' . esc_attr( $id ) . '">' . wp_get_attachment_image( $id, 'thumbnail' ) . '<button type="button" class="ak-gallery__remove" aria-label="Görseli kaldır">×</button></li>';
		}
		echo '</ul>';
		echo '<input type="hidden" name="ak_gallery" value="' . esc_attr( implode( ',', $ids ) ) . '">';
		echo '<p><button type="button" class="button" data-ak-gallery-add>Görsel ekle</button> <span class="description">Sürükleyerek sıralayın. Görsellerin alternatif metinlerini Ortam Kütüphanesi\'nden girin.</span></p>';
		echo '</div>';
	}

	/**
	 * Services checklist (projects + posts).
	 *
	 * @param WP_Post $post Post.
	 */
	public static function box_services_select( $post ) {
		wp_nonce_field( 'akilli_save_meta', self::NONCE );
		$selected = akilli_project_service_ids( $post->ID );
		$tree     = akilli_get_service_tree();
		if ( ! $tree ) {
			echo '<p>Henüz hizmet eklenmemiş.</p>';
			return;
		}
		echo '<input type="hidden" name="ak_services_present" value="1"><div class="ak-checklist">';
		foreach ( $tree as $node ) {
			$parent = $node['post'];
			echo '<p class="ak-checklist__group"><label><input type="checkbox" name="ak_services[]" value="' . esc_attr( $parent->ID ) . '"' . checked( in_array( $parent->ID, $selected, true ), true, false ) . '> <strong>' . esc_html( get_the_title( $parent ) ) . '</strong></label></p><ul>';
			foreach ( $node['children'] as $child ) {
				echo '<li><label><input type="checkbox" name="ak_services[]" value="' . esc_attr( $child->ID ) . '"' . checked( in_array( $child->ID, $selected, true ), true, false ) . '> ' . esc_html( get_the_title( $child ) ) . '</label></li>';
			}
			echo '</ul>';
		}
		echo '</div>';
	}

	/**
	 * Reference box.
	 *
	 * @param WP_Post $post Post.
	 */
	public static function box_reference( $post ) {
		wp_nonce_field( 'akilli_save_meta', self::NONCE );
		self::field( 'ak_ref_url', 'Bağlantı', get_post_meta( $post->ID, '_ak_ref_url', true ), 'url', 'Logoya tıklanınca açılacak adres (isteğe bağlı).' );
		echo '<p class="description">Logoyu sağdaki "Kapak görseli" alanından ekleyin. Sıralamak için Referanslar → Sıralama ekranını kullanın. Yalnızca gerçekten çalıştığınız ve izin aldığınız markaları ekleyin.</p>';
	}

	/**
	 * Save handler.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post.
	 */
	public static function save( $post_id, $post ) {
		if ( ! isset( $_POST[ self::NONCE ] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST[ self::NONCE ] ) ), 'akilli_save_meta' ) ) {
			return;
		}
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		// phpcs:disable WordPress.Security.NonceVerification.Missing -- verified above.
		$text = function ( $key ) {
			return isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '';
		};
		$area = function ( $key ) {
			return isset( $_POST[ $key ] ) ? sanitize_textarea_field( wp_unslash( $_POST[ $key ] ) ) : '';
		};
		$url  = function ( $key ) {
			return isset( $_POST[ $key ] ) ? esc_url_raw( wp_unslash( $_POST[ $key ] ) ) : '';
		};
		$flag = function ( $key ) {
			return empty( $_POST[ $key ] ) ? '' : '1';
		};

		switch ( $post->post_type ) {
			case 'ak_hizmet':
				$icon = $text( 'ak_icon' );
				update_post_meta( $post_id, '_ak_icon', array_key_exists( $icon, self::service_icons() ) ? $icon : 'spark' );
				update_post_meta( $post_id, '_ak_menu_label', $text( 'ak_menu_label' ) );
				update_post_meta( $post_id, '_ak_hide_in_form', $flag( 'ak_hide_in_form' ) );
				break;

			case 'ak_proje':
				foreach ( array( 'client', 'sector', 'year', 'stack' ) as $k ) {
					update_post_meta( $post_id, '_ak_' . $k, $text( 'ak_' . $k ) );
				}
				foreach ( array( 'need', 'solution', 'results' ) as $k ) {
					update_post_meta( $post_id, '_ak_' . $k, $area( 'ak_' . $k ) );
				}
				update_post_meta( $post_id, '_ak_url', $url( 'ak_url' ) );
				update_post_meta( $post_id, '_ak_video', $url( 'ak_video' ) );
				update_post_meta( $post_id, '_ak_is_demo', $flag( 'ak_is_demo' ) );
				update_post_meta( $post_id, '_ak_results_verified', $flag( 'ak_results_verified' ) );
				$accent = sanitize_hex_color( $text( 'ak_accent' ) );
				update_post_meta( $post_id, '_ak_accent', $accent ? $accent : '' );
				$gallery = isset( $_POST['ak_gallery'] ) ? array_filter( array_map( 'absint', explode( ',', sanitize_text_field( wp_unslash( $_POST['ak_gallery'] ) ) ) ) ) : array();
				update_post_meta( $post_id, '_ak_gallery', implode( ',', $gallery ) );
				self::save_services( $post_id );
				break;

			case 'post':
				self::save_services( $post_id );
				break;

			case 'ak_referans':
				update_post_meta( $post_id, '_ak_ref_url', $url( 'ak_ref_url' ) );
				break;
		}
		// phpcs:enable
	}

	/**
	 * Store selected services as multiple meta rows (_ak_service).
	 *
	 * @param int $post_id Post ID.
	 */
	private static function save_services( $post_id ) {
		// phpcs:disable WordPress.Security.NonceVerification.Missing -- verified in save().
		if ( empty( $_POST['ak_services_present'] ) ) {
			return;
		}
		$ids = isset( $_POST['ak_services'] ) ? array_unique( array_map( 'absint', (array) wp_unslash( $_POST['ak_services'] ) ) ) : array();
		// phpcs:enable
		delete_post_meta( $post_id, '_ak_service' );
		foreach ( $ids as $id ) {
			if ( 'ak_hizmet' === get_post_type( $id ) ) {
				add_post_meta( $post_id, '_ak_service', $id );
			}
		}
	}

	/**
	 * Project list columns.
	 *
	 * @param array $cols Columns.
	 * @return array
	 */
	public static function project_columns( $cols ) {
		$new = array();
		foreach ( $cols as $k => $v ) {
			if ( 'title' === $k ) {
				$new['ak_thumb'] = 'Kapak';
			}
			$new[ $k ] = $v;
			if ( 'title' === $k ) {
				$new['ak_client'] = 'Müşteri';
				$new['ak_demo']   = 'Tür';
			}
		}
		return $new;
	}

	/**
	 * Project column output.
	 *
	 * @param string $col     Column.
	 * @param int    $post_id Post.
	 */
	public static function project_column( $col, $post_id ) {
		if ( 'ak_thumb' === $col ) {
			echo get_the_post_thumbnail( $post_id, array( 60, 40 ) );
		} elseif ( 'ak_client' === $col ) {
			echo esc_html( get_post_meta( $post_id, '_ak_client', true ) );
		} elseif ( 'ak_demo' === $col ) {
			echo get_post_meta( $post_id, '_ak_is_demo', true ) ? '<span class="ak-badge ak-badge--demo">Örnek</span>' : '<span class="ak-badge">Gerçek</span>';
		}
	}

	/**
	 * Reference list columns.
	 *
	 * @param array $cols Columns.
	 * @return array
	 */
	public static function ref_columns( $cols ) {
		return array(
			'cb'        => $cols['cb'],
			'ak_logo'   => 'Logo',
			'title'     => 'Marka',
			'ak_ref'    => 'Bağlantı',
			'ak_order'  => 'Sıra',
			'date'      => $cols['date'],
		);
	}

	/**
	 * Reference column output.
	 *
	 * @param string $col     Column.
	 * @param int    $post_id Post.
	 */
	public static function ref_column( $col, $post_id ) {
		if ( 'ak_logo' === $col ) {
			echo get_the_post_thumbnail( $post_id, array( 100, 50 ) );
		} elseif ( 'ak_ref' === $col ) {
			$u = get_post_meta( $post_id, '_ak_ref_url', true );
			echo $u ? '<a href="' . esc_url( $u ) . '" target="_blank" rel="noopener">' . esc_html( $u ) . '</a>' : '—';
		} elseif ( 'ak_order' === $col ) {
			echo (int) get_post_field( 'menu_order', $post_id );
		}
	}
}
