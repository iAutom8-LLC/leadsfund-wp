<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://i-autom8.com
 * @since      1.0.0
 *
 * @package    Iautom8_Cc
 * @subpackage Iautom8_Cc/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Iautom8_Cc
 * @subpackage Iautom8_Cc/admin
 * @author     iAutoM8 <support@i-autom8.com>
 */
class Iautom8_Cc_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/iautom8-cc-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name . '_clipboard', plugin_dir_url( __FILE__ ) . 'js/clipboard.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/iautom8-cc-admin.js', array( 'jquery', $this->plugin_name . '_clipboard' ), $this->version, false );

	}

	public function hide_unique_id_class() {
	    echo '<style>.hide-unique-id{display:none;}</style>';
    }

    public function register_shortcode() {
	    add_shortcode( 'leadsfund', function( $atts ) {
	        $atts = shortcode_atts( [
	            'embed' => '',
                'widget' => '',
            ], $atts );

	        if ( ! $atts['embed'] || ! $atts['widget'] ) {
	           return '';
            }

            $embed_id = (int) $atts['embed'];

            $widgets = get_field( 'widgets', $embed_id );

            $widgets_matching_id = array_values( array_filter( $widgets, function( $widget ) use( $atts ) {
                return $widget['shortcode_id'] === $atts['widget'];
            }) );

            if ( empty( $widgets_matching_id ) || ! isset( $widgets_matching_id[0], $widgets_matching_id[0]['script']) ) {
                return '';
            }

            $script = $widgets_matching_id[0]['script'];

            if ( $widgets_matching_id[0]['override_button'] ) {
                $re = '/buttons=[a-zA-Z0-9.\_\-]{1,30}/m';
                $subst = 'buttons=' . $widgets_matching_id[0]['button_style'];

                $result = preg_replace($re, $subst, $script);

                $re = '/btn-(?:warning|primary|danger|success|info|inverse|purple)/m';
                $subst = $widgets_matching_id[0]['button_style'];

                $class_result = preg_replace($re, $subst, $result);

                return $class_result;
            }

            return $script;
        });
    }

	public function register_cpt() {
        register_extended_post_type( 'leads_fund_script', [

            # Add the post type to the site's main RSS feed:
            'show_in_feed' => false,

            # Add the post type to the 'Recently Published' section of the dashboard:
            'dashboard_activity' => true,

            # Add some custom columns to the admin screen:
            'admin_cols' => [
                'shortcode' => [
                    'title'  => 'Shortcode',
                    'function' => function() {
                        $post_id = get_the_ID();

                        if( have_rows('widgets') ):

                            // Loop through rows.
                            while( have_rows('widgets') ) : the_row();

                                // Load sub field value.
                                $sub_value = get_sub_field('name');
                                $shortcode_id = get_sub_field( 'shortcode_id' );

                                // Do something...
                                $shortcode = '[leadsfund embed=&quot;' . $post_id . '&quot;  widget=&quot;' . $shortcode_id . '&quot; /]';
                               ?>
                            <div style="display: block; margin-bottom: 15px;" class="widget-wrapper">
                                <button
                                        type="button"
                                        class="btn-copy"
                                        data-clipboard-text="<?php echo $shortcode; ?>"
                                >
                                    <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" width="24px" height="24px"><path d="M 20.5 4 C 18.203405 4 16.305701 5.7666235 16.050781 8 L 12.5 8 C 10.032499 8 8 10.032499 8 12.5 L 8 39.5 C 8 41.967501 10.032499 44 12.5 44 L 35.5 44 C 37.967501 44 40 41.967501 40 39.5 L 40 12.5 C 40 10.032499 37.967501 8 35.5 8 L 31.949219 8 C 31.694299 5.7666235 29.796595 4 27.5 4 L 20.5 4 z M 20.5 7 L 27.5 7 C 28.346499 7 29 7.6535009 29 8.5 C 29 9.3464991 28.346499 10 27.5 10 L 20.5 10 C 19.653501 10 19 9.3464991 19 8.5 C 19 7.6535009 19.653501 7 20.5 7 z M 12.5 11 L 16.769531 11 C 17.581237 12.2019 18.954719 13 20.5 13 L 27.5 13 C 29.045281 13 30.418763 12.2019 31.230469 11 L 35.5 11 C 36.346499 11 37 11.653501 37 12.5 L 37 39.5 C 37 40.346499 36.346499 41 35.5 41 L 12.5 41 C 11.653501 41 11 40.346499 11 39.5 L 11 12.5 C 11 11.653501 11.653501 11 12.5 11 z M 16.5 20 A 1.5 1.5 0 0 0 16.5 23 A 1.5 1.5 0 0 0 16.5 20 z M 22.5 20 A 1.50015 1.50015 0 1 0 22.5 23 L 31.5 23 A 1.50015 1.50015 0 1 0 31.5 20 L 22.5 20 z M 16.5 26 A 1.5 1.5 0 0 0 16.5 29 A 1.5 1.5 0 0 0 16.5 26 z M 22.5 26 A 1.50015 1.50015 0 1 0 22.5 29 L 31.5 29 A 1.50015 1.50015 0 1 0 31.5 26 L 22.5 26 z M 16.5 32 A 1.5 1.5 0 0 0 16.5 35 A 1.5 1.5 0 0 0 16.5 32 z M 22.5 32 A 1.50015 1.50015 0 1 0 22.5 35 L 31.5 35 A 1.50015 1.50015 0 1 0 31.5 32 L 22.5 32 z"/></svg>
                                </button>
                                <?php
                                echo $sub_value;
                                echo '<input style="display: block; margin-top: 5px; width: 100%;" type="text" readonly disabled value="' . $shortcode . '">';
                                ?>
                            </div>
<?php
                                // End loop.
                            endwhile;

                            // No value.
                        else :
                            // Do something...
                        endif;
                    }
                ],
            ],

            'publicly_queryable' => false,

            'show_in_rest' => false,
            'block_editor' => false,
        ], [

            # Override the base names used for labels:
            'singular' => 'Leads Fund Script',
            'plural'   => 'Leads Fund Scripts',
            'slug'     => 'leads-fund-script',
        ] );
    }

}
