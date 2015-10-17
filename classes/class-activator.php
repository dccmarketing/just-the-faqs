<?php

/**
 * Fired during plugin activation
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Just_The_FAQs
 * @subpackage Just_The_FAQs/classes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Just_The_FAQs
 * @subpackage Just_The_FAQs/classes
 * @author     Slushman <chris@slushman.com>
 */
class Just_The_FAQs_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-cpt-question.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-tax-topic.php';

		Just_The_FAQs_CPT_Question::new_cpt_question();
		Just_The_FAQs_Tax_Topic::new_taxonomy_topic();

		flush_rewrite_rules();

		$opts 		= array();
		$options 	= Just_The_FAQs_Admin::get_options_list();

		foreach ( $options as $option ) {

			$opts[ $option[0] ] = $option[2];

		}

		update_option( 'just-the-faqs-options', $opts );

	} // activate()

} // class
