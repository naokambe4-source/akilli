<?php
/**
 * Block: team grid. Renders nothing without members.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
$items = array_values(
	array_filter(
		(array) $a['items'],
		function ( $t ) {
			return ! empty( $t['name'] );
		}
	)
);
if ( ! $items ) {
	return;
}
?>
<section class="ak-section ak-team"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-wrap">
		<?php akilli_section_head( $a ); ?>
		<ul class="ak-team__grid">
			<?php foreach ( $items as $i => $t ) : ?>
				<li class="ak-team__item" data-reveal style="--i:<?php echo (int) $i; ?>">
					<div class="ak-team__photo">
						<?php
						if ( ! empty( $t['photo'] ) ) {
							echo wp_get_attachment_image( (int) $t['photo'], 'medium_large', false, array( 'alt' => $t['name'], 'loading' => 'lazy', 'sizes' => '(max-width:700px) 50vw, 25vw' ) );
						}
						?>
					</div>
					<h3 class="ak-team__name"><?php echo esc_html( $t['name'] ); ?></h3>
					<?php if ( ! empty( $t['role'] ) ) : ?>
						<p class="ak-team__role"><?php echo esc_html( $t['role'] ); ?></p>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
