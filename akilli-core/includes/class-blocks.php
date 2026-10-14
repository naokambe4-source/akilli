<?php
/**
 * Dynamic Gutenberg blocks.
 *
 * Every block is server-rendered (SEO-friendly HTML, no block-validation
 * issues) and edited through a schema-driven sidebar UI (assets/blocks-editor.js).
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Block registry.
 */
class Akilli_Blocks {

	/**
	 * Hooks.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register' ), 20 );
		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'editor_assets' ) );
		add_filter( 'block_categories_all', array( __CLASS__, 'category' ) );
		add_action( 'init', array( __CLASS__, 'patterns' ), 30 );
	}

	/**
	 * Shared fields appended to every block.
	 *
	 * @return array
	 */
	private static function common() {
		return array(
			'anchor' => array(
				'type'  => 'text',
				'label' => 'Bağlantı adı (#)',
				'help'  => 'Menüden bu bölüme bağlantı vermek için. Boşsa başlıktan üretilir.',
				'group' => 'Bölüm ayarları',
			),
			'hidden' => array(
				'type'    => 'toggle',
				'label'   => 'Bu bölümü sitede gizle',
				'help'    => 'İçerik silinmez; yalnızca ziyaretçilere gösterilmez.',
				'default' => false,
				'group'   => 'Bölüm ayarları',
			),
		);
	}

