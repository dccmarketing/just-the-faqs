<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Just_The_FAQs
 * @subpackage Just_The_FAQs/classes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Just_The_FAQs
 * @subpackage Just_The_FAQs/classes
 * @author     Slushman <chris@slushman.com>
 */
class Just_The_FAQs_Public {

	/**
	 * The post meta data
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$meta    			The post meta data.
	 */
	private $meta;

	/**
	 * The plugin options.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$options    The plugin options.
	 */
	private $options;

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

		$this->set_options();
		$this->set_meta();

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/classes.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the scripts for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/classes.min.js', array( 'jquery' ), $this->version, true );

	}

	/**
	 * Returns a cache name based on the attributes.
	 *
	 * @param 	array 		$args 			The WP_Query args
	 * @param   string 		$cache 			Optional cache name
	 * @return 	string 						The cache name
	 */
	private function get_cache_name( $args, $cache = '' ) {

		if ( empty( $args ) ) { return ''; }

		$return = $this->plugin_name . '_questions';

		if ( ! empty( $cache ) ) {

			$return = $this->plugin_name . $cache . '_questions';

		}

		if ( ! empty( $args['topic'] ) ) {

			$return = $this->plugin_name . $cache . $args['topic'] . '_questions';

		}

		return $return;

	} // get_cache_name()

	private function query( $params = array(), $cache = '' ) {

		$return 	= '';
		$cache_name = $this->get_cache_name( $params, $cache );
		$return 	= wp_cache_get( $cache_name, $this->plugin_name . '_posts' );

		if ( false === $return ) {

			$args 	= apply_filters( $this->plugin_name . '-query-args', $args );
			$query 	= new WP_Query( $args );

			if ( is_wp_error( $query ) && empty( $query ) ) {

				$options 	= get_option( $this->plugin_name . '-options' );
				$return 	= $options['none-found-message'];

			} else {

				wp_cache_set( $cache_name, $query, $this->plugin_name . '_posts', 5 * MINUTE_IN_SECONDS );

				$return = $query;

			}

		}

		return $return;

	} // query()

	/**
	 * Registers all shortcodes at once
	 */
	public function register_shortcodes() {

		add_shortcode( 'justthefaqs', array( $this, 'shortcode_justthefaqs' ) );

	} // register_shortcodes()

	/**
	 * Sets the args array for a WP_Query call
	 *
	 * @param 	array 		$params 		Array of shortcode parameters
	 * @return 	array 						An array of parameters for WP_Query
	 */
	private function set_args( $params ) {

		if ( empty( $params ) ) { return; }

		$args = array();

		$args['no_found_rows']				= true;
		$args['order'] 						= $params['order'];
		$args['orderby'] 					= 'date';
		$args['post_type'] 					= 'question';
		$args['post_status'] 				= 'publish';
		$args['posts_per_page'] 			= absint( $params['quantity'] );;
		$args['update_post_term_cache'] 	= false;

		unset( $params['order'] );
		unset( $params['quantity'] );
		unset( $params['loop-template'] );

		if ( empty( $params ) ) { return $args; }

		if ( ! empty( $params['status'] ) ) {

			$args['tax_query'][0]['field'] 		= 'slug';
			$args['tax_query'][0]['taxonomy'] 	= 'topic';
			$args['tax_query'][0]['terms'] 		= $params['topic'];

			unset( $args['topic'] );

		}

		$args = wp_parse_args( $params, $args );

		return $args;

	} // set_args()

	/**
	 * Sets the class variable $options
	 */
	public function set_meta() {

		global $post;

		if ( empty( $post ) ) { return; }
		if ( 'question' !== $post->post_type ) { return; }

		$this->meta = get_post_custom( $post->ID );

	} // set_meta()

	/**
	 * Sets the class variable $options
	 */
	private function set_options() {

		$this->options = get_option( $this->plugin_name . '-options' );

	} // set_options()

	/**
	 * Processes the shortcode
	 *
	 * @param 	array 		$atts 			Attributes from the shortocde
	 * @return 	mixed 						The shortocde output
	 */
	private function shortcode_justthefaqs( $atts = array() ) {

		ob_start();

		$defaults['topic'] 			= '';
		$defaults['loop-template'] 	= $this->plugin_name . '-loop';
		$defaults['order'] 			= 'ASC';
		$defaults['quantity'] 		= 100;
		$args 						= shortcode_atts( $defaults, $atts, 'justthefaqs' );
		$items						= $this->query( $args, 'faqs' );

		if ( is_array( $items ) || is_object( $items ) ) {

			$include = just_the_faqs_get_template( $args['loop-template'] );

			include $include;

		} else {

			echo $items;

		}

		$output = ob_get_contents();

		ob_end_clean();

		return $output;

	} // shortcode_justthefaqs()

} // class
