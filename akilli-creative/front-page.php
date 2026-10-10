<?php
/**
 * Front page: renders the page content (blocks). Falls back to the blog list.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;
if ( 'posts' === get_option( 'show_on_front' ) ) {
	include get_home_template();
	return;
}
get_header();
while ( have_posts() ) :
	the_post();
	if ( ! akilli_has_hero() ) {
		akilli_page_header( get_the_title(), get_the_excerpt() );
	}
	?>
	<div class="ak-flow ak-prose">
		<?php the_content(); ?>
	</div>
	<?php
endwhile;
get_footer();
