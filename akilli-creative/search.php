<?php
/**
 * Search results.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;
get_header();
global $wp_query;
$q      = get_search_query();
$labels = array(
	'ak_hizmet' => 'Hizmet',
	'ak_proje'  => 'Proje',
	'post'      => 'Blog',
	'page'      => 'Sayfa',
);
?>
<header class="ak-pagehead">
	<div class="ak-wrap">
		<?php akilli_breadcrumbs(); ?>
		<p class="ak-eyebrow">Arama</p>
		<h1 class="ak-pagehead__title">
			<?php
			if ( '' === trim( $q ) ) {
				echo 'Ne arıyorsunuz?';
			} else {
				/* translators: %s: search query */
				echo esc_html( sprintf( '“%s” için sonuçlar', $q ) );
			}
			?>
		</h1>
		<?php get_search_form(); ?>
		<?php if ( '' !== trim( $q ) ) : ?>
			<p class="ak-pagehead__text" style="margin-top:1rem" role="status"><?php echo esc_html( sprintf( '%d sonuç bulundu.', (int) $wp_query->found_posts ) ); ?></p>
		<?php endif; ?>
	</div>
</header>
<div class="ak-wrap ak-section">
	<?php if ( '' !== trim( $q ) && have_posts() ) : ?>
		<ul class="ak-results-list">
			<?php
			while ( have_posts() ) :
				the_post();
				$type = get_post_type();
				?>
				<li class="ak-result">
					<a href="<?php the_permalink(); ?>">
						<span class="ak-badge ak-result__type"><?php echo esc_html( isset( $labels[ $type ] ) ? $labels[ $type ] : 'İçerik' ); ?></span>
						<span class="ak-result__title"><?php the_title(); ?></span>
						<span class="ak-result__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 26, '…' ) ); ?></span>
					</a>
				</li>
			<?php endwhile; ?>
		</ul>
		<?php akilli_pagination(); ?>
	<?php else : ?>
		<div class="ak-empty" style="text-align:left">
			<?php if ( '' !== trim( $q ) ) : ?>
				<p><strong>Sonuç bulunamadı.</strong> Farklı bir kelime deneyebilir veya aşağıdaki sayfalara göz atabilirsiniz.</p>
			<?php else : ?>
				<p>Hizmetlerimiz, projelerimiz ve blog yazılarımız arasında arama yapabilirsiniz.</p>
			<?php endif; ?>
			<div class="ak-404__links">
				<?php
				foreach ( array( 'hizmetlerimiz' => 'Hizmetlerimiz', 'calismalarimiz' => 'Çalışmalarımız', 'blog' => 'Blog', 'iletisim' => 'İletişim' ) as $path => $label ) {
					$p = get_page_by_path( $path );
					if ( $p ) {
						echo '<a class="ak-chip" href="' . esc_url( get_permalink( $p ) ) . '">' . esc_html( $label ) . '</a>';
					}
				}
				?>
			</div>
		</div>
	<?php endif; ?>
</div>
<?php
get_footer();
