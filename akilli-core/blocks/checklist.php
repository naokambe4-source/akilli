<?php
/**
 * Block: checklist.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
$items = akilli_lines( $a['items'] );
if ( ! $items ) {
	return;
}
?>
<section class="ak-section ak-checklist"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-wrap ak-checklist__layout">
		<?php akilli_section_head( $a ); ?>
		<ul class="ak-checklist__list">
			<?php foreach ( $items as $i => $item ) : ?>
				<li data-reveal style="--i:<?php echo (int) $i; ?>"><span class="ak-checklist__num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><span><?php akilli_inline( $item ); ?></span></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
