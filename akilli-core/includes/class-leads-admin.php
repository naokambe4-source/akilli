<?php
/**
 * Lead (talep) management in wp-admin.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Lead list, detail screen, status, internal notes, e-mail status, privacy tools.
 */
class Akilli_Leads_Admin {

	const CAP_VERSION = 2;

	/**
	 * Hooks.
	 */
	public static function init() {
		add_action( 'admin_init', array( __CLASS__, 'maybe_grant_caps' ) );
		add_action( 'add_meta_boxes_ak_talep', array( __CLASS__, 'boxes' ) );
		add_action( 'save_post_ak_talep', array( __CLASS__, 'save' ), 10, 2 );
		add_filter( 'manage_ak_talep_posts_columns', array( __CLASS__, 'columns' ) );
		add_action( 'manage_ak_talep_posts_custom_column', array( __CLASS__, 'column' ), 10, 2 );
		add_action( 'restrict_manage_posts', array( __CLASS__, 'filter_ui' ) );
		add_action( 'pre_get_posts', array( __CLASS__, 'filter_query' ) );
		add_action( 'admin_menu', array( __CLASS__, 'menu_badge' ), 99 );
		add_action( 'admin_notices', array( __CLASS__, 'mail_failure_notice' ) );
		add_action( 'admin_post_akilli_resend', array( __CLASS__, 'resend' ) );
		add_filter( 'post_row_actions', array( __CLASS__, 'row_actions' ), 10, 2 );
		add_filter( 'wp_privacy_personal_data_exporters', array( __CLASS__, 'register_exporter' ) );
		add_filter( 'wp_privacy_personal_data_erasers', array( __CLASS__, 'register_eraser' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'assets' ) );
	}

	/**
	 * Status labels.
	 *
	 * @return array
	 */
	public static function statuses() {
		return array(
			'yeni'      => 'Yeni',
			'inceleme'  => 'İnceleniyor',
			'gorusme'   => 'Görüşme yapıldı',
			'teklif'    => 'Teklif gönderildi',
			'kazanildi' => 'Kazanıldı',
			'kapandi'   => 'Kapandı',
		);
	}

	/**
	 * Grant capabilities to administrators and editors.
	 */
	public static function grant_caps() {
		$caps = array( 'edit_ak_talep', 'read_ak_talep', 'delete_ak_talep', 'edit_ak_talepler', 'edit_others_ak_talepler', 'publish_ak_talepler', 'read_private_ak_talepler', 'delete_ak_talepler', 'delete_private_ak_talepler', 'delete_published_ak_talepler', 'delete_others_ak_talepler', 'edit_private_ak_talepler', 'edit_published_ak_talepler' );
		foreach ( array( 'administrator', 'editor' ) as $role_name ) {
			$role = get_role( $role_name );
			if ( $role ) {
				foreach ( $caps as $cap ) {
					$role->add_cap( $cap );
				}
			}
		}
		update_option( 'akilli_caps_version', self::CAP_VERSION );
	}

	/**
	 * Grant caps once if the plugin was installed without activation hook (e.g. mu-plugin).
	 */
	public static function maybe_grant_caps() {
		if ( (int) get_option( 'akilli_caps_version' ) < self::CAP_VERSION ) {
			self::grant_caps();
		}
	}

	/**
	 * Styles.
	 *
	 * @param string $hook Hook.
	 */
	public static function assets( $hook ) {
		$screen = get_current_screen();
		if ( $screen && 'ak_talep' === $screen->post_type ) {
			wp_enqueue_style( 'akilli-admin', AKILLI_CORE_URL . 'assets/admin.css', array(), AKILLI_CORE_VERSION );
		}
	}

	/**
	 * Meta boxes.
	 */
	public static function boxes() {
		add_meta_box( 'akilli_lead_detail', 'Talep detayları', array( __CLASS__, 'box_detail' ), 'ak_talep', 'normal', 'high' );
		add_meta_box( 'akilli_lead_notes', 'İç notlar', array( __CLASS__, 'box_notes' ), 'ak_talep', 'normal' );
		add_meta_box( 'akilli_lead_status', 'Durum', array( __CLASS__, 'box_status' ), 'ak_talep', 'side', 'high' );
		add_meta_box( 'akilli_lead_mail', 'E-posta bildirimi', array( __CLASS__, 'box_mail' ), 'ak_talep', 'side' );
	}

