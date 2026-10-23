<?php
/**
 * Settings screen: contact data, forms, notifications.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * "Akıllı Creative → Ayarlar" screen built on the Settings API.
 */
class Akilli_Settings {

	const OPTION = 'akilli_core_settings';

	/**
	 * Hooks.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ), 9 );
		add_action( 'admin_init', array( __CLASS__, 'register' ) );
	}

	/**
	 * Field schema grouped by tab.
	 *
	 * @return array
	 */
	public static function schema() {
		return array(
			'iletisim' => array(
				'label'  => 'İletişim bilgileri',
				'intro'  => 'Bu bilgiler header, footer, iletişim sayfası, WhatsApp/telefon düğmeleri ve yapılandırılmış verilerde kullanılır.',
				'fields' => array(
					'company_name'   => array( 'Firma adı', 'text' ),
					'email'          => array( 'E-posta', 'email' ),
					'phone'          => array( 'Telefon', 'text', 'Örn. +90 530 611 82 80 — tıklanabilir arama bağlantısı otomatik oluşturulur.' ),
					'whatsapp'       => array( 'WhatsApp numarası', 'text', 'Ülke koduyla yazın. Boş bırakılırsa WhatsApp düğmeleri gizlenir.' ),
					'whatsapp_text'  => array( 'WhatsApp hazır mesajı', 'textarea' ),
					'address'        => array( 'Açık adres (tek satır)', 'text' ),
					'address_street' => array( 'Adres: sokak / bina', 'text', 'Yapılandırılmış veri için.' ),
					'address_region' => array( 'Adres: ilçe', 'text' ),
					'address_city'   => array( 'Adres: il', 'text' ),
					'address_postal' => array( 'Posta kodu', 'text' ),
					'map_url'        => array( 'Harita bağlantısı', 'url', 'Google Haritalar paylaşım bağlantısı. Harita yalnızca tıklanınca açılır (çerez/izleme yok).' ),
					'working_hours'  => array( 'Çalışma saatleri', 'text' ),
					'instagram'      => array( 'Instagram', 'url' ),
					'linkedin'       => array( 'LinkedIn', 'url' ),
					'facebook'       => array( 'Facebook', 'url' ),
					'youtube'        => array( 'YouTube', 'url' ),
					'x'              => array( 'X (Twitter)', 'url' ),
				),
			),
			'formlar'  => array(
				'label'  => 'Teklif ve iletişim formları',
				'intro'  => 'Formdaki zorunlu alanları, metinleri ve bütçe seçeneklerini buradan yönetin. Ad soyad, e-posta, hizmet ve proje açıklaması her zaman zorunludur.',
				'fields' => array(
					'q_req_company' => array( 'Firma alanı zorunlu', 'checkbox' ),
					'q_req_phone'   => array( 'Telefon alanı zorunlu', 'checkbox' ),
					'q_show_budget' => array( 'Bütçe aralığı alanını göster', 'checkbox' ),
					'q_req_budget'  => array( 'Bütçe aralığı zorunlu', 'checkbox' ),
					'q_budgets'     => array( 'Bütçe seçenekleri', 'textarea', 'Her satıra bir seçenek.' ),
					'q_intro'       => array( 'Teklif formu bilgilendirme metni', 'textarea' ),
					'q_success'     => array( 'Teklif formu başarı mesajı', 'textarea' ),
					'c_success'     => array( 'İletişim formu başarı mesajı', 'textarea' ),
					'consent_text'  => array( 'Onay kutusu metni', 'textarea', '{kvkk} ifadesi aşağıda seçtiğiniz aydınlatma metni sayfasının bağlantısına dönüşür.' ),
					'privacy_page'  => array( 'KVKK aydınlatma metni sayfası', 'page' ),
					'min_seconds'   => array( 'Spam koruması: en az doldurma süresi (sn)', 'number', 'Bu süreden hızlı gönderilen formlar bot kabul edilir.' ),
					'rate_limit'    => array( 'Spam koruması: 10 dakikada en fazla gönderim', 'number', 'Aynı IP adresinden.' ),
				),
			),
			'ai'       => array(
				'label'  => 'Yapay zekâ (AEO / GEO)',
				'intro'  => 'ChatGPT, Gemini, Claude, Perplexity gibi yapay zekâ asistanları ve yanıt motorlarının sitenizi doğru anlaması için ayarlar. /llms.txt dosyası hizmetlerinizden, sayfalarınızdan ve yazılarınızdan otomatik oluşturulur. Hiçbir ayar yapay zekâ yanıtlarında yer almayı garanti etmez; yalnızca içeriğinizi okunabilir ve tutarlı kılar.',
				'fields' => array(
					'llms_enabled'      => array( '/llms.txt ve /llms-full.txt dosyalarını oluştur', 'checkbox', 'Sunucunuzda aynı adla gerçek bir dosya varsa o dosya öncelikli olur.' ),
					'llms_summary'      => array( 'Firma özeti (yapay zekâ için)', 'textarea', 'Kim olduğunuzu, nerede ve kimlere hizmet verdiğinizi 2–3 net cümleyle anlatın. llms.txt dosyasının başında yer alır.' ),
					'llms_facts'        => array( 'Doğrulanmış kısa bilgiler', 'textarea', 'Her satıra bir bilgi (örn. "Kuruluş yılı: 2019"). Yalnızca doğru ve güncel bilgiler yazın; boş bırakabilirsiniz.' ),
					'ai_block_training' => array( 'Model eğitimi için içerik toplayan botları engelle', 'checkbox', 'GPTBot, Google-Extended, CCBot, ClaudeBot, Applebot-Extended, meta-externalagent ve Bytespider için robots.txt kuralı ekler. Arama/yanıt botları (OAI-SearchBot, ChatGPT-User, PerplexityBot, Claude-SearchBot) engellenmez.' ),
				),
			),
			'bildirim' => array(
				'label'  => 'Bildirimler',
				'intro'  => 'Yeni talep geldiğinde e-posta bildirimi gönderilir. E-posta gönderilemese bile talep "Talepler" ekranında saklanır ve durumu gösterilir. Güvenilir gönderim için bir SMTP eklentisi (ör. WP Mail SMTP) kullanmanızı öneririz.',
				'fields' => array(
					'notify_emails' => array( 'Bildirim adresleri', 'text', 'Virgülle ayırın. Boşsa iletişim e-postası, o da boşsa site yöneticisi e-postası kullanılır.' ),
					'mail_subject'  => array( 'E-posta konusu', 'text', '{tur} (Teklif talebi / İletişim mesajı), {ad} ve {hizmet} kullanılabilir.' ),
				),
			),
		);
	}