	/**
	 * Block definitions.
	 *
	 * @param bool $with_options Resolve dynamic select options (editor only).
	 * @return array
	 */
	public static function definitions( $with_options = false ) {
		$icon_opts = array();
		foreach ( Akilli_Meta_Boxes::service_icons() as $k => $l ) {
			$icon_opts[] = array(
				'value' => $k,
				'label' => $l,
			);
		}
		$proj_cats = array(
			array(
				'value' => '',
				'label' => 'Tümü',
			),
		);
		$post_cats = $proj_cats;
		if ( $with_options ) {
			foreach ( get_terms( array( 'taxonomy' => 'ak_proje_kategori', 'hide_empty' => false ) ) as $t ) {
				$proj_cats[] = array(
					'value' => $t->slug,
					'label' => $t->name,
				);
			}
			foreach ( get_categories( array( 'hide_empty' => false ) ) as $t ) {
				$post_cats[] = array(
					'value' => $t->slug,
					'label' => $t->name,
				);
			}
		}
		$opts = function ( $map ) {
			$out = array();
			foreach ( $map as $v => $l ) {
				$out[] = array(
					'value' => (string) $v,
					'label' => $l,
				);
			}
			return $out;
		};
		$heading = array(
			'eyebrow' => array(
				'type'  => 'text',
				'label' => 'Üst başlık',
			),
			'title'   => array(
				'type'  => 'textarea',
				'label' => 'Başlık',
				'help'  => '<em>kelime</em> ile vurgulu kelime oluşturabilirsiniz.',
			),
			'text'    => array(
				'type'  => 'textarea',
				'label' => 'Açıklama',
			),
		);
		$btn     = function ( $n, $label ) {
			return array(
				'btn' . $n . '_text' => array(
					'type'  => 'text',
					'label' => $label . ' metni',
					'group' => 'Butonlar',
				),
				'btn' . $n . '_url'  => array(
					'type'  => 'url',
					'label' => $label . ' bağlantısı',
					'group' => 'Butonlar',
				),
			);
		};

		$defs = array(
			'hero'          => array(
				'title'       => 'Ana sayfa girişi (Hero)',
				'icon'        => 'star-filled',
				'description' => 'Kalın başlık, yüzen kartlar (ekip fotoğrafı / proje), kanıt etiketleri ve hizmet kısayollarıyla açılış ekranı.',
				'fields'      => array_merge(
					$heading,
					array(
						'words'         => array(
							'type'  => 'textarea',
							'label' => 'Dönen kelimeler',
							'help'  => 'Her satıra bir ifade. Başlıktaki {kelime} yer tutucusunun yerine sırayla gelir.',
						),
						'visual'        => array(
							'type'    => 'select',
							'label'   => 'Arka plan görseli',
							'options' => $opts(
								array(
									'cards' => 'Yüzen kartlar (ekip / proje)',
									'gl'    => 'Saten ışık plakası (WebGL)',
									'image' => 'Görsel',
									'none'  => 'Sade',
								)
							),
							'default' => 'cards',
							'group'   => 'Görsel',
						),
						'chips'         => array(
							'type'  => 'textarea',
							'label' => 'Kanıt etiketleri',
							'help'  => 'Her satıra bir kısa ifade (örn. Ücretsiz ön görüşme). Yalnızca doğru bilgiler yazın.',
						),
						'cards'         => array(
							'type'   => 'repeater',
							'label'  => 'Yüzen kartlar',
							'group'  => 'Görsel',
							'fields' => array(
								'image' => array(
									'type'  => 'image',
									'label' => 'Fotoğraf / görsel',
								),
								'title' => array(
									'type'  => 'text',
									'label' => 'Başlık (örn. kişi adı)',
								),
								'text'  => array(
									'type'  => 'text',
									'label' => 'Alt yazı (örn. unvan)',
								),
								'url'   => array(
									'type'  => 'url',
									'label' => 'Bağlantı (isteğe bağlı)',
								),
							),
						),
						'image'         => array(
							'type'  => 'image',
							'label' => 'Görsel (görsel modu ve WebGL yedeği)',
							'group' => 'Görsel',
						),
						'show_services' => array(
							'type'    => 'toggle',
							'label'   => 'Hizmet kategorisi kısayollarını göster',
							'default' => true,
						),
					),
					$btn( 1, 'Birincil buton' ),
					$btn( 2, 'İkincil buton' )
				),
			),
			'page-hero'     => array(
				'title'       => 'Sayfa girişi',
				'icon'        => 'cover-image',
				'description' => 'İç sayfalar için büyük başlık alanı.',
				'fields'      => array_merge(
					$heading,
					array(
						'image' => array(
							'type'  => 'image',
							'label' => 'Görsel (isteğe bağlı)',
							'group' => 'Görsel',
						),
					),
					$btn( 1, 'Birincil buton' ),
					$btn( 2, 'İkincil buton' )
				),
			),
			'marquee'       => array(
				'title'       => 'Kayan yazı bandı',
				'icon'        => 'leftright',
				'description' => 'Yatay kayan, büyük tipografili kelime bandı. Hareket azaltıldığında sabit durur.',
				'fields'      => array(
					'items' => array(
						'type'  => 'textarea',
						'label' => 'İfadeler',
						'help'  => 'Her satıra bir ifade.',
					),
				),
			),
			'services'      => array(
				'title'       => 'Hizmet gezgini',
				'icon'        => 'lightbulb',
				'description' => 'Hizmetler menüsündeki kategori ve alt hizmetleri otomatik listeler.',
				'fields'      => array_merge(
					$heading,
					array(
						'layout' => array(
							'type'    => 'select',
							'label'   => 'Yerleşim',
							'options' => $opts(
								array(
									'showcase' => 'Renkli vitrin (animasyonlu)',
									'explorer' => 'Gezgin (kategori sekmeleri)',
									'grid'     => 'Tüm hizmetler (ızgara)',
								)
							),
							'default' => 'showcase',
						),
					),
					$btn( 1, 'Buton' )
				),
			),
			'projects'      => array(
				'title'       => 'Proje vitrini',
				'icon'        => 'portfolio',
				'description' => 'Projeleri vitrin veya filtrelenebilir portföy olarak gösterir.',
				'fields'      => array_merge(
					$heading,
					array(
						'layout'       => array(
							'type'    => 'select',
							'label'   => 'Yerleşim',
							'options' => $opts(
								array(
									'showcase' => 'Vitrin (büyük kartlar)',
									'grid'     => 'Portföy ızgarası',
								)
							),
							'default' => 'showcase',
						),
						'show_filters' => array(
							'type'    => 'toggle',
							'label'   => 'Kategori ve hizmet filtrelerini göster',
							'default' => false,
						),
						'count'        => array(
							'type'    => 'number',
							'label'   => 'Gösterilecek proje sayısı',
							'default' => 4,
						),
						'category'     => array(
							'type'    => 'select',
							'label'   => 'Yalnızca bu kategori',
							'options' => $proj_cats,
							'default' => '',
						),
					),
					$btn( 1, 'Buton' )
				),
			),
			'references'    => array(
				'title'       => 'Referans logoları',
				'icon'        => 'awards',
				'description' => 'Referanslar menüsünden eklenen logolar. Kayıt yoksa ziyaretçilere hiç gösterilmez.',
				'fields'      => array_merge(
					$heading,
					array(
						'layout' => array(
							'type'    => 'select',
							'label'   => 'Yerleşim',
							'options' => $opts(
								array(
									'marquee' => 'Kayan şerit',
									'grid'    => 'Izgara',
								)
							),
							'default' => 'grid',
						),
					)
				),
			),
			'process'       => array(
				'title'       => 'Süreç adımları',
				'icon'        => 'editor-ol',
				'description' => 'Kaydırdıkça ilerleyen numaralı süreç anlatımı.',
				'fields'      => array_merge(
					$heading,
					array(
						'steps' => array(
							'type'   => 'repeater',
							'label'  => 'Adımlar',
							'fields' => array(
								'title' => array(
									'type'  => 'text',
									'label' => 'Adım başlığı',
								),
								'text'  => array(
									'type'  => 'textarea',
									'label' => 'Açıklama',
								),
							),
						),
					)
				),
			),
			'features'      => array(
				'title'       => 'Özellik / kapsam listesi',
				'icon'        => 'screenoptions',
				'description' => 'Kartlar, liste veya numaralı maddelerle içerik grubu.',
				'fields'      => array_merge(
					$heading,
					array(
						'style' => array(
							'type'    => 'select',
							'label'   => 'Görünüm',
							'options' => $opts(
								array(
									'cards'    => 'Kartlar',
									'list'     => 'Liste (iki sütun)',
									'numbered' => 'Numaralı',
								)
							),
							'default' => 'cards',
						),
						'items' => array(
							'type'   => 'repeater',
							'label'  => 'Maddeler',
							'fields' => array(
								'icon'  => array(
									'type'    => 'select',
									'label'   => 'İkon',
									'options' => array_merge(
										array(
											array(
												'value' => '',
												'label' => 'İkonsuz',
											),
										),
										$icon_opts
									),
								),
								'title' => array(
									'type'  => 'text',
									'label' => 'Başlık',
								),
								'text'  => array(
									'type'  => 'textarea',
									'label' => 'Açıklama',
								),
								'url'   => array(
									'type'  => 'url',
									'label' => 'Bağlantı (isteğe bağlı)',
								),
							),
						),
					)
				),
			),
			'checklist'     => array(
				'title'       => 'Kontrol listesi',
				'icon'        => 'yes-alt',
				'description' => 'Teslim edilenler gibi kısa maddeler.',
				'fields'      => array_merge(
					$heading,
					array(
						'items' => array(
							'type'  => 'textarea',
							'label' => 'Maddeler',
							'help'  => 'Her satıra bir madde.',
						),
					)
				),
			),
			'faq'           => array(
				'title'       => 'Sık sorulan sorular',
				'icon'        => 'editor-help',
				'description' => 'Açılır-kapanır soru/cevap listesi (FAQPage yapılandırılmış verisiyle).',
				'fields'      => array_merge(
					$heading,
					array(
						'items' => array(
							'type'   => 'repeater',
							'label'  => 'Sorular',
							'fields' => array(
								'q' => array(
									'type'  => 'text',
									'label' => 'Soru',
								),
								'a' => array(
									'type'  => 'textarea',
									'label' => 'Cevap',
								),
							),
						),
					)
				),
			),
			'cta'           => array(
				'title'       => 'Çağrı bandı (CTA)',
				'icon'        => 'megaphone',
				'description' => 'Teklif ve iletişime yönlendiren kapanış bandı.',
				'fields'      => array_merge(
					$heading,
					array(
						'show_contact' => array(
							'type'    => 'toggle',
							'label'   => 'Telefon ve WhatsApp bağlantılarını göster',
							'default' => true,
						),
					),
					$btn( 1, 'Birincil buton' ),
					$btn( 2, 'İkincil buton' )
				),
			),
			'statement'     => array(
				'title'       => 'Manifesto metni',
				'icon'        => 'format-quote',
				'description' => 'Kaydırdıkça kelime kelime belirginleşen büyük ifade.',
				'fields'      => array(
					'eyebrow' => array(
						'type'  => 'text',
						'label' => 'Üst başlık',
					),
					'text'    => array(
						'type'  => 'textarea',
						'label' => 'Metin',
					),
					'caption' => array(
						'type'  => 'textarea',
						'label' => 'Alt not',
					),
				),
			),
			'split'         => array(
				'title'       => 'Görsel + metin',
				'icon'        => 'align-pull-left',
				'description' => 'Katmanlı görsel ve anlatım.',
				'fields'      => array_merge(
					$heading,
					array(
						'items'   => array(
							'type'  => 'textarea',
							'label' => 'Madde listesi (isteğe bağlı)',
							'help'  => 'Her satıra bir madde.',
						),
						'image'   => array(
							'type'  => 'image',
							'label' => 'Görsel',
							'group' => 'Görsel',
						),
						'reverse' => array(
							'type'    => 'toggle',
							'label'   => 'Görseli sola al',
							'default' => false,
							'group'   => 'Görsel',
						),
					),
					$btn( 1, 'Buton' )
				),
			),
			'posts'         => array(
				'title'       => 'Blog yazıları',
				'icon'        => 'admin-post',
				'description' => 'Son blog yazıları.',
				'fields'      => array_merge(
					$heading,
					array(
						'count'    => array(
							'type'    => 'number',
							'label'   => 'Yazı sayısı',
							'default' => 3,
						),
						'category' => array(
							'type'    => 'select',
							'label'   => 'Kategori',
							'options' => $post_cats,
							'default' => '',
						),
					),
					$btn( 1, 'Buton' )
				),
			),
			'stats'         => array(
				'title'       => 'Rakamlar',
				'icon'        => 'chart-bar',
				'description' => 'Yalnızca doğrulanmış rakamlar için. Madde yoksa hiç gösterilmez.',
				'fields'      => array_merge(
					$heading,
					array(
						'items' => array(
							'type'   => 'repeater',
							'label'  => 'Rakamlar',
							'fields' => array(
								'value' => array(
									'type'  => 'text',
									'label' => 'Değer (örn. 120+)',
								),
								'label' => array(
									'type'  => 'text',
									'label' => 'Açıklama',
								),
							),
						),
					)
				),
			),
			'contact'       => array(
				'title'       => 'İletişim bilgileri',
				'icon'        => 'location',
				'description' => 'Ayarlardaki iletişim bilgileri ve iletişim formu.',
				'fields'      => array_merge(
					$heading,
					array(
						'show_form' => array(
							'type'    => 'toggle',
							'label'   => 'İletişim formunu göster',
							'default' => true,
						),
					)
				),
			),
			'booking'       => array(
				'title'       => 'Görüşme günü şeridi',
				'icon'        => 'calendar-alt',
				'description' => 'Önümüzdeki iş günlerini gösterir; tıklanan gün teklif formuna "tercih edilen görüşme günü" olarak gelir.',
				'fields'      => array_merge(
					$heading,
					array(
						'days' => array(
							'type'    => 'number',
							'label'   => 'Gösterilecek iş günü sayısı',
							'default' => 10,
						),
						'note' => array(
							'type'  => 'text',
							'label' => 'Alt not',
						),
					)
				),
			),
			'testimonials'  => array(
				'title'       => 'Müşteri yorumları',
				'icon'        => 'format-quote',
				'description' => 'Kaydırdıkça üst üste binen yorum kartları. Yalnızca gerçek ve izinli yorumlar ekleyin; yorum yoksa bölüm görünmez.',
				'fields'      => array_merge(
					$heading,
					array(
						'items' => array(
							'type'   => 'repeater',
							'label'  => 'Yorumlar',
							'fields' => array(
								'quote' => array(
									'type'  => 'textarea',
									'label' => 'Yorum',
								),
								'name'  => array(
									'type'  => 'text',
									'label' => 'Ad soyad',
								),
								'role'  => array(
									'type'  => 'text',
									'label' => 'Unvan / firma',
								),
								'photo' => array(
									'type'  => 'image',
									'label' => 'Fotoğraf (isteğe bağlı)',
								),
							),
						),
					)
				),
			),
			'team'          => array(
				'title'       => 'Ekip',
				'icon'        => 'groups',
				'description' => 'Ekip fotoğrafları ve unvanları. Kişi eklenmezse bölüm görünmez.',
				'fields'      => array_merge(
					$heading,
					array(
						'items' => array(
							'type'   => 'repeater',
							'label'  => 'Ekip üyeleri',
							'fields' => array(
								'photo' => array(
									'type'  => 'image',
									'label' => 'Fotoğraf',
								),
								'name'  => array(
									'type'  => 'text',
									'label' => 'Ad soyad',
								),
								'role'  => array(
									'type'  => 'text',
									'label' => 'Unvan',
								),
							),
						),
					)
				),
			),
			'quote-form'    => array(
				'title'       => 'Teklif formu',
				'icon'        => 'feedback',
				'description' => 'Teklif talep formu. ?hizmet= parametresiyle gelen hizmet otomatik seçilir.',
				'fields'      => array_merge(
					$heading,
					array(
						'show_aside' => array(
							'type'    => 'toggle',
							'label'   => 'Yan bilgi panelini göster',
							'default' => true,
						),
					)
				),
			),
		);

		foreach ( $defs as $k => $d ) {
			$defs[ $k ]['fields'] = array_merge( $d['fields'], self::common() );
		}
		return $defs;
	}

