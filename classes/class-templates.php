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
 * Defines the methods for creating the templates.
 *
 * @package    Just_The_FAQs
 * @subpackage Just_The_FAQs/classes
 *
 */
class Just_The_FAQs_Templates {

	/**
	 * Private static reference to this class
	 * Useful for removing actions declared here.
	 *
	 * @var 	object 		$_this
 	 */
	private static $_this;

	/**
	 * The post meta data
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$meta    			The post meta data.
	 */
	private $meta;

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
	 * @param      string    $version 			The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		self::$_this = $this;

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	} // __construct()

	/**
	 * Includes the question template file
	 *
	 * @hooked 		just-the-faqs-loop-content 		15
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_answer( $item, $meta ) {

		include just_the_faqs_get_template( 'loop-content-answer' );

	} // loop_content_answer()

	/**
	 * Includes the link end template file
	 *
	 * @hooked 		just-the-faqs-after-loop-content 		10
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_link_end( $item, $meta ) {

		include just_the_faqs_get_template( 'loop-content-link-end' );

	} // loop_content_link_end()

	/**
	 * Includes the link start template file
	 *
	 * @hooked 		just-the-faqs-before-loop-content 		15
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_link_start( $item, $meta ) {

		include just_the_faqs_get_template( 'loop-content-link-start' );

	} // loop_content_link_start()

	/**
	 * Includes the question template file
	 *
	 * @hooked 		just-the-faqs-loop-content 		15
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_question( $item, $meta ) {

		include just_the_faqs_get_template( 'loop-content-question' );

	} // loop_content_question()

	/**
	 * Includes the content wrap end template file
	 *
	 * @hooked 		just-the-faqs-after-loop-content 		90
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_wrap_end( $item, $meta ) {

		include just_the_faqs_get_template( 'loop-content-wrap-end' );

	} // loop_content_wrap_end()

	/**
	 * Includes the content wrap start template file
	 *
	 * @hooked 		just-the-faqs-before-loop-content 		10
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_wrap_start( $item, $meta ) {

		include just_the_faqs_get_template( 'loop-content-wrap-start' );

	} // loop_content_wrap_start()

	/**
	 * Includes the list wrap end template file
	 *
	 * @hooked 		just-the-faqs-after-loop 		10
	 */
	public function loop_wrap_end( $args ) {

		include just_the_faqs_get_template( 'loop-wrap-end' );

	} // list_wrap_end()

	/**
	 * Includes the list wrap start template file
	 *
	 * @hooked 		just-the-faqs-before-loop 		10
	 */
	public function loop_wrap_start( $args ) {

		if ( empty( $args['topic'] ) ) {

			$class = '';

		} else {

			$class = $args['topic'];

		}

		include just_the_faqs_get_template( 'loop-wrap-start' );

	} // list_wrap_start()

	/**
	 * Includes the single question content
	 */
	public function single_question_content() {

		include just_the_faqs_get_template( 'single-question-content' );

	} // single_question_content()

	/**
	 * Includes the single question title
	 */
	public function single_question_title() {

		include just_the_faqs_get_template( 'single-question-title' );

	} // single_question_title()

	/**
	 * Returns a reference to this class. Used for removing
	 * actions and/or filters declared here.
	 *
	 * @see  	http://hardcorewp.com/2012/enabling-action-and-filter-hook-removal-from-class-based-wordpress-plugins/
	 * @return 	object 		This class
	 */
	static function this() {

		return self::$_this;

	} // this()

} // class