	/**
	 * Detail box (read-only).
	 *
	 * @param WP_Post $post Post.
	 */
	public static function box_detail( $post ) {
		$m     = function ( $k ) use ( $post ) {
			return (string) get_post_meta( $post->ID, '_ak_' . $k, true );
		};
		$email = $m( 'email' );
		$phone = $m( 'phone' );
		$rows  = array(
			'Tür'          => 'iletisim' === $m( 'type' ) ? 'İletişim mesajı' : 'Teklif talebi',
			'Ad soyad'     => esc_html( $m( 'name' ) ),
			'Firma'        => esc_html( $m( 'company' ) ),
			'E-posta'      => $email ? '<a href="' . esc_url( 'mailto:' . $email ) . '">' . esc_html( $email ) . '</a>' : '',
			'Telefon'      => $phone ? '<a href="' . esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a>' : '',
			'Hizmet'       => esc_html( $m( 'service_name' ) ),
			'Bütçe aralığı' => esc_html( $m( 'budget' ) ),
			'Görüşme günü'  => esc_html( Akilli_Forms::format_day( $m( 'day' ) ) ),
			'Mesaj'        => esc_html( $m( 'message' ) ),
			'Kaynak sayfa' => $m( 'source' ) ? '<a href="' . esc_url( $m( 'source' ) ) . '" target="_blank" rel="noopener">' . esc_html( $m( 'source' ) ) . '</a>' : '',
			'Onay zamanı'  => esc_html( $m( 'consent' ) ),
			'Geliş tarihi' => esc_html( get_the_date( 'd.m.Y H:i', $post ) ),
		);
		echo '<table class="ak-lead-table">';
		foreach ( $rows as $label => $html ) {
			if ( '' === $html ) {
				continue;
			}
			echo '<tr><th scope="row">' . esc_html( $label ) . '</th><td>' . wp_kses_post( $html ) . '</td></tr>';
		}
		echo '</table>';
	}

	/**
	 * Status box.
	 *
	 * @param WP_Post $post Post.
	 */
	public static function box_status( $post ) {
		wp_nonce_field( 'akilli_lead_save', 'akilli_lead_nonce' );
		$current = get_post_meta( $post->ID, '_ak_status', true );
		echo '<label class="screen-reader-text" for="ak_status">Durum</label><select id="ak_status" name="ak_status" class="widefat">';
		foreach ( self::statuses() as $key => $label ) {
			echo '<option value="' . esc_attr( $key ) . '"' . selected( $current, $key, false ) . '>' . esc_html( $label ) . '</option>';
		}
		echo '</select><p class="description">Değişikliği kaydetmek için "Güncelle" düğmesine basın.</p>';
	}

	/**
	 * Notes box.
	 *
	 * @param WP_Post $post Post.
	 */
	public static function box_notes( $post ) {
		$notes = (array) get_post_meta( $post->ID, '_ak_notes', true );
		$notes = array_filter( $notes, 'is_array' );
		if ( $notes ) {
			echo '<ul class="ak-notes">';
			foreach ( array_reverse( $notes ) as $note ) {
				echo '<li><small>' . esc_html( $note['time'] . ' · ' . $note['user'] ) . '</small>' . nl2br( esc_html( $note['text'] ) ) . '</li>';
			}
			echo '</ul>';
		} else {
			echo '<p><em>Henüz not eklenmedi.</em></p>';
		}
		echo '<label for="ak_note"><strong>Yeni not</strong></label><textarea id="ak_note" name="ak_note" rows="3" class="widefat" placeholder="Örn. 12 Ekim’de arandı, toplantı planlandı."></textarea><p class="description">Notlar yalnızca yönetim panelinde görünür.</p>';
	}

