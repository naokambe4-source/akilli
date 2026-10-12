<?php
/**
 * Plugin Name:       Akıllı Creative Çekirdek
 * Plugin URI:        https://www.akillicreative.com/
 * Description:       Akıllı Creative teması için hizmetler, projeler, referanslar, teklif/iletişim talepleri, Gutenberg blokları ve demo içerik kurulumu. Tema değişse bile içerikleriniz ve talepleriniz korunur.
 * Version:           1.0.1
 * Requires at least: 6.4
 * Requires PHP:      7.4
 * Author:            Akıllı Creative
 * Author URI:        https://www.akillicreative.com/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       akilli-core
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

define( 'AKILLI_CORE_VERSION', '1.0.1' );
define( 'AKILLI_CORE_FILE', __FILE__ );
define( 'AKILLI_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'AKILLI_CORE_URL', plugin_dir_url( __FILE__ ) );

require_once AKILLI_CORE_DIR . 'includes/helpers.php';
require_once AKILLI_CORE_DIR . 'includes/class-post-types.php';
require_once AKILLI_CORE_DIR . 'includes/class-meta-boxes.php';
require_once AKILLI_CORE_DIR . 'includes/class-references-order.php';
require_once AKILLI_CORE_DIR . 'includes/class-settings.php';
require_once AKILLI_CORE_DIR . 'includes/class-forms.php';
require_once AKILLI_CORE_DIR . 'includes/class-leads-admin.php';
require_once AKILLI_CORE_DIR . 'includes/class-blocks.php';
require_once AKILLI_CORE_DIR . 'includes/class-seo.php';
require_once AKILLI_CORE_DIR . 'includes/class-demo-installer.php';

Akilli_Post_Types::init();
Akilli_Meta_Boxes::init();
Akilli_References_Order::init();
Akilli_Settings::init();
Akilli_Forms::init();
Akilli_Leads_Admin::init();
Akilli_Blocks::init();
Akilli_SEO::init();
Akilli_Demo_Installer::init();

register_activation_hook( __FILE__, 'akilli_core_activate' );
register_deactivation_hook( __FILE__, 'akilli_core_deactivate' );

/**
 * Activation: register CPTs, grant lead capabilities, flush rewrites once.
 */
function akilli_core_activate() {
	Akilli_Post_Types::register();
	Akilli_Leads_Admin::grant_caps();
	flush_rewrite_rules();
}

/**
 * Deactivation: only flush rewrites. Content and leads are never deleted.
 */
function akilli_core_deactivate() {
	flush_rewrite_rules();
}

add_action( 'init', function () {
	load_plugin_textdomain( 'akilli-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}, 1 );
