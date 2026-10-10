<?php
/**
 * Block: page hero.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
$has_img = ! empty( $a['image'] );
?>
<section class="ak-phero<?php echo $has_img ? ' ak-phero--media' : ''; ?>"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-phero__bg" aria-hidden="true"><span></span><span></span></div>
	<div class="ak-wrap ak-phero__inner">
		<div class="ak-phero__copy">
			<?php
			if ( function_exists( 'akilli_breadcrumbs' ) ) {
				akilli_breadcrumbs();
			}
			?>
			<?php if ( $a['eyebrow'] ) : ?>
				<p class="ak-eyebrow"><?php echo esc_html( $a['eyebrow'] ); ?></p>
			<?php endif; ?>
			<h1 class="ak-phero__title"><?php akilli_inline( $a['title'] ? $a['title'] : get_the_title() ); ?></h1>
			<?php if ( $a['text'] ) : ?>
				<p class="ak-phero__text"><?php akilli_inline( $a['text'] ); ?></p>
			<?php endif; ?>
			<?php if ( $a['btn1_text'] || $a['btn2_text'] ) : ?>
				<div class="ak-phero__actions">
					<?php
					echo akilli_button( $a['btn1_text'], $a['btn1_url'], 'primary' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo akilli_button( $a['btn2_text'], $a['btn2_url'], 'ghost' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</div>
			<?php endif; ?>
		</div>
		<?php if ( $has_img ) : ?>
			<figure class="ak-phero__media" data-reveal>
				<?php
				echo wp_get_attachment_image(
					(int) $a['image'],
					'large',
					false,
					array(
						'loading'       => 'eager',
						'fetchpriority' => 'high',
						'sizes'         => '(max-width: 900px) 100vw, 45vw',
					)
				);
				?>
			</figure>
		<?php endif; ?>
	</div>
</section>
