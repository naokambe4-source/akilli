<?php
/**
 * Project detail — layered, scroll-driven story.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;
get_header();
while ( have_posts() ) :
	the_post();
	$pid      = get_the_ID();
	$m        = function ( $k ) use ( $pid ) {
		return (string) get_post_meta( $pid, '_ak_' . $k, true );
	};
	$accent   = $m( 'accent' );
	$services = function_exists( 'akilli_project_service_names' ) ? akilli_project_service_names( $pid ) : array();
	$stack    = array_filter( array_map( 'trim', explode( ',', $m( 'stack' ) ) ) );
	$terms    = get_the_terms( $pid, 'ak_proje_kategori' );
	$gallery  = array_filter( array_map( 'absint', explode( ',', $m( 'gallery' ) ) ) );
	$results  = $m( 'results_verified' ) ? array_filter( array_map( 'trim', preg_split( '/\r\n|\n/', $m( 'results' ) ) ) ) : array();
	$first    = $services ? array_key_first( $services ) : 0;
	$story    = array(
		array( 'İhtiyaç', 'İhtiyaç ve hedef', $m( 'need' ) ),
		array( 'Çözüm', 'Sunduğumuz çözüm', $m( 'solution' ) ),
	);
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'ak-proj' ); ?><?php echo $accent ? ' style="--accent:' . esc_attr( $accent ) . '"' : ''; ?>>
		<header class="ak-proj-hero">
			<div class="ak-wrap">
				<?php akilli_breadcrumbs(); ?>
				<div class="ak-proj-hero__top">
					<?php if ( $m( 'is_demo' ) ) : ?>
						<span class="ak-badge ak-badge--demo">Örnek çalışma — gerçek bir müşteri projesi değildir</span>
					<?php endif; ?>
					<?php
					if ( $terms && ! is_wp_error( $terms ) ) {
						foreach ( $terms as $t ) {
							echo '<a class="ak-badge" href="' . esc_url( get_term_link( $t ) ) . '">' . esc_html( $t->name ) . '</a>';
						}
					}
					?>
				</div>
				<h1 class="ak-proj-hero__title"><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p class="ak-proj-hero__text"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
				<dl class="ak-facts">
					<?php if ( $m( 'client' ) ) : ?>
						<div><dt>Müşteri</dt><dd><?php echo esc_html( $m( 'client' ) ); ?></dd></div>
					<?php endif; ?>
					<?php if ( $m( 'sector' ) ) : ?>
						<div><dt>Sektör</dt><dd><?php echo esc_html( $m( 'sector' ) ); ?></dd></div>
					<?php endif; ?>
					<?php if ( $services ) : ?>
						<div><dt>Verilen hizmetler</dt><dd>
							<?php
							$links = array();
							foreach ( $services as $sid => $name ) {
								$links[] = '<a href="' . esc_url( get_permalink( $sid ) ) . '">' . esc_html( $name ) . '</a>';
							}
							echo implode( ', ', $links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
						</dd></div>
					<?php endif; ?>
					<?php if ( $m( 'year' ) ) : ?>
						<div><dt>Yıl</dt><dd><?php echo esc_html( $m( 'year' ) ); ?></dd></div>
					<?php endif; ?>
					<?php if ( $m( 'url' ) ) : ?>
						<div><dt>Bağlantı</dt><dd><a href="<?php echo esc_url( $m( 'url' ) ); ?>" target="_blank" rel="noopener">Siteyi ziyaret et <span class="screen-reader-text">(yeni sekmede açılır)</span>↗</a></dd></div>
					<?php endif; ?>
				</dl>
			</div>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="ak-proj-cover" style="view-transition-name: proje-<?php echo (int) $pid; ?>">
				<?php
				the_post_thumbnail(
					'ak-wide',
					array(
						'loading'       => 'eager',
						'fetchpriority' => 'high',
						'sizes'         => '(max-width: 1680px) 100vw, 1600px',
					)
				);
				?>
			</figure>
		<?php endif; ?>

		<div class="ak-wrap ak-story">
			<?php
			$n = 0;
			foreach ( $story as $row ) :
				if ( '' === trim( $row[2] ) ) {
					continue;
				}
				++$n;
				?>
				<section class="ak-story__row" data-reveal>
					<p class="ak-story__label"><span aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $n ) ); ?></span><?php echo esc_html( $row[0] ); ?></p>
					<div>
						<h2><?php echo esc_html( $row[1] ); ?></h2>
						<p><?php echo esc_html( $row[2] ); ?></p>
					</div>
				</section>
			<?php endforeach; ?>

			<?php if ( $stack ) : ?>
				<?php ++$n; ?>
				<section class="ak-story__row" data-reveal>
					<p class="ak-story__label"><span aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $n ) ); ?></span>Altyapı</p>
					<div>
						<h2>Kullanılan altyapı</h2>
						<ul class="ak-tags">
							<?php foreach ( $stack as $s ) : ?>
								<li><?php echo esc_html( $s ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</section>
			<?php endif; ?>

			<?php if ( $results ) : ?>
				<?php ++$n; ?>
				<section class="ak-story__row" data-reveal>
					<p class="ak-story__label"><span aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $n ) ); ?></span>Sonuçlar</p>
					<div>
						<h2>Doğrulanmış sonuçlar</h2>
						<ul class="ak-results">
							<?php foreach ( $results as $r ) : ?>
								<li><?php echo akilli_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $r ); ?></span></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</section>
			<?php endif; ?>

			<?php if ( trim( get_the_content() ) ) : ?>
				<section class="ak-story__row">
					<p class="ak-story__label">Notlar</p>
					<div class="ak-prose"><?php the_content(); ?></div>
				</section>
			<?php endif; ?>
		</div>

		<?php
		$video = $m( 'video' );
		if ( $video ) :
			$embed = '';
			if ( preg_match( '~(?:youtube\.com/(?:watch\?v=|embed/|shorts/)|youtu\.be/)([\w-]{11})~', $video, $yt ) ) {
				$embed = 'https://www.youtube-nocookie.com/embed/' . $yt[1] . '?autoplay=1&rel=0';
			} elseif ( preg_match( '~vimeo\.com/(\d+)~', $video, $vm ) ) {
				$embed = 'https://player.vimeo.com/video/' . $vm[1] . '?autoplay=1&dnt=1';
			}
			?>
			<div class="ak-wrap">
				<div class="ak-video">
					<?php if ( $embed ) : ?>
						<button type="button" class="ak-video__btn" data-ak-video="<?php echo esc_url( $embed ); ?>" data-title="<?php echo esc_attr( get_the_title() . ' videosu' ); ?>">
							<span><?php echo akilli_icon( 'play' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>Videoyu oynat</span>
						</button>
						<noscript><a href="<?php echo esc_url( $video ); ?>">Videoyu izleyin</a></noscript>
					<?php else : ?>
						<video controls preload="none" playsinline <?php echo has_post_thumbnail() ? 'poster="' . esc_url( get_the_post_thumbnail_url( null, 'large' ) ) . '"' : ''; ?>>
							<source src="<?php echo esc_url( $video ); ?>">
						</video>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $gallery ) : ?>
			<section class="ak-wrap ak-gallery" aria-label="Proje galerisi" data-ak-gallery>
				<?php foreach ( $gallery as $i => $att ) : ?>
					<?php
					$full    = wp_get_attachment_image_url( $att, 'full' );
					$caption = wp_get_attachment_caption( $att );
					$alt     = get_post_meta( $att, '_wp_attachment_image_alt', true );
					if ( ! $full ) {
						continue;
					}
					?>
					<figure class="ak-gallery__item" data-speed="<?php echo esc_attr( 0 === $i % 3 && count( $gallery ) > 2 ? '0' : ( 1 === $i % 3 ? '-0.035' : '0.045' ) ); ?>">
						<a class="ak-gallery__btn" href="<?php echo esc_url( $full ); ?>" data-ak-lightbox>
							<?php echo wp_get_attachment_image( $att, 'large', false, array( 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 100vw, 50vw' ) ); ?>
							<span class="screen-reader-text">Görseli büyüt: <?php echo esc_html( $alt ); ?></span>
						</a>
						<?php if ( $caption ) : ?>
							<figcaption><?php echo esc_html( $caption ); ?></figcaption>
						<?php endif; ?>
					</figure>
				<?php endforeach; ?>
			</section>
		<?php endif; ?>

		<section class="ak-cta">
			<div class="ak-wrap">
				<div class="ak-cta__panel" data-reveal data-ak-pointer>
					<div class="ak-cta__layers" aria-hidden="true"><span></span><span></span><span></span></div>
					<div class="ak-cta__copy">
						<p class="ak-eyebrow">Benzer bir proje mi?</p>
						<h2 class="ak-cta__title">Sizin için de <em>kurgulayalım</em>.</h2>
						<p class="ak-cta__text">Hedefinizi ve mevcut durumunuzu anlatın; size uygun kapsamı ve yol haritasını birlikte çıkaralım.</p>
						<div class="ak-cta__actions">
							<a class="ak-btn ak-btn--primary ak-btn--lg" href="<?php echo esc_url( akilli_quote_url( $first ? $first : null ) ); ?>"><span class="ak-btn__label">Teklif al</span><?php echo akilli_icon( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
							<?php
							$works = (int) get_option( 'akilli_page_calismalar' );
							if ( $works ) :
								?>
								<a class="ak-btn ak-btn--ghost ak-btn--lg" href="<?php echo esc_url( get_permalink( $works ) ); ?>"><span class="ak-btn__label">Tüm çalışmalar</span></a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</section>

		<?php
		$related_args = array(
			'post_type'    => 'ak_proje',
			'numberposts'  => 2,
			'post__not_in' => array( $pid ),
		);
		if ( $terms && ! is_wp_error( $terms ) ) {
			$related_args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				array(
					'taxonomy' => 'ak_proje_kategori',
					'terms'    => wp_list_pluck( $terms, 'term_id' ),
				),
			);
		}
		$related = get_posts( $related_args );
		if ( count( $related ) < 2 ) {
			$related = array_merge(
				$related,
				get_posts(
					array(
						'post_type'    => 'ak_proje',
						'numberposts'  => 2 - count( $related ),
						'post__not_in' => array_merge( array( $pid ), wp_list_pluck( $related, 'ID' ) ),
					)
				)
			);
		}
		if ( $related ) :
			?>
			<section class="ak-section ak-projects" aria-labelledby="ilgili-projeler">
				<div class="ak-wrap">
					<header class="ak-head">
						<p class="ak-eyebrow">Sıradaki</p>
						<h2 class="ak-title" id="ilgili-projeler">İlgili <em>projeler</em></h2>
					</header>
					<div class="ak-pgrid">
						<?php
						foreach ( $related as $p ) {
							akilli_project_card( $p );
						}
						?>
					</div>
				</div>
			</section>
		<?php endif; ?>
	</article>
	<?php
endwhile;
get_footer();
