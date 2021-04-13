<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://i-autom8.com
 * @since             1.0.0
 * @package           Iautom8_Cc
 *
 * @wordpress-plugin
 * Plugin Name:       Matt's Plugin
 * Plugin URI:        https://i-autom8.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            iAutoM8
 * Author URI:        https://i-autom8.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       iautom8-cc
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( __DIR__ . '/vendor/autoload.php' );

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'IAUTOM8_CC_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-iautom8-cc-activator.php
 */
function activate_iautom8_cc() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-iautom8-cc-activator.php';
	Iautom8_Cc_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-iautom8-cc-deactivator.php
 */
function deactivate_iautom8_cc() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-iautom8-cc-deactivator.php';
	Iautom8_Cc_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_iautom8_cc' );
register_deactivation_hook( __FILE__, 'deactivate_iautom8_cc' );

/**
 * Plugin update checker
 */
require 'includes/puc/plugin-update-checker.php';

$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/iAutom8-LLC/leadsfund-wp/',
    __FILE__,
    'leadsfund'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('stable');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-iautom8-cc.php';

define( 'IAUTOM8_CC_ACF_PATH', plugin_dir_path( __FILE__ ) . '/includes/acf/' );
define( 'IAUTOM8_CC_ACF_URL', plugin_dir_url( __FILE__ ) . '/includes/acf/' );

// Include the ACF plugin.
include_once( IAUTOM8_CC_ACF_PATH . 'acf.php' );

// Customize the url setting to fix incorrect asset URLs.
add_filter('acf/settings/url', 'my_acf_settings_url');

function my_acf_settings_url( $url ) {
    return IAUTOM8_CC_ACF_URL;
}

function include_field_types_unique_id( $version ) {
    include_once('acf-unique_id-v5.php');
}

add_action('acf/include_field_types', 'include_field_types_unique_id');


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_iautom8_cc() {

	$plugin = new Iautom8_Cc();
	$plugin->run();

}
run_iautom8_cc();
