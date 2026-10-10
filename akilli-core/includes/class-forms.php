<?php
/**
 * Quote and contact forms: rendering, validation, storage, notification.
 *
 * Flow: validate → save lead (always first) → send e-mail → record mail status.
 * Works without JavaScript (admin-post + redirect) and progressively with fetch.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Forms.
 */
class Akilli_Forms {

	/**
	 * Hooks.
	 */
	public static function init() {
		add_action( 'admin_post_nopriv_akilli_form', array( __CLASS__, 'handle' ) );
		add_action( 'admin_post_akilli_form', array( __CLASS__, 'handle' ) );
		add_shortcode( 'akilli_teklif_formu', array( __CLASS__, 'shortcode_quote' ) );
		add_shortcode( 'akilli_iletisim_formu', array( __CLASS__, 'shortcode_contact' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'register_assets' ) );
	}

	/**
	 * Register front-end script (enqueued only when a form is rendered).
	 */
	public static function register_assets() {
		wp_register_script( 'akilli-forms', AKILLI_CORE_URL . 'assets/forms.js', array(), AKILLI_CORE_VERSION, array( 'in_footer' => true, 'strategy' => 'defer' ) );
	}

	/**
	 * Shortcode: quote form.
	 *
	 * @return string
	 */
	public static function shortcode_quote() {
		return self::render( 'teklif' );
	}

	/**
	 * Shortcode: contact form.
	 *
	 * @return string
	 */
	public static function shortcode_contact() {
		return self::render( 'iletisim' );
	}

	/**
	 * Services for the select box, grouped.
	 *
	 * @return array
	 */
	public static function service_options() {
		$groups = array();
		foreach ( akilli_get_service_tree() as $node ) {
			$parent = $node['post'];
			if ( get_post_meta( $parent->ID, '_ak_hide_in_form', true ) ) {
				continue;
			}
			$items = array( $parent->ID => get_the_title( $parent ) . ' (genel)' );
			foreach ( $node['children'] as $child ) {
				if ( ! get_post_meta( $child->ID, '_ak_hide_in_form', true ) ) {
					$items[ $child->ID ] = get_the_title( $child );
				}
			}
			$groups[ get_the_title( $parent ) ] = $items;
		}
		return $groups;
	}