	/**
	 * Attribute schema from fields.
	 *
	 * @param array $fields Fields.
	 * @return array
	 */
	private static function attributes( $fields ) {
		$attrs = array();
		foreach ( $fields as $key => $f ) {
			switch ( $f['type'] ) {
				case 'toggle':
					$attrs[ $key ] = array(
						'type'    => 'boolean',
						'default' => isset( $f['default'] ) ? (bool) $f['default'] : false,
					);
					break;
				case 'number':
				case 'image':
					$attrs[ $key ] = array(
						'type'    => 'number',
						'default' => isset( $f['default'] ) ? $f['default'] : 0,
					);
					break;
				case 'repeater':
					$attrs[ $key ] = array(
						'type'    => 'array',
						'default' => array(),
						'items'   => array( 'type' => 'object' ),
					);
					break;
				default:
					$attrs[ $key ] = array(
						'type'    => 'string',
						'default' => isset( $f['default'] ) ? $f['default'] : '',
					);
			}
		}
		$attrs['className'] = array(
			'type'    => 'string',
			'default' => '',
		);
		return $attrs;
	}

	/**
	 * Register blocks.
	 */
	public static function register() {
		wp_register_script(
			'akilli-blocks-editor',
			AKILLI_CORE_URL . 'assets/blocks-editor.js',
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-server-side-render', 'wp-data', 'wp-i18n' ),
			AKILLI_CORE_VERSION,
			true
		);
		foreach ( self::definitions() as $name => $def ) {
			register_block_type(
				'akilli/' . $name,
				array(
					'api_version'     => 3,
					'title'           => $def['title'],
					'description'     => $def['description'],
					'category'        => 'akilli',
					'icon'            => $def['icon'],
					'attributes'      => self::attributes( $def['fields'] ),
					'editor_script'   => 'akilli-blocks-editor',
					'supports'        => array(
						'html'     => false,
						'anchor'   => false,
						'align'    => false,
						'multiple' => true,
					),
					'render_callback' => function ( $attributes, $content, $block ) use ( $name ) {
						return Akilli_Blocks::render( $name, $attributes, $block );
					},
				)
			);
		}
	}

