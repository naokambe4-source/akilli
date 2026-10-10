<?php
/**
 * Fallback template.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;
get_header();
akilli_page_header( is_archive() ? get_the_archive_title() : get_bloginfo( 'name' ), is_archive() ? get_the_archive_description() : '' );
?>
<div class="ak-wrap ak-section">
	<?php if ( have_posts() ) : ?>
		<div class="ak-post-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/card', 'post', array( 'heading' => 'h2' ) );
			endwhile;
			?>
		</div>
		<?php akilli_pagination(); ?>
	<?php else : ?>
		<p class="ak-empty">Henüz içerik yok.</p>
	<?php endif; ?>
</div>
<?php
get_footer();
