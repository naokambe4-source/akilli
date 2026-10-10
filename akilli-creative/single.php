<?php
/**
 * Blog post.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;
get_header();
while ( have_posts() ) :
	the_post();
	$cats = get_the_category();
	?>
	<div class="ak-progress" data-ak-progress aria-hidden="true"></div>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'ak-article' ); ?>>
		<header class="ak-article-head">
			<div class="ak-wrap">
				<?php akilli_breadcrumbs(); ?>
				<?php if ( $cats ) : ?>
					<a class="ak-badge" href="<?php echo esc_url( get_category_link( $cats[0] ) ); ?>"><?php echo esc_html( $cats[0]->name ); ?></a>
				<?php endif; ?>
				<h1><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p class="ak-pagehead__text"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
				<p class="ak-article-meta">
					<span><?php echo get_avatar( get_the_author_meta( 'ID' ), 28, '', '', array( 'style' => 'border-radius:50%;display:inline-block;vertical-align:middle;margin-right:6px' ) ); ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a></span>
					<?php akilli_post_meta(); ?>
				</p>
			</div>
		</header>
		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="ak-article-cover">
				<?php
				the_post_thumbnail(
					'ak-wide',
					array(
						'loading'       => 'eager',
						'fetchpriority' => 'high',
						'sizes'         => '(max-width: 1240px) 100vw, 1180px',
					)
				);
				?>
			</figure>
		<?php endif; ?>
		<div class="ak-flow ak-prose">
			<?php
			the_content();
			wp_link_pages();
			?>
		</div>
		<footer class="ak-article-foot">
			<?php
			$tags = get_the_tags();
			if ( $tags ) :
				?>
				<ul class="ak-tags" aria-label="Etiketler">
					<?php foreach ( $tags as $t ) : ?>
						<li><a href="<?php echo esc_url( get_tag_link( $t ) ); ?>">#<?php echo esc_html( $t->name ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php
			$service_ids = function_exists( 'akilli_project_service_ids' ) ? akilli_project_service_ids( get_the_ID() ) : array();
			$service_ids = array_filter(
				$service_ids,
				function ( $id ) {
					return 'publish' === get_post_status( $id );
				}
			);
			if ( $service_ids ) :
				?>
				<aside class="ak-related-services" aria-labelledby="ak-rel-svc">
					<h2 id="ak-rel-svc">Bu yazıyla ilgili hizmetlerimiz</h2>
					<ul class="ak-scard-grid" style="grid-template-columns:1fr">
						<?php
						foreach ( $service_ids as $sid ) {
							akilli_service_card( get_post( $sid ), 'h3', false );
						}
						?>
					</ul>
				</aside>
			<?php endif; ?>

			<?php if ( akilli_mod( 'akilli_author_box' ) && get_the_author_meta( 'description' ) ) : ?>
				<div class="ak-author">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 64 ); ?>
					<div>
						<h2><?php the_author(); ?></h2>
						<p><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
					</div>
				</div>
			<?php endif; ?>
		</footer>
	</article>

	<?php
	$related = get_posts(
		array(
			'post_type'           => 'post',
			'numberposts'         => 3,
			'post__not_in'        => array( get_the_ID() ),
			'category__in'        => wp_list_pluck( $cats, 'term_id' ),
			'ignore_sticky_posts' => true,
		)
	);
	if ( count( $related ) < 3 ) {
		$related = array_merge(
			$related,
			get_posts(
				array(
					'post_type'    => 'post',
					'numberposts'  => 3 - count( $related ),
					'post__not_in' => array_merge( array( get_the_ID() ), wp_list_pluck( $related, 'ID' ) ),
				)
			)
		);
	}
	if ( $related ) :
		?>
		<section class="ak-section" aria-labelledby="ak-related-posts">
			<div class="ak-wrap">
				<header class="ak-head">
					<p class="ak-eyebrow">Okumaya devam edin</p>
					<h2 class="ak-title" id="ak-related-posts">İlgili yazılar</h2>
				</header>
				<div class="ak-post-grid">
					<?php
					global $post;
					foreach ( $related as $post ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
						setup_postdata( $post );
						get_template_part( 'template-parts/card', 'post', array( 'heading' => 'h3' ) );
					endforeach;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
endwhile;
get_footer();
