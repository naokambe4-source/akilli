<?php
/**
 * Customizer: brand, typography, header/footer, immersive effects.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;

/**
 * Defaults.
 *
 * @return array
 */
function akilli_theme_defaults() {
	return array(
		'akilli_color_primary' => '#f04e00',
		'akilli_color_accent'  => '#ff6b1a',
		'akilli_color_ink'     => '#0d0d0d',
		'akilli_color_paper'   => '#ffffff',
		'akilli_color_tint'    => '#fff1e8',
		'akilli_font_display'  => 'poppins',
		'akilli_font_body'     => 'poppins',
		'akilli_font_scale'    => '100',
		'akilli_header_cta'    => 'Ücretsiz görüşme',
		'akilli_header_cta_url' => '/teklif-al/',
		'akilli_header_phone'  => true,
		'akilli_footer_title'  => 'Projenizi konuşalım, <em>ilk adımları birlikte belirleyelim.</em>',
		'akilli_footer_text'   => 'Antalya merkezli dijital ajans. Web siteleri, e-ticaret altyapıları, marka kimlikleri ve dijital büyüme çalışmalarını; hızlı, ölçülebilir ve markanıza özel üretiyoruz.',
		'akilli_copyright'     => '© {yil} Akıllı Creative. Tüm hakları saklıdır.',
		'akilli_mobile_bar'    => true,
		'akilli_motion'        => 'full',
		'akilli_gl'            => true,
		'akilli_gl_mobile'     => false,
		'akilli_cursor'        => true,
		'akilli_transitions'   => true,
		'akilli_motion_toggle' => true,
		'akilli_reading_time'  => true,
		'akilli_author_box'    => true,
		'akilli_cookie'        => true,
		'akilli_cookie_text'   => 'Bu site reklam veya izleme çerezi kullanmaz; yalnızca gerekli tercihleri tarayıcınızda saklar.',
		'akilli_og_image'      => 0,
	);
}

/**
 * Theme mod with default.
 *
 * @param string $key Key.
 * @return mixed
 */
function akilli_mod( $key ) {
	$d = akilli_theme_defaults();
	return get_theme_mod( $key, isset( $d[ $key ] ) ? $d[ $key ] : '' );
}

/**
 * Font choices.
 *
 * @return array
 */
function akilli_font_choices() {
	return array(
		'display' => array(
			'poppins'    => array( 'Poppins (kurumsal ajans — önerilen)', '"Poppins", system-ui, sans-serif' ),
			'intertight' => array( 'Inter Tight (kalın, sıkı)', '"Inter Tight", "Plus Jakarta Sans", system-ui, sans-serif' ),
			'jakarta'    => array( 'Plus Jakarta Sans (yuvarlak hatlı)', '"Plus Jakarta Sans", system-ui, sans-serif' ),
			'jost'       => array( 'Jost (geometrik)', '"Jost", system-ui, sans-serif' ),
			'system'     => array( 'Sistem yazı tipi (en hızlı)', 'system-ui, -apple-system, "Segoe UI", Roboto, sans-serif' ),
		),
		'body'    => array(
			'poppins' => array( 'Poppins (önerilen)', '"Poppins", system-ui, -apple-system, "Segoe UI", sans-serif' ),
			'jakarta' => array( 'Plus Jakarta Sans', '"Plus Jakarta Sans", system-ui, -apple-system, "Segoe UI", sans-serif' ),
			'hanken'  => array( 'Hanken Grotesk', '"Hanken Grotesk", system-ui, -apple-system, "Segoe UI", sans-serif' ),
			'system'  => array( 'Sistem yazı tipi (en hızlı)', 'system-ui, -apple-system, "Segoe UI", Roboto, sans-serif' ),
		),
	);
}

