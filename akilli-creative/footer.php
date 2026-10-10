<?php
/**
 * Footer.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;
$tel  = akilli_phone_href();
$wa   = akilli_whatsapp_url();
$mail = akilli_get_setting( 'email' );
?>
</main>
<footer class="ak-footer">
	<div class="ak-wrap">
		<div class="ak-footer__top">
			<p class="ak-footer__title"><?php akilli_inline( akilli_mod( 'akilli_footer_title' ) ); ?></p>
			<div>
				<?php if ( $mail ) : ?>
					<a class="ak-footer__mail" href="<?php echo esc_url( 'mailto:' . $mail ); ?>"><?php echo esc_html( $mail ); ?></a>
				<?php endif; ?>
				<p style="margin-top:18px"><a class="ak-btn ak-btn--primary" href="<?php echo esc_url( akilli_url_mod( 'akilli_header_cta_url' ) ); ?>"><span class="ak-btn__label"><?php echo esc_html( akilli_mod( 'akilli_header_cta' ) ); ?></span><?php echo akilli_icon( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></p>
			</div>
		</div>
		<div class="ak-footer__cols">
			<div class="ak-footer__brand">
				<?php akilli_logo(); ?>
				<p><?php echo esc_html( akilli_mod( 'akilli_footer_text' ) ); ?></p>
				<?php
				$social = akilli_social_links();
				if ( $social ) :
					?>
					<ul class="ak-social" aria-label="Sosyal medya hesaplarımız">
						<?php foreach ( $social as $net => $url ) : ?>
							<li><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener"><?php echo akilli_icon( $net ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span class="screen-reader-text"><?php echo esc_html( ucfirst( $net ) ); ?> (yeni sekmede açılır)</span></a></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
			<?php foreach ( array( 'footer_services' => 'Hizmetler', 'footer_company' => 'Kurumsal' ) as $loc => $label ) : ?>
				<?php if ( has_nav_menu( $loc ) ) : ?>
					<nav aria-label="<?php echo esc_attr( $label ); ?>">
						<h2><?php echo esc_html( $label ); ?></h2>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => $loc,
								'container'      => false,
								'menu_class'     => 'ak-footer__menu',
								'depth'          => 1,
							)
						);
						?>
					</nav>
				<?php endif; ?>
			<?php endforeach; ?>
			<div>
				<h2>İletişim</h2>
				<ul class="ak-footer__contact">
					<?php if ( akilli_get_setting( 'address' ) ) : ?>
						<li><?php echo akilli_icon( 'map-pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( akilli_get_setting( 'address' ) ); ?></span></li>
					<?php endif; ?>
					<?php if ( $tel ) : ?>
						<li><?php echo akilli_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><a href="<?php echo esc_url( $tel ); ?>"><?php echo esc_html( akilli_get_setting( 'phone' ) ); ?></a></li>
					<?php endif; ?>
					<?php if ( $wa ) : ?>
						<li><?php echo akilli_icon( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><a href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener">WhatsApp’tan yazın</a></li>
					<?php endif; ?>
					<?php if ( $mail ) : ?>
						<li><?php echo akilli_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><a href="<?php echo esc_url( 'mailto:' . $mail ); ?>"><?php echo esc_html( $mail ); ?></a></li>
					<?php endif; ?>
					<?php if ( akilli_get_setting( 'working_hours' ) ) : ?>
						<li><?php echo akilli_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( akilli_get_setting( 'working_hours' ) ); ?></span></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<div class="ak-footer__bottom">
			<p><?php echo esc_html( akilli_copyright() ); ?></p>
			<?php
			if ( has_nav_menu( 'legal' ) ) {
				wp_nav_menu(
					array(
						'theme_location'  => 'legal',
						'container'       => 'nav',
						'container_class' => 'ak-footer__legal-nav',
						'container_aria_label' => 'Yasal bağlantılar',
						'menu_class'      => 'ak-footer__legal',
						'depth'           => 1,
					)
				);
			}
			?>
			<div class="ak-footer__tools">
				<?php if ( akilli_mod( 'akilli_motion_toggle' ) && 'off' !== akilli_motion_level() ) : ?>
					<button type="button" class="ak-tool" data-ak-motion-toggle aria-pressed="false" hidden>Hareketi azalt</button>
				<?php endif; ?>
				<a class="ak-tool" href="#icerik">Başa dön ↑</a>
			</div>
		</div>
	</div>
	<p class="ak-footer__word" aria-hidden="true">akıllı creative</p>
</footer>

<?php if ( akilli_mod( 'akilli_mobile_bar' ) && ( $tel || $wa ) ) : ?>
	<nav class="ak-mobilebar" aria-label="Hızlı iletişim" data-ak-mobilebar>
		<?php if ( $tel ) : ?>
			<a href="<?php echo esc_url( $tel ); ?>"><?php echo akilli_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>Ara</a>
		<?php endif; ?>
		<?php if ( $wa ) : ?>
			<a href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener"><?php echo akilli_icon( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>WhatsApp</a>
		<?php endif; ?>
		<a href="<?php echo esc_url( akilli_url_mod( 'akilli_header_cta_url' ) ); ?>"><?php echo esc_html( akilli_mod( 'akilli_header_cta' ) ); ?></a>
	</nav>
<?php endif; ?>

<?php if ( akilli_mod( 'akilli_cookie' ) ) : ?>
	<div class="ak-cookie" data-ak-cookie hidden role="region" aria-label="Çerez bilgilendirmesi">
		<p>
			<?php echo esc_html( akilli_mod( 'akilli_cookie_text' ) ); ?>
			<?php
			$cookie_page = (int) get_option( 'akilli_page_cerez' );
			if ( $cookie_page && 'publish' === get_post_status( $cookie_page ) ) {
				echo ' <a href="' . esc_url( get_permalink( $cookie_page ) ) . '">Çerez Politikası</a>';
			}
			?>
		</p>
		<button type="button" class="ak-btn ak-btn--primary ak-btn--sm" data-ak-cookie-ok>Tamam</button>
	</div>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
