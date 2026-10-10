<?php
/**
 * Block: statement / manifesto with scroll-linked word reveal.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
if ( ! $a['text'] ) {
	return;
}
?>
<section class="ak-section ak-statement"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-wrap">
		<?php if ( $a['eyebrow'] ) : ?>
			<p class="ak-eyebrow"><?php echo esc_html( $a['eyebrow'] ); ?></p>
		<?php endif; ?>
		<p class="ak-statement__text" data-ak-words><?php akilli_inline( $a['text'] ); ?></p>
		<?php if ( $a['caption'] ) : ?>
			<p class="ak-statement__caption"><?php akilli_inline( $a['caption'] ); ?></p>
		<?php endif; ?>
	</div>
</section>
