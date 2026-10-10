<?php
/**
 * Front-end template functions shared by blocks and the theme.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Top-level service ancestor for a service ID.
 *
 * @param int $id Service ID.
 * @return int
 */
function akilli_service_root( $id ) {
	$anc = get_post_ancestors( $id );
	return $anc ? (int) end( $anc ) : (int) $id;
}

/**
 * Service names attached to a project.
 *
 * @param int $post_id Project.
 * @return string[] id => title
 */
function akilli_project_service_names( $post_id ) {
	$out = array();
	foreach ( akilli_project_service_ids( $post_id ) as $sid ) {
		if ( 'publish' === get_post_status( $sid ) ) {
			$label       = get_post_meta( $sid, '_ak_menu_label', true );
			$out[ $sid ] = $label ? $label : get_the_title( $sid );
		}
	}
	return $out;
}

/**
 * Project card.
 *
 * @param WP_Post|int $post Project.
 * @param array       $args heading (h2|h3), size (image size), eager (bool), class.
 */
function akilli_project_card( $post, $args = array() ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return;
	}
	$args     = wp_parse_args(
		$args,
		array(
			'heading' => 'h3',
			'size'    => 'large',
			'eager'   => false,
			'class'   => '',
		)
	);
	$services = akilli_project_service_names( $post->ID );
	$roots    = array();
	foreach ( array_keys( $services ) as $sid ) {
		$roots[] = $sid;
		$roots[] = akilli_service_root( $sid );
	}
	$terms  = get_the_terms( $post, 'ak_proje_kategori' );
	$slugs  = $terms && ! is_wp_error( $terms ) ? wp_list_pluck( $terms, 'slug' ) : array();
	$names  = $terms && ! is_wp_error( $terms ) ? wp_list_pluck( $terms, 'name' ) : array();
	$accent = get_post_meta( $post->ID, '_ak_accent', true );
	$demo   = get_post_meta( $post->ID, '_ak_is_demo', true );
	$sector = get_post_meta( $post->ID, '_ak_sector', true );
	$tag    = in_array( $args['heading'], array( 'h2', 'h3' ), true ) ? $args['heading'] : 'h3';
	?>
	<article class="ak-pcard <?php echo esc_attr( $args['class'] ); ?>" data-cats="<?php echo esc_attr( implode( ' ', $slugs ) ); ?>" data-services="<?php echo esc_attr( implode( ' ', array_unique( $roots ) ) ); ?>"<?php echo $accent ? ' style="--accent:' . esc_attr( $accent ) . '"' : ''; ?>>
		<a class="ak-pcard__link" href="<?php echo esc_url( get_permalink( $post ) ); ?>" data-cursor="İncele">
			<div class="ak-pcard__media" style="view-transition-name: proje-<?php echo (int) $post->ID; ?>">
				<?php
				if ( has_post_thumbnail( $post ) ) {
					echo get_the_post_thumbnail(
						$post,
						$args['size'],
						array(
							'loading'  => $args['eager'] ? 'eager' : 'lazy',
							'decoding' => 'async',
							'sizes'    => '(max-width: 760px) 100vw, (max-width: 1200px) 50vw, 640px',
						)
					);
				} else {
					echo '<span class="ak-pcard__placeholder" aria-hidden="true"></span>';
				}
				?>
				<?php if ( $demo ) : ?>
					<span class="ak-badge ak-badge--demo">Örnek çalışma</span>
				<?php endif; ?>
			</div>
			<div class="ak-pcard__body">
				<p class="ak-pcard__meta">
					<?php echo esc_html( implode( ' · ', array_filter( array_merge( array( $sector ), $names ) ) ) ); ?>
				</p>
				<<?php echo tag_escape( $tag ); ?> class="ak-pcard__title"><?php echo esc_html( get_the_title( $post ) ); ?></<?php echo tag_escape( $tag ); ?>>
				<?php if ( has_excerpt( $post ) ) : ?>
					<p class="ak-pcard__excerpt"><?php echo esc_html( get_the_excerpt( $post ) ); ?></p>
				<?php endif; ?>
				<?php if ( $services ) : ?>
					<ul class="ak-tags" aria-label="Verilen hizmetler">
						<?php foreach ( array_slice( $services, 0, 3 ) as $name ) : ?>
							<li><?php echo esc_html( $name ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<span class="ak-pcard__cta" aria-hidden="true"><?php echo akilli_icon( 'arrow-up-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			</div>
		</a>
	</article>
	<?php
}

/**
 * Blog post card (theme may override via template-parts/card-post.php).
 *
 * @param WP_Post|int $post Post.
 * @param string      $heading Heading tag.
 */
function akilli_post_card( $post, $heading = 'h3' ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return;
	}
	if ( locate_template( 'template-parts/card-post.php' ) ) {
		$GLOBALS['post'] = $post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		setup_postdata( $post );
		get_template_part( 'template-parts/card', 'post', array( 'heading' => $heading ) );
		wp_reset_postdata();
		return;
	}
	echo '<article class="ak-post-card"><a href="' . esc_url( get_permalink( $post ) ) . '">';
	echo get_the_post_thumbnail( $post, 'medium_large', array( 'loading' => 'lazy' ) );
	echo '<' . tag_escape( $heading ) . '>' . esc_html( get_the_title( $post ) ) . '</' . tag_escape( $heading ) . '></a></article>';
}

