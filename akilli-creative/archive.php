<?php
/**
 * Archives: categories, tags, authors, dates.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;
get_header();
$eyebrow = is_category() ? 'Kategori' : ( is_tag() ? 'Etiket' : ( is_author() ? 'Yazar' : 'Arşiv' ) );
?>
<header class="ak-pagehead">
	<div class="ak-wrap">
		<?php akilli_breadcrumbs(); ?>
		<p class="ak-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
		<h1 class="ak-pagehead__title"><?php echo esc_html( wp_strip_all_tags( get_the_archive_title() ) ); ?></h1>
		<?php
		$desc = is_author() ? get_the_author_meta( 'description', get_queried_object_id() ) : get_the_archive_description();
		if ( $desc ) {
			echo '<div class="ak-pagehead__text">' . wp_kses_post( wpautop( $desc ) ) . '</div>';
		}
		if ( is_category() || is_tag() ) {
			akilli_category_nav();
		}
		?>
	</div>
</header>
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
		<p class="ak-empty">Bu arşivde henüz içerik yok.</p>
	<?php endif; ?>
</div>
<?php
get_footer();
