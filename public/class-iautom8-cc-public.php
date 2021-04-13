<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://i-autom8.com
 * @since      1.0.0
 *
 * @package    Iautom8_Cc
 * @subpackage Iautom8_Cc/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Iautom8_Cc
 * @subpackage Iautom8_Cc/public
 * @author     iAutoM8 <support@i-autom8.com>
 */
class Iautom8_Cc_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Iautom8_Cc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Iautom8_Cc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/iautom8-cc-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Iautom8_Cc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Iautom8_Cc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/iautom8-cc-public.js', array( 'jquery' ), $this->version, false );

	}

	public function leadsfund_script() {
	    $content = get_the_content();
	    $tag = 'leadsfund';

        if ( is_admin() || false === strpos( $content, '[' ) ) {
            return false;
        }

        if ( shortcode_exists( $tag ) ) {
            preg_match_all( '/' . get_shortcode_regex() . '/', $content, $matches, PREG_SET_ORDER );
            if ( empty( $matches ) ) {
                return '';
            }

            foreach ( $matches as $shortcode ) {
                if ( $tag === $shortcode[2] ) {
                    $atts = shortcode_parse_atts( $shortcode[0] );

                    if ( ! isset( $atts['embed'] ) || empty( $atts['embed'] ) ) {
                        return '';
                    }

                    $embed_id = (int) $atts['embed'];

                    echo get_field( 'head_embed_code', $embed_id, false );
                } elseif ( ! empty( $shortcode[5] ) && has_shortcode( $shortcode[5], $tag ) ) {
                    return '';
                }
            }
        }
    }

}
