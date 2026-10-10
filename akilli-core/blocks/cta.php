<?php
/**
 * Block: CTA band.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="ak-cta"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-wrap">
		<div class="ak-cta__panel" data-reveal>
			<div class="ak-cta__layers" aria-hidden="true"><span></span><span></span><span></span></div>
			<div class="ak-cta__copy">
				<?php if ( $a['eyebrow'] ) : ?>
					<p class="ak-eyebrow"><?php echo esc_html( $a['eyebrow'] ); ?></p>
				<?php endif; ?>
				<?php if ( $a['title'] ) : ?>
					<h2 class="ak-cta__title"><?php akilli_inline( $a['title'] ); ?></h2>
				<?php endif; ?>
				<?php if ( $a['text'] ) : ?>
					<p class="ak-cta__text"><?php akilli_inline( $a['text'] ); ?></p>
				<?php endif; ?>
				<div class="ak-cta__actions">
					<?php
					echo akilli_button( $a['btn1_text'], $a['btn1_url'], 'primary' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo akilli_button( $a['btn2_text'], $a['btn2_url'], 'ghost' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</div>
				<?php
				if ( $a['show_contact'] ) {
					akilli_contact_links( 'ak-cta__contact' );
				}
				?>
			</div>
		</div>
	</div>
</section>
