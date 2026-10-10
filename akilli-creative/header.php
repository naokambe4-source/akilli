<?php
/**
 * Header.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="<?php echo esc_attr( akilli_mod( 'akilli_color_paper' ) ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="ak-skip" href="#icerik">İçeriğe geç</a>
<header class="ak-header" data-ak-header>
	<div class="ak-wrap ak-header__bar">
		<?php akilli_logo(); ?>
		<nav class="ak-nav" id="site-nav" aria-label="Ana menü" data-ak-nav>
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'ak-nav__list',
						'depth'          => 3,
						'walker'         => new Akilli_Nav_Walker(),
						'fallback_cb'    => 'akilli_nav_fallback',
					)
				);
			} else {
				akilli_nav_fallback();
			}
			?>
			<div class="ak-nav__extra">
				<a class="ak-btn ak-btn--primary" href="<?php echo esc_url( akilli_url_mod( 'akilli_header_cta_url' ) ); ?>"><span class="ak-btn__label"><?php echo esc_html( akilli_mod( 'akilli_header_cta' ) ); ?></span><?php echo akilli_icon( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<?php akilli_contact_links(); ?>
			</div>
		</nav>
		<div class="ak-header__actions">
			<?php
			$tel = akilli_phone_href();
			if ( $tel && akilli_mod( 'akilli_header_phone' ) ) :
				?>
				<a class="ak-header__phone" href="<?php echo esc_url( $tel ); ?>"><?php echo akilli_icon( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( akilli_get_setting( 'phone' ) ); ?></span></a>
			<?php endif; ?>
			<a class="ak-header__search" href="<?php echo esc_url( home_url( '/?s=' ) ); ?>" data-ak-search-link><?php echo akilli_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span class="screen-reader-text">Sitede ara</span></a>
			<a class="ak-btn ak-btn--primary ak-header__cta" href="<?php echo esc_url( akilli_url_mod( 'akilli_header_cta_url' ) ); ?>"><span class="ak-btn__label"><?php echo esc_html( akilli_mod( 'akilli_header_cta' ) ); ?></span></a>
			<a class="ak-menu-toggle" href="#site-nav" data-ak-menu-toggle aria-controls="site-nav" aria-expanded="false">
				<?php echo akilli_icon( 'menu', 'ak-icon--menu' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php echo akilli_icon( 'close', 'ak-icon--close' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span class="ak-menu-toggle__label">Menü</span>
			</a>
		</div>
	</div>
</header>
<main id="icerik" tabindex="-1">