	/**
	 * Editor data.
	 */
	public static function editor_assets() {
		$defs = self::definitions( true );
		foreach ( $defs as $k => $d ) {
			$defs[ $k ]['attributes'] = self::attributes( $d['fields'] );
		}
		wp_localize_script( 'akilli-blocks-editor', 'akilliBlocks', array( 'blocks' => $defs ) );
	}

	/**
	 * Block category.
	 *
	 * @param array $cats Categories.
	 * @return array
	 */
	public static function category( $cats ) {
		array_unshift(
			$cats,
			array(
				'slug'  => 'akilli',
				'title' => 'Akıllı Creative',
				'icon'  => null,
			)
		);
		return $cats;
	}

	/**
	 * Is this a block-renderer (editor preview) request?
	 *
	 * @return bool
	 */
	public static function is_preview() {
		return defined( 'REST_REQUEST' ) && REST_REQUEST;
	}

	/**
	 * Render a block template.
	 *
	 * @param string   $name  Block name.
	 * @param array    $a     Attributes.
	 * @param WP_Block $block Block instance.
	 * @return string
	 */
	public static function render( $name, $a, $block = null ) {
		if ( ! empty( $a['hidden'] ) ) {
			return self::is_preview() ? '<div class="ak-editor-note">Bu bölüm gizli — ziyaretçilere gösterilmiyor. (Bölüm ayarları → "Bu bölümü sitede gizle")</div>' : '';
		}
		$a['_id'] = akilli_block_anchor( $a );
		$file     = akilli_locate_block_template( $name );
		if ( ! file_exists( $file ) ) {
			return '';
		}
		ob_start();
		include $file;
		$html = trim( ob_get_clean() );
		if ( '' === $html && self::is_preview() ) {
			return '<div class="ak-editor-note">' . esc_html( self::definitions()[ $name ]['title'] ) . ': gösterilecek içerik yok, bu yüzden ziyaretçilere görünmez.</div>';
		}
		return $html;
	}

