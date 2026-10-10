<?php
/**
 * 404.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<section class="ak-404" data-ak-pointer>
	<div class="ak-phero__bg" aria-hidden="true"><span></span><span></span></div>
	<div class="ak-wrap">
		<p class="ak-404__num" aria-hidden="true"><span>4</span><span>0</span><span>4</span></p>
		<h1>Bu sayfa başka bir katmanda kaldı.</h1>
		<p class="ak-pagehead__text">Aradığınız sayfa taşınmış, adı değişmiş ya da hiç var olmamış olabilir. Aşağıdan arama yapabilir veya en çok ziyaret edilen sayfalara geçebilirsiniz.</p>
		<?php get_search_form(); ?>
		<div class="ak-404__links">
			<a class="ak-btn ak-btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="ak-btn__label">Ana sayfaya dön</span><?php echo akilli_icon( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			<?php
			foreach ( array( 'hizmetlerimiz' => 'Hizmetlerimiz', 'calismalarimiz' => 'Çalışmalarımız', 'teklif-al' => 'Teklif al', 'iletisim' => 'İletişim' ) as $path => $label ) {
				$p = get_page_by_path( $path );
				if ( $p ) {
					echo '<a class="ak-chip" href="' . esc_url( get_permalink( $p ) ) . '">' . esc_html( $label ) . '</a>';
				}
			}
			?>
		</div>
	</div>
</section>
<?php
get_footer();