/**
 * Service link card.
 *
 * @param WP_Post $svc     Service.
 * @param string  $heading Heading.
 * @param bool    $excerpt Show excerpt.
 */
function akilli_service_card( $svc, $heading = 'h3', $excerpt = true ) {
	$icon  = get_post_meta( $svc->ID, '_ak_icon', true );
	$label = get_post_meta( $svc->ID, '_ak_menu_label', true );
	?>
	<li class="ak-scard">
		<a href="<?php echo esc_url( get_permalink( $svc ) ); ?>" class="ak-scard__link">
			<span class="ak-scard__icon"><?php echo akilli_icon( $icon ? $icon : 'spark' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			<<?php echo tag_escape( $heading ); ?> class="ak-scard__title"><?php echo esc_html( $label ? $label : get_the_title( $svc ) ); ?></<?php echo tag_escape( $heading ); ?>>
			<?php if ( $excerpt && has_excerpt( $svc ) ) : ?>
				<p class="ak-scard__text"><?php echo esc_html( get_the_excerpt( $svc ) ); ?></p>
			<?php endif; ?>
			<span class="ak-scard__arrow" aria-hidden="true"><?php echo akilli_icon( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		</a>
	</li>
	<?php
}

/**
 * Contact quick links (phone, WhatsApp, e-mail).
 *
 * @param string $class Wrapper class.
 */
function akilli_contact_links( $class = '' ) {
	$items = array();
	$tel   = akilli_phone_href();
	$wa    = akilli_whatsapp_url();
	$mail  = akilli_get_setting( 'email' );
	if ( $tel ) {
		$items[] = '<a class="ak-clink" href="' . esc_url( $tel ) . '">' . akilli_icon( 'phone' ) . '<span>' . esc_html( akilli_get_setting( 'phone' ) ) . '</span></a>';
	}
	if ( $wa ) {
		$items[] = '<a class="ak-clink" href="' . esc_url( $wa ) . '" target="_blank" rel="noopener">' . akilli_icon( 'whatsapp' ) . '<span>WhatsApp</span></a>';
	}
	if ( $mail ) {
		$items[] = '<a class="ak-clink" href="' . esc_url( 'mailto:' . $mail ) . '">' . akilli_icon( 'mail' ) . '<span>' . esc_html( $mail ) . '</span></a>';
	}
	if ( $items ) {
		echo '<div class="ak-clinks ' . esc_attr( $class ) . '">' . implode( '', $items ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
	}
}
