<?php
/**
 * Block: image + text.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
$items = akilli_lines( $a['items'] );
$paras = array_filter( array_map( 'trim', preg_split( '/\n\s*\n/', (string) $a['text'] ) ) );
?>
<section class="ak-section ak-split<?php echo $a['reverse'] ? ' ak-split--reverse' : ''; ?><?php echo $a['image'] ? '' : ' ak-split--noimg'; ?>"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-wrap ak-split__layout">
		<div class="ak-split__copy">
			<?php if ( $a['eyebrow'] ) : ?>
				<p class="ak-eyebrow" data-reveal><?php echo esc_html( $a['eyebrow'] ); ?></p>
			<?php endif; ?>
			<?php if ( $a['title'] ) : ?>
				<h2 class="ak-title" data-reveal="lines"><?php akilli_inline( $a['title'] ); ?></h2>
			<?php endif; ?>
			<?php foreach ( $paras as $p ) : ?>
				<p data-reveal><?php akilli_inline( $p ); ?></p>
			<?php endforeach; ?>
			<?php if ( $items ) : ?>
				<ul class="ak-split__list">
					<?php foreach ( $items as $item ) : ?>
						<li data-reveal><span><?php akilli_inline( $item ); ?></span></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<?php echo akilli_button( $a['btn1_text'], $a['btn1_url'], 'ghost' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php if ( $a['image'] ) : ?>
			<figure class="ak-split__media" data-reveal data-parallax>
				<?php echo wp_get_attachment_image( (int) $a['image'], 'large', false, array( 'loading' => 'lazy', 'sizes' => '(max-width: 900px) 100vw, 50vw' ) ); ?>
			</figure>
		<?php endif; ?>
	</div>
</section>
