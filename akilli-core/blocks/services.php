<?php
/**
 * Block: services explorer / grid.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
$tree = akilli_get_service_tree();
if ( ! $tree ) {
	return;
}
$uid    = 'aksvc-' . substr( md5( wp_json_encode( $a ) ), 0, 6 );
$layout = 'grid' === $a['layout'] ? 'grid' : 'explorer';
?>
<section class="ak-section ak-services ak-services--<?php echo esc_attr( $layout ); ?>"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-wrap">
		<?php akilli_section_head( $a ); ?>

		<?php if ( 'explorer' === $layout ) : ?>
			<div class="ak-explorer" data-ak-tabs>
				<ul class="ak-explorer__index" data-ak-tablist>
					<?php
					$n = 0;
					foreach ( $tree as $node ) :
						++$n;
						$p = $node['post'];
						?>
						<li>
							<a class="ak-explorer__tab" href="#<?php echo esc_attr( $uid . '-' . $p->ID ); ?>" id="<?php echo esc_attr( $uid . '-tab-' . $p->ID ); ?>" data-ak-tab>
								<span class="ak-explorer__num"><?php echo esc_html( array( 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII' )[ $n - 1 ] ?? $n ); ?></span>
								<span class="ak-explorer__name"><?php echo esc_html( get_the_title( $p ) ); ?></span>
								<span class="ak-explorer__count"><?php echo esc_html( count( $node['children'] ) ); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
				<div class="ak-explorer__panels">
					<?php
					foreach ( $tree as $node ) :
						$p    = $node['post'];
						$icon = get_post_meta( $p->ID, '_ak_icon', true );
						?>
						<div class="ak-explorer__panel" id="<?php echo esc_attr( $uid . '-' . $p->ID ); ?>" data-ak-panel>
							<div class="ak-explorer__intro">
								<h3 class="ak-explorer__title"><a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><?php echo esc_html( get_the_title( $p ) ); ?></a></h3>
								<?php if ( has_excerpt( $p ) ) : ?>
									<p><?php echo esc_html( get_the_excerpt( $p ) ); ?></p>
								<?php endif; ?>
								<?php echo akilli_button( get_the_title( $p ) . ' hizmetlerini incele', get_permalink( $p ), 'link' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
							<?php if ( $node['children'] ) : ?>
								<ul class="ak-explorer__list">
									<?php
									foreach ( $node['children'] as $child ) {
										akilli_service_card( $child, 'h4', false );
									}
									?>
								</ul>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php else : ?>
			<div class="ak-svc-grid">
				<?php
				$n = 0;
				foreach ( $tree as $node ) :
					++$n;
					$p    = $node['post'];
					$icon = get_post_meta( $p->ID, '_ak_icon', true );
					?>
					<section class="ak-svc-group" data-reveal aria-labelledby="<?php echo esc_attr( $uid . '-g-' . $p->ID ); ?>">
						<header class="ak-svc-group__head">
							<span class="ak-svc-group__num"><?php echo esc_html( array( 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII' )[ $n - 1 ] ?? $n ); ?></span>
							<h3 id="<?php echo esc_attr( $uid . '-g-' . $p->ID ); ?>"><a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><?php echo esc_html( get_the_title( $p ) ); ?></a></h3>
							<?php if ( has_excerpt( $p ) ) : ?>
								<p><?php echo esc_html( get_the_excerpt( $p ) ); ?></p>
							<?php endif; ?>
						</header>
						<ul class="ak-svc-group__list">
							<?php foreach ( $node['children'] as $child ) : ?>
								<li><a href="<?php echo esc_url( get_permalink( $child ) ); ?>"><span><?php echo esc_html( get_the_title( $child ) ); ?></span><?php echo akilli_icon( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></li>
							<?php endforeach; ?>
						</ul>
					</section>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $a['btn1_text'] ) : ?>
			<div class="ak-section__foot"><?php echo akilli_button( $a['btn1_text'], $a['btn1_url'], 'ghost' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
		<?php endif; ?>
	</div>
</section>
