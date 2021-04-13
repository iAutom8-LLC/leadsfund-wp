<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://i-autom8.com
 * @since      1.0.0
 *
 * @package    Iautom8_Cc
 * @subpackage Iautom8_Cc/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Iautom8_Cc
 * @subpackage Iautom8_Cc/includes
 * @author     iAutoM8 <support@i-autom8.com>
 */
class Iautom8_Cc_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'iautom8-cc',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
