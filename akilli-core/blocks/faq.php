<?php
/**
 * Block: FAQ (native <details>, no JS required).
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
$items = array_values( array_filter( (array) $a['items'], function ( $s ) {
	return ! empty( $s['q'] ) && ! empty( $s['a'] );
} ) );
if ( ! $items ) {
	return;
}
if ( ! Akilli_Blocks::is_preview() ) {
	Akilli_SEO::add_faq( $items );
}
?>
<section class="ak-section ak-faq"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-wrap ak-faq__layout">
		<?php akilli_section_head( $a ); ?>
		<div class="ak-faq__list">
			<?php foreach ( $items as $i => $item ) : ?>
				<details class="ak-faq__item" data-reveal<?php echo 0 === $i ? ' open' : ''; ?>>
					<summary><h3 class="ak-faq__q"><?php echo esc_html( $item['q'] ); ?></h3><span class="ak-faq__toggle" aria-hidden="true"><?php echo akilli_icon( 'plus' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span></summary>
					<div class="ak-faq__a"><?php echo wpautop( wp_kses( $item['a'], akilli_inline_kses() ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
