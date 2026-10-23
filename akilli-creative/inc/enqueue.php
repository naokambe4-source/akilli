<?php
/**
 * Assets: styles, scripts (loaded only where needed), fonts, editor styles.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;

/**
 * Versioned asset URL helper.
 *
 * @param string $path Relative path.
 * @return string
 */
function akilli_asset_ver( $path ) {
	$file = AKILLI_THEME_DIR . '/' . $path;
	return file_exists( $file ) ? AKILLI_THEME_VERSION . '.' . filemtime( $file ) : AKILLI_THEME_VERSION;
}

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style( 'akilli-fonts', AKILLI_THEME_URI . '/assets/css/fonts.css', array(), akilli_asset_ver( 'assets/css/fonts.css' ) );
		wp_enqueue_style( 'akilli-main', AKILLI_THEME_URI . '/assets/css/main.css', array( 'akilli-fonts' ), akilli_asset_ver( 'assets/css/main.css' ) );
		wp_add_inline_style( 'akilli-main', akilli_custom_css() );

		if ( akilli_mod( 'akilli_transitions' ) && 'off' !== akilli_motion_level() ) {
			wp_add_inline_style( 'akilli-main', '@media (prefers-reduced-motion:no-preference){@view-transition{navigation:auto}}' );
		}

		// Core block library CSS is only needed where core blocks are rendered.
		if ( ! is_singular() || ! has_blocks() ) {
			wp_dequeue_style( 'wp-block-library' );
		}
		wp_dequeue_style( 'classic-theme-styles' );

		$strategy = array(
			'in_footer' => true,
			'strategy'  => 'defer',
		);
		wp_enqueue_script( 'akilli-main', AKILLI_THEME_URI . '/assets/js/main.js', array(), akilli_asset_ver( 'assets/js/main.js' ), $strategy );
		wp_localize_script(
			'akilli-main',
			'akilliTheme',
			array(
				'motion'     => akilli_motion_level(),
				'gl'         => (bool) akilli_mod( 'akilli_gl' ),
				'glMobile'   => (bool) akilli_mod( 'akilli_gl_mobile' ),
				'cursor'     => (bool) akilli_mod( 'akilli_cursor' ),
				'i18n'       => array(
					'showing' => '%d proje gösteriliyor',
					'open'    => 'Menüyü aç',
					'close'   => 'Menüyü kapat',
				),
			)
		);

		// Loaded on demand by templates / blocks (wp_enqueue_script inside render).
		wp_register_script( 'akilli-hero-gl', AKILLI_THEME_URI . '/assets/js/hero-gl.js', array( 'akilli-main' ), akilli_asset_ver( 'assets/js/hero-gl.js' ), $strategy );
		wp_register_script( 'akilli-portfolio', AKILLI_THEME_URI . '/assets/js/portfolio.js', array( 'akilli-main' ), akilli_asset_ver( 'assets/js/portfolio.js' ), $strategy );
		wp_register_script( 'akilli-project', AKILLI_THEME_URI . '/assets/js/project.js', array( 'akilli-main' ), akilli_asset_ver( 'assets/js/project.js' ), $strategy );

		if ( is_singular( 'ak_proje' ) ) {
			wp_enqueue_script( 'akilli-project' );
		}
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
);

/**
 * Early inline script: no-js → js and motion preference (before first paint).
 * Includes a failsafe that reveals content if main.js never runs.
 */
add_action(
	'wp_head',
	function () {
		$level = akilli_motion_level();
		?>
<script>
(function(d){var h=d.documentElement,l=<?php echo wp_json_encode( $level ); ?>,u=null;h.className=h.className.replace(/\bno-js\b/,'js');try{u=localStorage.getItem('ak-motion')}catch(e){}var r=window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches;if(u==='off'||r)l='off';h.setAttribute('data-motion',l);if(l!=='off'){h.classList.add('ak-motion','ak-motion-'+l);setTimeout(function(){if(!window.akilliReady){h.classList.remove('ak-motion','ak-motion-full','ak-motion-lite')}},4000)}})(document);
</script>
		<?php
	},
	0
);

/**
 * Preload the two critical font files of the selected families.
 */
add_action(
	'wp_head',
	function () {
		$map     = array(
			'intertight' => 'inter-tight-latin-wght-normal.woff2',
			'jakarta'    => 'plus-jakarta-sans-latin-wght-normal.woff2',
			'hanken'     => 'hanken-grotesk-latin-wght-normal.woff2',
			'jost'       => 'jost-latin-wght-normal.woff2',
		);

		$display = akilli_mod( 'akilli_font_display' );
		$body    = akilli_mod( 'akilli_font_body' );
		foreach ( array_unique( array( $display, $body ) ) as $font ) {
			if ( isset( $map[ $font ] ) ) {
				echo '<link rel="preload" href="' . esc_url( AKILLI_THEME_URI . '/assets/fonts/' . $map[ $font ] ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
			}
		}
	},
	1
);

/**
 * Editor: brand variables for the editor canvas.
 */
add_filter(
	'block_editor_settings_all',
	function ( $settings ) {
		$settings['styles'][] = array( 'css' => akilli_custom_css() );
		return $settings;
	}
);
add_action(
	'after_setup_theme',
	function () {
		add_editor_style( array( 'assets/css/main.css', 'assets/css/editor.css' ) );
	},
	20
);