	/**
	 * Menus.
	 */
	public static function menu() {
		add_menu_page( 'Akıllı Creative', 'Akıllı Creative', 'manage_options', 'akilli-creative', array( __CLASS__, 'render' ), 'dashicons-star-filled', 3 );
		add_submenu_page( 'akilli-creative', 'Ayarlar', 'Ayarlar', 'manage_options', 'akilli-creative', array( __CLASS__, 'render' ) );
	}

	/**
	 * Register setting.
	 */
	public static function register() {
		register_setting(
			'akilli_core',
			self::OPTION,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( __CLASS__, 'sanitize' ),
				'default'           => array(),
			)
		);
	}

	/**
	 * Sanitize the full option. Fields of other tabs are kept as-is.
	 *
	 * @param array $input Raw input.
	 * @return array
	 */
	public static function sanitize( $input ) {
		$current = wp_parse_args( (array) get_option( self::OPTION, array() ), akilli_settings_defaults() );
		$input   = (array) $input;
		$tab     = isset( $input['_tab'] ) ? sanitize_key( $input['_tab'] ) : '';
		$schema  = self::schema();
		if ( ! isset( $schema[ $tab ] ) ) {
			return $current;
		}
		foreach ( $schema[ $tab ]['fields'] as $key => $def ) {
			$raw = isset( $input[ $key ] ) ? $input[ $key ] : '';
			switch ( $def[1] ) {
				case 'email':
					$current[ $key ] = sanitize_email( $raw );
					break;
				case 'url':
					$current[ $key ] = esc_url_raw( $raw );
					break;
				case 'textarea':
					$current[ $key ] = sanitize_textarea_field( $raw );
					break;
				case 'checkbox':
					$current[ $key ] = empty( $raw ) ? 0 : 1;
					break;
				case 'number':
				case 'page':
					$current[ $key ] = absint( $raw );
					break;
				default:
					$current[ $key ] = sanitize_text_field( $raw );
			}
		}
		if ( 'bildirim' === $tab ) {
			$emails                   = array_filter( array_map( 'sanitize_email', array_map( 'trim', explode( ',', $current['notify_emails'] ) ) ) );
			$current['notify_emails'] = implode( ', ', $emails );
		}
		return $current;
	}

	/**
	 * Render screen.
	 */
	public static function render() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$schema = self::schema();
		$tab    = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'iletisim'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! isset( $schema[ $tab ] ) ) {
			$tab = 'iletisim';
		}
		$values = wp_parse_args( (array) get_option( self::OPTION, array() ), akilli_settings_defaults() );
		echo '<div class="wrap ak-settings"><h1>Akıllı Creative ayarları</h1>';
		echo '<p>Görsel ayarlar (logo, renkler, yazı tipleri, header/footer, efektler) <a href="' . esc_url( admin_url( 'customize.php' ) ) . '">Görünüm → Özelleştir</a> ekranındadır.</p>';
		echo '<nav class="nav-tab-wrapper">';
		foreach ( $schema as $key => $group ) {
			echo '<a class="nav-tab' . ( $key === $tab ? ' nav-tab-active' : '' ) . '" href="' . esc_url( admin_url( 'admin.php?page=akilli-creative&tab=' . $key ) ) . '">' . esc_html( $group['label'] ) . '</a>';
		}
		echo '</nav>';
		settings_errors();
		echo '<form method="post" action="options.php">';
		settings_fields( 'akilli_core' );
		echo '<input type="hidden" name="' . esc_attr( self::OPTION ) . '[_tab]" value="' . esc_attr( $tab ) . '">';
		echo '<p>' . esc_html( $schema[ $tab ]['intro'] ) . '</p><table class="form-table" role="presentation">';
		foreach ( $schema[ $tab ]['fields'] as $key => $def ) {
			$id   = 'ak-' . $key;
			$name = self::OPTION . '[' . $key . ']';
			$val  = $values[ $key ];
			echo '<tr><th scope="row"><label for="' . esc_attr( $id ) . '">' . esc_html( $def[0] ) . '</label></th><td>';
			switch ( $def[1] ) {
				case 'textarea':
					echo '<textarea id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" rows="4">' . esc_textarea( $val ) . '</textarea>';
					break;
				case 'checkbox':
					echo '<input type="checkbox" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="1"' . checked( $val, 1, false ) . '>';
					break;
				case 'page':
					wp_dropdown_pages(
						array(
							'name'              => esc_attr( $name ),
							'id'                => esc_attr( $id ),
							'selected'          => (int) $val,
							'show_option_none'  => '— Seçin —',
							'option_none_value' => 0,
						)
					);
					break;
				default:
					echo '<input class="regular-text" type="' . esc_attr( 'number' === $def[1] ? 'number' : ( 'email' === $def[1] ? 'email' : ( 'url' === $def[1] ? 'url' : 'text' ) ) ) . '" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $val ) . '">';
			}
			if ( ! empty( $def[2] ) ) {
				echo '<p class="description">' . esc_html( $def[2] ) . '</p>';
			}
			echo '</td></tr>';
		}
		echo '</table>';
		submit_button( 'Değişiklikleri kaydet' );
		echo '</form></div>';
	}
}
