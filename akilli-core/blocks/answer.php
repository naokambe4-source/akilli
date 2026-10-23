<?php
/**
 * Block: short answer (answer-engine friendly Q&A box).
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
if ( empty( $a['question'] ) || empty( $a['answer'] ) ) {
	return;
}
$points = akilli_lines( $a['points'] );
if ( ! Akilli_Blocks::is_preview() ) {
	Akilli_SEO::add_faq(
		array(
			array(
				'q' => $a['question'],
				'a' => $a['answer'] . ( $points ? ' ' . implode( '. ', $points ) . '.' : '' ),
			),
		)
	);
}
?>
<section class="ak-section ak-answer"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-wrap">
		<div class="ak-answer__box" data-reveal>
			<p class="ak-answer__label"><?php echo akilli_icon( 'spark' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>Kısa cevap</p>
			<h2 class="ak-answer__q"><?php echo esc_html( $a['question'] ); ?></h2>
			<p class="ak-answer__a"><?php echo esc_html( $a['answer'] ); ?></p>
			<?php if ( $points ) : ?>
				<ul class="ak-answer__points">
					<?php foreach ( $points as $pt ) : ?>
						<li><?php echo akilli_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $pt ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<?php if ( ! empty( $a['updated'] ) && get_the_ID() ) : ?>
				<p class="ak-answer__meta">Son güncelleme: <time datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"><?php echo esc_html( get_the_modified_date( 'j F Y' ) ); ?></time> · <?php echo esc_html( akilli_get_setting( 'company_name' ) ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>
