<?php
/**
 * Block: features (cards / list / numbered).
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
$items = array_values( array_filter( (array) $a['items'], function ( $s ) {
	return ! empty( $s['title'] ) || ! empty( $s['text'] );
} ) );
if ( ! $items ) {
	return;
}
$style = in_array( $a['style'], array( 'cards', 'list', 'numbered' ), true ) ? $a['style'] : 'cards';
?>
<section class="ak-section ak-features ak-features--<?php echo esc_attr( $style ); ?>"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-wrap">
		<?php akilli_section_head( $a ); ?>
		<ul class="ak-features__list ak-cols-<?php echo esc_attr( min( 4, max( 2, count( $items ) % 3 === 0 ? 3 : ( count( $items ) === 2 || count( $items ) === 4 ? 2 : 3 ) ) ) ); ?>">
			<?php foreach ( $items as $i => $item ) : ?>
				<li class="ak-feature" data-reveal style="--i:<?php echo (int) $i; ?>">
					<?php if ( 'numbered' === $style ) : ?>
						<span class="ak-feature__num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
					<?php elseif ( ! empty( $item['icon'] ) ) : ?>
						<span class="ak-feature__icon" aria-hidden="true"><?php echo akilli_icon( $item['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php endif; ?>
					<?php if ( ! empty( $item['title'] ) ) : ?>
						<h3 class="ak-feature__title">
							<?php if ( ! empty( $item['url'] ) ) : ?>
								<a href="<?php echo esc_url( akilli_url( $item['url'] ) ); ?>"><?php echo esc_html( $item['title'] ); ?></a>
							<?php else : ?>
								<?php echo esc_html( $item['title'] ); ?>
							<?php endif; ?>
						</h3>
					<?php endif; ?>
					<?php if ( ! empty( $item['text'] ) ) : ?>
						<p><?php akilli_inline( $item['text'] ); ?></p>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