	/**
	 * Mail status box.
	 *
	 * @param WP_Post $post Post.
	 */
	public static function box_mail( $post ) {
		$status = get_post_meta( $post->ID, '_ak_mail_status', true );
		$error  = get_post_meta( $post->ID, '_ak_mail_error', true );
		$time   = get_post_meta( $post->ID, '_ak_mail_time', true );
		if ( 'sent' === $status ) {
			echo '<p><span class="ak-badge ak-badge--ok">Gönderildi</span> ' . esc_html( $time ) . '</p>';
		} elseif ( 'failed' === $status ) {
			echo '<p><span class="ak-badge ak-badge--fail">Gönderilemedi</span> ' . esc_html( $time ) . '</p>';
			if ( $error ) {
				echo '<p class="description">' . esc_html( $error ) . '</p>';
			}
		} else {
			echo '<p><span class="ak-badge">Bekliyor</span></p>';
		}
		$url = wp_nonce_url( admin_url( 'admin-post.php?action=akilli_resend&lead=' . $post->ID ), 'akilli_resend_' . $post->ID );
		echo '<p><a class="button" href="' . esc_url( $url ) . '">Bildirimi tekrar gönder</a></p>';
		echo '<p class="description">Alıcılar: ' . esc_html( implode( ', ', Akilli_Forms::recipients() ) ) . '</p>';
	}

