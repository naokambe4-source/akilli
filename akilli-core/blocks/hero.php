<?php
/**
 * Block: hero — bold headline, proof chips and floating cards.
 * Variables: $a (attributes).
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

$words  = akilli_lines( $a['words'] );
$title  = (string) $a['title'];
$visual = in_array( $a['visual'], array( 'cards', 'gl', 'image', 'none' ), true ) ? $a['visual'] : 'cards';
if ( 'gl' === $visual ) {
	wp_enqueue_script( 'akilli-hero-gl' );
}
$rotator = '';
if ( $words && false !== strpos( $title, '{kelime}' ) ) {
	$rotator = '<span class="ak-rotator" data-ak-rotator data-words="' . esc_attr( wp_json_encode( $words ) ) . '" aria-hidden="true"><span class="ak-rotator__word">' . esc_html( $words[0] ) . '</span></span><span class="screen-reader-text">' . esc_html( implode( ', ', $words ) ) . '</span>';
}
$title_html = str_replace( '{kelime}', $rotator, wp_kses( $title, akilli_inline_kses() ) );
$chips      = akilli_lines( $a['chips'] );
$cards      = array_values(
	array_filter(
		(array) $a['cards'],
		function ( $c ) {
			return ! empty( $c['image'] ) || ! empty( $c['title'] );
		}
	)
);
$positions  = array( 'tl', 'bl', 'tr', 'br', 'ml', 'mr' );
?>
<section class="ak-hero ak-hero--<?php echo esc_attr( $visual ); ?>"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?> data-ak-hero>
	<div class="ak-hero__glow" aria-hidden="true"></div>

	<?php if ( 'cards' === $visual && $cards ) : ?>
		<div class="ak-hero__cards" aria-hidden="true">
			<?php foreach ( array_slice( $cards, 0, 6 ) as $i => $c ) : ?>
				<div class="ak-fcard ak-fcard--<?php echo esc_attr( $positions[ $i ] ); ?>" style="--d:<?php echo esc_attr( ( $i % 2 ? -1 : 1 ) * ( 14 + $i * 6 ) ); ?>px;--t:<?php echo esc_attr( 5 + $i ); ?>s;--r:<?php echo esc_attr( $i % 2 ? 4 : -4 ); ?>deg" data-ak-float>
					<?php if ( ! empty( $c['image'] ) ) : ?>
						<div class="ak-fcard__img"><?php echo wp_get_attachment_image( (int) $c['image'], 'medium_large', false, array( 'loading' => 0 === $i ? 'eager' : 'lazy', 'alt' => '', 'sizes' => '240px' ) ); ?></div>
					<?php endif; ?>
					<?php if ( ! empty( $c['title'] ) || ! empty( $c['text'] ) ) : ?>
						<div class="ak-fcard__cap">
							<?php if ( ! empty( $c['title'] ) ) : ?>
								<strong><?php echo esc_html( $c['title'] ); ?></strong>
							<?php endif; ?>
							<?php if ( ! empty( $c['text'] ) ) : ?>
								<span><?php echo esc_html( $c['text'] ); ?></span>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<div class="ak-wrap ak-hero__head">
		<?php if ( $a['eyebrow'] ) : ?>
			<p class="ak-hero__badge"><span class="ak-pulse" aria-hidden="true"></span><?php echo esc_html( $a['eyebrow'] ); ?></p>
		<?php endif; ?>
		<h1 class="ak-hero__title" data-ak-split><?php echo $title_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- kses above. ?></h1>
		<?php if ( $a['text'] ) : ?>
			<p class="ak-hero__text"><?php akilli_inline( $a['text'] ); ?></p>
		<?php endif; ?>
		<div class="ak-hero__actions">
			<?php
			echo akilli_button( $a['btn1_text'], $a['btn1_url'], 'primary' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo akilli_button( $a['btn2_text'], $a['btn2_url'], 'ghost', 'arrow-down' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</div>
		<?php if ( $chips ) : ?>
			<ul class="ak-hero__chips">
				<?php foreach ( $chips as $chip ) : ?>
					<li><?php echo akilli_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $chip ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>

	<?php if ( in_array( $visual, array( 'gl', 'image' ), true ) ) : ?>
		<figure class="ak-hero__plate" data-ak-plate>
			<div class="ak-hero__visual" aria-hidden="true">
				<?php
				if ( $a['image'] ) {
					echo wp_get_attachment_image( (int) $a['image'], 'full', false, array( 'class' => 'ak-hero__img', 'loading' => 'eager', 'fetchpriority' => 'high', 'sizes' => '100vw', 'alt' => '' ) );
				}
				if ( 'gl' === $visual ) {
					echo '<canvas class="ak-hero__gl" data-ak-gl></canvas>';
				}
				?>
			</div>
		</figure>
	<?php endif; ?>

	<?php
	if ( $a['show_services'] ) :
		$tree = akilli_get_service_tree();
		if ( $tree ) :
			?>
			<nav class="ak-wrap ak-hero__services" aria-label="Hizmet disiplinleri">
				<ul>
					<?php
					foreach ( $tree as $node ) :
						$p    = $node['post'];
						$icon = get_post_meta( $p->ID, '_ak_icon', true );
						?>
						<li>
							<a href="<?php echo esc_url( get_permalink( $p ) ); ?>">
								<span class="ak-hero__svc-icon" aria-hidden="true"><?php echo akilli_icon( $icon ? $icon : 'spark' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
								<span class="ak-hero__svc-name"><?php echo esc_html( get_the_title( $p ) ); ?></span>
								<span class="ak-hero__svc-count"><?php echo esc_html( count( $node['children'] ) . ' hizmet' ); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>
			<?php
		endif;
	endif;
	?>
</section>
