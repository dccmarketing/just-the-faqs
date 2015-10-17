<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Just_The_FAQs
 * @subpackage Just_The_FAQs/classes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Just_The_FAQs
 * @subpackage Just_The_FAQs/classes
 * @author     Slushman <chris@slushman.com>
 */
class Just_The_FAQs {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Just_The_FAQs_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * Sanitizer for cleaning user input
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Just_The_FAQs_Sanitize    $sanitizer    Sanitizes data
	 */
	private $sanitizer;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'just-the-faqs';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_cpt_and_tax_hooks();
		$this->define_template_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Just_The_FAQs_Loader. Orchestrates the hooks of the plugin.
	 * - Just_The_FAQs_i18n. Defines internationalization functionality.
	 * - Just_The_FAQs_Admin. Defines all hooks for the admin area.
	 * - Just_The_FAQs_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-public.php';

		/**
		 * The class responsible for sanitizing user input
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-sanitize.php';

		/**
		 * The class responsible for defining all actions relating to the question custom post type.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-cpt-question.php';

		/**
		 * The class responsible for defining all actions relating to the topic taxonomy.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-tax-topic.php';

		/**
		 * The class responsible for defining all actions creating the templates.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-templates.php';

		/**
		 * The class responsible for all global functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/global-functions.php';

		$this->loader = new Just_The_FAQs_Loader();
		$this->sanitizer = new Just_The_FAQs_Sanitize();

	} // load_dependencies()

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Just_The_FAQs_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->action( 'admin_init', $plugin_admin, 'register_fields' );
		$this->loader->action( 'admin_init', $plugin_admin, 'register_sections' );
		$this->loader->action( 'admin_init', $plugin_admin, 'register_settings' );
		$this->loader->action( 'admin_menu', $plugin_admin, 'add_menu' );
		$this->loader->action( 'plugin_action_links_' . JUST_THE_FAQS_FILE, $plugin_admin, 'link_settings' );
		$this->loader->action( 'plugin_row_meta', $plugin_admin, 'link_row_meta', 10, 2 );

	}

	/**
	 * Register all of the hooks related to custom post types and taxonomies
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_cpt_and_tax_hooks() {

		$plugin_cpt_question = new Just_The_FAQs_CPT_Question( $this->get_plugin_name(), $this->get_version() );

		$this->loader->action( 'init', $plugin_cpt_question, 'new_cpt_question' );
		$this->loader->action( 'enter_title_here', $plugin_cpt_question, 'change_title_text', 10, 2 );



		$plugin_tax_topic =new Just_The_FAQs_Tax_Topic( $this->get_plugin_name(), $this->get_version() );

		$this->loader->action( 'init', $plugin_tax_topic, 'new_taxonomy_topic' );

	} // define_cpt_and_tax_hooks()

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Just_The_FAQs_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->action( 'init', $plugin_public, 'register_shortcodes' );

	}

	/**
	 * Register all of the hooks related to the templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_template_hooks() {

		$plugin_templates = new Just_The_FAQs_Templates( $this->get_plugin_name(), $this->get_version() );

		// Loop
		$this->loader->action( 'just-the-faqs-before-loop', 		$plugin_templates, 'loop_wrap_start', 10, 1 );
		$this->loader->action( 'just-the-faqs-before-loop-content', $plugin_templates, 'loop_content_wrap_start', 10, 2 );
		$this->loader->action( 'just-the-faqs-before-loop-content', $plugin_templates, 'loop_content_link_start', 15, 3 );
		$this->loader->action( 'just-the-faqs-loop-content', 		$plugin_templates, 'loop_content_image', 10, 2 );
		$this->loader->action( 'just-the-faqs-loop-content', 		$plugin_templates, 'loop_content_name', 15, 2 );
		$this->loader->action( 'just-the-faqs-loop-content', 		$plugin_templates, 'loop_content_job_title', 20, 2 );
		$this->loader->action( 'just-the-faqs-after-loop-content', 	$plugin_templates, 'loop_content_link_end', 10, 2 );
		$this->loader->action( 'just-the-faqs-after-loop-content', 	$plugin_templates, 'loop_content_wrap_end', 90, 2 );
		$this->loader->action( 'just-the-faqs-after-loop', 			$plugin_templates, 'loop_wrap_end', 10, 1 );


		// Single
		$this->loader->action( 'just-the-faqs-single-content', $plugin_templates, 'single_question_title', 10 );
		$this->loader->action( 'just-the-faqs-single-content', $plugin_templates, 'single_question_content', 15 );

	} // define_template_hooks()

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Just_The_FAQs_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}
	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Just_The_FAQs_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Just_The_FAQs_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

} // class
