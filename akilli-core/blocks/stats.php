<?php
/**
 * Block: stats — only for verified numbers; renders nothing when empty.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
$items = array_values( array_filter( (array) $a['items'], function ( $s ) {
	return ! empty( $s['value'] ) && ! empty( $s['label'] );
} ) );
if ( ! $items ) {
	return;
}
?>
<section class="ak-section ak-stats"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-wrap">
		<?php akilli_section_head( $a ); ?>
		<dl class="ak-stats__list">
			<?php foreach ( $items as $item ) : ?>
				<div class="ak-stats__item" data-reveal>
					<dt><?php echo esc_html( $item['label'] ); ?></dt>
					<dd><?php echo esc_html( $item['value'] ); ?></dd>
				</div>
			<?php endforeach; ?>
		</dl>
	</div>
</section>
