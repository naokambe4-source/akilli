<?php
/**
 * Blog post card.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;
$heading = isset( $args['heading'] ) && in_array( $args['heading'], array( 'h2', 'h3' ), true ) ? $args['heading'] : 'h3';
$feature = ! empty( $args['feature'] );
$cats    = get_the_category();
?>
<article <?php post_class( 'ak-post-card' . ( $feature ? ' ak-post-card--feature' : '' ) ); ?>>
	<div class="ak-post-card__media">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail(
				$feature ? 'large' : 'ak-card',
				array(
					'loading' => $feature ? 'eager' : 'lazy',
					'sizes'   => $feature ? '(max-width: 900px) 100vw, 60vw' : '(max-width: 700px) 100vw, (max-width: 1100px) 50vw, 420px',
					'alt'     => '',
				)
			);
		}
		?>
	</div>
	<div class="ak-post-card__body">
		<?php if ( $cats ) : ?>
			<a class="ak-badge ak-post-card__cat" href="<?php echo esc_url( get_category_link( $cats[0] ) ); ?>"><?php echo esc_html( $cats[0]->name ); ?></a>
		<?php endif; ?>
		<<?php echo tag_escape( $heading ); ?> class="ak-post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo tag_escape( $heading ); ?>>
		<p class="ak-post-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<p class="ak-post-card__meta"><?php akilli_post_meta(); ?></p>
	</div>
</article>
