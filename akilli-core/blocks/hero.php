<?php
/**
 * Block: hero — editorial headline + full-bleed "satin" plate.
 * Variables: $a (attributes).
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
$title_html = str_replace( '{kelime}', $rotator, wp_kses( $title, akilli_inline_kses() ) );
$meta       = array_filter( array_map( 'trim', explode( '·', (string) $a['eyebrow'] ) ) );
$romans     = array( 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII' );
?>
<section class="ak-hero ak-hero--<?php echo esc_attr( $visual ); ?>"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-wrap ak-hero__head">
		<?php if ( $meta ) : ?>
			<p class="ak-hero__meta">
				<?php foreach ( $meta as $m ) : ?>
					<span><?php echo esc_html( $m ); ?></span>
				<?php endforeach; ?>
			</p>
		<?php endif; ?>
		<h1 class="ak-hero__title" data-ak-split><?php echo $title_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- kses above. ?></h1>
		<div class="ak-hero__foot">
			<?php if ( $a['text'] ) : ?>
				<p class="ak-hero__text"><?php akilli_inline( $a['text'] ); ?></p>
			<?php endif; ?>
			<div class="ak-hero__actions">
				<?php
				echo akilli_button( $a['btn1_text'], $a['btn1_url'], 'primary' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo akilli_button( $a['btn2_text'], $a['btn2_url'], 'link', 'arrow-down' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</div>
		</div>
	</div>

	<?php if ( 'none' !== $visual ) : ?>
		<figure class="ak-hero__plate" data-ak-plate>
			<div class="ak-hero__visual" aria-hidden="true">
				<?php
				if ( $a['image'] ) {
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
				} else {
					echo '<span class="ak-hero__fallback"></span>';
				}
				if ( 'gl' === $visual ) {
					echo '<canvas class="ak-hero__gl" data-ak-gl></canvas>';
				}
				?>
			</div>
			<figcaption class="ak-hero__caption"><span>Fig. 01</span><span>Ölçüye göre, elde dikilmiş gibi.</span></figcaption>
		</figure>
	<?php endif; ?>

	<?php
	if ( $a['show_services'] ) :
		$tree = akilli_get_service_tree();
		if ( $tree ) :
			?>
			<nav class="ak-wrap ak-hero__services" aria-label="Hizmet disiplinleri">
				<ol>
					<?php
					$i = 0;
					foreach ( $tree as $node ) :
						$p = $node['post'];
						?>
						<li>
							<a href="<?php echo esc_url( get_permalink( $p ) ); ?>">
								<span class="ak-hero__svc-num"><?php echo esc_html( $romans[ $i ] ?? (string) ( $i + 1 ) ); ?></span>
								<span class="ak-hero__svc-name"><?php echo esc_html( get_the_title( $p ) ); ?></span>
								<span class="ak-hero__svc-count"><?php echo esc_html( count( $node['children'] ) . ' hizmet' ); ?></span>
							</a>
						</li>
						<?php
						++$i;
					endforeach;
					?>
				</ol>
			</nav>
			<?php
		endif;
	endif;
	?>
</section>
