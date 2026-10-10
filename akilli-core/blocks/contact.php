<?php
/**
 * Block: contact details + form.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
$tel   = akilli_phone_href();
$wa    = akilli_whatsapp_url();
$mail  = akilli_get_setting( 'email' );
$addr  = akilli_get_setting( 'address' );
$map   = akilli_get_setting( 'map_url' );
$hours = akilli_get_setting( 'working_hours' );
?>
<section class="ak-section ak-contact"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-wrap ak-contact__layout<?php echo $a['show_form'] ? '' : ' ak-contact__layout--single'; ?>">
		<div class="ak-contact__info">
			<?php akilli_section_head( $a ); ?>
			<ul class="ak-contact__cards">
				<?php if ( $tel ) : ?>
					<li><a href="<?php echo esc_url( $tel ); ?>"><?php echo akilli_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><small>Telefon</small><?php echo esc_html( akilli_get_setting( 'phone' ) ); ?></span></a></li>
				<?php endif; ?>
				<?php if ( $wa ) : ?>
					<li><a href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener"><?php echo akilli_icon( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><small>WhatsApp</small>Mesaj gönderin</span></a></li>
				<?php endif; ?>
				<?php if ( $mail ) : ?>
					<li><a href="<?php echo esc_url( 'mailto:' . $mail ); ?>"><?php echo akilli_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><small>E-posta</small><?php echo esc_html( $mail ); ?></span></a></li>
				<?php endif; ?>
				<?php if ( $addr ) : ?>
					<li>
						<?php if ( $map ) : ?>
							<a href="<?php echo esc_url( $map ); ?>" target="_blank" rel="noopener"><?php echo akilli_icon( 'map-pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><small>Ofis · Haritada aç</small><?php echo esc_html( $addr ); ?></span></a>
						<?php else : ?>
							<div><?php echo akilli_icon( 'map-pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><small>Ofis</small><?php echo esc_html( $addr ); ?></span></div>
						<?php endif; ?>
					</li>
				<?php endif; ?>
				<?php if ( $hours ) : ?>
					<li><div><?php echo akilli_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><small>Çalışma saatleri</small><?php echo esc_html( $hours ); ?></span></div></li>
				<?php endif; ?>
			</ul>
			<?php
			$social = akilli_social_links();
			if ( $social ) :
				?>
				<ul class="ak-social" aria-label="Sosyal medya">
					<?php foreach ( $social as $net => $url ) : ?>
						<li><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener"><?php echo akilli_icon( $net ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span class="screen-reader-text"><?php echo esc_html( ucfirst( $net ) ); ?></span></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
		<?php if ( $a['show_form'] ) : ?>
			<div class="ak-contact__form ak-panel">
				<h2 class="ak-panel__title">Bize yazın</h2>
				<?php echo Akilli_Forms::render( 'iletisim' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endif; ?>
	</div>
</section>
