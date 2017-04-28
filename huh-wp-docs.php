<?php
/**
 * @wordpress-plugin
 * Plugin Name: Huh! WP Docs
 * Plugin URI:  https://required.com
 * Description: Connector plugin for OpenInbound.com.
 * Version:     1.0.0
 * Author:      required
 * Author URI:  https://required.com
 * Text Domain: huh-wp-docs
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 *
 * Note: This plugin is based on the awesome <https://secretpizza.party/huh-making-documentation-easier/> and a fork of
 * it (<https://github.com/Daronspence/huh>) that allows to use multiple markdown files. Thanks for that!
 */

namespace Required\WP_Huh;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	include __DIR__ . '/vendor/autoload.php';
}
if ( ! class_exists( __NAMESPACE__ . '\Plugin' ) ) {
	trigger_error( sprintf( '%s does not exist. Check Composer\'s autoloader.', __NAMESPACE__ . '\Plugin' ) );

	return;
}
/**
 * Initializes the plugin.
 *
 * @since 1.0.0
 */
function init() {

	$md_docs = plugin_dir_url( __FILE__ ) . 'README.md,https://presence.dev/wp-content/plugins/cpt-casestudy/README.md';

	$plugin = new Plugin();
	$plugin->init( $md_docs );
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\init' );

/*if ( defined( 'LS_DOCURLS' ) ) {
	$ls_docs = new WP_Huh();
	$ls_docs->init( LS_DOCURLS );
}*/
