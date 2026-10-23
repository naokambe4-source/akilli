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
if ( ! function_exists( 'akilli_service_root' ) ) :
function akilli_service_root( $id ) {
	$anc = get_post_ancestors( $id );
	return $anc ? (int) end( $anc ) : (int) $id;
}
endif;

/**
 * Service names attached to a project.
 *
 * @param int $post_id Project.
 * @return string[] id => title
 */
if ( ! function_exists( 'akilli_project_service_names' ) ) :
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
endif;

/**
 * Project card.
 *
 * @param WP_Post|int $post Project.
 * @param array       $args heading (h2|h3), size (image size), eager (bool), class.
 */
if ( ! function_exists( 'akilli_project_card' ) ) :
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
			</div>
			<div class="ak-pcard__body">
				<p class="ak-pcard__meta">
					<span><?php echo esc_html( implode( ' — ', array_filter( array_merge( array( $sector ), array_slice( $names, 0, 1 ) ) ) ) ); ?></span>
					<?php if ( $demo ) : ?>
						<span class="ak-pcard__demo">Örnek proje</span>
					<?php endif; ?>
				</p>
				<<?php echo tag_escape( $tag ); ?> class="ak-pcard__title"><?php echo esc_html( get_the_title( $post ) ); ?></<?php echo tag_escape( $tag ); ?>>
				<?php if ( has_excerpt( $post ) ) : ?>
					<p class="ak-pcard__excerpt"><?php echo esc_html( get_the_excerpt( $post ) ); ?></p>
				<?php endif; ?>
				<span class="ak-pcard__cta" aria-hidden="true">Projeyi incele</span>
			</div>
		</a>
	</article>
	<?php
}
endif;

/**
 * Blog post card (theme may override via template-parts/card-post.php).
 *
 * @param WP_Post|int $post Post.
 * @param string      $heading Heading tag.
 */
if ( ! function_exists( 'akilli_post_card' ) ) :
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
endif;

/**
 * Service link card.
 *
 * @param WP_Post $svc     Service.
 * @param string  $heading Heading.
 * @param bool    $excerpt Show excerpt.
 */
