<?php
/**
 * Block: latest posts.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
$args = array(
	'post_type'           => 'post',
	'posts_per_page'      => max( 1, min( 12, (int) $a['count'] ) ),
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);
if ( $a['category'] ) {
	$args['category_name'] = sanitize_title( $a['category'] );
}
$q = new WP_Query( $args );
if ( ! $q->have_posts() ) {
	return;
}
?>
<section class="ak-section ak-posts"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-wrap">
		<div class="ak-posts__head">
			<?php akilli_section_head( $a ); ?>
			<?php echo akilli_button( $a['btn1_text'], $a['btn1_url'], 'ghost' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<div class="ak-post-grid">
			<?php
			foreach ( $q->posts as $p ) {
				akilli_post_card( $p, 'h3' );
			}
			?>
		</div>
	</div>
</section>
