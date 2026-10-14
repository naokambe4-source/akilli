<?php
/**
 * Block: testimonials — sticky stacking cards. Renders nothing without items.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
$items = array_values(
	array_filter(
		(array) $a['items'],
		function ( $t ) {
			return ! empty( $t['quote'] ) && ! empty( $t['name'] );
		}
	)
);
if ( ! $items ) {
	return;
}
?>
<section class="ak-section ak-testimonials"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-wrap">
		<?php akilli_section_head( $a ); ?>
		<ul class="ak-tstack">
			<?php foreach ( $items as $i => $t ) : ?>
				<li class="ak-tcard" style="--i:<?php echo (int) $i; ?>">
					<figure>
						<?php echo akilli_icon( 'quote', 'ak-tcard__mark' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<blockquote><p><?php echo esc_html( $t['quote'] ); ?></p></blockquote>
						<figcaption>
							<?php
							if ( ! empty( $t['photo'] ) ) {
								echo wp_get_attachment_image( (int) $t['photo'], 'thumbnail', false, array( 'class' => 'ak-tcard__photo', 'alt' => '', 'loading' => 'lazy' ) );
							}
							?>
							<span><strong><?php echo esc_html( $t['name'] ); ?></strong><?php echo ! empty( $t['role'] ) ? '<small>' . esc_html( $t['role'] ) . '</small>' : ''; ?></span>
						</figcaption>
					</figure>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