if ( ! function_exists( 'akilli_service_card' ) ) :
function akilli_service_card( $svc, $heading = 'h3', $excerpt = true ) {
	$label = get_post_meta( $svc->ID, '_ak_menu_label', true );
	?>
	<li class="ak-scard">
		<a href="<?php echo esc_url( get_permalink( $svc ) ); ?>" class="ak-scard__link">
			<<?php echo tag_escape( $heading ); ?> class="ak-scard__title"><?php echo esc_html( $label ? $label : get_the_title( $svc ) ); ?></<?php echo tag_escape( $heading ); ?>>
			<?php if ( $excerpt && has_excerpt( $svc ) ) : ?>
				<p class="ak-scard__text"><?php echo esc_html( get_the_excerpt( $svc ) ); ?></p>
			<?php endif; ?>
			<span class="ak-scard__arrow" aria-hidden="true"><?php echo akilli_icon( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		</a>
	</li>
	<?php
}
endif;

/**
 * Contact quick links (phone, WhatsApp, e-mail).
 *
 * @param string $class Wrapper class.
 */
if ( ! function_exists( 'akilli_contact_links' ) ) :
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
endif;

/**
 * Decorative, CSS-animated UI illustration for a service category.
 * Pure markup (no images); animations live in the theme stylesheet and stop
 * under reduced motion.
 *
 * @param string $kind web|cart|pen|growth.
 */
if ( ! function_exists( 'akilli_service_illustration' ) ) :
function akilli_service_illustration( $kind ) {
	switch ( $kind ) {
		case 'cart':
			?>
			<div class="ak-ui ak-ui--cart">
				<div class="ak-ui__product">
					<span class="ak-ui__photo"></span>
					<span class="ak-ui__line ak-ui__line--w70"></span>
					<span class="ak-ui__line ak-ui__line--w40"></span>
					<span class="ak-ui__price">₺1.240</span>
					<span class="ak-ui__add">Sepete ekle</span>
				</div>
				<div class="ak-ui__bag"><?php echo akilli_icon( 'cart' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><b>1</b></div>
				<div class="ak-ui__toast"><?php echo akilli_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>Ödeme alındı</div>
			</div>
			<?php
			break;
		case 'pen':
			?>
			<div class="ak-ui ak-ui--pen">
				<div class="ak-ui__canvas">
					<svg viewBox="0 0 240 160" fill="none"><path class="ak-ui__draw" d="M20 120 C 60 20, 110 20, 120 80 S 190 150, 220 40" /><circle cx="20" cy="120" r="5"/><circle cx="120" cy="80" r="5"/><circle cx="220" cy="40" r="5"/></svg>
					<span class="ak-ui__type">Aa</span>
				</div>
				<div class="ak-ui__swatches"><span></span><span></span><span></span><span></span></div>
			</div>
			<?php
			break;
		case 'growth':
			?>
			<div class="ak-ui ak-ui--growth">
				<div class="ak-ui__chart">
					<span style="--h:30%"></span><span style="--h:45%"></span><span style="--h:38%"></span><span style="--h:62%"></span><span style="--h:74%"></span><span style="--h:92%"></span>
					<svg viewBox="0 0 240 120" fill="none" preserveAspectRatio="none"><path class="ak-ui__draw" d="M0 100 L48 80 L96 88 L144 52 L192 38 L240 8" /></svg>
				</div>
				<div class="ak-ui__kpi"><?php echo akilli_icon( 'arrow-up-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span>Kampanya</span><b>Yayında</b></div>
			</div>
			<?php
			break;
		default:
			?>
			<div class="ak-ui ak-ui--web">
				<div class="ak-ui__browser">
					<div class="ak-ui__bar"><i></i><i></i><i></i><span></span></div>
					<div class="ak-ui__hero"><span class="ak-ui__line ak-ui__line--w60"></span><span class="ak-ui__line ak-ui__line--w40"></span><span class="ak-ui__btn"></span></div>
					<div class="ak-ui__cards"><span></span><span></span><span></span></div>
				</div>
				<div class="ak-ui__pointer"><?php echo akilli_icon( 'arrow-up-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
			</div>
			<?php
	}
}
endif;

/**
 * Brand "A-star" mark with the glowing orange orbit ring (decorative SVG).
 * The ring is split in two layers so its lower arc passes in front of the mark.
 *
 * @param string $class Extra class.
 */
if ( ! function_exists( 'akilli_orbit_mark' ) ) :
function akilli_orbit_mark( $class = '' ) {
	$uid = 'akorb' . wp_unique_id();
	?>
	<svg class="ak-orbit <?php echo esc_attr( $class ); ?>" viewBox="0 0 640 600" aria-hidden="true" focusable="false">
		<defs>
			<linearGradient id="<?php echo esc_attr( $uid ); ?>-ring" x1="0" y1="0" x2="1" y2="0">
				<stop offset="0" stop-color="#ff3d00"/>
				<stop offset=".45" stop-color="#ffa04d"/>
				<stop offset=".7" stop-color="#ff6a00"/>
				<stop offset="1" stop-color="#ff3d00"/>
			</linearGradient>
			<linearGradient id="<?php echo esc_attr( $uid ); ?>-a" x1="0" y1="0" x2="1" y2="1">
				<stop offset="0" stop-color="#3a3a3a"/>
				<stop offset=".55" stop-color="#121212"/>
				<stop offset="1" stop-color="#050505"/>
			</linearGradient>
			<mask id="<?php echo esc_attr( $uid ); ?>-m">
				<rect width="640" height="600" fill="#fff"/>
				<polygon fill="#000" points="320,146 361,261 484,265 387,340 421,457 320,388 219,457 253,340 156,265 279,261"/>
				<polygon fill="#000" points="276,560 320,470 364,560"/>
			</mask>
		</defs>
		<g class="ak-orbit__ring ak-orbit__ring--back">
			<ellipse cx="320" cy="330" rx="300" ry="112" fill="none" stroke="url(#<?php echo esc_attr( $uid ); ?>-ring)" stroke-width="20"/>
		</g>
		<polygon class="ak-orbit__a" mask="url(#<?php echo esc_attr( $uid ); ?>-m)" fill="url(#<?php echo esc_attr( $uid ); ?>-a)" points="270,40 370,40 560,560 80,560"/>
		<g class="ak-orbit__ring ak-orbit__ring--front">
			<path d="M20 330 A300 112 0 0 0 620 330" fill="none" stroke="url(#<?php echo esc_attr( $uid ); ?>-ring)" stroke-width="20" stroke-linecap="round"/>
			<path class="ak-orbit__spark" d="M20 330 A300 112 0 0 0 620 330" fill="none" stroke="#fff" stroke-width="5" stroke-linecap="round" pathLength="100" stroke-dasharray="6 94"/>
		</g>
	</svg>
	<?php
}
endif;