	/**
	 * Register block patterns (page/section templates).
	 */
	public static function patterns() {
		if ( ! function_exists( 'register_block_pattern' ) ) {
			return;
		}
		register_block_pattern_category( 'akilli', array( 'label' => 'Akıllı Creative' ) );
		require_once AKILLI_CORE_DIR . 'demo/builder.php';
		$patterns = array(
			'hizmet-sayfasi' => array(
				'title'   => 'Hizmet sayfası iskeleti',
				'content' => akilli_demo_service_blocks(
					array(
						'intro'   => array( 'Hizmetin kime, hangi sorun için ve nasıl bir sonuç sunduğunu iki üç cümleyle anlatın.' ),
						'scope'   => array( array( 'Kapsam maddesi', 'Bu maddede ne yapıldığını açıklayın.' ) ),
						'for'     => array( array( 'Hedef kitle', 'Bu hizmet kimler için uygun?' ) ),
						'needs'   => array( array( 'Çözülen ihtiyaç', 'Müşterinin yaşadığı sorun ve çözümünüz.' ) ),
						'deliver' => array( 'Teslim edilen iş 1', 'Teslim edilen iş 2' ),
						'process' => array( array( 'Keşif', 'İlk görüşme ve ihtiyaç analizi.' ), array( 'Uygulama', 'Tasarım ve geliştirme.' ), array( 'Teslim', 'Eğitim ve yayın.' ) ),
						'faq'     => array( array( 'Soru?', 'Cevap.' ) ),
					)
				),
			),
			'kapanis-cta'    => array(
				'title'   => 'Kapanış çağrı bandı',
				'content' => akilli_demo_block(
					'cta',
					array(
						'eyebrow'   => 'Bir sonraki adım',
						'title'     => 'Projenizi <em>birlikte</em> planlayalım.',
						'text'      => 'İhtiyacınızı dinleyelim, size uygun kapsamı ve yol haritasını netleştirelim.',
						'btn1_text' => 'Teklif al',
						'btn1_url'  => '/teklif-al/',
						'btn2_text' => 'Çalışmalarımız',
						'btn2_url'  => '/calismalarimiz/',
					)
				),
			),
			'proje-vitrini'  => array(
				'title'   => 'Proje vitrini',
				'content' => akilli_demo_block(
					'projects',
					array(
						'eyebrow' => 'Çalışmalar',
						'title'   => 'Seçili <em>işler</em>',
						'count'   => 4,
					)
				),
			),
		);
		foreach ( $patterns as $slug => $p ) {
			register_block_pattern(
				'akilli/' . $slug,
				array(
					'title'      => $p['title'],
					'categories' => array( 'akilli' ),
					'content'    => $p['content'],
				)
			);
		}
	}
}

