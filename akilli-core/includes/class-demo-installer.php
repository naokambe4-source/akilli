<?php
/**
 * Idempotent demo/setup installer.
 *
 * Creates pages, services, projects, blog posts, media and menus. Every item
 * carries a `_ak_demo_key`; existing items (by key or by slug) are skipped, so
 * running the installer again never duplicates or deletes anything.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Demo installer.
 */
class Akilli_Demo_Installer {

	/**
	 * Report lines.
	 *
	 * @var array
	 */
	private $log = array(
		'created' => array(),
		'skipped' => array(),
		'notes'   => array(),
	);

	/**
	 * Hooks.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ), 20 );
		add_action( 'admin_post_akilli_install_demo', array( __CLASS__, 'handle' ) );
		add_action( 'admin_notices', array( __CLASS__, 'notice' ) );
	}

	/**
	 * Menu.
	 */
	public static function menu() {
		add_submenu_page( 'akilli-creative', 'Kurulum ve demo içerik', 'Kurulum', 'manage_options', 'akilli-demo', array( __CLASS__, 'render' ) );
	}

	/**
	 * Notice until setup has run.
	 */
	public static function notice() {
		if ( get_option( 'akilli_demo_installed' ) || ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$screen = get_current_screen();
		if ( $screen && 'akilli-creative_page_akilli-demo' === $screen->id ) {
			return;
		}
		echo '<div class="notice notice-info"><p><strong>Akıllı Creative:</strong> Sayfaları, hizmetleri, menüleri ve örnek içerikleri tek tıkla oluşturabilirsiniz. <a class="button button-primary" href="' . esc_url( admin_url( 'admin.php?page=akilli-demo' ) ) . '">Kurulum ekranına git</a></p></div>';
	}

	/**
	 * Settings screen.
	 */
	public static function render() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$report = get_transient( 'akilli_demo_report_' . get_current_user_id() );
		echo '<div class="wrap ak-settings"><h1>Kurulum ve demo içerik</h1>';
		if ( is_array( $report ) ) {
			delete_transient( 'akilli_demo_report_' . get_current_user_id() );
			echo '<div class="notice notice-success"><p><strong>Kurulum tamamlandı.</strong> ' . count( $report['created'] ) . ' öğe oluşturuldu, ' . count( $report['skipped'] ) . ' öğe zaten vardı ve olduğu gibi bırakıldı.</p></div>';
			echo '<div class="ak-card"><details><summary><strong>Ayrıntılı rapor</strong></summary>';
			foreach ( array( 'created' => 'Oluşturulanlar', 'skipped' => 'Atlananlar (zaten mevcut)', 'notes' => 'Notlar' ) as $k => $label ) {
				if ( $report[ $k ] ) {
					echo '<h3>' . esc_html( $label ) . '</h3><ul style="list-style:disc;margin-left:20px">';
					foreach ( $report[ $k ] as $line ) {
						echo '<li>' . esc_html( $line ) . '</li>';
					}
					echo '</ul>';
				}
			}
			echo '</details></div>';
		}
		?>
		<div class="ak-card">
			<h2>Neler oluşturulur?</h2>
			<ul style="list-style:disc;margin-left:20px">
				<li><strong>Sayfalar:</strong> Ana Sayfa, Hakkımızda, Hizmetlerimiz, Referanslarımız, Çalışmalarımız, Blog, Teklif Al, İletişim, Gizlilik Politikası, Çerez Politikası, KVKK Aydınlatma Metni</li>
				<li><strong>Hizmetler:</strong> 4 kategori sayfası ve 24 alt hizmet detay sayfası (tamamlanmış içerik, SSS ve meta taslaklarıyla)</li>
				<li><strong>Örnek projeler:</strong> 6 proje — sitede “Örnek çalışma” etiketiyle gösterilir; müşteri adı, yorum veya sonuç içermez</li>
				<li><strong>Blog:</strong> 6 yazı, kategoriler ve etiketler</li>
				<li><strong>Menüler:</strong> Ana menü (hizmetler mega menüsüyle), footer menüleri ve yasal bağlantılar</li>
				<li><strong>Ayarlar:</strong> Ana sayfa ve blog sayfası ataması (yalnızca henüz ayarlanmamışsa), kalıcı bağlantı yapısı (yalnızca “Düz” ise)</li>
			</ul>
			<p><strong>Güvenli tekrar kurulum:</strong> Aynı adla veya aynı kısa adla (slug) var olan içerikler atlanır; hiçbir içerik silinmez veya üzerine yazılmaz.</p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'akilli_install_demo' ); ?>
				<input type="hidden" name="action" value="akilli_install_demo">
				<p><label><input type="checkbox" name="with_demo" value="1" checked> Örnek projeleri ve blog yazılarını da oluştur</label></p>
				<p><label><input type="checkbox" name="noindex" value="1" <?php checked( ! get_option( 'akilli_demo_installed' ) ); ?>> Siteyi arama motorlarına kapat (demo/geliştirme ortamı için önerilir)</label></p>
				<?php submit_button( get_option( 'akilli_demo_installed' ) ? 'Eksik içerikleri tamamla' : 'Kurulumu başlat', 'primary', 'submit', false ); ?>
			</form>
		</div>
		<div class="ak-card">
			<h2>Yayına geçmeden önce</h2>
			<ol style="margin-left:20px">
				<li>Örnek projeleri gerçek çalışmalarınızla değiştirin veya taslağa alın.</li>
				<li>Referanslar menüsünden izinli müşteri logolarını ekleyin.</li>
				<li>Yasal sayfaları hukuk danışmanınızla gözden geçirin.</li>
				<li><a href="<?php echo esc_url( admin_url( 'options-reading.php' ) ); ?>">Ayarlar → Okuma</a> ekranında arama motoru engelini kaldırın.</li>
				<li>Form bildirimlerini test edin (<a href="<?php echo esc_url( admin_url( 'admin.php?page=akilli-creative&tab=bildirim' ) ); ?>">Bildirim ayarları</a>).</li>
			</ol>
		</div>
		</div>
		<?php
	}

	/**
	 * Form handler.
	 */
	public static function handle() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Bu işlem için yetkiniz yok.', 403 );
		}
		check_admin_referer( 'akilli_install_demo' );
		$installer = new self();
		$report    = $installer->run(
			array(
				'with_demo' => ! empty( $_POST['with_demo'] ),
				'noindex'   => ! empty( $_POST['noindex'] ),
			)
		);
		set_transient( 'akilli_demo_report_' . get_current_user_id(), $report, 10 * MINUTE_IN_SECONDS );
		wp_safe_redirect( admin_url( 'admin.php?page=akilli-demo' ) );
		exit;
	}

	/**
	 * Run the installer (also callable from WP-CLI: `wp eval 'print_r((new Akilli_Demo_Installer())->run());'`).
	 *
	 * @param array $opts Options.
	 * @return array Report.
	 */
	public function run( $opts = array() ) {
		$opts = wp_parse_args(
			$opts,
			array(
				'with_demo' => true,
				'noindex'   => true,
			)
		);
		require_once AKILLI_CORE_DIR . 'demo/builder.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		if ( function_exists( 'set_time_limit' ) ) {
			@set_time_limit( 300 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		}
		Akilli_Post_Types::register();

		// Pretty permalinks are required for clean URLs; only switch from "plain".
		if ( '' === (string) get_option( 'permalink_structure' ) ) {
			update_option( 'permalink_structure', '/%postname%/' );
			$this->log['notes'][] = 'Kalıcı bağlantı yapısı "Yazı adı" (/%postname%/) olarak ayarlandı.';
		}

		$images   = $this->images();
		$services = $this->services();
		$posts    = $opts['with_demo'] ? $this->posts( $services ) : array();
		if ( $opts['with_demo'] ) {
			$this->projects( $services, $images );
		}
		$pages = $this->pages( $images );
		$this->resolve_placeholders( array_merge( array_values( $services ), array_values( $pages ) ), $posts, $pages );
		$this->settings( $pages );
		$this->menus( $pages, $services );

		$this->retire_wp_samples();
		if ( $opts['noindex'] ) {
			update_option( 'blog_public', '0' );
			$this->log['notes'][] = 'Site arama motorlarına kapatıldı (Ayarlar → Okuma).';
		}
		update_option( 'akilli_demo_installed', time() );
		flush_rewrite_rules();
		return $this->log;
	}

	/**
	 * Move WordPress' untouched sample post/page to drafts (never deletes; skipped once edited).
	 */
	private function retire_wp_samples() {
		foreach ( array( array( 'post', array( 'hello-world', 'merhaba-dunya' ) ), array( 'page', array( 'sample-page', 'ornek-sayfa' ) ) ) as $def ) {
			foreach ( $def[1] as $slug ) {
				$found = get_posts(
					array(
						'post_type'   => $def[0],
						'name'        => $slug,
						'post_status' => 'publish',
						'numberposts' => 1,
					)
				);
				if ( $found && $found[0]->post_modified === $found[0]->post_date && ! get_post_meta( $found[0]->ID, '_ak_demo_key', true ) ) {
					wp_update_post(
						array(
							'ID'          => $found[0]->ID,
							'post_status' => 'draft',
						)
					);
					$this->log['notes'][] = 'WordPress örnek içeriği taslağa alındı (silinmedi): ' . $found[0]->post_title;
				}
			}
		}
	}

	/**
	 * Find existing item by demo key, then by slug.
	 *
	 * @param string $key       Demo key.
	 * @param string $post_type Type.
	 * @param string $slug      Slug.
	 * @param int    $parent    Parent ID (hierarchical types).
	 * @return int
	 */
	private function find( $key, $post_type, $slug = '', $parent = 0 ) {
		$by_key = get_posts(
			array(
				'post_type'   => $post_type,
				'post_status' => 'any',
				'numberposts' => 1,
				'fields'      => 'ids',
				'meta_key'    => '_ak_demo_key', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_value'  => $key, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			)
		);
		if ( $by_key ) {
			return (int) $by_key[0];
		}
		if ( $slug ) {
			$args = array(
				'post_type'   => $post_type,
				'name'        => $slug,
				'post_status' => array( 'publish', 'draft', 'pending', 'private', 'future' ),
				'numberposts' => 1,
				'fields'      => 'ids',
			);
			if ( is_post_type_hierarchical( $post_type ) ) {
				$args['post_parent'] = $parent;
			}
			$by_slug = get_posts( $args );
			if ( $by_slug ) {
				return (int) $by_slug[0];
			}
		}
		return 0;
	}

	/**
	 * Insert a post unless it exists.
	 *
	 * @param string $key   Demo key.
	 * @param array  $args  wp_insert_post args.
	 * @param array  $seo   [title, desc].
	 * @param string $label Report label.
	 * @return array [id, created]
	 */
	private function ensure( $key, $args, $seo = array(), $label = '' ) {
		$parent   = isset( $args['post_parent'] ) ? (int) $args['post_parent'] : 0;
		$existing = $this->find( $key, $args['post_type'], $args['post_name'], $parent );
		$label    = $label ? $label : $args['post_title'];
		if ( $existing ) {
			$this->log['skipped'][] = $label;
			return array( $existing, false );
		}
		$args = wp_parse_args(
			$args,
			array(
				'post_status' => 'publish',
				'post_author' => get_current_user_id() ? get_current_user_id() : 1,
			)
		);
		$id   = wp_insert_post( wp_slash( $args ), true );
		if ( is_wp_error( $id ) ) {
			$this->log['notes'][] = $label . ': ' . $id->get_error_message();
			return array( 0, false );
		}
		update_post_meta( $id, '_ak_demo_key', $key );
		if ( $seo ) {
			update_post_meta( $id, '_ak_seo_title', $seo[0] );
			update_post_meta( $id, '_ak_seo_desc', $seo[1] );
			// Drafts for SEO plugins, so switching to Yoast / Rank Math keeps them.
			update_post_meta( $id, '_yoast_wpseo_title', $seo[0] );
			update_post_meta( $id, '_yoast_wpseo_metadesc', $seo[1] );
			update_post_meta( $id, 'rank_math_title', $seo[0] );
			update_post_meta( $id, 'rank_math_description', $seo[1] );
		}
		$this->log['created'][] = $label;
		return array( (int) $id, true );
	}

	/**
	 * Import bundled images into the media library.
	 *
	 * @return array name => attachment ID
	 */
	private function images() {
		$out   = array();
		$alts  = array(
			'studio-katmanlar' => 'Fikirden tasarıma ve koda uzanan süreci simgeleyen üst üste katmanlı soyut kompozisyon',
			'blog-web'         => 'Kurumsal web sitesi planlama yazısı için soyut kapak görseli',
			'blog-pos'         => 'Sanal POS ve 3D Secure yazısı için soyut kapak görseli',
			'blog-altyapi'     => 'E-ticaret altyapısı karşılaştırma yazısı için soyut kapak görseli',
			'blog-seo'         => 'Yerel SEO rehberi için soyut kapak görseli',
			'blog-logo'        => 'Logo ve kurumsal kimlik yazısı için soyut kapak görseli',
			'blog-saglik'      => 'Sağlık ve hukuk sektörü web içeriği yazısı için soyut kapak görseli',
		);
		$files = glob( AKILLI_CORE_DIR . 'demo/images/*.jpg' );
		foreach ( (array) $files as $file ) {
			$name = basename( $file, '.jpg' );
			$key  = 'img:' . $name;
			$have = $this->find( $key, 'attachment' );
			if ( $have ) {
				$out[ $name ] = $have;
				continue;
			}
			$tmp = wp_tempnam( $name . '.jpg' );
			copy( $file, $tmp );
			$id = media_handle_sideload(
				array(
					'name'     => 'akilli-' . $name . '.jpg',
					'tmp_name' => $tmp,
				),
				0,
				'Örnek görsel: ' . $name
			);
			if ( is_wp_error( $id ) ) {
				$this->log['notes'][] = 'Görsel yüklenemedi (' . $name . '): ' . $id->get_error_message();
				@unlink( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged,WordPress.WP.AlternativeFunctions.unlink_unlink
				continue;
			}
			update_post_meta( $id, '_ak_demo_key', $key );
			if ( isset( $alts[ $name ] ) ) {
				update_post_meta( $id, '_wp_attachment_image_alt', $alts[ $name ] );
			}
			$out[ $name ]           = (int) $id;
			$this->log['created'][] = 'Görsel: ' . $name;
		}
		return $out;
	}

	/**
	 * Services (categories + children).
	 *
	 * @return array slug => ID
	 */
	private function services() {
		$ids   = array();
		$order = 0;
		foreach ( array( 'web', 'eticaret', 'grafik', 'dijital' ) as $file ) {
			$cat = include AKILLI_CORE_DIR . 'demo/services-' . $file . '.php';
			list( $cid ) = $this->ensure(
				'svc:' . $cat['slug'],
				array(
					'post_type'    => 'ak_hizmet',
					'post_title'   => $cat['title'],
					'post_name'    => $cat['slug'],
					'post_excerpt' => $cat['excerpt'],
					'post_content' => akilli_demo_category_blocks( $cat ),
					'menu_order'   => $order++,
					'meta_input'   => array( '_ak_icon' => $cat['icon'] ),
				),
				$cat['seo'],
				'Hizmet kategorisi: ' . $cat['title']
			);
			if ( ! $cid ) {
				continue;
			}
			$ids[ $cat['slug'] ] = $cid;
			$child_order         = 0;
			foreach ( $cat['children'] as $s ) {
				list( $sid ) = $this->ensure(
					'svc:' . $s['slug'],
					array(
						'post_type'    => 'ak_hizmet',
						'post_title'   => $s['title'],
						'post_name'    => $s['slug'],
						'post_parent'  => $cid,
						'post_excerpt' => $s['excerpt'],
						'post_content' => akilli_demo_service_blocks( $s ),
						'menu_order'   => $child_order++,
						'meta_input'   => array(
							'_ak_icon'       => $s['icon'],
							'_ak_menu_label' => $s['label'],
						),
					),
					$s['seo'],
					'Hizmet: ' . $s['title']
				);
				if ( $sid ) {
					$ids[ $s['slug'] ] = $sid;
				}
			}
		}
		return $ids;
	}

	/**
	 * Blog posts with categories and tags.
	 *
	 * @param array $services slug => ID.
	 * @return array slug => ID
	 */
	private function posts( $services ) {
		$out   = array();
		$data  = include AKILLI_CORE_DIR . 'demo/posts.php';
		$imgs  = array( 'blog-web', 'blog-pos', 'blog-altyapi', 'blog-seo', 'blog-logo', 'blog-saglik' );
		$media = $this->images_cache();
		foreach ( $data as $i => $p ) {
			$term = term_exists( $p['category'], 'category' );
			if ( ! $term ) {
				$term = wp_insert_term( $p['category'], 'category' );
			}
			$cat_id      = is_array( $term ) ? (int) $term['term_id'] : (int) $term;
			list( $id, $created ) = $this->ensure(
				'post:' . $p['slug'],
				array(
					'post_type'     => 'post',
					'post_title'    => $p['title'],
					'post_name'     => $p['slug'],
					'post_excerpt'  => $p['excerpt'],
					'post_content'  => akilli_demo_post_blocks( $p['content'] ),
					'post_category' => array( $cat_id ),
					'tags_input'    => $p['tags'],
					'post_date'     => gmdate( 'Y-m-d H:i:s', strtotime( '-' . ( ( count( $data ) - $i ) * 9 ) . ' days', current_time( 'timestamp' ) ) ), // phpcs:ignore WordPress.DateTime.CurrentTimeTimestamp.Requested
				),
				$p['seo'],
				'Blog yazısı: ' . $p['title']
			);
			if ( ! $id ) {
				continue;
			}
			$out[ $p['slug'] ] = $id;
			if ( $created ) {
				if ( isset( $media[ $imgs[ $i ] ] ) ) {
					set_post_thumbnail( $id, $media[ $imgs[ $i ] ] );
				}
				foreach ( $p['services'] as $slug ) {
					if ( isset( $services[ $slug ] ) ) {
						add_post_meta( $id, '_ak_service', $services[ $slug ] );
					}
				}
			}
		}
		// Uncategorized → rename to something meaningful only if still default and empty.
		$default = get_term( (int) get_option( 'default_category' ), 'category' );
		if ( $default && ! is_wp_error( $default ) && in_array( $default->slug, array( 'uncategorized', 'genel', 'kategorilenmemis' ), true ) && 0 === (int) $default->count ) {
			wp_update_term(
				$default->term_id,
				'category',
				array(
					'name' => 'Genel',
					'slug' => 'genel',
				)
			);
		}
		return $out;
	}

	/**
	 * Cached map of demo images.
	 *
	 * @return array
	 */
	private function images_cache() {
		$out = array();
		foreach ( get_posts(
			array(
				'post_type'   => 'attachment',
				'post_status' => 'inherit',
				'numberposts' => 100,
				'meta_key'    => '_ak_demo_key', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			)
		) as $att ) {
			$out[ substr( get_post_meta( $att->ID, '_ak_demo_key', true ), 4 ) ] = $att->ID;
		}
		return $out;
	}

	/**
	 * Demo projects.
	 *
	 * @param array $services Services map.
	 * @param array $images   Images map.
	 */
	private function projects( $services, $images ) {
		$data = include AKILLI_CORE_DIR . 'demo/projects.php';
		foreach ( $data as $i => $p ) {
			list( $id, $created ) = $this->ensure(
				'proje:' . $p['slug'],
				array(
					'post_type'    => 'ak_proje',
					'post_title'   => $p['title'],
					'post_name'    => $p['slug'],
					'post_excerpt' => $p['excerpt'],
					'post_content' => akilli_demo_p( esc_html( $p['content'] ) ),
					'menu_order'   => $i,
					'meta_input'   => array(
						'_ak_client'   => $p['client'],
						'_ak_sector'   => $p['sector'],
						'_ak_year'     => $p['year'],
						'_ak_need'     => $p['need'],
						'_ak_solution' => $p['solution'],
						'_ak_stack'    => $p['stack'],
						'_ak_accent'   => $p['accent'],
						'_ak_is_demo'  => '1',
					),
				),
				array( 'Örnek Proje: ' . $p['title'] . ' | Akıllı Creative', wp_html_excerpt( $p['excerpt'], 155, '…' ) ),
				'Örnek proje: ' . $p['title']
			);
			if ( ! $id || ! $created ) {
				continue;
			}
			$terms = array();
			foreach ( $p['cats'] as $cat ) {
				$t = term_exists( $cat, 'ak_proje_kategori' );
				if ( ! $t ) {
					$t = wp_insert_term( $cat, 'ak_proje_kategori' );
				}
				if ( ! is_wp_error( $t ) ) {
					$terms[] = (int) ( is_array( $t ) ? $t['term_id'] : $t );
				}
			}
			wp_set_object_terms( $id, $terms, 'ak_proje_kategori' );
			foreach ( $p['services'] as $slug ) {
				if ( isset( $services[ $slug ] ) ) {
					add_post_meta( $id, '_ak_service', $services[ $slug ] );
				}
			}
			$img = $p['image'];
			if ( isset( $images[ $img ] ) ) {
				set_post_thumbnail( $id, $images[ $img ] );
				update_post_meta( $images[ $img ], '_wp_attachment_image_alt', 'Örnek çalışma: ' . $p['title'] . ' — masaüstü ve mobil arayüz kurgusu' );
			}
			$gallery = array();
			foreach ( array( '-detay-1', '-detay-2' ) as $n => $suffix ) {
				if ( isset( $images[ $img . $suffix ] ) ) {
					$gallery[] = $images[ $img . $suffix ];
					update_post_meta( $images[ $img . $suffix ], '_wp_attachment_image_alt', 'Örnek çalışma: ' . $p['title'] . ( 0 === $n ? ' — renk ve tipografi sistemi' : ' — mobil ekran kurguları' ) );
				}
			}
			update_post_meta( $id, '_ak_gallery', implode( ',', $gallery ) );
		}
	}

	/**
	 * Pages.
	 *
	 * @param array $images Images.
	 * @return array slug => ID
	 */
	private function pages( $images ) {
		$images  = wp_parse_args( $images, array( 'studio-katmanlar' => 0, 'hero-saten' => 0 ) );
		$builder = include AKILLI_CORE_DIR . 'demo/pages.php';
		$out     = array();
		foreach ( $builder( $images ) as $slug => $p ) {
			list( $id ) = $this->ensure(
				'page:' . $slug,
				array(
					'post_type'    => 'page',
					'post_title'   => $p['title'],
					'post_name'    => $slug,
					'post_excerpt' => isset( $p['excerpt'] ) ? $p['excerpt'] : '',
					'post_content' => $p['content'],
				),
				$p['seo'],
				'Sayfa: ' . $p['title']
			);
			if ( $id ) {
				$out[ $slug ] = $id;
			}
		}
		return $out;
	}

	/**
	 * Replace {home}, {post:slug} and {page:slug} in freshly created content.
	 *
	 * @param int[] $ids   Post IDs to scan.
	 * @param array $posts Post map.
	 * @param array $pages Page map.
	 */
	private function resolve_placeholders( $ids, $posts, $pages ) {
		$home = untrailingslashit( home_url() );
		foreach ( array_unique( array_map( 'intval', $ids ) ) as $id ) {
			$p = get_post( $id );
			if ( ! $p || false === strpos( $p->post_content . $p->post_excerpt, '{' ) ) {
				continue;
			}
			$content = preg_replace_callback(
				'/\{(home|post|page)(?::([a-z0-9\-]+))?\}/',
				function ( $m ) use ( $home, $posts, $pages ) {
					if ( 'home' === $m[1] ) {
						return $home;
					}
					$map = 'post' === $m[1] ? $posts : $pages;
					$id  = isset( $map[ $m[2] ] ) ? $map[ $m[2] ] : 0;
					if ( ! $id ) {
						$found = get_page_by_path( $m[2], OBJECT, 'post' === $m[1] ? 'post' : 'page' );
						$id    = $found ? $found->ID : 0;
					}
					return $id ? get_permalink( $id ) : $home . '/';
				},
				$p->post_content
			);
			if ( $content !== $p->post_content ) {
				wp_update_post(
					wp_slash(
						array(
							'ID'           => $id,
							'post_content' => $content,
						)
					)
				);
			}
		}
		// Blog posts too.
		foreach ( $posts as $id ) {
			$p = get_post( $id );
			if ( $p && false !== strpos( $p->post_content, '{home}' ) ) {
				wp_update_post(
					wp_slash(
						array(
							'ID'           => $id,
							'post_content' => str_replace( '{home}', $home, $p->post_content ),
						)
					)
				);
			}
		}
	}

	/**
	 * Reading settings and page options.
	 *
	 * @param array $pages Pages.
	 */
	private function settings( $pages ) {
		$map = array(
			'akilli_page_teklif'     => 'teklif-al',
			'akilli_page_hizmetler'  => 'hizmetlerimiz',
			'akilli_page_calismalar' => 'calismalarimiz',
			'akilli_page_kvkk'       => 'kvkk-aydinlatma-metni',
			'akilli_page_cerez'      => 'cerez-politikasi',
			'akilli_page_iletisim'   => 'iletisim',
		);
		foreach ( $map as $option => $slug ) {
			if ( ! get_option( $option ) && isset( $pages[ $slug ] ) ) {
				update_option( $option, $pages[ $slug ] );
			}
		}
		if ( 'page' !== get_option( 'show_on_front' ) || ! get_option( 'page_on_front' ) ) {
			if ( isset( $pages['ana-sayfa'], $pages['blog'] ) ) {
				update_option( 'show_on_front', 'page' );
				update_option( 'page_on_front', $pages['ana-sayfa'] );
				update_option( 'page_for_posts', $pages['blog'] );
				$this->log['notes'][] = 'Ana sayfa ve blog sayfası atandı (Ayarlar → Okuma).';
			}
		} else {
			$this->log['notes'][] = 'Statik ana sayfa zaten ayarlı olduğu için değiştirilmedi.';
		}
		$privacy = (int) get_option( 'wp_page_for_privacy_policy' );
		if ( ( ! $privacy || 'publish' !== get_post_status( $privacy ) ) && isset( $pages['gizlilik-politikasi'] ) ) {
			update_option( 'wp_page_for_privacy_policy', $pages['gizlilik-politikasi'] );
		}
		$settings = (array) get_option( 'akilli_core_settings', array() );
		if ( empty( $settings['privacy_page'] ) && isset( $pages['kvkk-aydinlatma-metni'] ) ) {
			$settings['privacy_page'] = $pages['kvkk-aydinlatma-metni'];
			update_option( 'akilli_core_settings', $settings );
		}
		if ( ! get_option( 'blogdescription' ) || in_array( get_option( 'blogdescription' ), array( 'Just another WordPress site', 'Bir başka WordPress sitesi' ), true ) ) {
			update_option( 'blogdescription', 'Antalya merkezli dijital ajans: web tasarım, e-ticaret yazılımı, grafik tasarım ve dijital büyüme.' );
		}
		update_option( 'posts_per_page', max( 9, (int) get_option( 'posts_per_page' ) ) );
	}

	/**
	 * Menus (only created when a menu with the same name doesn't exist).
	 *
	 * @param array $pages    Pages.
	 * @param array $services Services.
	 */
	private function menus( $pages, $services ) {
		$tree = array();
		foreach ( get_posts(
			array(
				'post_type'   => 'ak_hizmet',
				'numberposts' => 200,
				'post_parent' => 0,
				'orderby'     => 'menu_order',
				'order'       => 'ASC',
			)
		) as $cat ) {
			$tree[ $cat->ID ] = get_posts(
				array(
					'post_type'   => 'ak_hizmet',
					'numberposts' => 200,
					'post_parent' => $cat->ID,
					'orderby'     => 'menu_order',
					'order'       => 'ASC',
				)
			);
		}

		$page_item = function ( $menu, $slug, $parent = 0, $title = '' ) use ( $pages ) {
			if ( empty( $pages[ $slug ] ) ) {
				return 0;
			}
			return wp_update_nav_menu_item(
				$menu,
				0,
				array(
					'menu-item-title'     => $title,
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $pages[ $slug ],
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
					'menu-item-parent-id' => $parent,
				)
			);
		};
		$svc_item  = function ( $menu, $post, $parent = 0, $title = '' ) {
			return wp_update_nav_menu_item(
				$menu,
				0,
				array(
					'menu-item-title'     => $title,
					'menu-item-object'    => 'ak_hizmet',
					'menu-item-object-id' => $post->ID,
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
					'menu-item-parent-id' => $parent,
				)
			);
		};

		$locations = get_theme_mod( 'nav_menu_locations', array() );
		$defs      = array(
			'primary'        => 'Ana Menü',
			'footer_services' => 'Footer — Hizmetler',
			'footer_company' => 'Footer — Kurumsal',
			'legal'          => 'Yasal Bağlantılar',
		);
		foreach ( $defs as $location => $name ) {
			if ( wp_get_nav_menu_object( $name ) ) {
				$this->log['skipped'][] = 'Menü: ' . $name;
				$menu_id                = wp_get_nav_menu_object( $name )->term_id;
			} else {
				$menu_id = wp_create_nav_menu( $name );
				if ( is_wp_error( $menu_id ) ) {
					continue;
				}
				$this->log['created'][] = 'Menü: ' . $name;
				switch ( $location ) {
					case 'primary':
						$top = $page_item( $menu_id, 'hizmetlerimiz' );
						foreach ( $tree as $cat_id => $children ) {
							$cat_item = $svc_item( $menu_id, get_post( $cat_id ), $top );
							foreach ( $children as $child ) {
								$label = get_post_meta( $child->ID, '_ak_menu_label', true );
								$svc_item( $menu_id, $child, $cat_item, '' );
							}
						}
						$page_item( $menu_id, 'calismalarimiz' );
						$page_item( $menu_id, 'referanslarimiz' );
						$page_item( $menu_id, 'hakkimizda' );
						$page_item( $menu_id, 'blog' );
						$page_item( $menu_id, 'iletisim' );
						break;
					case 'footer_services':
						foreach ( $tree as $cat_id => $children ) {
							$svc_item( $menu_id, get_post( $cat_id ) );
						}
						$page_item( $menu_id, 'teklif-al', 0, 'Teklif al' );
						break;
					case 'footer_company':
						foreach ( array( 'hakkimizda', 'calismalarimiz', 'referanslarimiz', 'blog', 'iletisim' ) as $slug ) {
							$page_item( $menu_id, $slug );
						}
						break;
					case 'legal':
						foreach ( array( 'gizlilik-politikasi', 'cerez-politikasi', 'kvkk-aydinlatma-metni' ) as $slug ) {
							$page_item( $menu_id, $slug );
						}
						break;
				}
			}
			if ( empty( $locations[ $location ] ) ) {
				$locations[ $location ] = $menu_id;
			}
		}
		set_theme_mod( 'nav_menu_locations', $locations );
	}
}