add_action(
	'customize_register',
	function ( WP_Customize_Manager $wp ) {
		$d = akilli_theme_defaults();

		$wp->add_panel(
			'akilli',
			array(
				'title'       => 'Akıllı Creative tema ayarları',
				'priority'    => 25,
				'description' => 'Logo ve favicon için "Site Kimliği" bölümünü kullanın. İletişim bilgileri ve form ayarları yönetim panelindeki Akıllı Creative → Ayarlar ekranındadır.',
			)
		);

		$bool = function ( $v ) {
			return (bool) $v;
		};
		$add  = function ( $id, $section, $label, $type, $args = array() ) use ( $wp, $d, $bool ) {
			$sanitize = 'sanitize_text_field';
			if ( 'color' === $type ) {
				$sanitize = 'sanitize_hex_color';
			} elseif ( 'checkbox' === $type ) {
				$sanitize = $bool;
			} elseif ( 'textarea' === $type ) {
				$sanitize = function ( $v ) {
					return wp_kses( $v, array( 'em' => array(), 'strong' => array(), 'br' => array() ) );
				};
			} elseif ( 'select' === $type || 'radio' === $type ) {
				$choices  = $args['choices'];
				$sanitize = function ( $v ) use ( $choices, $id, $d ) {
					return array_key_exists( $v, $choices ) ? $v : $d[ $id ];
				};
			} elseif ( 'url' === $type ) {
				$sanitize = 'esc_url_raw';
			}
			$wp->add_setting(
				$id,
				array(
					'default'           => $d[ $id ],
					'sanitize_callback' => $sanitize,
					'transport'         => 'refresh',
				)
			);
			if ( 'color' === $type ) {
				$wp->add_control( new WP_Customize_Color_Control( $wp, $id, array_merge( array( 'label' => $label, 'section' => $section ), $args ) ) );
			} else {
				$wp->add_control( $id, array_merge( array( 'label' => $label, 'section' => $section, 'type' => $type ), $args ) );
			}
		};

		// Colours.
		$wp->add_section( 'akilli_colors', array( 'title' => 'Renkler', 'panel' => 'akilli', 'description' => 'Açık tema için tasarlanmış marka renkleri. Buton ve renkli blok metinleri "Metin rengi" ile yazılır; bu yüzden ana renk canlı/açık, metin rengi koyu kalmalıdır. Vurgu rengi metinde kullanıldığında okunurluk için otomatik olarak koyulaştırılır.' ) );
		$add( 'akilli_color_primary', 'akilli_colors', 'Ana renk (turuncu butonlar ve bloklar)', 'color' );
		$add( 'akilli_color_accent', 'akilli_colors', 'Vurgu rengi (vurgulu kelimeler, detaylar)', 'color' );
		$add( 'akilli_color_tint', 'akilli_colors', 'Yumuşak ton (açık renkli bloklar, rozetler)', 'color' );
		$add( 'akilli_color_ink', 'akilli_colors', 'Metin rengi (koyu lacivert önerilir)', 'color' );
		$add( 'akilli_color_paper', 'akilli_colors', 'Zemin rengi', 'color', array( 'description' => 'Açık bir ton seçin. Tema koyu zemine göre tasarlanmamıştır.' ) );

		// Typography.
		$fonts = akilli_font_choices();
		$wp->add_section( 'akilli_type', array( 'title' => 'Tipografi', 'panel' => 'akilli', 'description' => 'Yazı tipleri sitenin kendi sunucusundan yüklenir (Google Fonts bağlantısı yok).' ) );
		$add( 'akilli_font_display', 'akilli_type', 'Başlık yazı tipi', 'select', array( 'choices' => wp_list_pluck( $fonts['display'], 0 ) ) );
		$add( 'akilli_font_body', 'akilli_type', 'Metin yazı tipi', 'select', array( 'choices' => wp_list_pluck( $fonts['body'], 0 ) ) );
		$add(
			'akilli_font_scale',
			'akilli_type',
			'Yazı boyutu',
			'select',
			array(
				'choices' => array(
					'94'  => 'Küçük',
					'100' => 'Normal',
					'106' => 'Büyük',
				),
			)
		);

		// Header.
		$wp->add_section( 'akilli_header', array( 'title' => 'Header', 'panel' => 'akilli', 'description' => 'Menüyü Görünüm → Menüler ekranından düzenleyin. "Hizmetlerimiz" altındaki iki seviyeli öğeler otomatik olarak mega menüye dönüşür.' ) );
		$add( 'akilli_header_cta', 'akilli_header', 'Buton metni', 'text' );
		$add( 'akilli_header_cta_url', 'akilli_header', 'Buton bağlantısı', 'text', array( 'description' => 'Örn. /teklif-al/ veya tam adres.' ) );
		$add( 'akilli_header_phone', 'akilli_header', 'Telefon bağlantısını göster', 'checkbox' );

		// Footer.
		$wp->add_section( 'akilli_footer', array( 'title' => 'Footer', 'panel' => 'akilli' ) );
		$add( 'akilli_footer_title', 'akilli_footer', 'Büyük başlık', 'textarea', array( 'description' => '<em>vurgu</em> kullanılabilir.' ) );
		$add( 'akilli_footer_text', 'akilli_footer', 'Kısa tanıtım metni', 'textarea' );
		$add( 'akilli_copyright', 'akilli_footer', 'Telif metni', 'text', array( 'description' => '{yil} otomatik olarak bu yıla dönüşür.' ) );
		$add( 'akilli_mobile_bar', 'akilli_footer', 'Mobilde alt hızlı iletişim çubuğunu göster (Ara · WhatsApp · Teklif)', 'checkbox' );

		// Motion.
		$wp->add_section( 'akilli_motion', array( 'title' => 'Immersive efektler', 'panel' => 'akilli', 'description' => 'Ziyaretçinin cihazında "hareketi azalt" tercihi açıksa animasyonlar her durumda sadeleşir. Efektler kapalıyken de site eksiksiz çalışır.' ) );
		$add(
			'akilli_motion',
			'akilli_motion',
			'Efekt seviyesi',
			'radio',
			array(
				'choices' => array(
					'full' => 'Tam — kaydırma anlatımı, katmanlar, hareketli tipografi',
					'lite' => 'Hafif — yalnızca yumuşak geçişler',
					'off'  => 'Kapalı — animasyon yok',
				),
			)
		);
		$add( 'akilli_gl', 'akilli_motion', 'Giriş ekranında canlı ışık alanı (WebGL)', 'checkbox' );
		$add( 'akilli_gl_mobile', 'akilli_motion', 'Canlı ışık alanını telefonlarda da çalıştır', 'checkbox', array( 'description' => 'Kapalıyken telefonlarda hafif CSS alternatifi gösterilir (önerilir).' ) );
		$add( 'akilli_cursor', 'akilli_motion', 'Projelerde etkileşimli imleç etiketi (yalnızca fare ile)', 'checkbox' );
		$add( 'akilli_transitions', 'akilli_motion', 'Sayfalar arası yumuşak geçiş (View Transitions)', 'checkbox' );
		$add( 'akilli_motion_toggle', 'akilli_motion', 'Footer’da ziyaretçiye "Hareketi azalt" düğmesi göster', 'checkbox' );

		// Blog.
		$wp->add_section( 'akilli_blog', array( 'title' => 'Blog', 'panel' => 'akilli' ) );
		$add( 'akilli_reading_time', 'akilli_blog', 'Okuma süresini göster', 'checkbox' );
		$add( 'akilli_author_box', 'akilli_blog', 'Yazı sonunda yazar kutusunu göster', 'checkbox' );

		// Cookie notice + sharing.
		$wp->add_section( 'akilli_privacy', array( 'title' => 'Çerez bildirimi ve paylaşım', 'panel' => 'akilli' ) );
		$add( 'akilli_cookie', 'akilli_privacy', 'Çerez bilgilendirme şeridini göster', 'checkbox' );
		$add( 'akilli_cookie_text', 'akilli_privacy', 'Bilgilendirme metni', 'textarea', array( 'description' => 'Analiz veya reklam aracı eklerseniz metni ve Çerez Politikası sayfasını güncelleyin.' ) );
		$wp->add_setting(
			'akilli_og_image',
			array(
				'default'           => 0,
				'sanitize_callback' => 'absint',
			)
		);
		$wp->add_control(
			new WP_Customize_Media_Control(
				$wp,
				'akilli_og_image',
				array(
					'label'       => 'Varsayılan paylaşım görseli',
					'description' => 'Sosyal medyada paylaşılan ve kapak görseli olmayan sayfalarda kullanılır (1200×630 önerilir). SEO eklentisi etkinse onun ayarı geçerlidir.',
					'section'     => 'akilli_privacy',
					'mime_type'   => 'image',
				)
			)
		);
	}
);

