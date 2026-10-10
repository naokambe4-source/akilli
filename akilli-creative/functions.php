<?php
/**
 * Akıllı Creative theme bootstrap.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;

define( 'AKILLI_THEME_VERSION', '1.0.0' );
define( 'AKILLI_THEME_DIR', get_template_directory() );
define( 'AKILLI_THEME_URI', get_template_directory_uri() );

require AKILLI_THEME_DIR . '/inc/plugin-fallback.php';
require AKILLI_THEME_DIR . '/inc/setup.php';
require AKILLI_THEME_DIR . '/inc/customizer.php';
require AKILLI_THEME_DIR . '/inc/enqueue.php';
require AKILLI_THEME_DIR . '/inc/nav-walker.php';
require AKILLI_THEME_DIR . '/inc/template-tags.php';