	/**
	 * Resolve ?hizmet=slug|id to a service ID.
	 *
	 * @return int
	 */
	private static function preselected_service() {
		if ( empty( $_GET['hizmet'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return 0;
		}
		$raw = sanitize_title( wp_unslash( $_GET['hizmet'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ctype_digit( $raw ) ) {
			return 'ak_hizmet' === get_post_type( (int) $raw ) ? (int) $raw : 0;
		}
		$found = get_posts(
			array(
				'post_type'   => 'ak_hizmet',
				'name'        => $raw,
				'numberposts' => 1,
				'fields'      => 'ids',
			)
		);
		return $found ? (int) $found[0] : 0;
	}

	/**
	 * Signed timestamp used for the minimum-fill-time check.
	 *
	 * @return string
	 */
	private static function token() {
		$ts = (string) time();
		return $ts . '.' . hash_hmac( 'sha256', $ts, wp_salt( 'nonce' ) );
	}

	/**
	 * Fields definition per form type.
	 *
	 * @param string $type teklif|iletisim.
	 * @return array key => [label, required, kind, autocomplete]
	 */
	public static function fields( $type ) {
		if ( 'iletisim' === $type ) {
			return array(
				'ad'       => array( 'Ad soyad', true, 'text', 'name' ),
				'email'    => array( 'E-posta', true, 'email', 'email' ),
				'telefon'  => array( 'Telefon', false, 'tel', 'tel' ),
				'aciklama' => array( 'Mesajınız', true, 'textarea', 'off' ),
			);
		}
		return array(
			'ad'       => array( 'Ad soyad', true, 'text', 'name' ),
			'firma'    => array( 'Firma', (bool) akilli_get_setting( 'q_req_company' ), 'text', 'organization' ),
			'email'    => array( 'E-posta', true, 'email', 'email' ),
			'telefon'  => array( 'Telefon', (bool) akilli_get_setting( 'q_req_phone' ), 'tel', 'tel' ),
			'hizmet'   => array( 'İlgilendiğiniz hizmet', true, 'service', 'off' ),
			'butce'    => array( 'Bütçe aralığı', (bool) akilli_get_setting( 'q_req_budget' ), 'budget', 'off' ),
			'aciklama' => array( 'Proje açıklaması', true, 'textarea', 'off' ),
		);
	}

	/**
	 * Render a form.
	 *
	 * @param string $type teklif|iletisim.
	 * @param array  $args Options: id, title.
	 * @return string
	 */
	public static function render( $type, $args = array() ) {
		$type = 'iletisim' === $type ? 'iletisim' : 'teklif';
		wp_enqueue_script( 'akilli-forms' );
		$id      = ! empty( $args['id'] ) ? $args['id'] : ( 'teklif' === $type ? 'teklif-formu' : 'iletisim-formu' );
		$state   = self::state_from_request( $type );
		$values  = $state['values'];
		$errors  = $state['errors'];
		$fields  = self::fields( $type );
		$options = 'teklif' === $type ? self::service_options() : array();
		if ( ! isset( $values['hizmet'] ) ) {
			$values['hizmet'] = self::preselected_service();
		}
		$budgets = akilli_lines( akilli_get_setting( 'q_budgets' ) );

		ob_start();
		?>
		<form id="<?php echo esc_attr( $id ); ?>" class="ak-form ak-form--<?php echo esc_attr( $type ); ?>" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" data-ak-form>
			<div class="ak-form__status" role="status" aria-live="polite" tabindex="-1">
				<?php if ( $state['success'] ) : ?>
					<div class="ak-form__notice ak-form__notice--success"><?php echo akilli_icon( 'check' ); ?><p><?php echo esc_html( akilli_get_setting( 'teklif' === $type ? 'q_success' : 'c_success' ) ); ?></p></div>
				<?php elseif ( $errors ) : ?>
					<div class="ak-form__notice ak-form__notice--error"><p><?php echo esc_html( isset( $errors['_form'] ) ? $errors['_form'] : 'Lütfen işaretli alanları kontrol edin.' ); ?></p></div>
				<?php endif; ?>
			</div>
			<?php if ( 'teklif' === $type && akilli_get_setting( 'q_intro' ) ) : ?>
				<p class="ak-form__intro"><?php echo esc_html( akilli_get_setting( 'q_intro' ) ); ?></p>
			<?php endif; ?>
			<div class="ak-form__grid">
			<?php
			foreach ( $fields as $key => $def ) :
				list( $label, $required, $kind, $ac ) = $def;
				if ( 'budget' === $kind && ( ! akilli_get_setting( 'q_show_budget' ) || ! $budgets ) ) {
					continue;
				}
				$fid   = $id . '-' . $key;
				$err   = isset( $errors[ $key ] ) ? $errors[ $key ] : '';
				$val   = isset( $values[ $key ] ) ? $values[ $key ] : '';
				$wide  = in_array( $kind, array( 'textarea', 'service' ), true ) ? ' ak-field--wide' : '';
				$attrs = ( $required ? ' required aria-required="true"' : '' ) . ( $err ? ' aria-invalid="true"' : '' ) . ' aria-describedby="' . esc_attr( $fid . '-err' ) . '"';
				?>
				<div class="ak-field<?php echo esc_attr( $wide . ( $err ? ' has-error' : '' ) ); ?>" data-field="<?php echo esc_attr( $key ); ?>">
					<label for="<?php echo esc_attr( $fid ); ?>"><?php echo esc_html( $label ); ?><?php echo $required ? ' <span class="ak-req" aria-hidden="true">*</span>' : ' <span class="ak-opt">(isteğe bağlı)</span>'; ?></label>
					<?php if ( 'textarea' === $kind ) : ?>
						<textarea id="<?php echo esc_attr( $fid ); ?>" name="<?php echo esc_attr( $key ); ?>" rows="6" minlength="10" maxlength="5000"<?php echo $attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?> placeholder="<?php echo esc_attr( 'teklif' === $type ? 'Örn. Diş kliniğimiz için randevu talebi alabilen, hızlı ve mobil uyumlu bir web sitesi istiyoruz…' : '' ); ?>"><?php echo esc_textarea( $val ); ?></textarea>
					<?php elseif ( 'service' === $kind ) : ?>
						<select id="<?php echo esc_attr( $fid ); ?>" name="hizmet"<?php echo $attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<option value="">Bir hizmet seçin</option>
							<?php foreach ( $options as $group => $items ) : ?>
								<optgroup label="<?php echo esc_attr( $group ); ?>">
									<?php foreach ( $items as $sid => $sname ) : ?>
										<option value="<?php echo esc_attr( $sid ); ?>"<?php selected( (int) $val, (int) $sid ); ?>><?php echo esc_html( $sname ); ?></option>
									<?php endforeach; ?>
								</optgroup>
							<?php endforeach; ?>
							<option value="diger"<?php selected( $val, 'diger' ); ?>>Emin değilim / birden fazla hizmet</option>
						</select>
					<?php elseif ( 'budget' === $kind ) : ?>
						<select id="<?php echo esc_attr( $fid ); ?>" name="butce"<?php echo $attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<option value="">Seçiniz</option>
							<?php foreach ( $budgets as $b ) : ?>
								<option value="<?php echo esc_attr( $b ); ?>"<?php selected( $val, $b ); ?>><?php echo esc_html( $b ); ?></option>
							<?php endforeach; ?>
						</select>
					<?php else : ?>
						<input id="<?php echo esc_attr( $fid ); ?>" type="<?php echo esc_attr( $kind ); ?>" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $val ); ?>" autocomplete="<?php echo esc_attr( $ac ); ?>" maxlength="<?php echo 'email' === $kind ? 190 : 120; ?>"<?php echo 'tel' === $kind ? ' inputmode="tel"' : ''; ?><?php echo $attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<?php endif; ?>
					<p class="ak-field__error" id="<?php echo esc_attr( $fid . '-err' ); ?>"><?php echo esc_html( $err ); ?></p>
				</div>
			<?php endforeach; ?>
			</div>

			<div class="ak-field ak-field--check<?php echo isset( $errors['onay'] ) ? ' has-error' : ''; ?>" data-field="onay">
				<label class="ak-check">
					<input type="checkbox" name="onay" value="1" required aria-required="true" aria-describedby="<?php echo esc_attr( $id ); ?>-onay-err"<?php checked( ! empty( $values['onay'] ) ); ?><?php echo isset( $errors['onay'] ) ? ' aria-invalid="true"' : ''; ?>>
					<span><?php echo wp_kses( self::consent_text(), array( 'a' => array( 'href' => true, 'target' => true, 'rel' => true ) ) ); ?></span>
				</label>
				<p class="ak-field__error" id="<?php echo esc_attr( $id ); ?>-onay-err"><?php echo isset( $errors['onay'] ) ? esc_html( $errors['onay'] ) : ''; ?></p>
			</div>

			<div class="ak-hp" aria-hidden="true">
				<label for="<?php echo esc_attr( $id ); ?>-web">Web sitesi (boş bırakın)</label>
				<input type="text" id="<?php echo esc_attr( $id ); ?>-web" name="ak_website" value="" tabindex="-1" autocomplete="off">
			</div>
			<input type="hidden" name="action" value="akilli_form">
			<input type="hidden" name="ak_type" value="<?php echo esc_attr( $type ); ?>">
			<input type="hidden" name="ak_ts" value="<?php echo esc_attr( self::token() ); ?>">
			<input type="hidden" name="ak_form_id" value="<?php echo esc_attr( $id ); ?>">
			<input type="hidden" name="ak_return" value="<?php echo esc_url( self::current_url() ); ?>">

			<div class="ak-form__actions">
				<button type="submit" class="ak-btn ak-btn--primary ak-btn--lg">
					<span class="ak-btn__label"><?php echo esc_html( 'teklif' === $type ? 'Teklif talebini gönder' : 'Mesajı gönder' ); ?></span>
					<?php echo akilli_icon( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</button>
				<p class="ak-form__alt">
					<?php
					$wa = akilli_whatsapp_url();
					if ( $wa ) {
						echo 'Hızlı yanıt için <a href="' . esc_url( $wa ) . '" target="_blank" rel="noopener">WhatsApp\'tan yazın</a>';
						$tel = akilli_phone_href();
						if ( $tel ) {
							echo ' ya da <a href="' . esc_url( $tel ) . '">' . esc_html( akilli_get_setting( 'phone' ) ) . '</a> numarasını arayın';
						}
						echo '.';
					}
					?>
				</p>
			</div>
		</form>
		<?php
		return ob_get_clean();
	}

	/**
	 * Consent label HTML.
	 *
	 * @return string
	 */
	private static function consent_text() {
		$page = (int) akilli_get_setting( 'privacy_page' );
		if ( ! $page ) {
			$page = (int) get_option( 'akilli_page_kvkk' );
		}
		$link = $page && 'publish' === get_post_status( $page )
			? '<a href="' . esc_url( get_permalink( $page ) ) . '" target="_blank" rel="noopener">KVKK Aydınlatma Metni</a>'
			: 'KVKK Aydınlatma Metni';
		return str_replace( '{kvkk}', $link, esc_html( akilli_get_setting( 'consent_text' ) ) );
	}

	/**
	 * Current request URL (without our state params).
	 *
	 * @return string
	 */
	private static function current_url() {
		$uri = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '/';
		return remove_query_arg( array( 'ak_form', 'ak_sent' ), home_url( $uri ) );
	}

	/**
	 * State carried over a no-JS redirect.
	 *
	 * @param string $type Form type.
	 * @return array
	 */
	private static function state_from_request( $type ) {
		$state = array(
			'values'  => array(),
			'errors'  => array(),
			'success' => false,
		);
		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- read-only display state.
		if ( isset( $_GET['ak_sent'] ) && sanitize_key( wp_unslash( $_GET['ak_sent'] ) ) === $type ) {
			$state['success'] = true;
		}
		if ( ! empty( $_GET['ak_form'] ) ) {
			$key  = 'akilli_fs_' . preg_replace( '/[^a-zA-Z0-9]/', '', sanitize_text_field( wp_unslash( $_GET['ak_form'] ) ) );
			$data = get_transient( $key );
			if ( is_array( $data ) && isset( $data['type'] ) && $data['type'] === $type ) {
				$state['values'] = $data['values'];
				$state['errors'] = $data['errors'];
			}
		}
		// phpcs:enable
		return $state;
	}

	/**
	 * Is the current request an AJAX (fetch) submission?
	 *
	 * @return bool
	 */
	private static function is_ajax() {
		return ! empty( $_SERVER['HTTP_X_AKILLI_AJAX'] );
	}

	/**
	 * Respond and exit.
	 *
	 * @param bool   $ok     Success.
	 * @param string $type   Form type.
	 * @param array  $errors Errors.
	 * @param array  $values Values (for no-JS refill).
	 * @param string $form_id Anchor.
	 */
	private static function respond( $ok, $type, $errors = array(), $values = array(), $form_id = '' ) {
		if ( self::is_ajax() ) {
			if ( $ok ) {
				wp_send_json_success( array( 'message' => akilli_get_setting( 'teklif' === $type ? 'q_success' : 'c_success' ) ) );
			}
			wp_send_json_error(
				array(
					'message' => isset( $errors['_form'] ) ? $errors['_form'] : 'Lütfen işaretli alanları kontrol edin.',
					'errors'  => $errors,
				),
				400
			);
		}
		$return = isset( $_POST['ak_return'] ) ? esc_url_raw( wp_unslash( $_POST['ak_return'] ) ) : home_url( '/' ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$return = wp_validate_redirect( $return, home_url( '/' ) );
		$anchor = $form_id ? '#' . sanitize_html_class( $form_id ) : '';
		if ( $ok ) {
			wp_safe_redirect( add_query_arg( 'ak_sent', $type, $return ) . $anchor, 303 );
			exit;
		}
		$token = wp_generate_password( 20, false );
		unset( $values['ak_website'] );
		set_transient(
			'akilli_fs_' . $token,
			array(
				'type'   => $type,
				'values' => $values,
				'errors' => $errors,
			),
			10 * MINUTE_IN_SECONDS
		);
		wp_safe_redirect( add_query_arg( 'ak_form', $token, $return ) . $anchor, 303 );
		exit;
	}

	/**
	 * Handle submission.
	 */
	public static function handle() {
		// phpcs:disable WordPress.Security.NonceVerification.Missing -- public form; protected by signed timestamp, honeypot and rate limit (nonces break on cached pages).
		$type    = ( isset( $_POST['ak_type'] ) && 'iletisim' === $_POST['ak_type'] ) ? 'iletisim' : 'teklif';
		$form_id = isset( $_POST['ak_form_id'] ) ? sanitize_html_class( wp_unslash( $_POST['ak_form_id'] ) ) : '';
		$fields  = self::fields( $type );

		$values = array(
			'ad'       => isset( $_POST['ad'] ) ? sanitize_text_field( wp_unslash( $_POST['ad'] ) ) : '',
			'firma'    => isset( $_POST['firma'] ) ? sanitize_text_field( wp_unslash( $_POST['firma'] ) ) : '',
			'email'    => isset( $_POST['email'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['email'] ) ) ) : '',
			'telefon'  => isset( $_POST['telefon'] ) ? sanitize_text_field( wp_unslash( $_POST['telefon'] ) ) : '',
			'hizmet'   => isset( $_POST['hizmet'] ) ? sanitize_text_field( wp_unslash( $_POST['hizmet'] ) ) : '',
			'butce'    => isset( $_POST['butce'] ) ? sanitize_text_field( wp_unslash( $_POST['butce'] ) ) : '',
			'aciklama' => isset( $_POST['aciklama'] ) ? sanitize_textarea_field( wp_unslash( $_POST['aciklama'] ) ) : '',
			'onay'     => empty( $_POST['onay'] ) ? '' : '1',
		);
		$honeypot = isset( $_POST['ak_website'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['ak_website'] ) ) ) : '';
		$token    = isset( $_POST['ak_ts'] ) ? sanitize_text_field( wp_unslash( $_POST['ak_ts'] ) ) : '';
		// phpcs:enable

		// Bots filling the honeypot get a silent "success" and nothing is stored.
		if ( '' !== $honeypot ) {
			self::respond( true, $type, array(), array(), $form_id );
		}

		$errors = array();
		list( $ts, $sig ) = array_pad( explode( '.', $token, 2 ), 2, '' );
		if ( ! $ts || ! hash_equals( hash_hmac( 'sha256', $ts, wp_salt( 'nonce' ) ), $sig ) ) {
			$errors['_form'] = 'Form doğrulanamadı. Lütfen sayfayı yenileyip tekrar deneyin.';
		} elseif ( time() - (int) $ts < (int) akilli_get_setting( 'min_seconds' ) ) {
			$errors['_form'] = 'Form çok hızlı gönderildi. Lütfen birkaç saniye sonra tekrar deneyin.';
		}

		if ( ! $errors && self::rate_limited() ) {
			$errors['_form'] = 'Kısa sürede çok fazla gönderim yapıldı. Lütfen biraz sonra tekrar deneyin veya bize telefonla ulaşın.';
		}

		if ( ! $errors ) {
			$errors = self::validate( $type, $fields, $values );
		}

		if ( $errors ) {
			self::respond( false, $type, $errors, $values, $form_id );
		}

		$values['email'] = sanitize_email( $values['email'] );
		$lead_id         = self::save_lead( $type, $values );
		if ( ! $lead_id ) {
			self::respond( false, $type, array( '_form' => 'Talebiniz kaydedilemedi. Lütfen tekrar deneyin veya bize telefonla ulaşın.' ), $values, $form_id );
		}
		self::notify( $lead_id );
		self::respond( true, $type, array(), array(), $form_id );
	}

	/**
	 * Validate values.
	 *
	 * @param string $type   Form type.
	 * @param array  $fields Field defs.
	 * @param array  $values Values.
	 * @return array
	 */
	private static function validate( $type, $fields, $values ) {
		$errors = array();
		foreach ( $fields as $key => $def ) {
			if ( 'butce' === $key && ! akilli_get_setting( 'q_show_budget' ) ) {
				continue;
			}
			if ( $def[1] && '' === trim( (string) $values[ $key ] ) ) {
				$errors[ $key ] = $def[0] . ' alanı zorunludur.';
			}
		}
		if ( ! isset( $errors['ad'] ) && mb_strlen( $values['ad'] ) < 3 ) {
			$errors['ad'] = 'Lütfen adınızı ve soyadınızı yazın.';
		}
		if ( ! isset( $errors['email'] ) && ! is_email( $values['email'] ) ) {
			$errors['email'] = 'Geçerli bir e-posta adresi yazın (örn. ad@firma.com).';
		}
		if ( '' !== $values['telefon'] && ! isset( $errors['telefon'] ) ) {
			$digits = preg_replace( '/\D/', '', $values['telefon'] );
			if ( strlen( $digits ) < 10 || strlen( $digits ) > 15 || preg_match( '/[^0-9\s+()\-.]/', $values['telefon'] ) ) {
				$errors['telefon'] = 'Geçerli bir telefon numarası yazın (örn. 0530 000 00 00).';
			}
		}
		if ( 'teklif' === $type && ! isset( $errors['hizmet'] ) && 'diger' !== $values['hizmet'] && 'ak_hizmet' !== get_post_type( (int) $values['hizmet'] ) ) {
			$errors['hizmet'] = 'Lütfen listeden bir hizmet seçin.';
		}
		if ( 'teklif' === $type && '' !== $values['butce'] && ! in_array( $values['butce'], akilli_lines( akilli_get_setting( 'q_budgets' ) ), true ) ) {
			$errors['butce'] = 'Lütfen listeden bir bütçe aralığı seçin.';
		}
		if ( ! isset( $errors['aciklama'] ) ) {
			$len = mb_strlen( trim( $values['aciklama'] ) );
			if ( $len < 10 ) {
				$errors['aciklama'] = 'Lütfen biraz daha ayrıntı verin (en az 10 karakter).';
			} elseif ( $len > 5000 ) {
				$errors['aciklama'] = 'Metin en fazla 5000 karakter olabilir.';
			} elseif ( preg_match_all( '#https?://#i', $values['aciklama'] ) > 3 ) {
				$errors['aciklama'] = 'Mesajda en fazla 3 bağlantı bulunabilir.';
			}
		}
		if ( empty( $values['onay'] ) ) {
			$errors['onay'] = 'Devam etmek için onay kutusunu işaretleyin.';
		}
		return $errors;
	}

	/**
	 * Simple per-IP rate limit (IP is hashed, never stored).
	 *
	 * @return bool
	 */
	private static function rate_limited() {
		$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
		$key = 'akilli_rl_' . substr( hash_hmac( 'sha256', $ip, wp_salt( 'auth' ) ), 0, 32 );
		$n   = (int) get_transient( $key );
		$max = max( 1, (int) akilli_get_setting( 'rate_limit' ) );
		if ( $n >= $max ) {
			return true;
		}
		set_transient( $key, $n + 1, 10 * MINUTE_IN_SECONDS );
		return false;
	}

	/**
	 * Save the lead as a private ak_talep post.
	 *
	 * @param string $type   Type.
	 * @param array  $values Values.
	 * @return int
	 */
	private static function save_lead( $type, $values ) {
		$service_id   = ctype_digit( (string) $values['hizmet'] ) ? (int) $values['hizmet'] : 0;
		$service_name = $service_id ? get_the_title( $service_id ) : ( 'diger' === $values['hizmet'] ? 'Belirtilmedi / birden fazla' : '' );
		$title        = $values['ad'] . ( $service_name ? ' – ' . $service_name : ( 'iletisim' === $type ? ' – İletişim mesajı' : '' ) );
		$source       = isset( $_POST['ak_return'] ) ? esc_url_raw( wp_unslash( $_POST['ak_return'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing

		$id = wp_insert_post(
			array(
				'post_type'   => 'ak_talep',
				'post_status' => 'private',
				'post_title'  => wp_strip_all_tags( $title ),
				'meta_input'  => array(
					'_ak_type'         => $type,
					'_ak_name'         => $values['ad'],
					'_ak_company'      => $values['firma'],
					'_ak_email'        => $values['email'],
					'_ak_phone'        => $values['telefon'],
					'_ak_service_id'   => $service_id,
					'_ak_service_name' => $service_name,
					'_ak_budget'       => $values['butce'],
					'_ak_message'      => $values['aciklama'],
					'_ak_consent'      => current_time( 'mysql' ),
					'_ak_source'       => $source,
					'_ak_status'       => 'yeni',
					'_ak_mail_status'  => 'pending',
				),
			),
			true
		);
		return is_wp_error( $id ) ? 0 : (int) $id;
	}

	/**
	 * Recipients for notifications.
	 *
	 * @return string[]
	 */
	public static function recipients() {
		$list = array_filter( array_map( 'trim', explode( ',', (string) akilli_get_setting( 'notify_emails' ) ) ), 'is_email' );
		if ( ! $list && is_email( akilli_get_setting( 'email' ) ) ) {
			$list = array( akilli_get_setting( 'email' ) );
		}
		if ( ! $list ) {
			$list = array( get_option( 'admin_email' ) );
		}
		return $list;
	}

	/**
	 * Send (or re-send) the notification for a lead and record the result.
	 *
	 * @param int $lead_id Lead ID.
	 * @return bool
	 */
	public static function notify( $lead_id ) {
		$m    = function ( $k ) use ( $lead_id ) {
			return (string) get_post_meta( $lead_id, '_ak_' . $k, true );
		};
		$type = 'iletisim' === $m( 'type' ) ? 'İletişim mesajı' : 'Teklif talebi';

		$subject = strtr(
			(string) akilli_get_setting( 'mail_subject' ),
			array(
				'{tur}'    => $type,
				'{ad}'     => $m( 'name' ),
				'{hizmet}' => $m( 'service_name' ),
			)
		);
		$lines   = array(
			'Tür'           => $type,
			'Ad soyad'      => $m( 'name' ),
			'Firma'         => $m( 'company' ),
			'E-posta'       => $m( 'email' ),
			'Telefon'       => $m( 'phone' ),
			'Hizmet'        => $m( 'service_name' ),
			'Bütçe'         => $m( 'budget' ),
			'Kaynak sayfa'  => $m( 'source' ),
			'Tarih'         => get_the_date( 'd.m.Y H:i', $lead_id ),
		);
		$body    = '';
		foreach ( $lines as $label => $value ) {
			if ( '' !== $value ) {
				$body .= $label . ': ' . $value . "\n";
			}
		}
		$body .= "\nMesaj:\n" . $m( 'message' ) . "\n\n";
		$body .= 'Panelde görüntüle: ' . admin_url( 'post.php?post=' . $lead_id . '&action=edit' ) . "\n";

		$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
		if ( is_email( $m( 'email' ) ) ) {
			$headers[] = 'Reply-To: ' . str_replace( array( "\r", "\n", '<', '>', ',' ), '', $m( 'name' ) ) . ' <' . $m( 'email' ) . '>';
		}

		$error   = '';
		$catcher = function ( $wp_error ) use ( &$error ) {
			$error = $wp_error instanceof WP_Error ? $wp_error->get_error_message() : 'Bilinmeyen hata';
		};
		add_action( 'wp_mail_failed', $catcher );
		$sent = wp_mail( self::recipients(), wp_strip_all_tags( $subject ), $body, $headers );
		remove_action( 'wp_mail_failed', $catcher );

		update_post_meta( $lead_id, '_ak_mail_status', $sent ? 'sent' : 'failed' );
		update_post_meta( $lead_id, '_ak_mail_error', $sent ? '' : ( $error ? $error : 'wp_mail() false döndürdü.' ) );
		update_post_meta( $lead_id, '_ak_mail_time', current_time( 'mysql' ) );
		return (bool) $sent;
	}
}