/**
 * Motion level for the current request.
 *
 * @return string full|lite|off
 */
function akilli_motion_level() {
	$m = akilli_mod( 'akilli_motion' );
	return in_array( $m, array( 'full', 'lite', 'off' ), true ) ? $m : 'full';
}

/**
 * CSS custom properties from Customizer.
 *
 * @return string
 */
function akilli_custom_css() {
	$fonts   = akilli_font_choices();
	$display = akilli_mod( 'akilli_font_display' );
	$body    = akilli_mod( 'akilli_font_body' );
	$vars    = array(
		'--ak-primary'  => sanitize_hex_color( akilli_mod( 'akilli_color_primary' ) ),
		'--ak-accent'   => sanitize_hex_color( akilli_mod( 'akilli_color_accent' ) ),
		'--ak-ink'      => sanitize_hex_color( akilli_mod( 'akilli_color_ink' ) ),
		'--ak-paper'    => sanitize_hex_color( akilli_mod( 'akilli_color_paper' ) ),
		'--ak-tint'     => sanitize_hex_color( akilli_mod( 'akilli_color_tint' ) ),
		'--ak-f-display' => isset( $fonts['display'][ $display ] ) ? $fonts['display'][ $display ][1] : $fonts['display']['poppins'][1],
		'--ak-f-body'   => isset( $fonts['body'][ $body ] ) ? $fonts['body'][ $body ][1] : $fonts['body']['poppins'][1],
		'--ak-scale'    => ( (int) akilli_mod( 'akilli_font_scale' ) / 100 ),
	);
	$css = ':root{';
	foreach ( $vars as $k => $v ) {
		if ( '' !== (string) $v ) {
			$css .= $k . ':' . $v . ';';
		}
	}
	return $css . '}';
}
