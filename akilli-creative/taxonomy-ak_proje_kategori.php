<?php
/**
 * Project category archive.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;
get_header();
$term = get_queried_object();
akilli_page_header( single_term_title( '', false ), term_description(), 'Çalışmalar' );
?>
<section class="ak-section ak-projects ak-projects--grid">
	<div class="ak-wrap">
		<?php
		$works = (int) get_option( 'akilli_page_calismalar' );
		if ( $works ) {
			echo '<p><a class="ak-btn ak-btn--link" href="' . esc_url( add_query_arg( 'kategori', $term->slug, get_permalink( $works ) ) ) . '"><span class="ak-btn__label">Tüm çalışmaları filtreleyerek görüntüle</span>' . akilli_icon( 'arrow-right' ) . '</a></p>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
		<?php if ( have_posts() ) : ?>
			<div class="ak-pgrid">
				<?php
				while ( have_posts() ) :
					the_post();
					akilli_project_card( get_post(), array( 'heading' => 'h2' ) );
				endwhile;
				?>
			</div>
			<?php akilli_pagination(); ?>
		<?php else : ?>
			<p class="ak-empty">Bu kategoride henüz proje yok.</p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