/**
 * Stable anchor for a block (manual anchor or slug of the title).
 *
 * @param array $a Attributes.
 * @return string
 */
if ( ! function_exists( 'akilli_block_anchor' ) ) :
function akilli_block_anchor( $a ) {
	if ( ! empty( $a['anchor'] ) ) {
		return sanitize_title( $a['anchor'] );
	}
	if ( ! empty( $a['title'] ) ) {
		return sanitize_title( wp_strip_all_tags( $a['title'] ) );
	}
	return '';
}
endif;

/**
 * Section heading markup shared by blocks.
 *
 * @param array  $a     Attributes.
 * @param string $tag   Heading tag.
 * @param string $class Extra class.
 */
if ( ! function_exists( 'akilli_section_head' ) ) :
function akilli_section_head( $a, $tag = 'h2', $class = '' ) {
	if ( empty( $a['eyebrow'] ) && empty( $a['title'] ) && empty( $a['text'] ) ) {
		return;
	}
	echo '<header class="ak-head ' . esc_attr( $class ) . '">';
	if ( ! empty( $a['eyebrow'] ) ) {
		echo '<p class="ak-eyebrow" data-reveal>' . esc_html( $a['eyebrow'] ) . '</p>';
	}
	if ( ! empty( $a['title'] ) ) {
		echo '<' . tag_escape( $tag ) . ' class="ak-title" data-reveal="lines">';
		akilli_inline( $a['title'] );
		echo '</' . tag_escape( $tag ) . '>';
	}
	if ( ! empty( $a['text'] ) ) {
		echo '<p class="ak-lead" data-reveal>';
		akilli_inline( $a['text'] );
		echo '</p>';
	}
	echo '</header>';
}
endif;

