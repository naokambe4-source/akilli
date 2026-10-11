<?php
/**
 * Service category / service detail.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;
get_header();
while ( have_posts() ) :
	the_post();
	$post_id   = get_the_ID();
	$is_parent = 0 === (int) wp_get_post_parent_id( $post_id );
	$parent_id = $is_parent ? 0 : (int) wp_get_post_parent_id( $post_id );
	$icon      = get_post_meta( $post_id, '_ak_icon', true );
	$children  = $is_parent ? get_children(
		array(
			'post_parent' => $post_id,
			'post_type'   => 'ak_hizmet',
			'post_status' => 'publish',
			'orderby'     => 'menu_order',
			'order'       => 'ASC',
		)
	) : array();
	$quote     = akilli_quote_url( $post_id );
	$wa        = akilli_whatsapp_url( sprintf( 'Merhaba, "%s" hizmetiniz hakkında bilgi almak istiyorum.', get_the_title() ) );
	$anchors   = akilli_content_anchors( get_post() );
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'ak-svc' ); ?>>
		<header class="ak-svc-hero">
			<div class="ak-svc-hero__bg" aria-hidden="true"><span></span><span></span></div>
			<div class="ak-wrap">
				<?php akilli_breadcrumbs(); ?>
				<div class="ak-svc-hero__layout">
					<div>
						<p class="ak-eyebrow"><?php echo esc_html( $is_parent ? 'Hizmet kategorisi' : get_the_title( $parent_id ) ); ?></p>
						<h1 class="ak-svc-hero__title"><?php the_title(); ?></h1>
						<?php if ( has_excerpt() ) : ?>
							<p class="ak-svc-hero__text"><?php echo esc_html( get_the_excerpt() ); ?></p>
						<?php endif; ?>
						<div class="ak-svc-hero__actions">
							<a class="ak-btn ak-btn--primary ak-btn--lg" href="<?php echo esc_url( $quote ); ?>"><span class="ak-btn__label"><?php echo esc_html( $is_parent ? 'Teklif al' : 'Bu hizmet için teklif al' ); ?></span><?php echo akilli_icon( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
							<?php if ( $wa ) : ?>
								<a class="ak-btn ak-btn--link" href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener"><span class="ak-btn__label">WhatsApp’tan sorun</span><?php echo akilli_icon( 'arrow-up-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
							<?php endif; ?>
						</div>
					</div>
					<aside class="ak-svc-card" aria-label="Hizmet özeti">
						<p class="ak-svc-card__label"><?php echo esc_html( $is_parent && $children ? 'Bu disiplinde' : 'Bu sayfada' ); ?></p>
						<ol class="ak-svc-card__list">
							<?php if ( $is_parent && $children ) : ?>
								<?php foreach ( $children as $child ) : ?>
									<li><a href="<?php echo esc_url( get_permalink( $child ) ); ?>"><?php echo esc_html( get_the_title( $child ) ); ?></a></li>
								<?php endforeach; ?>
							<?php else : ?>
								<?php foreach ( $anchors as $aid => $label ) : ?>
									<li><a href="#<?php echo esc_attr( $aid ); ?>"><?php echo esc_html( $label ); ?></a></li>
								<?php endforeach; ?>
							<?php endif; ?>
						</ol>
						<p class="ak-svc-card__note"><?php echo esc_html( $is_parent ? 'Her hizmetin kapsamı, süreci ve sık sorulan soruları kendi sayfasında.' : 'Teklif formunda bu hizmet seçili gelir; bir iş günü içinde dönüş yapıyoruz.' ); ?></p>
					</aside>
				</div>
			</div>
		</header>

		<?php if ( $anchors || $children ) : ?>
			<nav class="ak-subnav" aria-label="Bu sayfada" data-ak-subnav>
				<ul class="ak-wrap">
					<?php if ( $children ) : ?>
						<li><a href="#alt-hizmetler">Hizmetler</a></li>
					<?php endif; ?>
					<?php foreach ( $anchors as $id => $label ) : ?>
						<li><a href="#<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></a></li>
					<?php endforeach; ?>
					<li class="ak-subnav__cta"><a href="<?php echo esc_url( $quote ); ?>">Teklif al</a></li>
				</ul>
			</nav>
		<?php endif; ?>

		<?php if ( $children ) : ?>
			<section class="ak-section" id="alt-hizmetler" aria-labelledby="alt-hizmetler-baslik">
				<div class="ak-wrap">
					<header class="ak-head">
						<p class="ak-eyebrow">Hizmetler</p>
						<h2 class="ak-title" id="alt-hizmetler-baslik"><?php echo esc_html( get_the_title() ); ?> <em>disiplini</em></h2>
					</header>
					<ul class="ak-scard-grid">
						<?php
						foreach ( $children as $child ) {
							akilli_service_card( $child, 'h3', true );
						}
						?>
					</ul>
				</div>
			</section>
		<?php endif; ?>

		<div class="ak-flow ak-prose ak-svc-body">
			<?php the_content(); ?>
		</div>

		<?php
		$projects = function_exists( 'akilli_projects_for_service' ) ? akilli_projects_for_service( $post_id, 3 ) : array();
		if ( $projects ) :
			?>
			<section class="ak-section ak-projects ak-projects--grid" aria-labelledby="ilgili-calismalar">
				<div class="ak-wrap">
					<header class="ak-head">
						<p class="ak-eyebrow">Çalışmalar</p>
						<h2 class="ak-title" id="ilgili-calismalar">İlgili <em>çalışmalar</em></h2>
					</header>
					<div class="ak-pgrid">
						<?php
						foreach ( $projects as $p ) {
							akilli_project_card( $p );
						}
						?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php
		$siblings = $parent_id ? get_children(
			array(
				'post_parent' => $parent_id,
				'post_type'   => 'ak_hizmet',
				'post_status' => 'publish',
				'orderby'     => 'menu_order',
				'order'       => 'ASC',
				'exclude'     => $post_id,
			)
		) : array();
		unset( $siblings[ $post_id ] );
		if ( $siblings ) :
			?>
			<section class="ak-section" aria-labelledby="diger-hizmetler">
				<div class="ak-wrap">
					<header class="ak-head">
						<p class="ak-eyebrow"><?php echo esc_html( get_the_title( $parent_id ) ); ?></p>
						<h2 class="ak-title" id="diger-hizmetler">Bu kategorideki <em>diğer</em> hizmetler</h2>
					</header>
					<ul class="ak-scard-grid">
						<?php
						foreach ( $siblings as $s ) {
							akilli_service_card( $s, 'h3', false );
						}
						?>
					</ul>
				</div>
			</section>
		<?php endif; ?>

		<?php
		$rel_posts = function_exists( 'akilli_posts_for_service' ) ? akilli_posts_for_service( $post_id, 3 ) : array();
		if ( $rel_posts ) :
			?>
			<section class="ak-section" aria-labelledby="ilgili-yazilar">
				<div class="ak-wrap">
					<header class="ak-head">
						<p class="ak-eyebrow">Blog</p>
						<h2 class="ak-title" id="ilgili-yazilar">Konuyla ilgili <em>rehberler</em></h2>
					</header>
					<div class="ak-post-grid">
						<?php
						global $post;
						foreach ( $rel_posts as $post ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
							setup_postdata( $post );
							get_template_part( 'template-parts/card', 'post', array( 'heading' => 'h3' ) );
						endforeach;
						wp_reset_postdata();
						?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<section class="ak-cta" id="teklif">
			<div class="ak-wrap">
				<div class="ak-cta__panel" data-reveal data-ak-pointer>
					<div class="ak-cta__copy">
						<p class="ak-eyebrow">Bir sonraki adım</p>
						<h2 class="ak-cta__title"><?php echo esc_html( get_the_title() ); ?> için <em>teklif</em> alın.</h2>
						<p class="ak-cta__text">Formda bu hizmet seçili gelir. İhtiyacınızı birkaç cümleyle anlatmanız yeterli; en geç bir iş günü içinde dönüş yapıyoruz.</p>
						<div class="ak-cta__actions">
							<a class="ak-btn ak-btn--primary ak-btn--lg" href="<?php echo esc_url( $quote ); ?>"><span class="ak-btn__label">Teklif formuna git</span><?php echo akilli_icon( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
						</div>
						<?php akilli_contact_links(); ?>
					</div>
				</div>
			</div>
		</section>
	</article>
	<?php
endwhile;
get_footer();
