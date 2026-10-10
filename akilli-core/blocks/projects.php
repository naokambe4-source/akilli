<?php
/**
 * Block: projects showcase / filterable portfolio.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

$filters = ! empty( $a['show_filters'] );
$layout  = 'grid' === $a['layout'] ? 'grid' : 'showcase';
$args    = array(
	'post_type'      => 'ak_proje',
	'posts_per_page' => $filters ? 100 : max( 1, (int) $a['count'] ),
	'orderby'        => array(
		'menu_order' => 'ASC',
		'date'       => 'DESC',
	),
	'no_found_rows'  => true,
);
if ( $a['category'] ) {
	$args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		array(
			'taxonomy' => 'ak_proje_kategori',
			'field'    => 'slug',
			'terms'    => sanitize_title( $a['category'] ),
		),
	);
}
$projects = get_posts( $args );
if ( ! $projects ) {
	return;
}

// Active filters (server-side, works without JavaScript).
// phpcs:disable WordPress.Security.NonceVerification.Recommended -- read-only filters.
$active_cat = $filters && isset( $_GET['kategori'] ) ? sanitize_title( wp_unslash( $_GET['kategori'] ) ) : '';
$active_svc = $filters && isset( $_GET['hizmet'] ) ? absint( $_GET['hizmet'] ) : 0;
// phpcs:enable

$cat_terms = array();
$svc_used  = array();
if ( $filters ) {
	foreach ( $projects as $p ) {
		$terms = get_the_terms( $p, 'ak_proje_kategori' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $t ) {
				$cat_terms[ $t->slug ] = $t->name;
			}
		}
		foreach ( akilli_project_service_ids( $p->ID ) as $sid ) {
			$root = akilli_service_root( $sid );
			if ( 'publish' === get_post_status( $root ) ) {
				$svc_used[ $root ] = get_the_title( $root );
			}
		}
	}
	wp_enqueue_script( 'akilli-portfolio' );
}

$base    = remove_query_arg( array( 'kategori', 'hizmet' ) );
$visible = 0;
?>
<section class="ak-section ak-projects ak-projects--<?php echo esc_attr( $layout ); ?>"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-wrap">
		<?php akilli_section_head( $a ); ?>

		<?php if ( $filters && ( count( $cat_terms ) > 1 || count( $svc_used ) > 1 ) ) : ?>
			<div class="ak-filters" data-ak-filters>
				<?php if ( count( $cat_terms ) > 1 ) : ?>
					<div class="ak-filters__group" role="group" aria-label="Kategoriye göre filtrele">
						<span class="ak-filters__label">Kategori</span>
						<a class="ak-chip" href="<?php echo esc_url( add_query_arg( 'hizmet', $active_svc ? $active_svc : false, $base ) ); ?>" data-filter="kategori" data-value="" <?php echo $active_cat ? '' : 'aria-current="true"'; ?>>Tümü</a>
						<?php foreach ( $cat_terms as $slug => $name ) : ?>
							<a class="ak-chip" href="<?php echo esc_url( add_query_arg( array( 'kategori' => $slug, 'hizmet' => $active_svc ? $active_svc : false ), $base ) ); ?>" data-filter="kategori" data-value="<?php echo esc_attr( $slug ); ?>" <?php echo $active_cat === $slug ? 'aria-current="true"' : ''; ?>><?php echo esc_html( $name ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<?php if ( count( $svc_used ) > 1 ) : ?>
					<div class="ak-filters__group" role="group" aria-label="Hizmete göre filtrele">
						<span class="ak-filters__label">Hizmet</span>
						<a class="ak-chip" href="<?php echo esc_url( add_query_arg( 'kategori', $active_cat ? $active_cat : false, $base ) ); ?>" data-filter="hizmet" data-value="" <?php echo $active_svc ? '' : 'aria-current="true"'; ?>>Tümü</a>
						<?php foreach ( $svc_used as $sid => $name ) : ?>
							<a class="ak-chip" href="<?php echo esc_url( add_query_arg( array( 'hizmet' => $sid, 'kategori' => $active_cat ? $active_cat : false ), $base ) ); ?>" data-filter="hizmet" data-value="<?php echo esc_attr( $sid ); ?>" <?php echo $active_svc === $sid ? 'aria-current="true"' : ''; ?>><?php echo esc_html( $name ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<p class="ak-filters__status" role="status" aria-live="polite" data-ak-filter-status></p>
			</div>
		<?php endif; ?>

		<div class="ak-pgrid" data-ak-pgrid>
			<?php
			foreach ( $projects as $i => $p ) {
				$hide = false;
				if ( $active_cat && ! has_term( $active_cat, 'ak_proje_kategori', $p ) ) {
					$hide = true;
				}
				if ( $active_svc ) {
					$roots = array_map( 'akilli_service_root', akilli_project_service_ids( $p->ID ) );
					if ( ! in_array( $active_svc, $roots, true ) ) {
						$hide = true;
					}
				}
				if ( $hide ) {
					continue;
				}
				++$visible;
				akilli_project_card(
					$p,
					array(
						'class' => 'showcase' === $layout && 0 === $i ? 'ak-pcard--feature' : '',
						'size'    => 'large',
						'heading' => $a['title'] ? 'h3' : 'h2',
					)
				);
			}
			?>
		</div>
		<p class="ak-empty" data-ak-empty<?php echo $visible ? ' hidden' : ''; ?>>Bu filtreye uygun proje bulunamadı. <a href="<?php echo esc_url( $base ); ?>" data-ak-reset>Tüm projeleri göster</a></p>

		<?php if ( $a['btn1_text'] ) : ?>
			<div class="ak-section__foot"><?php echo akilli_button( $a['btn1_text'], $a['btn1_url'], 'ghost' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
		<?php endif; ?>
	</div>
	<?php if ( $filters && ( $active_cat || $active_svc ) ) : ?>
		<template data-ak-all-projects>
			<?php
			// Full set for client-side filtering (cards removed by server filters).
			foreach ( $projects as $p ) {
				akilli_project_card( $p, array( 'size' => 'large', 'heading' => $a['title'] ? 'h3' : 'h2' ) );
			}
			?>
		</template>
	<?php endif; ?>
</section>
