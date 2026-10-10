<?php
/**
 * Block: hero. Variables: $a (attributes).
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

$words  = akilli_lines( $a['words'] );
$title  = (string) $a['title'];
$visual = in_array( $a['visual'], array( 'gl', 'image', 'none' ), true ) ? $a['visual'] : 'gl';
if ( 'gl' === $visual ) {
	wp_enqueue_script( 'akilli-hero-gl' );
}
$rotator = '';
if ( $words && false !== strpos( $title, '{kelime}' ) ) {
	$rotator = '<span class="ak-rotator" data-ak-rotator data-words="' . esc_attr( wp_json_encode( $words ) ) . '" aria-hidden="true"><span class="ak-rotator__word">' . esc_html( $words[0] ) . '</span></span><span class="screen-reader-text">' . esc_html( implode( ', ', $words ) ) . '</span>';
}
$title_html = wp_kses( $title, akilli_inline_kses() );
$title_html = str_replace( '{kelime}', '%%ROT%%', $title_html );
$title_html = str_replace( '%%ROT%%', $rotator, $title_html );
?>
<section class="ak-hero ak-hero--<?php echo esc_attr( $visual ); ?>"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-hero__visual" aria-hidden="true">
		<div class="ak-hero__orbs"><span></span><span></span><span></span></div>
		<?php if ( 'gl' === $visual ) : ?>
			<canvas class="ak-hero__gl" data-ak-gl></canvas>
		<?php endif; ?>
		<?php
		if ( 'image' === $visual && $a['image'] ) {
			echo wp_get_attachment_image(
				(int) $a['image'],
				'full',
				false,
				array(
					'class'         => 'ak-hero__img',
					'loading'       => 'eager',
					'fetchpriority' => 'high',
					'sizes'         => '100vw',
					'alt'           => '',
				)
			);
		}
		?>
		<div class="ak-hero__grain"></div>
	</div>
	<div class="ak-wrap ak-hero__inner">
		<?php if ( $a['eyebrow'] ) : ?>
			<p class="ak-eyebrow ak-hero__eyebrow"><span class="ak-pulse"></span><?php echo esc_html( $a['eyebrow'] ); ?></p>
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
		<?php
		if ( $a['show_services'] ) :
			$tree = akilli_get_service_tree();
			if ( $tree ) :
				?>
				<nav class="ak-hero__services" aria-label="Hizmet kategorileri">
					<ul>
						<?php
						$i = 0;
						foreach ( $tree as $node ) :
							++$i;
							$p    = $node['post'];
							$icon = get_post_meta( $p->ID, '_ak_icon', true );
							?>
							<li style="--i:<?php echo (int) $i; ?>">
								<a href="<?php echo esc_url( get_permalink( $p ) ); ?>">
									<span class="ak-hero__svc-icon"><?php echo akilli_icon( $icon ? $icon : 'spark' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
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
	</div>
</section>
