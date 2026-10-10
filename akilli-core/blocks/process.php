<?php
/**
 * Block: process steps.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
$steps = array_values( array_filter( (array) $a['steps'], function ( $s ) {
	return ! empty( $s['title'] );
} ) );
if ( ! $steps ) {
	return;
}
?>
<section class="ak-section ak-process"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?> data-ak-process>
	<div class="ak-wrap ak-process__layout">
		<div class="ak-process__aside">
			<?php akilli_section_head( $a ); ?>
			<div class="ak-process__meter" aria-hidden="true"><span></span></div>
		</div>
		<ol class="ak-process__steps">
			<?php foreach ( $steps as $i => $s ) : ?>
				<li class="ak-process__step" data-reveal>
					<span class="ak-process__num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
					<div>
						<h3 class="ak-process__title"><?php echo esc_html( $s['title'] ); ?></h3>
						<?php if ( ! empty( $s['text'] ) ) : ?>
							<p><?php akilli_inline( $s['text'] ); ?></p>
						<?php endif; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
