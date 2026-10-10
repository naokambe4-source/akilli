<?php
/**
 * Blog index.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;
get_header();
$blog_id = (int) get_option( 'page_for_posts' );
$title   = $blog_id ? get_the_title( $blog_id ) : 'Blog';
$intro   = $blog_id && has_excerpt( $blog_id ) ? get_the_excerpt( $blog_id ) : 'Web, e-ticaret, SEO ve tasarım üzerine işletmeler için pratik rehberler.';
?>
<header class="ak-pagehead">
	<div class="ak-wrap">
		<?php akilli_breadcrumbs(); ?>
		<p class="ak-eyebrow">Blog</p>
		<h1 class="ak-pagehead__title"><?php echo esc_html( $title ); ?></h1>
		<p class="ak-pagehead__text"><?php echo esc_html( $intro ); ?></p>
		<?php akilli_category_nav(); ?>
	</div>
</header>
<div class="ak-wrap ak-section">
	<?php if ( have_posts() ) : ?>
		<div class="ak-post-grid">
			<?php
			$i = 0;
			while ( have_posts() ) :
				the_post();
				get_template_part(
					'template-parts/card',
					'post',
					array(
						'heading' => 'h2',
						'feature' => 0 === $i && ! is_paged(),
					)
				);
				++$i;
			endwhile;
			?>
		</div>
		<?php akilli_pagination(); ?>
	<?php else : ?>
		<p class="ak-empty">Henüz yazı yayımlanmadı.</p>
	<?php endif; ?>
</div>
<?php
get_footer();