	/**
	 * Save status and notes.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post.
	 */
	public static function save( $post_id, $post ) {
		if ( ! isset( $_POST['akilli_lead_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['akilli_lead_nonce'] ) ), 'akilli_lead_save' ) ) {
			return;
		}
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		$status = isset( $_POST['ak_status'] ) ? sanitize_key( wp_unslash( $_POST['ak_status'] ) ) : '';
		if ( array_key_exists( $status, self::statuses() ) ) {
			$old = get_post_meta( $post_id, '_ak_status', true );
			update_post_meta( $post_id, '_ak_status', $status );
			if ( $old && $old !== $status ) {
				self::add_note( $post_id, 'Durum değişti: ' . self::statuses()[ $old ] . ' → ' . self::statuses()[ $status ] );
			}
		}
		$note = isset( $_POST['ak_note'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ak_note'] ) ) : '';
		if ( '' !== trim( $note ) ) {
			self::add_note( $post_id, $note );
		}
		// Keep leads private regardless of the publish box.
		if ( 'private' !== $post->post_status && 'trash' !== $post->post_status ) {
			remove_action( 'save_post_ak_talep', array( __CLASS__, 'save' ), 10 );
			wp_update_post(
				array(
					'ID'          => $post_id,
					'post_status' => 'private',
				)
			);
			add_action( 'save_post_ak_talep', array( __CLASS__, 'save' ), 10, 2 );
		}
	}

	/**
	 * Append a note.
	 *
	 * @param int    $post_id Lead.
	 * @param string $text    Text.
	 */
	private static function add_note( $post_id, $text ) {
		$notes   = array_filter( (array) get_post_meta( $post_id, '_ak_notes', true ), 'is_array' );
		$user    = wp_get_current_user();
		$notes[] = array(
			'time' => current_time( 'd.m.Y H:i' ),
			'user' => $user && $user->exists() ? $user->display_name : 'Sistem',
			'text' => $text,
		);
		update_post_meta( $post_id, '_ak_notes', array_values( $notes ) );
	}

	/**
	 * Resend notification.
	 */
	public static function resend() {
		$id = isset( $_GET['lead'] ) ? absint( $_GET['lead'] ) : 0;
		check_admin_referer( 'akilli_resend_' . $id );
		if ( ! $id || 'ak_talep' !== get_post_type( $id ) || ! current_user_can( 'edit_post', $id ) ) {
			wp_die( 'Bu işlem için yetkiniz yok.', 403 );
		}
		$ok = Akilli_Forms::notify( $id );
		self::add_note( $id, $ok ? 'Bildirim e-postası tekrar gönderildi.' : 'Bildirim e-postası tekrar gönderilemedi.' );
		wp_safe_redirect( admin_url( 'post.php?post=' . $id . '&action=edit' ) );
		exit;
	}

	/**
	 * List columns.
	 *
	 * @param array $cols Cols.
	 * @return array
	 */
	public static function columns( $cols ) {
		return array(
			'cb'         => $cols['cb'],
			'title'      => 'Talep',
			'ak_type'    => 'Tür',
			'ak_contact' => 'İletişim',
			'ak_status'  => 'Durum',
			'ak_mail'    => 'Bildirim',
			'date'       => 'Tarih',
		);
	}

	/**
	 * Column output.
	 *
	 * @param string $col Column.
	 * @param int    $id  Lead.
	 */
	public static function column( $col, $id ) {
		switch ( $col ) {
			case 'ak_type':
				echo 'iletisim' === get_post_meta( $id, '_ak_type', true ) ? 'İletişim' : 'Teklif';
				break;
			case 'ak_contact':
				echo esc_html( get_post_meta( $id, '_ak_email', true ) ) . '<br>' . esc_html( get_post_meta( $id, '_ak_phone', true ) );
				break;
			case 'ak_status':
				$s = get_post_meta( $id, '_ak_status', true );
				$l = self::statuses();
				echo '<span class="ak-badge' . ( 'yeni' === $s ? ' ak-badge--new' : '' ) . '">' . esc_html( isset( $l[ $s ] ) ? $l[ $s ] : '—' ) . '</span>';
				break;
			case 'ak_mail':
				$m = get_post_meta( $id, '_ak_mail_status', true );
				if ( 'sent' === $m ) {
					echo '<span class="ak-badge ak-badge--ok">Gönderildi</span>';
				} elseif ( 'failed' === $m ) {
					echo '<span class="ak-badge ak-badge--fail">Başarısız</span>';
				} else {
					echo '<span class="ak-badge">Bekliyor</span>';
				}
				break;
		}
	}

	/**
	 * Status filter dropdown.
	 *
	 * @param string $post_type Type.
	 */
	public static function filter_ui( $post_type ) {
		if ( 'ak_talep' !== $post_type ) {
			return;
		}
		$current = isset( $_GET['ak_status'] ) ? sanitize_key( wp_unslash( $_GET['ak_status'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		echo '<label class="screen-reader-text" for="ak-status-filter">Duruma göre filtrele</label><select name="ak_status" id="ak-status-filter"><option value="">Tüm durumlar</option>';
		foreach ( self::statuses() as $k => $l ) {
			echo '<option value="' . esc_attr( $k ) . '"' . selected( $current, $k, false ) . '>' . esc_html( $l ) . '</option>';
		}
		echo '<option value="mail_failed"' . selected( $current, 'mail_failed', false ) . '>E-postası gönderilemeyenler</option></select>';
	}

	/**
	 * Apply filter.
	 *
	 * @param WP_Query $q Query.
	 */
	public static function filter_query( $q ) {
		if ( ! is_admin() || ! $q->is_main_query() || 'ak_talep' !== $q->get( 'post_type' ) || empty( $_GET['ak_status'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return;
		}
		$s = sanitize_key( wp_unslash( $_GET['ak_status'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( 'mail_failed' === $s ) {
			$q->set( 'meta_key', '_ak_mail_status' );
			$q->set( 'meta_value', 'failed' );
		} elseif ( array_key_exists( $s, self::statuses() ) ) {
			$q->set( 'meta_key', '_ak_status' );
			$q->set( 'meta_value', $s );
		}
	}

	/**
	 * Count new leads in the menu.
	 */
	public static function menu_badge() {
		global $menu;
		if ( ! current_user_can( 'edit_ak_talepler' ) || ! is_array( $menu ) ) {
			return;
		}
		$count = self::count_meta( '_ak_status', 'yeni' );
		if ( ! $count ) {
			return;
		}
		foreach ( $menu as $i => $item ) {
			if ( isset( $item[2] ) && 'edit.php?post_type=ak_talep' === $item[2] ) {
				$menu[ $i ][0] .= ' <span class="awaiting-mod"><span class="pending-count">' . (int) $count . '</span></span>'; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			}
		}
	}

	/**
	 * Count leads by meta.
	 *
	 * @param string $key   Key.
	 * @param string $value Value.
	 * @return int
	 */
	private static function count_meta( $key, $value ) {
		$q = new WP_Query(
			array(
				'post_type'      => 'ak_talep',
				'post_status'    => array( 'private', 'publish' ),
				'meta_key'       => $key, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_value'     => $value, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
				'fields'         => 'ids',
				'posts_per_page' => 1,
				'no_found_rows'  => false,
			)
		);
		return (int) $q->found_posts;
	}

	/**
	 * Warn when notifications failed.
	 */
	public static function mail_failure_notice() {
		if ( ! current_user_can( 'edit_ak_talepler' ) ) {
			return;
		}
		$screen = get_current_screen();
		if ( ! $screen || ! in_array( $screen->id, array( 'dashboard', 'edit-ak_talep' ), true ) ) {
			return;
		}
		$failed = self::count_meta( '_ak_mail_status', 'failed' );
		if ( $failed ) {
			echo '<div class="notice notice-warning"><p><strong>Akıllı Creative:</strong> ' . (int) $failed . ' talep için e-posta bildirimi gönderilemedi. Talepler güvende ve <a href="' . esc_url( admin_url( 'edit.php?post_type=ak_talep&ak_status=mail_failed' ) ) . '">Talepler</a> ekranında listeleniyor. Sunucunuzun e-posta ayarlarını veya bir SMTP eklentisini kontrol edin.</p></div>';
		}
	}

	/**
	 * Row actions: remove quick edit and view.
	 *
	 * @param array   $actions Actions.
	 * @param WP_Post $post    Post.
	 * @return array
	 */
	public static function row_actions( $actions, $post ) {
		if ( 'ak_talep' === $post->post_type ) {
			unset( $actions['inline hide-if-no-js'], $actions['view'] );
			if ( isset( $actions['edit'] ) ) {
				$actions['edit'] = '<a href="' . esc_url( get_edit_post_link( $post->ID ) ) . '">Görüntüle</a>';
			}
		}
		return $actions;
	}

	/**
	 * Privacy exporter registration.
	 *
	 * @param array $exporters Exporters.
	 * @return array
	 */
	public static function register_exporter( $exporters ) {
		$exporters['akilli-leads'] = array(
			'exporter_friendly_name' => 'Akıllı Creative talepleri',
			'callback'               => array( __CLASS__, 'export' ),
		);
		return $exporters;
	}

	/**
	 * Privacy eraser registration.
	 *
	 * @param array $erasers Erasers.
	 * @return array
	 */
	public static function register_eraser( $erasers ) {
		$erasers['akilli-leads'] = array(
			'eraser_friendly_name' => 'Akıllı Creative talepleri',
			'callback'             => array( __CLASS__, 'erase' ),
		);
		return $erasers;
	}

	/**
	 * Leads by e-mail.
	 *
	 * @param string $email Email.
	 * @return int[]
	 */
	private static function leads_by_email( $email ) {
		return get_posts(
			array(
				'post_type'   => 'ak_talep',
				'post_status' => 'any',
				'numberposts' => 100,
				'fields'      => 'ids',
				'meta_key'    => '_ak_email', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_value'  => $email, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			)
		);
	}

	/**
	 * Export personal data.
	 *
	 * @param string $email Email.
	 * @return array
	 */
	public static function export( $email ) {
		$data = array();
		foreach ( self::leads_by_email( $email ) as $id ) {
			$item = array();
			foreach ( array( 'name' => 'Ad soyad', 'company' => 'Firma', 'email' => 'E-posta', 'phone' => 'Telefon', 'service_name' => 'Hizmet', 'budget' => 'Bütçe', 'day' => 'Görüşme günü', 'message' => 'Mesaj', 'consent' => 'Onay zamanı' ) as $k => $label ) {
				$item[] = array(
					'name'  => $label,
					'value' => (string) get_post_meta( $id, '_ak_' . $k, true ),
				);
			}
			$data[] = array(
				'group_id'    => 'akilli-leads',
				'group_label' => 'Form talepleri',
				'item_id'     => 'lead-' . $id,
				'data'        => $item,
			);
		}
		return array(
			'data' => $data,
			'done' => true,
		);
	}

	/**
	 * Erase personal data (deletes the leads).
	 *
	 * @param string $email Email.
	 * @return array
	 */
	public static function erase( $email ) {
		$removed = false;
		foreach ( self::leads_by_email( $email ) as $id ) {
			$removed = (bool) wp_delete_post( $id, true ) || $removed;
		}
		return array(
			'items_removed'  => $removed,
			'items_retained' => false,
			'messages'       => array(),
			'done'           => true,
		);
	}
}
