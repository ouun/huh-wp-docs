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
 *
 * @package Required\WP_Huh
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
	/**
	 * Default docs url.
	 */
	//$doc_urls = 'https://raw.githubusercontent.com/neverything/huh-wp-docs/master/README.md';

	$doc_urls = [
		'all' => 'https://raw.githubusercontent.com/neverything/huh-wp-docs/master/README.md',
		'post.php' => 'https://gist.githubusercontent.com/neverything/4994f12366daabf2b672669161d0aed1/raw/bd2ec795c86f64ebc058de03c128ebe544f4ead3/wandeljetzt-wordpress-wandellust.md,https://gist.githubusercontent.com/neverything/105a3be234324e6b890448da14e359b5/raw/8ca588d574ef6fc8f53ff431bd3cd3d1ea3b1aa2/presence-workshop-2017-01-11.md',
		'edit.php' => 'https://gist.githubusercontent.com/neverything/4994f12366daabf2b672669161d0aed1/raw/bd2ec795c86f64ebc058de03c128ebe544f4ead3/wandeljetzt-wordpress-wandellust.md,https://gist.githubusercontent.com/neverything/105a3be234324e6b890448da14e359b5/raw/8ca588d574ef6fc8f53ff431bd3cd3d1ea3b1aa2/presence-workshop-2017-01-11.md',
	];

	$plugin = new Plugin();
	$plugin->init( $doc_urls );
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\init' );
