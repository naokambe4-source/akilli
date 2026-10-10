<?php
/**
 * Block: reference logos. Renders nothing when there are no references.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
$refs = get_posts(
	array(
		'post_type'   => 'ak_referans',
		'numberposts' => 100,
		'orderby'     => array(
			'menu_order' => 'ASC',
			'title'      => 'ASC',
		),
	)
);
$refs = array_filter( $refs, 'has_post_thumbnail' );
if ( ! $refs ) {
	return;
}
$layout = 'marquee' === $a['layout'] && count( $refs ) > 4 ? 'marquee' : 'grid';
$list   = function ( $hidden ) use ( $refs ) {
	echo '<ul class="ak-refs__list"' . ( $hidden ? ' aria-hidden="true"' : '' ) . '>';
	foreach ( $refs as $r ) {
		$url  = get_post_meta( $r->ID, '_ak_ref_url', true );
		$img  = get_the_post_thumbnail(
			$r,
			'medium',
			array(
				'alt'     => get_the_title( $r ),
				'loading' => 'lazy',
			)
		);
		$attr = $hidden ? ' tabindex="-1"' : '';
		echo '<li>' . ( $url ? '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener nofollow"' . $attr . '>' . $img . '</a>' : $img ) . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	echo '</ul>';
};
?>
<section class="ak-section ak-refs ak-refs--<?php echo esc_attr( $layout ); ?>"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-wrap">
		<?php akilli_section_head( $a ); ?>
		<div class="ak-refs__track">
			<?php
			$list( false );
			if ( 'marquee' === $layout ) {
				$list( true );
			}
			?>
		</div>
	</div>
</section>