/**
 * Button markup.
 *
 * @param string $text  Label.
 * @param string $url   URL.
 * @param string $style primary|ghost|link.
 * @param string $icon  Icon.
 * @return string
 */
if ( ! function_exists( 'akilli_button' ) ) :
function akilli_button( $text, $url, $style = 'primary', $icon = 'arrow-right' ) {
	if ( ! $text || ! $url ) {
		return '';
	}
	if ( 0 === strpos( $url, '/' ) && 0 !== strpos( $url, '//' ) ) {
		$url = home_url( $url );
	}
	$external = 0 === strpos( $url, 'http' ) && false === strpos( $url, wp_parse_url( home_url(), PHP_URL_HOST ) );
	return '<a class="ak-btn ak-btn--' . esc_attr( $style ) . '" href="' . esc_url( $url ) . '"' . ( $external ? ' target="_blank" rel="noopener"' : '' ) . '><span class="ak-btn__label">' . esc_html( $text ) . '</span>' . akilli_icon( $icon ) . '</a>';
}
endif;

/**
 * Resolve a stored relative URL.
 *
 * @param string $url URL.
 * @return string
 */
if ( ! function_exists( 'akilli_url' ) ) :
function akilli_url( $url ) {
	if ( $url && 0 === strpos( $url, '/' ) && 0 !== strpos( $url, '//' ) ) {
		return home_url( $url );
	}
	return $url;
}
endif;
