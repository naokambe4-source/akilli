<?php
/**
 * Page.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;
get_header();
while ( have_posts() ) :
	the_post();
	$hero = akilli_has_hero();
	if ( ! $hero ) {
		akilli_page_header( get_the_title(), has_excerpt() ? get_the_excerpt() : '' );
	}
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="ak-flow ak-prose<?php echo $hero ? '' : ' ak-page-body'; ?>">
			<?php
			the_content();
			wp_link_pages(
				array(
					'before' => '<nav class="ak-pagination" aria-label="Sayfa bölümleri"><div class="nav-links">',
					'after'  => '</div></nav>',
				)
			);
			?>
		</div>
	</article>
	<?php
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
endwhile;
get_footer();
